<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import CalendarWidget from '@/Components/CalendarWidget.vue';

const props = defineProps({
    visits: Array,
    attendances: Array,
});

const activeTab = ref('visitors'); // 'visitors' or 'staff'
const searchQuery = ref('');
const selectedDate = ref(new Date().toISOString().split('T')[0]); // Default to today

const formatDateTime = (dateVal, timeVal = null) => {
    if (!dateVal && !timeVal) return { date: '-', time: '-' };
    
    // Determine the best source for date and time
    // ISO usually has 'T', but MySQL/Carbon often serializes with a space ' '
    const isFullTimestamp = (val) => val && String(val).length >= 10 && (String(val).includes('T') || String(val).includes(' '));
    
    const source = isFullTimestamp(timeVal) ? timeVal : 
                   isFullTimestamp(dateVal) ? dateVal : null;

    if (source) {
        const d = new Date(String(source).replace(' ', 'T')); // Replace space with T if needed for Safari/Old browsers
        if (!isNaN(d.getTime())) {
            return {
                date: d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }),
                time: d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })
            };
        }
    }
    
    // Fallback for separate date and simple time strings (HH:mm:ss)
    const datePart = dateVal ? new Date(dateVal).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : '';
    let timePart = '-';
    
    if (timeVal) {
        const timeStr = String(timeVal);
        if (timeStr.includes(':')) {
            // It's likely a time string like "14:30:00"
            const parts = timeStr.split(':');
            const h = parseInt(parts[0]);
            const m = parts[1];
            const ampm = h >= 12 ? 'PM' : 'AM';
            const h12 = h % 12 || 12;
            timePart = `${h12}:${m} ${ampm}`;
        } else if (timeStr.length >= 5) {
            timePart = timeStr.substring(0, 5);
        }
    }
    
    return {
        date: datePart || '-',
        time: timePart
    };
};

const getStatusColor = (status) => {
    switch (status) {
        case 'Approved': return 'bg-emerald-50 text-emerald-700 border-emerald-200';
        case 'Checked Out': return 'bg-stone-100 text-stone-600 border-stone-200';
        case 'Rejected': return 'bg-red-50 text-red-700 border-red-200';
        case 'Pending': return 'bg-orange-50 text-orange-700 border-orange-200';
        case 'Active': return 'bg-sky-50 text-sky-700 border-sky-200';
        default: return 'bg-stone-100 text-stone-600 border-stone-200';
    }
};

const filteredVisits = computed(() => {
    let result = props.visits;
    if (selectedDate.value) {
        result = result.filter(v => {
            const vDate = v.visit_date.split(' ')[0].replace('T', ' ');
            return vDate === selectedDate.value;
        });
    }
    if (searchQuery.value) {
        const lowerQuery = searchQuery.value.toLowerCase();
        result = result.filter(v => 
            v.pass_number.toLowerCase().includes(lowerQuery) || 
            v.purpose.toLowerCase().includes(lowerQuery) ||
            (v.visitors && v.visitors.some(vis => vis.name.toLowerCase().includes(lowerQuery) || vis.ic_number.toLowerCase().includes(lowerQuery)))
        );
    }
    return result;
});

const filteredAttendances = computed(() => {
    let result = props.attendances;
    if (selectedDate.value) {
        result = result.filter(a => {
            if (!a.check_in_time) return false;
            const dateStr = a.check_in_time.split(' ')[0].replace('T', ' ').split(' ')[0];
            return dateStr === selectedDate.value;
        });
    }
    if (searchQuery.value) {
        const lowerQuery = searchQuery.value.toLowerCase();
        result = result.filter(a => 
            (a.staff && a.staff.name.toLowerCase().includes(lowerQuery)) ||
            (a.vehicle_plate && a.vehicle_plate.toLowerCase().includes(lowerQuery))
        );
    }
    return result;
});

const calculateDuration = (checkIn, checkOut) => {
    if (!checkIn || !checkOut) return '-';
    const start = new Date(checkIn);
    const end = new Date(checkOut);
    const diffMs = end - start;
    if (diffMs < 0) return '-';
    const diffHrs = Math.floor(diffMs / 3600000);
    const diffMins = Math.floor((diffMs % 3600000) / 60000);
    return `${diffHrs}h ${diffMins}m`;
};

const exportToCSV = () => {
    const data = activeTab.value === 'visitors' ? filteredVisits.value : filteredAttendances.value;
    if (data.length === 0) return;

    let csvContent = "data:text/csv;charset=utf-8,";
    
    if (activeTab.value === 'visitors') {
        csvContent += "Pass Number,Date,Time,Visitor Name,IC Number,Purpose,Host,Status\n";
        data.forEach(v => {
            const dt = formatDateTime(v.visit_date, v.check_in_time);
            const visitorName = v.visitors && v.visitors.length > 0 ? v.visitors[0].name : 'N/A';
            const icNumber = v.visitors && v.visitors.length > 0 ? v.visitors[0].ic_number : 'N/A';
            const row = [
                v.pass_number,
                dt.date,
                dt.time,
                visitorName,
                icNumber,
                v.purpose,
                v.employee ? v.employee.name : 'Unknown',
                v.status
            ].map(val => `"${String(val).replace(/"/g, '""')}"`).join(",");
            csvContent += row + "\n";
        });
    } else {
        csvContent += "Date,Check In,Check Out,Staff Name,Vehicle Plate,Duration\n";
        data.forEach(a => {
            const dtIn = formatDateTime(a.check_in_time);
            const dtOut = a.check_out_time ? formatDateTime(a.check_out_time) : { time: 'Active' };
            const duration = a.check_out_time ? calculateDuration(a.check_in_time, a.check_out_time) : 'Active';
            const row = [
                dtIn.date,
                dtIn.time,
                dtOut.time,
                a.employee ? a.employee.name : 'Unknown',
                a.vehicle_plate || 'N/A',
                duration
            ].map(val => `"${String(val).replace(/"/g, '""')}"`).join(",");
            csvContent += row + "\n";
        });
    }

    const blob = new Blob(["\uFEFF", csvContent], { type: 'text/csv;charset=utf-8' });
    const url = window.URL.createObjectURL(blob);
    const link = document.createElement("a");
    link.style.display = 'none';
    link.href = url;
    
    // Filename follows the date
    const filenameDate = selectedDate.value ? selectedDate.value : new Date().toISOString().split('T')[0];
    link.setAttribute("download", `Lembah_Entry_${activeTab.value}_Logs_${filenameDate}.csv`);
    
    document.body.appendChild(link);
    link.click();
    
    // Delay cleanup to ensure browser captures the blob handoff
    setTimeout(() => {
        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
    }, 100);
};

const exportToPDF = () => {
    const reportRoute = activeTab.value === 'visitors' ? 'reports.visitor' : 'reports.staff';
    const params = selectedDate.value ? { date: selectedDate.value } : {};
    window.open(route(reportRoute, params), '_blank');
};
</script>

<template>
    <Head title="History & Reports - Sari Heritage" />
    <AuthenticatedLayout>
        <div class="p-8 space-y-8 max-w-7xl mx-auto w-full font-body">
            
            <!-- Header Editorial Section -->
            <div class="flex flex-col md:flex-row justify-between items-end gap-8 border-b border-outline-variant/10 pb-6">
                <div class="max-w-xl">
                    <h3 class="text-4xl font-extrabold tracking-tight text-primary leading-tight font-headline">Archives & Insights</h3>
                    <p class="mt-4 text-on-surface-variant text-lg leading-relaxed">Detailed logs of every heritage site visitor and internal staff attendance. Generate comprehensive compliance reports.</p>
                </div>
                <div class="flex gap-4 print:hidden">
                    <button @click="exportToPDF" class="bg-surface-container-lowest text-on-surface px-6 py-3 rounded-lg font-bold flex items-center gap-2 transition-all hover:bg-surface-container shadow-sm border border-outline-variant/10">
                        <span class="material-symbols-outlined text-xl" data-icon="picture_as_pdf">picture_as_pdf</span>
                        Export Summary
                    </button>
                    <button @click="exportToCSV" class="bg-secondary text-white px-6 py-3 rounded-lg font-bold flex items-center gap-2 transition-all hover:opacity-90 shadow-sm">
                        <span class="material-symbols-outlined text-xl" data-icon="download">download</span>
                        Excel Data
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                <!-- Main Content Area -->
                <div class="md:col-span-8 lg:col-span-9 space-y-6">
                    <!-- Tab Navigation & Search -->
                    <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-surface-container-low p-3 rounded-2xl print:hidden">
                <div class="relative flex p-1.5 bg-stone-100/80 backdrop-blur-sm rounded-xl w-full md:w-[420px] border border-stone-200/50 shadow-inner overflow-hidden">
                    <!-- Sliding Indicator -->
                    <div 
                        class="absolute top-1.5 bottom-1.5 left-1.5 w-[calc(50%-6px)] bg-primary rounded-lg shadow-lg shadow-primary/20 transition-all duration-300 ease-out z-0"
                        :class="activeTab === 'staff' ? 'translate-x-full' : 'translate-x-0'"
                    ></div>
                    
                    <button 
                        @click="activeTab = 'visitors'" 
                        class="relative z-10 w-1/2 px-6 py-3 text-sm font-bold tracking-tight transition-all duration-300 rounded-lg flex items-center justify-center gap-2"
                        :class="activeTab === 'visitors' ? 'text-white' : 'text-stone-500 hover:text-stone-700'"
                    >
                        <span class="material-symbols-outlined text-lg transition-transform duration-300" :class="activeTab === 'visitors' ? 'scale-110 opacity-100' : 'scale-100 opacity-40'">person</span>
                        Visitor Logs
                    </button>
                    <button 
                        @click="activeTab = 'staff'" 
                        class="relative z-10 w-1/2 px-6 py-3 text-sm font-bold tracking-tight transition-all duration-300 rounded-lg flex items-center justify-center gap-2"
                        :class="activeTab === 'staff' ? 'text-white' : 'text-stone-500 hover:text-stone-700'"
                    >
                        <span class="material-symbols-outlined text-lg transition-transform duration-300" :class="activeTab === 'staff' ? 'scale-110 opacity-100' : 'scale-100 opacity-40'">badge</span>
                        Staff Attendance
                    </button>
                </div>
                
                <div class="relative group w-full md:w-80">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant opacity-40 group-focus-within:opacity-100 transition-opacity" data-icon="search">search</span>
                    <input v-model="searchQuery" class="w-full bg-white border border-stone-200 py-3 pl-12 pr-4 rounded-xl focus:ring-4 focus:ring-primary/5 text-sm focus:border-primary transition-all shadow-sm outline-none placeholder:text-stone-300" placeholder="Search archive records..." type="text"/>
                </div>
            </div>

            <!-- Data Table Section -->
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/10 overflow-hidden shadow-sm">
                
                <!-- VISITOR TAB -->
                <div v-if="activeTab === 'visitors'" class="overflow-x-auto h-[600px] overflow-y-auto">
                    <table class="w-full border-collapse text-left">
                        <thead class="sticky top-0 bg-surface-container-lowest z-10 border-b border-outline-variant/10 shadow-sm">
                            <tr class="font-label">
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Name</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Date</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Company</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Vehicle</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Time In</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Time Out</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Pass</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container">
                            <tr v-for="visit in filteredVisits" :key="visit.visit_id" class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div v-if="visit.visitors && visit.visitors.length > 0">
                                        <div class="font-bold text-sm text-on-surface">{{ visit.visitors[0].name }}</div>
                                        <div v-if="visit.visitors.length > 1" class="text-[10px] text-primary mt-0.5">(+{{ visit.visitors.length - 1 }} others)</div>
                                    </div>
                                    <div v-else class="text-xs text-outline italic">No Visitor Recorded</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-on-surface">{{ formatDateTime(visit.visit_date).date }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-on-surface uppercase truncate max-w-[120px]">
                                        {{ (visit.visitors && visit.visitors.length > 0) ? (visit.visitors[0].company || '-') : '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span v-if="visit.vehicles && visit.vehicles.length > 0" class="text-[10px] font-mono font-bold bg-stone-100 text-stone-600 px-2 py-0.5 rounded border border-stone-200">{{ visit.vehicles[0].plate_number }}</span>
                                    <span v-else class="text-xs text-outline opacity-40">-</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-mono font-bold text-stone-600">{{ formatDateTime(visit.visit_date, visit.check_in_time).time }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-on-surface">
                                    <span v-if="visit.check_out_time" class="text-xs font-mono">{{ formatDateTime(visit.visit_date, visit.check_out_time).time }}</span>
                                    <span v-else class="text-[9px] font-black uppercase text-amber-500 animate-pulse tracking-widest">Active</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-black font-mono text-sm tracking-tight text-secondary">{{ visit.pass_number }}</span>
                                </td>
                            </tr>
                            <tr v-if="filteredVisits.length === 0">
                                <td colspan="5" class="px-6 py-12 text-center text-outline font-medium text-sm border-t border-outline-variant/10">No visitor records found.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- STAFF ATTENDANCE TAB -->
                <div v-if="activeTab === 'staff'" class="overflow-x-auto h-[600px] overflow-y-auto">
                    <table class="w-full border-collapse text-left">
                        <thead class="sticky top-0 bg-surface-container-lowest z-10 border-b border-outline-variant/10 shadow-sm">
                            <tr class="font-label">
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Name</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Date</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Vehicle No</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Time In</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Time Out</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container">
                            <tr v-for="record in filteredAttendances" :key="record.attendance_id" class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center font-bold text-primary overflow-hidden uppercase text-[10px]">
                                            {{ record.employee ? record.employee.name.substring(0,2) : 'ST' }}
                                        </div>
                                        <span class="font-bold text-sm text-on-surface uppercase">{{ record.employee ? record.employee.name : 'Unknown Staff' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-on-surface text-sm uppercase">{{ formatDateTime(record.check_in_time).date }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span v-if="record.vehicle_plate" class="text-[10px] font-mono font-bold uppercase bg-stone-100 text-stone-600 border border-stone-200 px-2 py-1 rounded shadow-sm tracking-tight">{{ record.vehicle_plate }}</span>
                                    <span v-else class="text-xs text-outline italic opacity-50">N/A</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-mono font-bold text-stone-600 tracking-tight">{{ formatDateTime(record.check_in_time).time }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-on-surface">
                                    <span v-if="record.check_out_time" class="text-xs font-mono tracking-tight">{{ formatDateTime(record.check_out_time).time }}</span>
                                    <span v-else class="text-[9px] font-black uppercase text-amber-500 animate-pulse tracking-widest">On-Duty</span>
                                </td>
                            </tr>
                            <tr v-if="filteredAttendances.length === 0">
                                <td colspan="5" class="px-6 py-12 text-center text-outline font-medium text-sm border-t border-outline-variant/10">No attendance records found.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                    </div>
                </div>

                <!-- Sidebar Calendar -->
                <div class="md:col-span-4 lg:col-span-3 space-y-6 print:hidden">
                    <CalendarWidget 
                        v-model="selectedDate" 
                        :visits="visits" 
                    />
                    
                    <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm flex flex-col gap-2">
                        <span class="text-[10px] font-bold text-outline uppercase tracking-widest">Active Filter Date</span>
                        <span class="text-xl font-headline font-extrabold text-primary">{{ selectedDate ? new Date(selectedDate).toLocaleDateString('en-US', { day: 'numeric', month: 'long', year: 'numeric' }) : 'All Time' }}</span>
                        <button v-if="selectedDate" @click="selectedDate = null" class="mt-2 text-xs font-bold text-secondary text-left hover:underline">Clear Date Filter</button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
@media print {
    /* Hide scrollbars for overflow containers */
    .overflow-y-auto {
        overflow: visible !important;
        height: auto !important;
    }
    
    /* Ensure the table is fully visible */
    table {
        page-break-inside: auto;
    }
    
    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }

    /* Standard print cleanup */
    thead {
        display: table-header-group;
    }
}
</style>
