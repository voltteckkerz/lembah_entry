<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import CalendarWidget from '@/Components/CalendarWidget.vue';

const props = defineProps({
    stats: Object,
    recentVisits: Array,
    calendarVisits: Array,
    supportRequests: Array,
});

const actionForm = useForm({});

const checkInVisitor = (visit) => {
    actionForm.patch(route('visits.checkin', visit.visit_id));
};

const checkOutVisitor = (visit) => {
    actionForm.patch(route('visits.checkout', visit.visit_id));
};

const resolveRequest = (requestId) => {
    actionForm.patch(route('support.resolve', requestId));
};

const selectedDate = ref(new Date().toISOString().split('T')[0]);

const dailyVisits = computed(() => {
    return props.calendarVisits?.filter(v => v.visit_date === selectedDate.value) || [];
});

const formatDate = (dateStr) => {
    return new Date(dateStr).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
};

const getStatusColor = (status) => {
    switch (status) {
        case 'Approved': return 'bg-emerald-50 text-emerald-700 border border-emerald-200';
        case 'Active': return 'bg-sky-50 text-sky-700 border border-sky-200';
        case 'Checked Out': return 'bg-stone-100 text-stone-600 border border-stone-200';
        case 'Rejected': return 'bg-red-50 text-red-700 border border-red-200';
        case 'Pending': return 'bg-orange-50 text-orange-700 border border-orange-200';
        default: return 'bg-stone-100 text-stone-600 border border-stone-200';
    }
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto p-8">
            <!-- Dashboard Header -->
            <div class="mb-10 flex justify-between items-end">
                <div>
                    <h1 class="text-4xl font-headline font-extrabold text-primary tracking-tight mb-2">Welcome back, {{ $page.props.auth.user.name }}</h1>
                    <p class="text-on-surface-variant font-medium">Here is what's happening at the Heritage Center today.</p>
                </div>
            </div>

            <!-- Admin Support Alerts (Only for Admin) -->
            <div v-if="$page.props.auth.user.role === 'Admin' && supportRequests && supportRequests.length > 0" class="mb-10 space-y-4">
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-error animate-pulse">priority_high</span>
                    <h2 class="text-lg font-headline font-extrabold text-primary uppercase tracking-tight">Pending Support Alerts</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="req in supportRequests" :key="req.support_id" class="bg-white border-l-4 border-error p-5 rounded-xl shadow-lg shadow-error/5 flex flex-col justify-between group relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-error bg-error/10 px-2 py-0.5 rounded">Password Reset</span>
                                <span class="text-[9px] font-mono text-stone-400 font-bold uppercase">{{ new Date(req.created_at).toLocaleTimeString() }}</span>
                            </div>
                            <h4 class="font-bold text-stone-800 text-sm mb-1 uppercase tracking-tight">Guard: <span class="text-primary">{{ req.username }}</span></h4>
                            <p class="text-xs text-stone-500 leading-relaxed mb-4">Guard is unable to log in and requires a manual password reset from the User Management panel.</p>
                        </div>
                        <div class="mt-2 flex gap-2 relative z-10">
                            <button @click="resolveRequest(req.support_id)" class="flex-1 py-2.5 bg-stone-100 text-stone-600 rounded-lg text-[10px] font-bold uppercase tracking-widest hover:bg-stone-200 transition-all active:scale-95">
                                Dismiss
                            </button>
                            <a :href="route('users.index')" class="flex-1 py-2.5 bg-primary text-white rounded-lg text-[10px] font-bold uppercase tracking-widest hover:opacity-90 transition-all flex items-center justify-center gap-2 shadow-sm active:scale-95">
                                <span class="material-symbols-outlined text-sm">manage_accounts</span>
                                Reset
                            </a>
                        </div>
                        <!-- Decorative background element -->
                        <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-error/5 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    </div>
                </div>
            </div>

            <!-- Metric Cards: Layering Principle -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-surface-container-lowest p-8 rounded-xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-outlined text-6xl text-primary">group</span>
                    </div>
                    <p class="text-on-surface-variant font-bold text-sm uppercase tracking-widest mb-4">Total Visitors Today</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-headline font-extrabold text-primary">{{ stats.totalVisitorsToday }}</span>
                        <span class="text-secondary font-bold text-sm">Visits</span>
                    </div>
                    <div class="mt-6 h-1 w-full bg-surface-container rounded-full overflow-hidden">
                        <div class="h-full bg-primary w-3/4 rounded-full"></div>
                    </div>
                </div>

                <div class="bg-surface-container-lowest p-8 rounded-xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-outlined text-6xl text-secondary">meeting_room</span>
                    </div>
                    <p class="text-on-surface-variant font-bold text-sm uppercase tracking-widest mb-4">Active Visitors (Inside)</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-headline font-extrabold text-primary">{{ stats.activeVisitors }}</span>
                        <span class="text-on-surface-variant font-medium text-sm">currently on site</span>
                    </div>
                    <div class="mt-6 h-1 w-full bg-surface-container rounded-full overflow-hidden">
                        <div class="h-full bg-secondary w-2/3 rounded-full"></div>
                    </div>
                </div>

                <div class="bg-surface-container-lowest p-8 rounded-xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-outlined text-6xl text-on-tertiary-container">badge</span>
                    </div>
                    <p class="text-on-surface-variant font-bold text-sm uppercase tracking-widest mb-4">Staff Checked-in</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-headline font-extrabold text-primary">{{ stats.staffPresent }}</span>
                        <span class="text-on-surface-variant font-medium text-sm">present today</span>
                    </div>
                    <div class="mt-6 h-1 w-full bg-surface-container rounded-full overflow-hidden">
                        <div class="h-full bg-tertiary-container w-4/5 rounded-full"></div>
                    </div>
                </div>
            </div>

            <!-- Main Grid: Bento Style -->
            <div class="grid grid-cols-12 gap-8">
                <!-- Visitor Activity Feed (Left) -->
                <div class="col-span-12 lg:col-span-8 space-y-6">
                    <div class="bg-surface-container-low rounded-xl p-6">
                        <div class="flex justify-between items-center mb-8">
                            <h3 class="text-xl font-headline font-extrabold text-primary">Recent Visitor Activity</h3>
                            <button class="text-secondary font-bold text-sm hover:underline">View All</button>
                        </div>

                        <div class="space-y-4">
                            <!-- Activity Item -->
                            <div v-for="visit in recentVisits" :key="visit.visit_id" class="bg-surface-container-lowest p-4 rounded-lg flex items-center justify-between group transition-all hover:translate-x-1">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold"
                                         :class="visit.status === 'Active' ? 'bg-sky-100 text-sky-700' : 'bg-orange-100 text-orange-700'">
                                        {{ visit.visitors && visit.visitors.length > 0 ? visit.visitors[0].name.substring(0,2).toUpperCase() : 'V' }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-on-surface">{{ visit.visitors && visit.visitors.length > 0 ? visit.visitors[0].name : 'Unknown Visitor' }}</h4>
                                        <p class="text-xs text-on-surface-variant">Check-in: {{ visit.check_in_time ? new Date(visit.check_in_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : 'Pending' }} • Host: {{ visit.employee ? visit.employee.name : 'Unknown' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span v-if="visit.status === 'Approved' || visit.status === 'Active'" 
                                          class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tight"
                                          :class="getStatusColor(visit.status)">
                                        {{ visit.status }}
                                    </span>
                                    <span v-else class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tight"
                                          :class="getStatusColor(visit.status)">
                                        {{ visit.status }}
                                    </span>

                                    <!-- Action Menu restricted by role/status -->
                                    <Menu v-if="($page.props.auth.user.role === 'guard') || (visit.status === 'Approved' || visit.status === 'Active')" as="div" class="relative inline-block text-left">
                                        <MenuButton class="p-2 text-on-surface-variant hover:text-primary transition-colors flex items-center justify-center rounded-full hover:bg-primary/5">
                                            <span class="material-symbols-outlined">more_vert</span>
                                        </MenuButton>

                                        <transition 
                                            enter-active-class="transition ease-out duration-100" 
                                            enter-from-class="transform opacity-0 scale-95" 
                                            enter-to-class="transform scale-100" 
                                            leave-active-class="transition ease-in duration-75" 
                                            leave-from-class="transform scale-100" 
                                            leave-to-class="transform opacity-0 scale-95"
                                        >
                                            <MenuItems class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-xl bg-white/95 backdrop-blur-xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] ring-1 ring-black/5 focus:outline-none overflow-hidden border border-stone-100/50">
                                                <div class="py-1">
                                                    <div class="px-4 py-2 border-b border-stone-100 mb-1">
                                                        <p class="text-[9px] font-bold text-stone-400 uppercase tracking-widest">Entry Actions</p>
                                                    </div>

                                                    <MenuItem v-if="visit.status === 'Approved' || visit.status === 'Active'" v-slot="{ active }">
                                                        <Link 
                                                            :href="route('visits.pass', visit.visit_id)" 
                                                            :class="[active ? 'bg-stone-50 text-primary' : 'text-stone-600', 'flex items-center gap-3 px-4 py-2.5 text-sm transition-colors cursor-pointer font-medium']"
                                                        >
                                                            <span class="material-symbols-outlined text-[18px] opacity-60">print</span>
                                                            Print Pass
                                                        </Link>
                                                    </MenuItem>

                                                    <MenuItem v-if="visit.status === 'Approved'" v-slot="{ active }">
                                                        <button 
                                                            @click="checkInVisitor(visit)"
                                                            :disabled="actionForm.processing"
                                                            :class="[active ? 'bg-primary/5 text-primary' : 'text-stone-600', 'flex w-full items-center gap-3 px-4 py-2.5 text-sm transition-colors cursor-pointer group disabled:opacity-50 font-medium']"
                                                        >
                                                            <span class="material-symbols-outlined text-[18px] opacity-60 group-hover:opacity-100">login</span>
                                                            Check-In
                                                        </button>
                                                    </MenuItem>

                                                    <MenuItem v-else-if="visit.status === 'Active' && $page.props.auth.user.role === 'guard'" v-slot="{ active }">
                                                        <button 
                                                            @click="checkOutVisitor(visit)"
                                                            :disabled="actionForm.processing"
                                                            :class="[active ? 'bg-red-50 text-red-600' : 'text-stone-600', 'flex w-full items-center gap-3 px-4 py-2.5 text-sm transition-colors cursor-pointer group disabled:opacity-50 font-medium']"
                                                        >
                                                            <span class="material-symbols-outlined text-[18px] opacity-60 group-hover:opacity-100">logout</span>
                                                            Checkout
                                                        </button>
                                                    </MenuItem>
                                                </div>
                                            </MenuItems>
                                        </transition>
                                    </Menu>
                                </div>
                            </div>
                            <div v-if="!recentVisits || recentVisits.length === 0" class="p-8 text-center text-on-surface-variant bg-surface-container-lowest rounded-xl">
                                No recent visitor activity.
                            </div>
                        </div>
                    </div>

                    <!-- Editorial Break Section -->
                    <div class="editorial-gradient rounded-xl p-8 flex flex-col md:flex-row items-center gap-8 relative overflow-hidden">
                        <div class="absolute inset-0 opacity-10 mix-blend-overlay pointer-events-none bg-black"></div>
                        <div class="relative z-10 space-y-4 md:w-2/3">
                            <h2 class="text-3xl font-headline font-extrabold text-white leading-tight">Streamlining Guest Access</h2>
                            <p class="text-white/80 font-medium">New pre-registration tools are now available for all departments to reduce lobby wait times by 40%.</p>
                            <button class="px-6 py-3 bg-white text-primary rounded-lg font-bold hover:bg-surface-bright transition-all active:scale-95">
                                Learn More
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar / Quick Actions -->
                <div class="col-span-12 lg:col-span-4 space-y-8">
                    <!-- Quick Actions -->
                    <div class="bg-surface-container-lowest rounded-xl p-6">
                        <h3 class="text-lg font-headline font-extrabold text-primary mb-6">Quick Actions</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <Link :href="route('visits.create')" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-surface-container-low hover:bg-secondary-fixed transition-colors group">
                                <span class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">person_add</span>
                                <span class="text-xs font-bold text-on-surface-variant">Pre-Register</span>
                            </Link>
                            <Link :href="route('attendance.index')" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-surface-container-low hover:bg-secondary-fixed transition-colors group">
                                <span class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">output</span>
                                <span class="text-xs font-bold text-on-surface-variant">Bulk Checkout</span>
                            </Link>
                            <button class="flex flex-col items-center gap-2 p-4 rounded-xl bg-surface-container-low hover:bg-secondary-fixed transition-colors group">
                                <span class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">description</span>
                                <span class="text-xs font-bold text-on-surface-variant">E-Logbook</span>
                            </button>
                            <button class="flex flex-col items-center gap-2 p-4 rounded-xl bg-surface-container-low hover:bg-secondary-fixed transition-colors group">
                                <span class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">emergency_share</span>
                                <span class="text-xs font-bold text-error">Evacuation</span>
                            </button>
                        </div>
                    </div>

                    <!-- Interactive Calendar Widget -->
                    <CalendarWidget 
                        v-model="selectedDate" 
                        :visits="calendarVisits" 
                    />

                    <!-- Scheduled Visits for Selected Day -->
                    <div class="bg-surface-container-lowest rounded-xl p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-sm font-headline font-extrabold text-primary uppercase tracking-widest">Visits on {{ formatDate(selectedDate) }}</h3>
                            <div class="flex items-center gap-2">
                                <Link :href="route('reports.visitor', { date: selectedDate })" class="p-1 px-2 bg-stone-100 hover:bg-primary/10 text-[#3e0007] text-[9px] font-bold rounded uppercase flex items-center gap-1 transition-colors" title="View Visitor Report">
                                    <span class="material-symbols-outlined text-xs">description</span> Visitor
                                </Link>
                                <Link :href="route('reports.staff', { date: selectedDate })" class="p-1 px-2 bg-stone-100 hover:bg-primary/10 text-[#3e0007] text-[9px] font-bold rounded uppercase flex items-center gap-1 transition-colors" title="View Staff Report">
                                    <span class="material-symbols-outlined text-xs">badge</span> Staff
                                </Link>
                                <span class="px-2 py-0.5 bg-primary/10 text-primary text-[10px] font-black rounded-full ml-1">{{ dailyVisits.length }}</span>
                            </div>
                        </div>
                        
                        <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            <div v-for="visit in dailyVisits" :key="visit.visit_id" class="flex gap-4 p-3 rounded-lg bg-surface-container-low hover:bg-surface-container transition-colors group">
                                <div class="flex-shrink-0 w-10 h-10 bg-white rounded-lg flex items-center justify-center border border-primary/5 shadow-sm">
                                    <span class="text-xs font-bold text-primary">{{ visit.visitors?.[0]?.name.substring(0,2).toUpperCase() || 'V' }}</span>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-bold text-sm text-on-surface truncate">{{ visit.visitors?.[0]?.name || 'Unknown' }}</h4>
                                    <p class="text-[10px] text-on-surface-variant uppercase font-medium tracking-tight mt-0.5">
                                        {{ visit.purpose }} • Host: {{ visit.employee?.name }}
                                    </p>
                                </div>
                            </div>
                            
                            <div v-if="dailyVisits.length === 0" class="py-12 flex flex-col items-center justify-center text-center opacity-40">
                                <span class="material-symbols-outlined text-4xl mb-2">event_busy</span>
                                <p class="text-[10px] font-bold uppercase tracking-widest leading-relaxed">No visits scheduled for<br/>this date</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.editorial-gradient {
    background: linear-gradient(135deg, #3e0007 0%, #620814 100%);
}
</style>
