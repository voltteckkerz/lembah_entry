<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Staff Attendance - Sari Heritage VMS" />
    <div class="bg-surface text-on-surface font-body selection:bg-secondary/10 min-h-screen">
        <!-- Top App Bar Replacement (Integrated) -->
        <header class="flex justify-between items-center px-10 py-6 bg-surface-bright/90 backdrop-blur-xl sticky top-0 z-30 border-b border-outline-variant/20">
        <div class="flex items-center gap-4">
        <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg">
        <span class="material-symbols-outlined" data-icon="fingerprint" style="font-variation-settings: 'FILL' 1, 'wght' 700;">fingerprint</span>
        </div>
        <div>
        <h1 class="text-2xl font-black text-primary tracking-tight font-headline">Attendance Sync</h1>
        <p class="text-xs uppercase tracking-widest font-bold text-secondary">Sari Heritage Terminals</p>
        </div>
        </div>
        <div class="flex items-center gap-6">
        <div class="flex items-center gap-2 bg-surface-container-highest px-4 py-2 rounded-full">
        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
        <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Terminals Online</span>
        </div>
        <button class="w-10 h-10 rounded-full border border-outline-variant/50 hover:bg-surface-container-highest transition-colors flex items-center justify-center text-on-surface-variant group">
        <span class="material-symbols-outlined group-hover:rotate-90 transition-transform" data-icon="settings">settings</span>
        </button>
        </div>
        </header>
        <!-- Main Layout -->
        <div class="flex">
        <!-- Sidebar Navigation -->
        <aside class="w-64 fixed h-[calc(100vh-89px)] border-r border-outline-variant/20 bg-surface flex flex-col pt-6 font-['Plus_Jakarta_Sans']">
        <nav class="flex-1 space-y-1 px-4">
        <a class="flex items-center px-4 py-3 text-[#44474e] hover:bg-[#f0eded] rounded-xl transition-all duration-200" href="#">
        <span class="material-symbols-outlined mr-3 text-xl" data-icon="grid_view">grid_view</span>
        <span class="font-medium text-sm">Overview</span>
        </a>
        <a class="flex items-center px-4 py-3 bg-[#3e0007] text-white rounded-xl shadow-md transition-all duration-200" href="#">
        <span class="material-symbols-outlined mr-3 text-xl" data-icon="fact_check" style="font-variation-settings: 'FILL' 1;">fact_check</span>
        <span class="font-bold text-sm">Live Attendance</span>
        </a>
        <a class="flex items-center px-4 py-3 text-[#44474e] hover:bg-[#f0eded] rounded-xl transition-all duration-200" href="#">
        <span class="material-symbols-outlined mr-3 text-xl" data-icon="date_range">date_range</span>
        <span class="font-medium text-sm">Timesheets</span>
        </a>
        <a class="flex items-center px-4 py-3 text-[#44474e] hover:bg-[#f0eded] rounded-xl transition-all duration-200" href="#">
        <span class="material-symbols-outlined mr-3 text-xl" data-icon="router">router</span>
        <span class="font-medium text-sm">Devices</span>
        </a>
        </nav>
        <div class="p-6">
        <div class="bg-secondary-container rounded-xl p-4">
        <p class="text-[10px] font-bold text-on-secondary-container uppercase tracking-wider mb-2">Sync Status</p>
        <div class="flex items-end justify-between">
        <span class="text-2xl font-black text-secondary font-headline">99%</span>
        <span class="text-xs text-on-secondary-container mb-1">Last: 2m ago</span>
        </div>
        <div class="w-full bg-white/40 h-1 rounded-full mt-2 overflow-hidden">
        <div class="bg-secondary h-full w-[99%]"></div>
        </div>
        </div>
        </div>
        </aside>
        <!-- Content Area -->
        <main class="ml-64 flex-1 bg-surface-container-lowest p-8 min-h-[calc(100vh-89px)]">
        <div class="max-w-6xl mx-auto">
        <!-- Quick Stats Bento -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <!-- Stat 1 -->
        <div class="bg-surface-container-low p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 opacity-[0.03] group-hover:opacity-10 transition-opacity">
        <span class="material-symbols-outlined text-[120px]" data-icon="badge">badge</span>
        </div>
        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-2 font-label">Total Staff</p>
        <div class="flex items-baseline gap-2">
        <h3 class="text-4xl font-extrabold text-primary font-headline">142</h3>
        <span class="text-xs font-semibold text-secondary">Active</span>
        </div>
        </div>
        <!-- Stat 2 -->
        <div class="bg-surface-container-low p-6 rounded-2xl relative overflow-hidden group border-b-4 border-emerald-500">
        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-2 font-label">Present Today</p>
        <div class="flex items-baseline gap-2">
        <h3 class="text-4xl font-extrabold text-on-surface font-headline">128</h3>
        <span class="text-xs font-semibold text-emerald-600 bg-emerald-100 px-2 py-0.5 rounded-full">90%</span>
        </div>
        </div>
        <!-- Stat 3 -->
        <div class="bg-surface-container-low p-6 rounded-2xl relative overflow-hidden group border-b-4 border-amber-500">
        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-2 font-label">Late Arrivals</p>
        <div class="flex items-baseline gap-2">
        <h3 class="text-4xl font-extrabold text-on-surface font-headline">12</h3>
        <span class="text-xs font-medium text-on-surface-variant">staff</span>
        </div>
        </div>
        <!-- Stat 4 -->
        <div class="bg-surface-container-low p-6 rounded-2xl relative overflow-hidden group border-b-4 border-error">
        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-2 font-label">Absent / Leave</p>
        <div class="flex items-baseline gap-2">
        <h3 class="text-4xl font-extrabold text-on-surface font-headline">2</h3>
        <span class="text-xs font-medium text-error">review needed</span>
        </div>
        </div>
        </div>
        <!-- Real-time Log Section -->
        <div class="bg-surface rounded-3xl shadow-[0_8px_30px_rgba(62,0,7,0.04)] border border-outline-variant/20 overflow-hidden flex flex-col h-[600px]">
        <!-- Table Header & Controls -->
        <div class="p-6 border-b border-outline-variant/10 flex justify-between items-center bg-surface-container-lowest">
        <div>
        <h2 class="text-lg font-bold text-primary font-headline">Live Check-in Feed</h2>
        <p class="text-xs text-on-surface-variant mt-1">Updates automatically from biometric terminals</p>
        </div>
        <div class="flex gap-3">
        <div class="relative">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm" data-icon="search">search</span>
        <input class="bg-surface-container-high border-none rounded-lg py-2 pl-9 pr-4 text-sm focus:ring-2 focus:ring-primary/20 w-64 text-on-surface" placeholder="Search staff ID or name..." type="text"/>
        </div>
        <button class="px-4 py-2 bg-surface-container-high rounded-lg text-sm font-bold text-on-surface-variant hover:bg-surface-container-highest transition-colors flex items-center gap-2">
        <span class="material-symbols-outlined text-sm" data-icon="filter_list">filter_list</span>
                                Filter
                            </button>
        </div>
        </div>
        <!-- Table Body (Scrollable) -->
        <div class="flex-1 overflow-auto bg-[#fbf9f8]">
        <table class="w-full text-left">
        <thead class="sticky top-0 bg-surface-container-low/95 backdrop-blur-sm z-10 shadow-sm">
        <tr class="text-[10px] font-black uppercase tracking-widest text-[#a68966]">
        <th class="px-6 py-4">Status</th>
        <th class="px-6 py-4">Staff Details</th>
        <th class="px-6 py-4">Department</th>
        <th class="px-6 py-4">Time Record</th>
        <th class="px-6 py-4">Terminal Location</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-outline-variant/10">
        <!-- Record 1 (Success) -->
        <tr class="group hover:bg-white transition-colors">
        <td class="px-6 py-4">
        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
        <span class="material-symbols-outlined text-sm" data-icon="login" style="font-variation-settings: 'FILL' 1;">login</span>
        </div>
        </td>
        <td class="px-6 py-4">
        <div class="flex items-center gap-3">
        <img class="w-10 h-10 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDQYofYtVfHItd6hCjB8x0K11V_Q07VvPscZ7Z9Z7c_W7_mIfU_n2V7kU_yL8Fj9M9J-0D1G7Zt6Jv2J4rW3pW3L2d0m8sH7G_jL2Bf1t8A5p4N1Yw4_l4N3p5J-1rY4y2V0X4Z0D_wJq55h_95D_E9Hqg3p1c8-j9o1h7eG_2M1n8D_V4b4H9QJ8F7N9I3A9H7D0YwH7QZ5N6M3K_H0D7W2O"/>
        <div>
        <p class="font-bold text-on-surface">Aminah Hassan</p>
        <p class="text-[10px] text-on-surface-variant font-mono">EMP-084</p>
        </div>
        </div>
        </td>
        <td class="px-6 py-4">
        <span class="text-sm font-semibold text-on-surface-variant">Archival</span>
        </td>
        <td class="px-6 py-4">
        <p class="text-sm font-black text-on-surface">08:42 AM</p>
        <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-wider mt-0.5">On Time</p>
        </td>
        <td class="px-6 py-4">
        <p class="text-xs text-on-surface-variant flex items-center gap-1">
        <span class="material-symbols-outlined text-[10px]" data-icon="location_on">location_on</span>
                                        Main Entrance - T1
                                    </p>
        </td>
        </tr>
        <!-- Record 2 (Late) -->
        <tr class="group hover:bg-white transition-colors bg-amber-50/30">
        <td class="px-6 py-4">
        <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-700">
        <span class="material-symbols-outlined text-sm" data-icon="schedule" style="font-variation-settings: 'FILL' 1;">schedule</span>
        </div>
        </td>
        <td class="px-6 py-4">
        <div class="flex items-center gap-3">
        <img class="w-10 h-10 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDBK7_O_yYxZzT4R0zX2HkQwz-y8oR-T9e9I8Uj6XwQyT7e2P_A1H5v3G7k0Bv6P_H3L1B4m9Z5D0b9U5R0zYvX3N9sH_W_D9A5Z9R6B6W-z2D_H7mB2J9T4G5Y1M_t5B_N5D9Z1D0oY8Q9G_u4m8D0oY0H9Zz-0O3C6M8v5Q7D7H2Y2L9V8y0A3X8C9V2D3F5Y5R3Z_W2J1W9oG_E2M8K1A"/>
        <div>
        <p class="font-bold text-on-surface">David Chen</p>
        <p class="text-[10px] text-on-surface-variant font-mono">EMP-112</p>
        </div>
        </div>
        </td>
        <td class="px-6 py-4">
        <span class="text-sm font-semibold text-on-surface-variant">IT Systems</span>
        </td>
        <td class="px-6 py-4">
        <p class="text-sm font-black text-on-surface">09:15 AM</p>
        <p class="text-[10px] text-amber-600 font-bold uppercase tracking-wider mt-0.5">Late +15m</p>
        </td>
        <td class="px-6 py-4">
        <p class="text-xs text-on-surface-variant flex items-center gap-1">
        <span class="material-symbols-outlined text-[10px]" data-icon="location_on">location_on</span>
                                        Basement Parking - T3
                                    </p>
        </td>
        </tr>
        <!-- Record 3 (Checkout) -->
        <tr class="group hover:bg-white transition-colors">
        <td class="px-6 py-4">
        <div class="w-8 h-8 rounded-full bg-surface-container-highest flex items-center justify-center text-on-surface-variant border border-outline-variant/30">
        <span class="material-symbols-outlined text-sm" data-icon="logout">logout</span>
        </div>
        </td>
        <td class="px-6 py-4">
        <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-black text-xs">
                                        SZ
                                    </div>
        <div>
        <p class="font-bold text-on-surface">Syed Zamri</p>
        <p class="text-[10px] text-on-surface-variant font-mono">EMP-045</p>
        </div>
        </div>
        </td>
        <td class="px-6 py-4">
        <span class="text-sm font-semibold text-on-surface-variant">Maintenance</span>
        </td>
        <td class="px-6 py-4">
        <p class="text-sm font-black text-on-surface">06:05 PM</p>
        <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-wider mt-0.5">Overtime Reg</p>
        </td>
        <td class="px-6 py-4">
        <p class="text-xs text-on-surface-variant flex items-center gap-1">
        <span class="material-symbols-outlined text-[10px]" data-icon="location_on">location_on</span>
                                        Service Lift - T4
                                    </p>
        </td>
        </tr>
        <!-- Record 4 (Anomaly/Error) -->
        <tr class="group hover:bg-white transition-colors bg-error-container/20">
        <td class="px-6 py-4">
        <div class="w-8 h-8 rounded-full bg-error-container flex items-center justify-center text-error border border-error/20">
        <span class="material-symbols-outlined text-sm" data-icon="warning">warning</span>
        </div>
        </td>
        <td class="px-6 py-4">
        <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center text-on-surface-variant">
        <span class="material-symbols-outlined" data-icon="person_off">person_off</span>
        </div>
        <div>
        <p class="font-bold text-error">Unrecognized Scan</p>
        <p class="text-[10px] text-error/70 font-mono">AUTH_FAIL_09X</p>
        </div>
        </div>
        </td>
        <td class="px-6 py-4">
        <span class="text-sm font-semibold text-on-surface-variant">-</span>
        </td>
        <td class="px-6 py-4">
        <p class="text-sm font-black text-on-surface">09:30 AM</p>
        <p class="text-[10px] text-error font-bold uppercase tracking-wider mt-0.5">Biometric Reject</p>
        </td>
        <td class="px-6 py-4">
        <p class="text-xs text-on-surface-variant flex items-center gap-1">
        <span class="material-symbols-outlined text-[10px]" data-icon="location_on">location_on</span>
                                        Gallery A - T2
                                    </p>
        </td>
        </tr>
        </tbody>
        </table>
        </div>
        <!-- Footer / Load Prev -->
        <div class="p-4 bg-surface-container-lowest border-t border-outline-variant/10 text-center">
        <button class="text-xs font-bold text-primary hover:underline uppercase tracking-widest">Load Previous Records</button>
        </div>
        </div>
        </div>
        </main>
        </div>
    </div>
</template>

<style scoped>
</style>
