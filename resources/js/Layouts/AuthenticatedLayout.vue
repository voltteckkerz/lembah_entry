<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const userRole = computed(() => {
    return page.props.auth.user ? page.props.auth.user.role.toLowerCase() : '';
});

const showingNavigationDropdown = ref(false);

const isUrlActive = (routeName) => {
    return route().current(routeName);
};
</script>

<template>
    <div class="font-body selection:bg-secondary-fixed selection:text-on-secondary-fixed">
        
        <!-- TopAppBar -->
        <header class="fixed top-0 w-full z-50 glass-header h-16 flex justify-between items-center px-6 no-border border-b border-primary/10">
            <div class="flex items-center gap-4">
                <Link :href="route('dashboard')">
                    <span class="text-xl font-headline font-bold tracking-tight text-primary">VisitorPass</span>
                </Link>
            </div>

            <div class="flex items-center gap-4">
                <!-- Search (Optional) -->
                <div class="hidden md:flex items-center bg-surface-container-high px-4 py-1.5 rounded-full text-on-surface-variant">
                    <span class="material-symbols-outlined text-lg mr-2">search</span>
                    <input type="text" placeholder="Search visitors..." class="bg-transparent border-none focus:ring-0 text-sm w-64 placeholder-on-surface-variant/60" />
                </div>

                <div class="flex items-center gap-3">
                    <Link :href="route('notifications.index')" class="p-2 rounded-full hover:bg-surface-container transition-colors duration-200 active:scale-95 text-on-surface-variant relative">
                        <span class="material-symbols-outlined">notifications</span>
                        <!-- Notification Badge dot (Mocked active state) -->
                        <span class="absolute top-1 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
                    </Link>
                    
                    <Link :href="route('profile.edit')" class="p-2 rounded-full hover:bg-surface-container transition-colors duration-200 active:scale-95 text-on-surface-variant">
                        <span class="material-symbols-outlined">settings</span>
                    </Link>

                    <!-- User Profile / Dropdown Trigger (Simplified for demo) -->
                    <div class="flex items-center gap-3 border-l border-outline-variant/30 pl-4 ml-2">
                        <div class="h-8 w-8 rounded-full overflow-hidden bg-primary-fixed flex items-center justify-center text-primary font-bold text-xs ring-2 ring-primary/10">
                            {{ $page.props.auth.user.name.charAt(0) }}
                        </div>
                        <div class="hidden md:block text-sm">
                            <p class="font-bold text-[#3e0007]">{{ $page.props.auth.user.name }}</p>
                            <p class="text-[10px] text-stone-500 uppercase tracking-widest">{{ $page.props.auth.user.role || 'Admin' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- SideNavBar -->
        <aside class="h-screen w-64 fixed left-0 top-0 border-r border-primary/10 bg-surface flex flex-col pt-20 pb-8 px-4 z-40 bg-[#fbf9f8]">
            <div class="mb-8 px-2">
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-8 h-8 md:w-10 md:h-10 editorial-gradient rounded-lg flex items-center justify-center text-white shadow-lg">
                        <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">museum</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-headline font-extrabold text-primary leading-tight">Visitor Management</h2>
                    </div>
                </div>
                <p class="text-[10px] font-medium text-stone-500 uppercase tracking-widest pl-12">Portal Administration</p>
            </div>

            <nav class="flex-1 space-y-1">
                <Link
                    :href="route('dashboard')"
                    :class="[
                        'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-300',
                        isUrlActive('dashboard') 
                            ? 'text-primary font-bold border-r-4 border-primary bg-surface-container' 
                            : 'text-on-surface-variant opacity-80 hover:bg-surface-container hover:opacity-100'
                    ]"
                >
                    <span class="material-symbols-outlined" :style="isUrlActive('dashboard') ? 'font-variation-settings: \'FILL\' 1;' : ''">
                        dashboard
                    </span>
                    <span class="font-medium text-sm">Dashboard</span>
                </Link>

                <!-- Registration (Guard Only) -->
                <Link
                    v-if="userRole === 'guard'"
                    :href="route('visits.create')"
                    :class="[
                        'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-300',
                        isUrlActive('visits.create') 
                            ? 'text-primary font-bold border-r-4 border-primary bg-surface-container' 
                            : 'text-on-surface-variant opacity-80 hover:bg-surface-container hover:opacity-100'
                    ]"
                >
                    <span class="material-symbols-outlined" :style="isUrlActive('visits.create') ? 'font-variation-settings: \'FILL\' 1;' : ''">app_registration</span>
                    <span class="font-medium text-sm">Register Visit</span>
                </Link>

                <!-- Attendance (Guard Only) -->
                <Link
                    v-if="userRole === 'guard'"
                    :href="route('attendance.index')"
                    :class="[
                        'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-300',
                        isUrlActive('attendance.index') 
                            ? 'text-primary font-bold border-r-4 border-primary bg-surface-container' 
                            : 'text-on-surface-variant opacity-80 hover:bg-surface-container hover:opacity-100'
                    ]"
                >
                    <span class="material-symbols-outlined" :style="isUrlActive('attendance.index') ? 'font-variation-settings: \'FILL\' 1;' : ''">fact_check</span>
                    <span class="font-medium text-sm">Attendance</span>
                </Link>

                <!-- Approvals (Host & Supervisor Only) -->
                <Link
                    v-if="['host', 'supervisor'].includes(userRole)"
                    :href="route('approvals.index')"
                    :class="[
                        'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-300',
                        isUrlActive('approvals.index') 
                            ? 'text-primary font-bold border-r-4 border-primary bg-surface-container' 
                            : 'text-on-surface-variant opacity-80 hover:bg-surface-container hover:opacity-100'
                    ]"
                >
                    <span class="material-symbols-outlined" :style="isUrlActive('approvals.index') ? 'font-variation-settings: \'FILL\' 1;' : ''">verified_user</span>
                    <span class="font-medium text-sm">Approval</span>
                </Link>

                <!-- History (Guard Only) -->
                <Link
                    v-if="userRole === 'guard'"
                    :href="route('history.index')"
                    :class="[
                        'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-300',
                        isUrlActive('history.index') 
                            ? 'text-primary font-bold border-r-4 border-primary bg-surface-container' 
                            : 'text-on-surface-variant opacity-80 hover:bg-surface-container hover:opacity-100'
                    ]"
                >
                    <span class="material-symbols-outlined" :style="isUrlActive('history.index') ? 'font-variation-settings: \'FILL\' 1;' : ''">history</span>
                    <span class="font-medium text-sm">Archives & Logs</span>
                </Link>
            </nav>

            <div class="mt-auto space-y-4">
                <Link v-if="userRole === 'guard'" :href="route('visits.create')" class="w-full editorial-gradient text-white py-3 rounded-xl font-bold flex items-center justify-center gap-2 active:scale-95 transition-transform shadow-lg shadow-primary/20 hover:opacity-90">
                    <span class="material-symbols-outlined">add</span>
                    <span>New Entry</span>
                </Link>
                
                <div class="pt-4 border-t border-outline-variant/30 space-y-1">
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="w-full flex items-center px-3 py-2 text-[#44474e] hover:bg-[#f0eded] rounded-lg transition-transform duration-200 hover:translate-x-1"
                    >
                        <span class="material-symbols-outlined mr-3 text-xl" data-icon="logout">logout</span>
                        <span class="font-medium text-sm">Logout</span>
                    </Link>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="pl-64 pt-16 min-h-screen bg-surface">
            <!-- Slot for page specific content -->
            <slot />
        </main>
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
