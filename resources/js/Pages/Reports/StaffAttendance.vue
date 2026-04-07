<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

const props = defineProps({
    attendances: Array,
    date: String
});

const formatTime = (timeString) => {
    if (!timeString) return '-';
    return new Date(timeString).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });
};

const formatDate = (dateString) => {
    if (!dateString) return '-';
    const d = new Date(dateString);
    return `${d.getDate()}/${d.getMonth() + 1}/${d.getFullYear()}`;
};

const printedDate = computed(() => {
    const d = new Date();
    return `${d.getDate()}/${d.getMonth() + 1}/${d.getFullYear()}`;
});

const printReport = () => {
    window.print();
};

const exportToExcel = () => {
    // Basic CSV Export
    let csvContent = "data:text/csv;charset=utf-8,";
    // Header
    const headers = ["Name", "Date", "Vehicle No", "Time In", "Time Out"];
    csvContent += headers.join(",") + "\n";
    
    // Rows
    props.attendances.forEach(att => {
        const rowData = [
            `\"${att.employee?.name || '-'}\"`,
            `\"${formatDate(att.check_in_time).replace(/\//g, '-')}\"`,
            `\"${att.vehicle_plate || '-'}\"`,
            `\"${formatTime(att.check_in_time)}\"`,
            `\"${formatTime(att.check_out_time)}\"`
        ];
        csvContent += rowData.join(",") + "\n";
    });

    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    // Filename follows the date as requested
    const fileName = `Staff_Attendance_${props.date}.csv`;
    link.setAttribute("download", fileName);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};

onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('print') === '1') {
        // Short delay to ensure styles and data are rendered
        setTimeout(() => window.print(), 800);
    }
});
</script>

<template>
    <Head title="Staff Attendance Report" />

    <div class="min-h-screen bg-stone-50 py-8 print:bg-white print:py-0">
        <!-- Controls -->
        <div class="max-w-[1000px] mx-auto mb-6 flex justify-between items-center print:hidden px-4">
            <Link :href="route('dashboard')" class="text-sm font-bold text-stone-500 hover:text-primary flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">arrow_back</span> Back to Dashboard
            </Link>
            <div class="flex items-center gap-2">
                <button @click="exportToExcel" class="bg-emerald-600 text-white px-6 py-2 rounded-lg font-bold shadow-lg hover:opacity-90 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">download</span> Excel Export
                </button>
                <button @click="printReport" class="bg-primary text-white px-6 py-2 rounded-lg font-bold shadow-lg hover:opacity-90 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">print</span> Print Report
                </button>
            </div>
        </div>

        <!-- Report Sheet -->
        <div class="max-w-[1000px] mx-auto bg-white shadow-xl p-12 print:shadow-none print:p-4 min-h-[11in] print:min-h-0">
            <!-- Header -->
            <div class="flex justify-between items-start mb-8">
                <div>
                    <div class="flex items-center mb-1">
                        <img src="/images/LSSB logo.jpg" alt="Lembah Sari Logo" class="h-14 w-auto object-contain" />
                    </div>
                    <div class="h-1 w-full bg-[#3e0007] opacity-20 mt-1"></div>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-stone-500 uppercase tracking-widest">Lembah Sari Visitor Management System</p>
                    <h1 class="text-2xl font-black text-[#3e0007] mt-1 italic tracking-tight uppercase">LSSB STAFF IN / OUT</h1>
                    <p class="text-[10px] font-bold text-stone-400 mt-2 uppercase tracking-widest">Printed Date : <span class="text-stone-700 ml-2 font-mono">{{ printedDate }}</span></p>
                </div>
            </div>

            <!-- Title Header -->
            <div class="text-center border-y-2 border-stone-200 py-3 mb-8 bg-stone-50/30">
                <h2 class="text-xl font-black text-stone-800 tracking-[0.2em] uppercase">LSSB STAFF - ATTENDANCE ( A.M - P.M )</h2>
            </div>

            <!-- Data Table -->
            <table class="w-full border-collapse report-table">
                <thead>
                    <tr class="bg-stone-100/50">
                        <th class="border border-stone-300 px-4 py-2 text-left text-xs font-black uppercase tracking-wider text-stone-600">Name</th>
                        <th class="border border-stone-300 px-4 py-2 text-left text-xs font-black uppercase tracking-wider text-stone-600">Date</th>
                        <th class="border border-stone-300 px-4 py-2 text-left text-xs font-black uppercase tracking-wider text-stone-600">Vehicle No</th>
                        <th class="border border-stone-300 px-4 py-2 text-left text-xs font-black uppercase tracking-wider text-stone-600">Time In</th>
                        <th class="border border-stone-300 px-4 py-2 text-left text-xs font-black uppercase tracking-wider text-stone-600">Time Out</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="attendances.length === 0">
                        <td colspan="5" class="border border-stone-300 px-4 py-8 text-center text-stone-400 italic font-medium">No staff attendance recorded for this date.</td>
                    </tr>
                    <tr v-for="att in attendances" :key="att.attendance_id">
                        <td class="border border-stone-300 px-4 py-3 text-sm font-bold text-stone-800 uppercase">{{ att.employee?.name || '-' }}</td>
                        <td class="border border-stone-300 px-4 py-3 text-sm font-mono text-stone-600">{{ formatDate(att.check_in_time) }}</td>
                        <td class="border border-stone-300 px-4 py-3 text-sm font-mono font-bold text-stone-700 uppercase">{{ att.vehicle_plate || '-' }}</td>
                        <td class="border border-stone-300 px-4 py-3 text-sm font-mono text-stone-600">{{ formatTime(att.check_in_time) }}</td>
                        <td class="border border-stone-300 px-4 py-3 text-sm font-mono text-stone-600">{{ formatTime(att.check_out_time) }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Footer -->
            <div class="mt-12 pt-8 border-t border-stone-100 flex justify-between items-end">
                <div class="space-y-12">
                    <div class="w-48 border-b border-stone-400"></div>
                </div>
                <p class="text-[9px] text-stone-300 font-medium italic">Generated by Lembah Sari VMS Portal - Automated Report Service</p>
            </div>
        </div>
    </div>
</template>

<style scoped>
.report-table th {
    background-color: #fafaf9;
}
@media print {
    .print\:hidden {
        display: none !important;
    }
    body {
        background: white !important;
    }
}
</style>
