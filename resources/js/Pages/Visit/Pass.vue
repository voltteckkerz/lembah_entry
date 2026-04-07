<script setup>
import { Head, usePage, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    visit: Object,
});

const page = usePage();
const userRole = computed(() => {
    return page.props.auth.user ? page.props.auth.user.role.toLowerCase() : '';
});

const formatDateTime = (dateString, timeString = null) => {
    if (!dateString) return '-';
    const datePart = new Date(dateString).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    const timePart = timeString ? new Date('1970-01-01T' + timeString + 'Z').toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : '';
    return `${datePart} ${timePart}`;
};

const printPass = () => {
    window.print();
};
</script>

<template>
    <Head :title="`Visitor Pass - ${visit.pass_number}`" />
    
    <div class="min-h-screen bg-stone-100 font-body py-12 flex justify-center print:bg-white print:py-0 print:block">
        
        <!-- On-screen Print Controls (Hidden when printing) -->
        <div class="fixed top-6 right-6 flex gap-4 print:hidden z-50">
            <Link :href="route('visits.create')" class="px-6 py-2 bg-white text-stone-600 font-bold rounded-lg shadow-sm hover:bg-stone-50 border border-stone-200 transition-colors">
                Go Back
            </Link>
            <button v-if="userRole === 'guard'" @click="printPass" class="px-6 py-2 bg-[#3e0007] text-white font-bold rounded-lg shadow-lg hover:opacity-90 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">print</span> Print Pass
            </button>
        </div>

        <!-- The Printable Visitor Pass -->
        <div class="w-[800px] h-[1130px] bg-white shadow-2xl relative overflow-hidden print:shadow-none print:w-full print:h-auto print:max-w-none print:m-0 border border-stone-200 print:border-none mx-auto p-12 flex flex-col justify-between">
            
            <!-- Header section -->
            <div>
                <div class="flex justify-between items-start border-b-4 border-[#3e0007] pb-8 mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-[#3e0007] rounded-xl flex items-center justify-center text-white">
                            <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">museum</span>
                        </div>
                        <div>
                            <h1 class="text-3xl font-headline font-black text-[#3e0007] tracking-tight uppercase">Sari Heritage Center</h1>
                            <p class="text-stone-500 font-bold text-sm uppercase tracking-widest mt-1">Official Visitor Pass</p>
                        </div>
                    </div>
                    <div class="text-right flex flex-col items-end">
                        <div class="font-mono text-3xl font-extrabold text-stone-800 tracking-wider">{{ visit.pass_number }}</div>
                        <img class="mt-2 opacity-50 h-10 object-contain" :src="`https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${visit.pass_number}`" alt="QR Code" />
                    </div>
                </div>

                <!-- Primary Data Grid -->
                <div class="grid grid-cols-2 gap-x-12 gap-y-8 mb-12">
                    
                    <!-- Guest Details -->
                    <div class="space-y-6">
                        <div>
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1 border-b border-stone-200 pb-1">Primary Guest Name</p>
                            <p class="text-xl font-bold text-stone-800">{{ visit.visitors[0]?.name || 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1 border-b border-stone-200 pb-1">IC / Passport Number</p>
                            <p class="text-lg font-mono font-medium text-stone-700">{{ visit.visitors[0]?.ic_number || 'N/A' }}</p>
                        </div>
                        <div v-if="visit.visitors.length > 1">
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1 border-b border-stone-200 pb-1">Additional Accompanying Guests</p>
                            <ul class="text-sm font-medium text-stone-700 list-disc pl-4 mt-2">
                                <li v-for="(v, idx) in visit.visitors.slice(1)" :key="idx">{{ v.name }} <span class="text-xs text-stone-400 font-mono ml-2">({{ v.ic_number }})</span></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Visit Specifics -->
                    <div class="space-y-6">
                        <div>
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1 border-b border-stone-200 pb-1">Sponsoring Host / Department</p>
                            <div class="flex items-center gap-2">
                                <p class="text-xl font-bold text-[#3e0007]">{{ visit.employee?.name || 'Unknown' }}</p>
                            </div>
                            <p class="text-sm text-stone-500 mt-0.5">{{ visit.employee?.department || 'Operations' }} Department</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1 border-b border-stone-200 pb-1">Date & Purpose of entry</p>
                            <p class="text-lg font-bold text-stone-800">{{ formatDateTime(visit.visit_date).split(' ')[0] }} <span class="text-sm text-stone-500 ml-2 font-medium">{{ formatDateTime(visit.visit_date).split(' ')[1] }} {{ formatDateTime(visit.visit_date).split(' ')[2] }}</span></p>
                            <p class="text-sm text-stone-600 italic mt-1 font-medium bg-stone-50 px-3 py-2 rounded-md">" {{ visit.purpose }} "</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1 border-b border-stone-200 pb-1">Time In</p>
                                <p class="text-lg font-mono font-medium text-stone-700 h-8">{{ visit.check_in_time ? formatDateTime(visit.visit_date, visit.check_in_time).split(' ').slice(1).join(' ') : '' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1 border-b border-stone-200 pb-1">Time Out</p>
                                <p class="text-lg font-mono font-medium text-stone-700 h-8">{{ visit.check_out_time ? formatDateTime(visit.visit_date, visit.check_out_time).split(' ').slice(1).join(' ') : '' }}</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Logistics Box (Vehicles & Items) -->
                <div v-if="visit.vehicles?.length > 0 || visit.items?.length > 0" class="border-2 border-dashed border-stone-200 rounded-xl p-6 mb-12 bg-[#fbf9f8]">
                    <div class="grid grid-cols-2 gap-8">
                        <div v-if="visit.vehicles?.length > 0">
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-3 flex items-center gap-2"><span class="material-symbols-outlined text-sm">directions_car</span> Registered Vehicle</p>
                            <div class="flex flex-col">
                                <span class="bg-stone-200 text-stone-800 font-mono font-bold text-lg px-4 py-2 border border-stone-300 rounded text-center uppercase tracking-widest">{{ visit.vehicles[0].plate_number }}</span>
                                <span class="text-xs text-stone-500 text-center mt-1 uppercase">{{ visit.vehicles[0].vehicle_type }}</span>
                            </div>
                        </div>
                        <div v-if="visit.items?.length > 0">
                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-3 flex items-center gap-2"><span class="material-symbols-outlined text-sm">inventory_2</span> Declared Items</p>
                            <ul class="text-sm font-medium text-stone-700 space-y-1">
                                <li v-for="item in visit.items" :key="item.item_id" class="flex justify-between border-b border-stone-200 pb-1">
                                    <span>{{ item.quantity }}x {{ item.item_name }}</span>
                                    <span class="text-[10px] text-stone-400 truncate max-w-[100px]">{{ item.remarks }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Pass verification Footer -->
            <div class="border-t-2 border-stone-200 pt-8 mt-auto">
                <p class="text-[9px] text-stone-400 text-center uppercase tracking-wider">This e-pass remains the property of Sari Heritage Center. Unauthorized reproduction is strictly prohibited.</p>
            </div>

        </div>
    </div>
</template>

<style>
@media print {
    body {
        margin: 0;
        padding: 0;
        background: white;
    }
}
</style>
