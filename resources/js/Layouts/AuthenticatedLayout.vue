<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { ChevronDownIcon } from '@heroicons/vue/20/solid';

const page = usePage();
const userRole = computed(() => {
    return page.props.auth.user ? page.props.auth.user.role.toLowerCase() : '';
});

const showingNavigationDropdown = ref(false);
const isSidebarFolded = ref(false);

const isUrlActive = (routeName) => {
    return route().current(routeName);
};

// Global Notifications Mechanics
const globalUnreadCount = ref(0);
const chatNotifications = ref([]);
let lastMessageId = null;
let pollInterval = null;

const playGlobalPing = () => {
    try {
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioCtx.createOscillator();
        const gainNode = audioCtx.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioCtx.destination);
        
        // Slightly different pitch than local ping for distinction
        oscillator.type = 'sine';
        oscillator.frequency.value = 600; // 600hz
        
        gainNode.gain.setValueAtTime(0.1, audioCtx.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.6);
        
        oscillator.start(audioCtx.currentTime);
        oscillator.stop(audioCtx.currentTime + 0.6);
    } catch(e) {}
};

const pollUnread = async () => {
    try {
        const res = await fetch(route('chat.unread'), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        const data = await res.json();
        
        globalUnreadCount.value = data.count;
        
        if (data.latest && data.latest.id !== lastMessageId) {
            if (lastMessageId !== null) { // Block popping up on the very first page load
                // Only sound the ping if user is NOT currently inside the chat window. 
                // Wait, user asked for global ping, even in attendance page! 
                // But in chat window, it pings locally. To avoid double ping, we mute global ping if on chat page.
                if (!isUrlActive('chat.index')) {
                    playGlobalPing();
                }
                
                const notifId = Date.now();
                chatNotifications.value.push({
                    id: notifId,
                    sender: data.latest.sender,
                    content: data.latest.content
                });
                
                setTimeout(() => {
                    chatNotifications.value = chatNotifications.value.filter(n => n.id !== notifId);
                }, 5000);
            }
            lastMessageId = data.latest.id;
        }
    } catch (e) {}
};

onMounted(() => {
    pollUnread();
    pollInterval = setInterval(pollUnread, 5000);
});

onUnmounted(() => {
    if (pollInterval) clearInterval(pollInterval);
});
</script>

<template>
    <div class="font-body selection:bg-secondary-fixed selection:text-on-secondary-fixed">
        
        <!-- TopAppBar -->
        <header class="fixed top-0 w-full z-50 glass-header h-16 flex justify-between items-center px-6 no-border border-b border-primary/10">
            <div class="flex items-center gap-4">
                <button 
                    @click="isSidebarFolded = !isSidebarFolded"
                    class="p-2 rounded-lg hover:bg-surface-container transition-colors text-on-surface-variant flex items-center justify-center"
                    aria-label="Toggle Sidebar"
                >
                    <span class="material-symbols-outlined transition-transform duration-300" :class="{'rotate-180': isSidebarFolded}">
                        menu_open
                    </span>
                </button>
                <img src="/images/LSSB logo.jpg" alt="LSSB Logo" class="h-14 w-auto object-contain" />
            </div>

            <div class="flex items-center gap-4">

                <div class="flex items-center gap-3">

                    <!-- User Profile Dropdown -->
                    <div class="flex items-center border-l border-outline-variant/30 pl-4 ml-2 h-8">
                        <Menu as="div" class="relative inline-block text-left">
                            <MenuButton class="group inline-flex items-center gap-2 rounded-lg py-1.5 px-2 transition-all hover:bg-surface-container active:scale-95 outline-none">
                                <div class="h-8 w-8 rounded-full overflow-hidden bg-primary-fixed flex items-center justify-center text-primary font-bold text-xs ring-2 ring-primary/10 transition-transform group-hover:scale-105">
                                    {{ $page.props.auth.user.name.charAt(0) }}
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-[11px] font-bold text-[#3e0007] leading-tight">{{ $page.props.auth.user.name }}</p>
                                    <p class="text-[9px] text-stone-500 uppercase tracking-widest leading-none">{{ $page.props.auth.user.role || 'Admin' }}</p>
                                </div>
                                <ChevronDownIcon class="w-4 h-4 text-stone-400 transition-transform group-hover:translate-y-0.5" />
                            </MenuButton>

                            <transition 
                                enter-active-class="transition ease-out duration-100" 
                                enter-from-class="transform opacity-0 scale-95" 
                                enter-to-class="transform scale-100" 
                                leave-active-class="transition ease-in duration-75" 
                                leave-from-class="transform scale-100" 
                                leave-to-class="transform opacity-0 scale-95"
                            >
                                <MenuItems class="absolute right-0 z-50 mt-2 w-56 origin-top-right rounded-xl bg-white/95 backdrop-blur-xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] ring-1 ring-black/5 focus:outline-none overflow-hidden">
                                    <div class="py-1">
                                        <div class="px-4 py-3 border-b border-stone-100 mb-1">
                                            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest">Account</p>
                                            <p class="text-xs font-semibold text-[#3e0007] truncate mt-0.5">{{ $page.props.auth.user.email }}</p>
                                        </div>
                                        
                                        <MenuItem v-slot="{ active }">
                                            <Link 
                                                :href="route('profile.edit')" 
                                                :class="[active ? 'bg-stone-50 text-primary' : 'text-stone-600', 'flex items-center gap-3 px-4 py-2.5 text-sm transition-colors cursor-pointer capitalize font-medium']"
                                            >
                                                <span class="material-symbols-outlined text-[18px] opacity-60">person</span>
                                                My Profile
                                            </Link>
                                        </MenuItem>


                                        <div class="h-px bg-stone-100 my-1 mx-2"></div>

                                        <MenuItem v-slot="{ active }">
                                            <Link 
                                                :href="route('logout')" 
                                                method="post" 
                                                as="button" 
                                                :class="[active ? 'bg-red-50 text-red-600' : 'text-stone-500', 'flex w-full items-center gap-3 px-4 py-2.5 text-sm transition-colors cursor-pointer capitalize font-medium']"
                                            >
                                                <span class="material-symbols-outlined text-[18px] opacity-60">logout</span>
                                                Sign Out
                                            </Link>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </div>
        </header>

        <!-- SideNavBar -->
        <aside 
            :class="[
                'h-screen fixed left-0 top-0 border-r border-primary/10 flex flex-col pt-20 pb-8 px-4 z-40 bg-surface transition-all duration-300 ease-in-out',
                isSidebarFolded ? 'w-20' : 'w-64'
            ]"
        >
            <div class="mb-8 px-2 overflow-hidden whitespace-nowrap">
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-10 h-10 editorial-gradient rounded-lg flex-shrink-0 flex items-center justify-center text-white shadow-lg">
                        <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">museum</span>
                    </div>
                    <div :class="['transition-all duration-300', isSidebarFolded ? 'opacity-0 -translate-x-4 pointer-events-none' : 'opacity-100 translate-x-0']">
                        <h2 class="text-lg font-headline font-extrabold text-primary leading-tight">Visitor Management</h2>
                    </div>
                </div>
                <p :class="['text-[10px] font-medium text-stone-500 uppercase tracking-widest pl-12 transition-all duration-300', isSidebarFolded ? 'opacity-0' : 'opacity-100']">Portal Administration</p>
            </div>

            <nav class="flex-1 space-y-1">
                <Link
                    :href="route('dashboard')"
                    :class="[
                        'flex items-center px-3 py-2.5 rounded-lg transition-all duration-300 group relative',
                        isSidebarFolded ? 'justify-center' : 'gap-3',
                        isUrlActive('dashboard') 
                            ? 'text-primary font-bold border-r-4 border-primary bg-surface-container' 
                            : 'text-on-surface-variant opacity-80 hover:bg-surface-container hover:opacity-100'
                    ]"
                >
                    <span class="material-symbols-outlined flex-shrink-0" :style="isUrlActive('dashboard') ? 'font-variation-settings: \'FILL\' 1;' : ''">
                        dashboard
                    </span>
                    <span :class="['font-medium text-sm transition-all duration-300 whitespace-nowrap overflow-hidden', isSidebarFolded ? 'w-0 opacity-0' : 'w-auto opacity-100']">Dashboard</span>
                </Link>

                <!-- Registration (Guard Only) -->
                <Link
                    v-if="userRole === 'guard'"
                    :href="route('visits.create')"
                    :class="[
                        'flex items-center px-3 py-2.5 rounded-lg transition-all duration-300 group relative',
                        isSidebarFolded ? 'justify-center' : 'gap-3',
                        isUrlActive('visits.create') 
                            ? 'text-primary font-bold border-r-4 border-primary bg-surface-container' 
                            : 'text-on-surface-variant opacity-80 hover:bg-surface-container hover:opacity-100'
                    ]"
                >
                    <span class="material-symbols-outlined flex-shrink-0" :style="isUrlActive('visits.create') ? 'font-variation-settings: \'FILL\' 1;' : ''">app_registration</span>
                    <span :class="['font-medium text-sm transition-all duration-300 whitespace-nowrap overflow-hidden', isSidebarFolded ? 'w-0 opacity-0' : 'w-auto opacity-100']">Register Visit</span>
                </Link>

                <!-- Attendance (Guard Only) -->
                <Link
                    v-if="userRole === 'guard'"
                    :href="route('attendance.index')"
                    :class="[
                        'flex items-center px-3 py-2.5 rounded-lg transition-all duration-300 group relative',
                        isSidebarFolded ? 'justify-center' : 'gap-3',
                        isUrlActive('attendance.index') 
                            ? 'text-primary font-bold border-r-4 border-primary bg-surface-container' 
                            : 'text-on-surface-variant opacity-80 hover:bg-surface-container hover:opacity-100'
                    ]"
                >
                    <span class="material-symbols-outlined flex-shrink-0" :style="isUrlActive('attendance.index') ? 'font-variation-settings: \'FILL\' 1;' : ''">fact_check</span>
                    <span :class="['font-medium text-sm transition-all duration-300 whitespace-nowrap overflow-hidden', isSidebarFolded ? 'w-0 opacity-0' : 'w-auto opacity-100']">Attendance</span>
                </Link>
                

                <!-- History (Guard Only) -->
                <Link
                    v-if="userRole === 'guard'"
                    :href="route('history.index')"
                    :class="[
                        'flex items-center px-3 py-2.5 rounded-lg transition-all duration-300 group relative',
                        isSidebarFolded ? 'justify-center' : 'gap-3',
                        isUrlActive('history.index') 
                            ? 'text-primary font-bold border-r-4 border-primary bg-surface-container' 
                            : 'text-on-surface-variant opacity-80 hover:bg-surface-container hover:opacity-100'
                    ]"
                >
                    <span class="material-symbols-outlined flex-shrink-0" :style="isUrlActive('history.index') ? 'font-variation-settings: \'FILL\' 1;' : ''">history</span>
                    <span :class="['font-medium text-sm transition-all duration-300 whitespace-nowrap overflow-hidden', isSidebarFolded ? 'w-0 opacity-0' : 'w-auto opacity-100']">Archives & Logs</span>
                </Link>

                <!-- User Administration (Admin Only) -->
                <Link
                    v-if="userRole === 'admin'"
                    :href="route('users.index')"
                    :class="[
                        'flex items-center px-3 py-2.5 rounded-lg transition-all duration-300 group relative',
                        isSidebarFolded ? 'justify-center' : 'gap-3',
                        isUrlActive('users.index') 
                            ? 'text-primary font-bold border-r-4 border-primary bg-surface-container' 
                            : 'text-on-surface-variant opacity-80 hover:bg-surface-container hover:opacity-100'
                    ]"
                >
                    <span class="material-symbols-outlined flex-shrink-0" :style="isUrlActive('users.index') ? 'font-variation-settings: \'FILL\' 1;' : ''">group</span>
                    <span :class="['font-medium text-sm transition-all duration-300 whitespace-nowrap overflow-hidden', isSidebarFolded ? 'w-0 opacity-0' : 'w-auto opacity-100']">User Management</span>
                </Link>

                <!-- Admin Support Comms -->
                <Link
                    v-if="userRole === 'admin'"
                    :href="route('chat.index')"
                    :class="[
                        'flex items-center px-3 py-2.5 rounded-lg transition-all duration-300 group relative',
                        isSidebarFolded ? 'justify-center' : 'gap-3',
                        isUrlActive('chat.index') 
                            ? 'text-primary font-bold border-r-4 border-primary bg-surface-container' 
                            : 'text-on-surface-variant opacity-80 hover:bg-surface-container hover:opacity-100'
                    ]"
                >
                    <div class="relative flex-shrink-0">
                        <span class="material-symbols-outlined block" :style="isUrlActive('chat.index') ? 'font-variation-settings: \'FILL\' 1;' : ''">forum</span>
                        <div v-if="globalUnreadCount > 0" class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-error rounded-full animate-pulse border-2 border-white"></div>
                    </div>
                    <span :class="['font-medium text-sm transition-all duration-300 whitespace-nowrap overflow-hidden', isSidebarFolded ? 'w-0 opacity-0' : 'w-auto opacity-100']">Guard Comms</span>
                </Link>
            </nav>

            <div class="mt-auto space-y-4">
                <!-- Support Assistance (Guard Only) -->
                <div v-if="userRole === 'guard'" :class="['transition-all duration-300', isSidebarFolded ? 'px-0 mb-2' : 'px-2 mb-4']">
                    <div :class="['editorial-gradient rounded-2xl p-4 shadow-lg shadow-primary/10 relative overflow-hidden group', isSidebarFolded ? 'h-12 w-12 flex items-center justify-center mx-auto' : 'w-full']">
                        <Link :href="route('chat.index')" class="absolute inset-0 z-20 w-full h-full cursor-pointer focus:outline-none focus:ring-4 focus:ring-white/20 rounded-2xl"></Link>
                        <div v-if="!isSidebarFolded" class="relative z-10 pointer-events-none">
                            <div class="flex items-center gap-2 mb-2 relative">
                                <div class="relative">
                                    <span class="material-symbols-outlined text-white/90 text-lg block">forum</span>
                                    <div v-if="globalUnreadCount > 0" class="absolute -top-1 -right-1.5 w-2.5 h-2.5 bg-error rounded-full animate-pulse border-2 border-error"></div>
                                </div>
                                <span class="text-[10px] font-bold uppercase tracking-widest text-white/70">Support Chat</span>
                            </div>
                            <p class="text-[11px] text-white/80 leading-relaxed mb-3">
                                Private, secure messaging with the <span class="font-bold text-white">System Overseer</span>.
                            </p>
                            <div class="w-full py-2 bg-white/20 backdrop-blur-md border border-white/30 rounded-lg text-[10px] font-bold uppercase tracking-tighter text-white text-center">
                                Open Chat
                            </div>
                        </div>
                        <div v-else class="flex items-center justify-center w-full h-full text-white pointer-events-none relative" title="Support Chat">
                            <div class="relative z-10">
                                <span class="material-symbols-outlined block">forum</span>
                                <div v-if="globalUnreadCount > 0" class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-error rounded-full animate-pulse border-2 border-error"></div>
                            </div>
                        </div>
                        <!-- Abstract background element -->
                        <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700 pointer-events-none"></div>
                    </div>
                </div>

                <Link v-if="userRole === 'guard'" :href="route('visits.create')">
                    <button 
                        :class="[
                            'w-full editorial-gradient text-white py-3 rounded-xl font-bold flex items-center justify-center gap-2 active:scale-95 transition-all duration-300 shadow-lg shadow-primary/20 hover:opacity-90 overflow-hidden',
                            isSidebarFolded ? 'px-0' : 'px-4'
                        ]"
                    >
                        <span class="material-symbols-outlined flex-shrink-0">add</span>
                        <span :class="['transition-all duration-300 whitespace-nowrap', isSidebarFolded ? 'w-0 opacity-0' : 'w-auto opacity-100 ml-1']">New Entry</span>
                    </button>
                </Link>
            </div>
        </aside>

        <!-- Main Content -->
        <main 
            :class="[
                'pt-16 min-h-screen bg-surface transition-all duration-300 ease-in-out',
                isSidebarFolded ? 'pl-20' : 'pl-64'
            ]"
        >
            <!-- Slot for page specific content -->
            <slot />
        </main>
        <!-- Global Chat Toasts UI -->
        <div class="fixed bottom-6 right-6 z-[100] flex flex-col gap-3 pointer-events-none">
            <transition-group 
                enter-active-class="transform ease-out duration-300 transition" 
                enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4" 
                enter-to-class="translate-y-0 opacity-100 sm:translate-x-0" 
                leave-active-class="transition ease-in duration-200" 
                leave-from-class="opacity-100" 
                leave-to-class="opacity-0 translate-x-4"
            >
                <div v-for="notif in chatNotifications" :key="notif.id" class="pointer-events-auto w-[320px] bg-white rounded-2xl shadow-xl shadow-primary/5 border border-stone-100 p-4 flex gap-4 overflow-hidden relative group">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary"></div>
                    <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0 font-bold mb-auto">
                        {{ notif.sender.substring(0, 2).toUpperCase() }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-stone-800">New Message</p>
                        <p class="text-xs text-stone-500 font-medium truncate mt-0.5">{{ notif.sender }}</p>
                        <p class="text-sm text-stone-700 mt-2 line-clamp-2 leading-tight">
                            "{{ notif.content }}"
                        </p>
                        <div class="mt-3">
                            <Link :href="route('chat.index')" class="text-[10px] uppercase tracking-widest font-bold text-primary hover:text-error transition-colors">
                                Open Chat ->
                            </Link>
                        </div>
                    </div>
                </div>
            </transition-group>
        </div>
    </div>
</template>

<style scoped>
.editorial-gradient {
    background: linear-gradient(135deg, #3e0007 0%, #620814 100%);
}
.glass-header {
    background: rgba(251, 249, 248, 0.85);
    backdrop-filter: blur(20px);
}
</style>
