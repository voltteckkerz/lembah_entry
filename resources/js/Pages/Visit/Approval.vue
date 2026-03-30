<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    pendingVisits: Array,
});

const form = useForm({
    status: ''
});

const actionSuccess = ref(false);
const lastActionedVisit = ref(null);

const updateStatus = (visit, newStatus) => {
    form.status = newStatus;
    form.patch(route('approvals.update', visit.visit_id), {
        onSuccess: () => {
            actionSuccess.value = true;
            lastActionedVisit.value = visit;
            setTimeout(() => {
                actionSuccess.value = false;
            }, 5000);
        }
    });
};
</script>

<template>
    <Head title="Access Approval - VMS Portal" />
    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto p-8">
            <!-- Editorial Header -->
            <header class="mb-12 flex justify-between items-end">
                <div>
                    <span class="text-[#620814] font-bold text-sm tracking-[0.2em] uppercase mb-2 block">Control Center</span>
                    <h2 class="text-4xl font-headline font-black text-[#620814] tracking-tighter leading-none">Access Approval</h2>
                    <p class="text-stone-500 mt-4 max-w-md font-medium">Review and manage site access requests. Decisions made here are logged and synchronized across the heritage security network.</p>
                </div>
                <!-- Filter Pills -->
                <div class="flex gap-2 p-1 bg-white border border-stone-100 rounded-xl shadow-sm">
                    <button class="px-6 py-2 rounded-lg text-sm font-bold bg-[#fbf9f8] text-[#620814] shadow-sm transition-all border border-stone-200">Pending</button>
                    <button class="px-6 py-2 rounded-lg text-sm font-medium text-stone-500 hover:text-[#620814] transition-all">All Requests</button>
                </div>
            </header>

            <!-- Dynamic Feedback Message (Success) -->
            <transition enter-active-class="transition ease-out duration-300 transform" enter-from-class="opacity-0 -translate-y-4" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div v-if="actionSuccess && lastActionedVisit" class="mb-8 flex items-center gap-4 p-4 bg-emerald-50 text-emerald-800 rounded-xl border border-emerald-200 shadow-sm animate-pulse">
                    <span class="material-symbols-outlined text-emerald-600" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    <div class="flex-1">
                        <p class="text-sm font-bold">Status Updated</p>
                        <p class="text-xs opacity-80 font-medium">Visit {{ lastActionedVisit.pass_number }} has been marked as {{ form.status }}.</p>
                    </div>
                    <button @click="actionSuccess = false" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
            </transition>

            <!-- Approval Table -->
            <div class="bg-white rounded-2xl shadow-[0_20px_40px_-15px_rgba(62,0,7,0.06)] border border-stone-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#fbf9f8] border-b border-stone-100">
                            <th class="px-8 py-5 text-xs font-black text-stone-500 uppercase tracking-widest">Pass No</th>
                            <th class="px-8 py-5 text-xs font-black text-stone-500 uppercase tracking-widest">Visitor</th>
                            <th class="px-8 py-5 text-xs font-black text-stone-500 uppercase tracking-widest">Purpose</th>
                            <th class="px-8 py-5 text-xs font-black text-stone-500 uppercase tracking-widest text-center">Status</th>
                            <th class="px-8 py-5 text-xs font-black text-stone-500 uppercase tracking-widest text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 font-body">
                        <tr v-for="visit in pendingVisits" :key="visit.visit_id" class="group hover:bg-stone-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <span class="font-headline font-bold text-[#620814] tracking-tight">{{ visit.pass_number }}</span>
                                <p class="text-xs text-stone-400 mt-1">{{ new Date(visit.visit_date).toLocaleDateString() }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-[#620814]/5 flex items-center justify-center text-[#620814] font-black text-xs uppercase">
                                        {{ visit.visitors && visit.visitors.length > 0 ? visit.visitors[0].name.substring(0, 2) : '?' }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-stone-800 leading-none">
                                            {{ visit.visitors && visit.visitors.length > 0 ? visit.visitors[0].name : 'Unknown' }}
                                        </p>
                                        <p class="text-xs text-stone-500 mt-1 font-mono">{{ visit.visitors && visit.visitors.length > 0 ? visit.visitors[0].ic_number : '-' }}</p>
                                        <p v-if="visit.visitors.length > 1" class="text-[10px] text-stone-400 font-bold mt-0.5">+{{ visit.visitors.length - 1 }} others</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <p class="text-sm text-stone-700 italic font-medium">"{{ visit.purpose }}"</p>
                                <p class="text-xs text-stone-400 mt-1">Host: {{ visit.employee ? visit.employee.name : 'Unknown' }}</p>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter bg-amber-100 text-amber-800">
                                    {{ visit.status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-3">
                                    <Link :href="route('visits.pass', visit.visit_id)" class="px-5 py-2 bg-gradient-to-br from-[#3e0007] to-[#620814] text-white text-[10px] uppercase tracking-widest font-bold rounded-lg hover:shadow-lg shadow-[0_10px_20px_rgba(98,8,20,0.1)] transition-all active:scale-95 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">draw</span> Review & Sign
                                    </Link>
                                    <button @click="updateStatus(visit, 'Rejected')" :disabled="form.processing && form.status === 'Rejected'" class="px-5 py-2 border border-stone-200 text-stone-600 text-[10px] uppercase tracking-widest font-bold rounded-lg hover:bg-red-50 hover:text-red-700 hover:border-red-200 transition-all disabled:opacity-50">
                                        Reject
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="pendingVisits.length === 0">
                            <td colspan="5" class="px-8 py-16 text-center text-stone-500 font-medium bg-[#fbf9f8]">
                                <div class="flex flex-col items-center gap-3">
                                    <span class="material-symbols-outlined text-4xl text-stone-300">verified</span>
                                    <p>No pending approvals at the moment.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Pagination / Summary Bar -->
                <div v-if="pendingVisits.length > 0" class="px-8 py-5 bg-[#fbf9f8] border-t border-stone-100 flex justify-between items-center">
                    <p class="text-xs text-stone-500 font-medium">Showing {{ pendingVisits.length }} pending approvals</p>
                </div>
            </div>

            <!-- Secondary Informational Section -->
            <section class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="col-span-1 bg-amber-50 border border-amber-100 p-8 rounded-2xl relative overflow-hidden group">
                    <div class="relative z-10">
                        <h3 class="font-headline font-black text-amber-900 text-xl mb-2">Security Notice</h3>
                        <p class="text-amber-800/80 text-sm font-medium">Verify identification for all maintenance access requests.</p>
                    </div>
                </div>
                <div class="col-span-1 md:col-span-2 bg-white border border-stone-100 shadow-[0_10px_30px_rgba(27,28,28,0.03)] p-8 rounded-2xl flex items-center justify-between">
                    <div class="max-w-md">
                        <h3 class="font-headline font-bold text-[#620814] text-lg mb-2">Signature E-Pass</h3>
                        <p class="text-stone-500 text-sm font-body">All authorizations are now securely processed through the interactive 4-signature E-Pass. Review the guest's profile before digitally authenticating the visit.</p>
                    </div>
                    <div class="flex -space-x-3">
                        <div class="w-12 h-12 rounded-full border-2 border-white bg-green-100 text-green-700 flex items-center justify-center font-bold text-sm z-30">92%</div>
                        <div class="w-12 h-12 rounded-full border-2 border-white bg-stone-100 text-stone-500 flex items-center justify-center font-bold text-[10px] z-20 overflow-hidden">
                            <span class="material-symbols-outlined text-lg">trending_up</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
