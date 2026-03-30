<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    stats: Object,
    recentVisits: Array,
});
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
                <div class="flex gap-3">
                    <button class="px-5 py-2.5 rounded-lg bg-surface-container-highest text-on-surface font-semibold text-sm hover:bg-surface-dim transition-colors">
                        Download Report
                    </button>
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
                                         :class="visit.status === 'Active' ? 'bg-primary/10 text-primary' : 'bg-secondary/10 text-secondary'">
                                        {{ visit.visitors && visit.visitors.length > 0 ? visit.visitors[0].name.substring(0,2).toUpperCase() : 'V' }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-on-surface">{{ visit.visitors && visit.visitors.length > 0 ? visit.visitors[0].name : 'Unknown Visitor' }}</h4>
                                        <p class="text-xs text-on-surface-variant">Check-in: {{ visit.check_in_time ? new Date(visit.check_in_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : 'Pending' }} • Host: {{ visit.employee ? visit.employee.name : 'Unknown' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider"
                                          :class="visit.status === 'Active' ? 'bg-secondary-fixed text-on-secondary-fixed' : 'bg-surface-variant text-on-surface-variant'">
                                        {{ visit.status }}
                                    </span>
                                    <button class="p-2 text-on-surface-variant hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined">more_vert</span>
                                    </button>
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
                                <span class="text-xs font-bold text-on-surface-variant text-error">Evacuation</span>
                            </button>
                        </div>
                    </div>

                    <!-- Upcoming Visits -->
                    <div class="bg-surface-container rounded-xl p-6">
                        <h3 class="text-lg font-headline font-extrabold text-primary mb-6">Upcoming Visits</h3>
                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-surface-container-lowest rounded-lg flex flex-col items-center justify-center border-t-4 border-primary shadow-sm">
                                    <span class="text-xs font-bold text-primary leading-none">OCT</span>
                                    <span class="text-lg font-extrabold text-primary">24</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm text-on-surface">Design Review Panel</h4>
                                    <p class="text-xs text-on-surface-variant">14:00 • 8 External Guests</p>
                                </div>
                            </div>
                        </div>
                        <button class="w-full mt-8 py-3 bg-surface-container-lowest text-primary font-bold rounded-lg border border-primary/10 hover:bg-white transition-colors">
                            View Calendar
                        </button>
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
