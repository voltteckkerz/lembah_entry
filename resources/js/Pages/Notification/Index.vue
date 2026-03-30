<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    notifications: Array,
});

const filterType = ref('All');

const filteredNotifications = computed(() => {
    if (filterType.value === 'Unread') {
        return props.notifications.filter(n => n.status === 'Unread');
    }
    return props.notifications;
});

const form = useForm({});

const markAsRead = (id) => {
    form.patch(route('notifications.read', id), {
        preserveScroll: true,
    });
};

const formatDate = (dateString) => {
    const raw = new Date(dateString);
    const now = new Date();
    const diffMs = now - raw;
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMins / 60);
    const diffDays = Math.floor(diffHours / 24);

    if (diffMins < 60) return `${diffMins} minutes ago`;
    if (diffHours < 24) return `${diffHours} hours ago`;
    if (diffDays === 1) return `Yesterday`;
    return raw.toLocaleDateString();
};
</script>

<template>
    <Head title="Notifications - VMS Portal" />
    <AuthenticatedLayout>
        <div class="px-10 max-w-5xl mx-auto mt-8">
            <header class="mb-10">
                <h2 class="text-3xl font-extrabold text-[#3e0007] tracking-tight font-headline">Alert Hub</h2>
                <p class="text-stone-500 text-sm mt-1">Manage and track all visitor activities and system alerts in one place.</p>
            </header>

            <!-- Filters & Controls -->
            <div class="flex items-center justify-between mb-8">
                <div class="inline-flex p-1.5 bg-white border border-stone-100 shadow-sm rounded-xl">
                    <button @click="filterType = 'All'" :class="filterType === 'All' ? 'bg-[#fbf9f8] text-[#620814] shadow-sm border-stone-200 border' : 'text-stone-500 hover:text-[#620814]'" class="px-6 py-2 font-bold rounded-lg text-sm transition-all border border-transparent">
                        All Notifications
                    </button>
                    <button @click="filterType = 'Unread'" :class="filterType === 'Unread' ? 'bg-[#fbf9f8] text-[#620814] shadow-sm border-stone-200 border' : 'text-stone-500 hover:text-[#620814]'" class="px-6 py-2 font-bold rounded-lg text-sm transition-all border border-transparent">
                        Unread ({{ notifications.filter(n => n.status === 'Unread').length }})
                    </button>
                </div>
            </div>

            <!-- Notifications List -->
            <div class="space-y-4 font-body">
                <transition-group name="list">
                    <div v-for="notif in filteredNotifications" :key="notif.notification_id" 
                        class="group relative flex items-start gap-5 p-6 rounded-2xl transition-all"
                        :class="notif.status === 'Unread' ? 'bg-white shadow-[0_10px_30px_rgba(27,28,28,0.03)] border border-stone-100 hover:translate-y-[-2px]' : 'bg-stone-50/50 hover:bg-white border border-transparent hover:border-stone-100 hover:shadow-sm'">
                        
                        <!-- Unread Dot -->
                        <div v-if="notif.status === 'Unread'" class="absolute top-6 right-6 w-2.5 h-2.5 bg-red-500 rounded-full shadow-[0_0_8px_rgba(239,68,68,0.4)]"></div>
                        
                        <!-- Icon -->
                        <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl"
                            :class="notif.status === 'Unread' ? 'bg-[#620814]/10 text-[#620814]' : 'bg-stone-200 text-stone-500'">
                            <span class="material-symbols-outlined text-2xl" :style="notif.status === 'Unread' ? 'font-variation-settings:\'FILL\' 1;' : ''">
                                {{ notif.visit_id ? 'person_add' : 'info' }}
                            </span>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1" :class="notif.status === 'Read' ? 'opacity-70 group-hover:opacity-100' : ''">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-lg font-bold text-stone-800 group-hover:text-[#620814] transition-colors font-headline">
                                    {{ notif.visit ? `Visit Update: ${notif.visit.pass_number}` : 'System Alert' }}
                                </h3>
                                <span class="text-xs font-semibold text-stone-400 uppercase tracking-wider">{{ formatDate(notif.created_at) }}</span>
                            </div>
                            <p class="text-stone-600 mb-4 leading-relaxed max-w-2xl">
                                {{ notif.message }}
                            </p>
                            
                            <!-- Actions -->
                            <div class="flex items-center gap-3">
                                <button v-if="notif.status === 'Unread'" @click="markAsRead(notif.notification_id)" class="px-4 py-1.5 bg-[#fbf9f8] text-[#620814] text-xs font-bold rounded-lg border border-stone-200 hover:bg-white transition-colors">
                                    Mark as Read
                                </button>
                                <span v-else class="text-xs font-bold text-stone-400">Read</span>
                            </div>
                        </div>
                    </div>
                </transition-group>

                <div v-if="filteredNotifications.length === 0" class="p-12 text-center text-stone-500 bg-white rounded-2xl border border-stone-100 shadow-sm font-medium">
                    <span class="material-symbols-outlined text-5xl text-stone-300 mb-3 block">notifications_paused</span>
                    No notifications to show here.
                </div>
            </div>
            
            <!-- Pro Tip Section -->
            <section class="mt-16 mb-12">
                <div class="bg-gradient-to-br from-[#a68966] to-[#8e7456] rounded-3xl overflow-hidden relative min-h-[220px] flex items-center p-12">
                    <div class="max-w-xl z-10 relative">
                        <span class="bg-white/20 backdrop-blur-md text-white text-[10px] font-black uppercase tracking-[0.2em] px-3 py-1 rounded-full mb-6 inline-block">Pro Tip</span>
                        <h2 class="text-3xl font-extrabold text-white leading-tight mb-4 font-headline">Master Your Alerts.</h2>
                        <p class="text-white/80 text-lg font-medium leading-relaxed">
                            Stay up to date with your visitor flows. Alerts help you keep track of pending approvals and overstaying guests instantly.
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}
</style>
