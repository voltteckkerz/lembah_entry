<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Notifications - Sari Heritage VMS" />
    <div class="bg-surface text-on-surface font-body selection:bg-primary/10 min-h-screen">
        <!-- Sidebar Navigation -->
        <aside class="h-screen w-64 fixed left-0 top-0 border-r border-primary/15 bg-[#fbf9f8] flex flex-col py-6 z-40">
        <div class="px-6 mb-8">
        <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white">
        <span class="material-symbols-outlined" data-icon="account_balance">account_balance</span>
        </div>
        <div>
        <h1 class="text-lg font-black text-[#3e0007] tracking-tight font-headline">Sari Heritage</h1>
        <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold">Visitor Management</p>
        </div>
        </div>
        </div>
        <nav class="flex-1 space-y-1">
        <a class="flex items-center px-6 py-3 text-[#44474e] hover:bg-[#f0eded] mx-2 rounded-lg transition-transform duration-200 hover:translate-x-1 group" href="#">
        <span class="material-symbols-outlined mr-3 text-xl" data-icon="dashboard">dashboard</span>
        <span class="font-medium text-sm">Dashboard</span>
        </a>
        <a class="flex items-center px-6 py-3 text-[#44474e] hover:bg-[#f0eded] mx-2 rounded-lg transition-transform duration-200 hover:translate-x-1 group" href="#">
        <span class="material-symbols-outlined mr-3 text-xl" data-icon="group">group</span>
        <span class="font-medium text-sm">Visitors</span>
        </a>
        <!-- Active Tab: Notifications -->
        <a class="flex items-center px-6 py-3 bg-[#3e0007] text-white rounded-lg mx-2 shadow-sm transition-transform duration-200" href="#">
        <span class="material-symbols-outlined mr-3 text-xl" data-icon="notifications" style="font-variation-settings: 'FILL' 1;">notifications</span>
        <span class="font-medium text-sm">Notifications</span>
        </a>
        <a class="flex items-center px-6 py-3 text-[#44474e] hover:bg-[#f0eded] mx-2 rounded-lg transition-transform duration-200 hover:translate-x-1 group" href="#">
        <span class="material-symbols-outlined mr-3 text-xl" data-icon="badge">badge</span>
        <span class="font-medium text-sm">Staff</span>
        </a>
        <a class="flex items-center px-6 py-3 text-[#44474e] hover:bg-[#f0eded] mx-2 rounded-lg transition-transform duration-200 hover:translate-x-1 group" href="#">
        <span class="material-symbols-outlined mr-3 text-xl" data-icon="analytics">analytics</span>
        <span class="font-medium text-sm">Reports</span>
        </a>
        </nav>
        <div class="px-4 mt-auto space-y-4">
        <button class="w-full py-3 px-4 bg-gradient-to-br from-primary to-primary-container text-white rounded-lg font-bold text-sm shadow-lg hover:opacity-90 active:scale-95 transition-all">
                        Pre-register Visitor
                    </button>
        <div class="pt-4 border-t border-outline-variant/30 space-y-1">
        <a class="flex items-center px-6 py-2 text-[#44474e] hover:bg-[#f0eded] mx-2 rounded-lg transition-transform duration-200 hover:translate-x-1" href="#">
        <span class="material-symbols-outlined mr-3 text-xl" data-icon="help">help</span>
        <span class="font-medium text-sm">Help</span>
        </a>
        <a class="flex items-center px-6 py-2 text-[#44474e] hover:bg-[#f0eded] mx-2 rounded-lg transition-transform duration-200 hover:translate-x-1" href="#">
        <span class="material-symbols-outlined mr-3 text-xl" data-icon="logout">logout</span>
        <span class="font-medium text-sm">Logout</span>
        </a>
        </div>
        </div>
        </aside>
        <!-- Main Content Area -->
        <main class="ml-64 bg-surface-container-low pb-12 min-h-screen">
        <!-- Top App Bar Replacement (Integrated) -->
        <header class="flex justify-between items-center px-10 py-8 bg-surface-bright/80 backdrop-blur-xl sticky top-0 z-30">
        <div>
        <h2 class="text-3xl font-extrabold text-primary tracking-tight font-headline">Notifications</h2>
        <p class="text-on-surface-variant text-sm mt-1">Manage and track all visitor activities and alerts.</p>
        </div>
        <div class="flex items-center gap-4">
        <div class="relative">
        <button class="p-2 bg-surface-container-high rounded-full hover:bg-surface-container-highest transition-colors">
        <span class="material-symbols-outlined text-on-surface" data-icon="search">search</span>
        </button>
        </div>
        <button class="p-2 bg-surface-container-high rounded-full hover:bg-surface-container-highest transition-colors">
        <span class="material-symbols-outlined text-on-surface" data-icon="settings">settings</span>
        </button>
        <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center overflow-hidden border-2 border-primary-container/10">
        <img alt="User profile avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB1hwQGVu2L1sjSzFiyFTTrA9y3cWa-wg6YNpEynYgSvM0TcpmJtFVtlxPVuAt91yBGGxIKC2kmAmf1H9W0LaGNKALAMCZp2gEkonpcuzWlYUa79PAm3bLRdo_i8CKK9iDkYKyHkzD226smBvB-JgrFYOfT6QRQxnOopuc7E-1BTpvCr_fnRORRyAZ_qC-8_YBJKSHyBqcMocOCY6dIDWXVneJ7uKNZhaZ4iQMau5gwxz4X3nZk8fwGXZFPEzrcgxaEl50FI-RTYqiz"/>
        </div>
        </div>
        </header>
        <!-- Notification Dashboard -->
        <div class="px-10 max-w-5xl mx-auto mt-8">
        <!-- Filters & Controls -->
        <div class="flex items-center justify-between mb-8">
        <div class="inline-flex p-1.5 bg-surface-container-high rounded-xl">
        <button class="px-6 py-2 bg-surface-container-lowest text-primary font-bold rounded-lg shadow-sm text-sm transition-all">All Notifications</button>
        <button class="px-6 py-2 text-on-surface-variant font-medium rounded-lg text-sm hover:text-primary transition-all">Unread (3)</button>
        </div>
        <button class="flex items-center gap-2 text-sm font-semibold text-primary hover:underline decoration-primary/30 underline-offset-4">
        <span class="material-symbols-outlined text-lg" data-icon="done_all">done_all</span>
                            Mark all as read
                        </button>
        </div>
        <!-- Notifications List -->
        <div class="space-y-4">
        <!-- Notification Item: Unread -->
        <div class="group relative flex items-start gap-5 p-6 bg-surface-container-lowest rounded-2xl shadow-sm transition-all hover:translate-y-[-2px] hover:shadow-md">
        <div class="absolute top-6 right-6 w-2.5 h-2.5 bg-error rounded-full shadow-[0_0_8px_rgba(186,26,26,0.4)]"></div>
        <div class="flex-shrink-0 w-12 h-12 bg-primary-fixed flex items-center justify-center rounded-xl text-primary">
        <span class="material-symbols-outlined text-2xl" data-icon="person_add" style="font-variation-settings: 'FILL' 1;">person_add</span>
        </div>
        <div class="flex-1">
        <div class="flex justify-between items-start mb-1">
        <h3 class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors font-headline">Visitor Approved</h3>
        <span class="text-xs font-semibold text-on-surface-variant/60 uppercase tracking-wider">2 minutes ago</span>
        </div>
        <p class="text-on-surface-variant mb-4 leading-relaxed max-w-2xl">
                                    Visitor <span class="font-bold text-on-surface">Ahmad Rosli</span> has been approved for entry by <span class="font-bold text-on-surface">Admin Shanor</span>. Proceed to gate check-in.
                                </p>
        <div class="flex items-center gap-3">
        <button class="px-4 py-1.5 bg-primary text-white text-xs font-bold rounded-lg hover:bg-primary-container transition-colors">View Details</button>
        <button class="px-4 py-1.5 bg-surface-container-high text-on-surface-variant text-xs font-bold rounded-lg hover:bg-surface-container-highest transition-colors">Mark as Read</button>
        </div>
        </div>
        </div>
        <!-- Notification Item: Read -->
        <div class="group relative flex items-start gap-5 p-6 bg-surface-container-low/50 rounded-2xl transition-all hover:bg-surface-container-lowest hover:shadow-sm">
        <div class="flex-shrink-0 w-12 h-12 bg-surface-container-highest flex items-center justify-center rounded-xl text-on-surface-variant">
        <span class="material-symbols-outlined text-2xl" data-icon="check_circle">check_circle</span>
        </div>
        <div class="flex-1 opacity-70 group-hover:opacity-100 transition-opacity">
        <div class="flex justify-between items-start mb-1">
        <h3 class="text-lg font-bold text-on-surface font-headline">Check-out Confirmed</h3>
        <span class="text-xs font-semibold text-on-surface-variant/60 uppercase tracking-wider">45 minutes ago</span>
        </div>
        <p class="text-on-surface-variant mb-4 leading-relaxed">
        <span class="font-bold text-on-surface">Sarah Jane</span> has completed her visit and checked out successfully from Main Block.
                                </p>
        <div class="flex items-center gap-3">
        <button class="px-4 py-1.5 bg-surface-container-high text-on-surface-variant text-xs font-bold rounded-lg hover:bg-surface-container-highest transition-colors">View History</button>
        </div>
        </div>
        </div>
        <!-- Notification Item: Unread -->
        <div class="group relative flex items-start gap-5 p-6 bg-surface-container-lowest rounded-2xl shadow-sm transition-all hover:translate-y-[-2px] hover:shadow-md">
        <div class="absolute top-6 right-6 w-2.5 h-2.5 bg-error rounded-full shadow-[0_0_8px_rgba(186,26,26,0.4)]"></div>
        <div class="flex-shrink-0 w-12 h-12 bg-secondary-fixed flex items-center justify-center rounded-xl text-secondary">
        <span class="material-symbols-outlined text-2xl" data-icon="arrival_launcher">launch</span>
        </div>
        <div class="flex-1">
        <div class="flex justify-between items-start mb-1">
        <h3 class="text-lg font-bold text-on-surface group-hover:text-primary transition-colors font-headline">Arrival Alert</h3>
        <span class="text-xs font-semibold text-on-surface-variant/60 uppercase tracking-wider">1 hour ago</span>
        </div>
        <p class="text-on-surface-variant mb-4 leading-relaxed">
                                    New pre-registered visitor <span class="font-bold text-on-surface">Michael Tan</span> is scheduled to arrive at the South Entrance in 15 minutes.
                                </p>
        <div class="flex items-center gap-3">
        <button class="px-4 py-1.5 bg-primary text-white text-xs font-bold rounded-lg hover:bg-primary-container transition-colors">Assign Host</button>
        <button class="px-4 py-1.5 bg-surface-container-high text-on-surface-variant text-xs font-bold rounded-lg hover:bg-surface-container-highest transition-colors">Dismiss</button>
        </div>
        </div>
        </div>
        <!-- Notification Item: Unread (Security) -->
        <div class="group relative flex items-start gap-5 p-6 bg-surface-container-lowest rounded-2xl shadow-sm border-l-4 border-error transition-all hover:translate-y-[-2px]">
        <div class="absolute top-6 right-6 w-2.5 h-2.5 bg-error rounded-full"></div>
        <div class="flex-shrink-0 w-12 h-12 bg-error-container flex items-center justify-center rounded-xl text-error">
        <span class="material-symbols-outlined text-2xl" data-icon="warning" style="font-variation-settings: 'FILL' 1;">warning</span>
        </div>
        <div class="flex-1">
        <div class="flex justify-between items-start mb-1">
        <h3 class="text-lg font-bold text-error font-headline">Security Exception</h3>
        <span class="text-xs font-semibold text-error/60 uppercase tracking-wider">3 hours ago</span>
        </div>
        <p class="text-on-surface-variant mb-4 leading-relaxed">
                                    An unauthorized access attempt was recorded at the <span class="font-bold text-on-surface">Heritage Gallery Backdoor</span>. Security team has been notified.
                                </p>
        <div class="flex items-center gap-3">
        <button class="px-4 py-1.5 bg-error text-white text-xs font-bold rounded-lg hover:opacity-90 transition-colors">Review Footage</button>
        </div>
        </div>
        </div>
        <!-- Notification Item: Read (System) -->
        <div class="group relative flex items-start gap-5 p-6 bg-surface-container-low/50 rounded-2xl transition-all">
        <div class="flex-shrink-0 w-12 h-12 bg-surface-container-highest flex items-center justify-center rounded-xl text-on-surface-variant">
        <span class="material-symbols-outlined text-2xl" data-icon="update">update</span>
        </div>
        <div class="flex-1 opacity-70">
        <div class="flex justify-between items-start mb-1">
        <h3 class="text-lg font-bold text-on-surface font-headline">System Update</h3>
        <span class="text-xs font-semibold text-on-surface-variant/60 uppercase tracking-wider">Yesterday</span>
        </div>
        <p class="text-on-surface-variant mb-4 leading-relaxed">
                                    The VMS core has been updated to version 2.4.0. New features include enhanced reporting and faster visitor QR scanning.
                                </p>
        <button class="text-xs font-bold text-primary underline decoration-primary/20 underline-offset-4">Read Release Notes</button>
        </div>
        </div>
        </div>
        <!-- Load More Section -->
        <div class="mt-10 flex flex-col items-center gap-6">
        <div class="h-px w-full bg-gradient-to-r from-transparent via-outline-variant/30 to-transparent"></div>
        <button class="px-8 py-3 bg-surface-container-high text-on-surface font-bold rounded-xl text-sm hover:bg-surface-container-highest transition-all flex items-center gap-2">
        <span class="material-symbols-outlined text-lg" data-icon="expand_more">expand_more</span>
                            Load older notifications
                        </button>
        </div>
        </div>
        <!-- Editorial Break / Info Section -->
        <section class="mt-16 mx-10">
        <div class="bg-secondary-container rounded-3xl overflow-hidden relative min-h-[280px] flex items-center p-12">
        <div class="max-w-xl z-10 relative">
        <span class="bg-white/20 backdrop-blur-md text-white text-[10px] font-black uppercase tracking-[0.2em] px-3 py-1 rounded-full mb-6 inline-block">Pro Tip</span>
        <h2 class="text-4xl font-extrabold text-on-secondary-container leading-tight mb-4 font-headline">Master Your Alerts.</h2>
        <p class="text-on-secondary-container/80 text-lg font-medium leading-relaxed">
                                Customize your notification preferences in the settings to receive instant WhatsApp or email alerts for high-priority visitor arrivals.
                            </p>
        <button class="mt-8 px-6 py-3 bg-white text-secondary font-bold rounded-lg shadow-xl hover:scale-105 transition-transform">Configure Alerts</button>
        </div>
        <div class="absolute right-[-5%] bottom-[-10%] w-[50%] opacity-20 transform -rotate-12 pointer-events-none">
        <span class="material-symbols-outlined text-[300px]" data-icon="notifications_active">notifications_active</span>
        </div>
        </div>
        </section>
        </main>
        <!-- Contextual Floating Action Button -->
        <button class="fixed bottom-10 right-10 w-16 h-16 bg-gradient-to-br from-primary to-primary-container text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all z-50 group">
        <span class="material-symbols-outlined text-3xl" data-icon="add">add</span>
        <span class="absolute right-full mr-4 bg-on-surface text-surface text-xs font-bold py-2 px-4 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap shadow-xl">New Registration</span>
        </button>
    </div>
</template>

<style scoped>
</style>
