<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    visits: Array,
    attendances: Array,
});

const activeTab = ref('visitors'); // 'visitors' or 'staff'
const searchQuery = ref('');

const formatDateTime = (dateString, timeString = null) => {
    if (!dateString && !timeString) return '-';
    
    // If it's a full ISO string (like from timestamps)
    if (dateString && dateString.includes('T')) {
        const d = new Date(dateString);
        return {
            date: d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }),
            time: d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
        };
    }
    
    // If date and time are separate fields (like in Visits)
    const datePart = dateString ? new Date(dateString).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : '';
    const timePart = timeString ? timeString.substring(0, 5) : '';
    
    return {
        date: datePart,
        time: timePart
    };
};

const getStatusColor = (status) => {
    switch (status) {
        case 'Active': return 'bg-blue-100 text-blue-800 border-blue-200';
        case 'Checked Out': return 'bg-green-100 text-green-800 border-green-200';
        case 'Rejected': return 'bg-red-100 text-red-800 border-red-200';
        case 'Pending': return 'bg-amber-100 text-amber-800 border-amber-200';
        default: return 'bg-gray-100 text-gray-800 border-gray-200';
    }
};

const filteredVisits = computed(() => {
    if (!searchQuery.value) return props.visits;
    const lowerQuery = searchQuery.value.toLowerCase();
    return props.visits.filter(v => 
        v.pass_number.toLowerCase().includes(lowerQuery) || 
        v.purpose.toLowerCase().includes(lowerQuery) ||
        (v.visitors && v.visitors.some(vis => vis.name.toLowerCase().includes(lowerQuery) || vis.ic_number.toLowerCase().includes(lowerQuery)))
    );
});

const filteredAttendances = computed(() => {
    if (!searchQuery.value) return props.attendances;
    const lowerQuery = searchQuery.value.toLowerCase();
    return props.attendances.filter(a => 
        (a.staff && a.staff.name.toLowerCase().includes(lowerQuery)) ||
        (a.staff && a.staff.department.toLowerCase().includes(lowerQuery)) ||
        (a.vehicle_plate && a.vehicle_plate.toLowerCase().includes(lowerQuery))
    );
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
                <div class="flex gap-4">
                    <button class="bg-surface-container-lowest text-on-surface px-6 py-3 rounded-lg font-bold flex items-center gap-2 transition-all hover:bg-surface-container shadow-sm border border-outline-variant/10">
                        <span class="material-symbols-outlined text-xl" data-icon="picture_as_pdf">picture_as_pdf</span>
                        Export Summary
                    </button>
                    <button class="bg-secondary text-white px-6 py-3 rounded-lg font-bold flex items-center gap-2 transition-all hover:opacity-90 shadow-sm">
                        <span class="material-symbols-outlined text-xl" data-icon="download">download</span>
                        Excel Data
                    </button>
                </div>
            </div>

            <!-- Tab Navigation & Search -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-surface-container-low p-2 rounded-xl">
                <div class="flex gap-2 w-full md:w-auto p-1 bg-surface-container-lowest rounded-lg">
                    <button @click="activeTab = 'visitors'" :class="activeTab === 'visitors' ? 'bg-primary text-white shadow-md' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface'" class="px-6 py-2.5 rounded-md font-bold text-sm tracking-wide transition-all w-full md:w-auto">
                        Visitor Logs
                    </button>
                    <button @click="activeTab = 'staff'" :class="activeTab === 'staff' ? 'bg-primary text-white shadow-md' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface'" class="px-6 py-2.5 rounded-md font-bold text-sm tracking-wide transition-all w-full md:w-auto">
                        Staff Attendance
                    </button>
                </div>
                
                <div class="relative group w-full md:w-80">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant" data-icon="search">search</span>
                    <input v-model="searchQuery" class="w-full bg-white border border-outline-variant/20 py-2.5 pl-10 pr-4 rounded-lg focus:ring-2 focus:ring-primary/20 text-sm focus:border-primary transition-all shadow-sm outline-none" placeholder="Search records..." type="text"/>
                </div>
            </div>

            <!-- Data Table Section -->
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/10 overflow-hidden shadow-sm">
                
                <!-- VISITOR TAB -->
                <div v-if="activeTab === 'visitors'" class="overflow-x-auto h-[600px] overflow-y-auto">
                    <table class="w-full border-collapse text-left">
                        <thead class="sticky top-0 bg-surface-container-lowest z-10 border-b border-outline-variant/10 shadow-sm">
                            <tr class="font-label">
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Pass / Date</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Primary Visitor</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Purpose</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Host</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container">
                            <tr v-for="visit in filteredVisits" :key="visit.visit_id" class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-on-surface font-mono text-sm tracking-tight text-secondary">{{ visit.pass_number }}</span>
                                        <span class="text-[10px] text-outline mt-0.5 truncate">{{ formatDateTime(visit.visit_date, visit.check_in_time).date }} {{ formatDateTime(visit.visit_date, visit.check_in_time).time }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div v-if="visit.visitors && visit.visitors.length > 0">
                                        <div class="font-bold text-sm text-on-surface">{{ visit.visitors[0].name }}</div>
                                        <div class="text-[10px] text-outline mt-0.5 font-mono">{{ visit.visitors[0].ic_number }} <span v-if="visit.visitors.length > 1" class="ml-1 text-primary"> (+{{ visit.visitors.length - 1 }})</span></div>
                                    </div>
                                    <div v-else class="text-xs text-outline italic">No Visitor Attached</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-on-surface truncate max-w-xs">{{ visit.purpose }}</div>
                                    <div v-if="visit.vehicles && visit.vehicles.length > 0" class="text-[10px] text-outline font-mono mt-0.5 border border-outline-variant/30 inline-block px-1 rounded">{{ visit.vehicles[0].plate_number }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-on-surface">
                                    {{ visit.employee ? visit.employee.name : 'Unknown Host' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span :class="['inline-flex items-center px-2.5 py-1 rounded border text-[10px] font-bold uppercase tracking-widest', getStatusColor(visit.status)]">
                                        {{ visit.status }}
                                    </span>
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
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Date / Time</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Staff Name</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Department</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Vehicle Plate</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Duration</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container">
                            <tr v-for="record in filteredAttendances" :key="record.attendance_id" class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-on-surface text-sm">{{ formatDateTime(record.check_in_time).date }}</span>
                                        <span class="text-xs text-outline mt-0.5">
                                            {{ formatDateTime(record.check_in_time).time }} 
                                            <span v-if="record.check_out_time" class="text-xs text-outline"> → {{ formatDateTime(record.check_out_time).time }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center font-bold text-primary overflow-hidden uppercase text-[10px]">
                                            {{ record.staff ? record.staff.name.substring(0,2) : 'ST' }}
                                        </div>
                                        <span class="font-bold text-sm text-on-surface">{{ record.staff ? record.staff.name : 'Unknown Staff' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-on-surface">
                                    {{ record.staff ? record.staff.department : 'Operations' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span v-if="record.vehicle_plate" class="text-[10px] font-mono font-bold uppercase bg-stone-100 text-stone-600 border border-stone-200 px-2 py-1 rounded">{{ record.vehicle_plate }}</span>
                                    <span v-else class="text-xs text-outline italic">N/A</span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-on-surface">
                                    <span v-if="record.check_out_time" class="text-green-600">{{ calculateDuration(record.check_in_time, record.check_out_time) }}</span>
                                    <span v-else class="text-amber-500 animate-pulse text-xs tracking-wider uppercase font-bold">Active Shift</span>
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
    </AuthenticatedLayout>
</template>
