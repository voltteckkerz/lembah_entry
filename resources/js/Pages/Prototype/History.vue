<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="History & Reports - Sari Heritage Visitor Management" />
    <div class="bg-surface text-on-surface font-body selection:bg-primary/10 min-h-screen">
        <!-- SideNavBar Component -->
        <aside class="fixed left-0 top-0 h-full w-[280px] z-50 bg-[#f6f3f2] dark:bg-[#121212] flex flex-col py-8 space-y-2 font-['Plus_Jakarta_SANS'] text-sm font-medium">
        <div class="px-8 mb-10">
        <h1 class="text-2xl font-black tracking-tighter text-[#3e0007] dark:text-[#fbf9f8] uppercase font-headline">Earthbound</h1>
        <p class="text-[10px] tracking-[0.2em] uppercase text-on-surface-variant/60 font-bold mt-1">Visitor Management</p>
        </div>
        <nav class="flex-1 space-y-1">
        <a class="text-[#5a5a5a] dark:text-[#a0a0a0] px-6 py-3 hover:bg-[#fbf9f8]/50 flex items-center gap-4 transition-all duration-200" href="#">
        <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
        <span>Dashboard</span>
        </a>
        <a class="text-[#5a5a5a] dark:text-[#a0a0a0] px-6 py-3 hover:bg-[#fbf9f8]/50 flex items-center gap-4 transition-all duration-200" href="#">
        <span class="material-symbols-outlined" data-icon="person_pin">person_pin</span>
        <span>Active Visitors</span>
        </a>
        <a class="bg-[#3e0007] text-white rounded-r-full mr-4 py-3 px-6 font-semibold flex items-center gap-4 transition-all duration-200" href="#">
        <span class="material-symbols-outlined" data-icon="history">history</span>
        <span>History Log</span>
        </a>
        <a class="text-[#5a5a5a] dark:text-[#a0a0a0] px-6 py-3 hover:bg-[#fbf9f8]/50 flex items-center gap-4 transition-all duration-200" href="#">
        <span class="material-symbols-outlined" data-icon="analytics">analytics</span>
        <span>Reporting</span>
        </a>
        <a class="text-[#5a5a5a] dark:text-[#a0a0a0] px-6 py-3 hover:bg-[#fbf9f8]/50 flex items-center gap-4 transition-all duration-200" href="#">
        <span class="material-symbols-outlined" data-icon="settings">settings</span>
        <span>Settings</span>
        </a>
        </nav>
        <div class="px-6 mt-auto pt-8">
        <button class="w-full bg-primary-container text-white py-4 rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-transform">
        <span class="material-symbols-outlined" data-icon="add">add</span>
                        Check In Visitor
                    </button>
        <div class="mt-8 pt-8 border-t border-outline-variant/20">
        <a class="text-[#5a5a5a] dark:text-[#a0a0a0] px-2 py-3 hover:text-[#3e0007] flex items-center gap-4 transition-all duration-200" href="#">
        <span class="material-symbols-outlined" data-icon="contact_support">contact_support</span>
        <span>Help Center</span>
        </a>
        </div>
        </div>
        </aside>
        <!-- Main Content Area -->
        <main class="ml-[280px] min-h-screen">
        <!-- TopAppBar Component -->
        <header class="fixed top-0 right-0 w-[calc(100%-280px)] z-40 bg-[#fbf9f8]/80 dark:bg-[#1a1a1a]/80 backdrop-blur-md flex justify-between items-center px-8 h-20">
        <div class="flex items-center gap-4">
        <h2 class="text-lg font-bold text-[#3e0007] dark:text-[#fbf9f8] font-['Plus_Jakarta_SANS'] tracking-tight font-headline">History & Reports</h2>
        </div>
        <div class="flex items-center gap-6">
        <div class="flex items-center gap-4">
        <span class="material-symbols-outlined text-[#5a5a5a] cursor-pointer" data-icon="notifications">notifications</span>
        <span class="material-symbols-outlined text-[#5a5a5a] cursor-pointer" data-icon="help_outline">help_outline</span>
        </div>
        <div class="h-10 w-10 rounded-full bg-surface-container-highest overflow-hidden cursor-pointer active:scale-95 transition-transform">
        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDz0s1NZjAtT0cAsphprY9e2NmtwYJPpzS2ntrlDUduQXI3pWQCb1Sio5Ihdn7nh-2lFN09Y3-bsZzwoe8XP3xVGlkhSoD8elfMUuW3YpLJi5tssdKxjJQZzth4mp2_zTYy1CPRkHax5zvUUdq8PQSWo_ugfaLMcUwv_ZjzwQvUREfPPd43KLq7qA0oUAXCx2ygXj324edJoiOAGervAWGaCzGP5UmnL1kOOYZF7AOjnm6IZOks1NiT-weZ9HUkhFXkfdqXDuayCKXZ"/>
        </div>
        </div>
        </header>
        <!-- Page Canvas -->
        <div class="pt-28 px-12 pb-20 max-w-7xl mx-auto">
        <!-- Header Editorial Section -->
        <div class="mb-12 flex flex-col md:flex-row justify-between items-end gap-8">
        <div class="max-w-xl">
        <h3 class="text-4xl font-extrabold tracking-tight text-primary leading-tight font-headline">Archives & Insights</h3>
        <p class="mt-4 text-on-surface-variant text-lg leading-relaxed">Detailed logs of every heritage site visitor. Monitor entries, track host performance, and generate comprehensive compliance reports.</p>
        </div>
        <div class="flex gap-4">
        <button class="bg-surface-container-lowest text-on-surface px-6 py-3 rounded-lg font-bold flex items-center gap-2 transition-all hover:bg-surface-container shadow-sm border border-outline-variant/10">
        <span class="material-symbols-outlined text-xl" data-icon="picture_as_pdf">picture_as_pdf</span>
                                Export as PDF
                            </button>
        <button class="bg-secondary text-white px-6 py-3 rounded-lg font-bold flex items-center gap-2 transition-all hover:opacity-90 shadow-sm">
        <span class="material-symbols-outlined text-xl" data-icon="download">download</span>
                                Excel Data
                            </button>
        </div>
        </div>
        <!-- Advanced Filter Bento -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-12">
        <!-- Search -->
        <div class="md:col-span-7 bg-surface-container-low p-6 rounded-2xl flex flex-col justify-between">
        <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-4 block font-label">Identity Search</label>
        <div class="relative group">
        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant group-focus-within:text-primary transition-colors" data-icon="search">search</span>
        <input class="w-full bg-surface-container-lowest border-none py-4 pl-12 pr-6 rounded-xl focus:ring-2 focus:ring-primary/20 placeholder:text-on-surface-variant/40 text-on-surface font-medium transition-all shadow-sm" placeholder="Search by Visitor Name, IC, or Passport..." type="text"/>
        </div>
        </div>
        <!-- Date Range -->
        <div class="md:col-span-5 bg-surface-container-low p-6 rounded-2xl">
        <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-4 block font-label">Temporal Range</label>
        <div class="flex flex-col gap-3">
        <div class="grid grid-cols-2 gap-2">
        <button class="bg-surface-container-lowest py-2.5 rounded-lg text-sm font-semibold text-primary hover:bg-primary-fixed-dim transition-colors">Today</button>
        <button class="bg-primary text-white py-2.5 rounded-lg text-sm font-semibold shadow-md">Last 7 Days</button>
        </div>
        <div class="relative">
        <input class="w-full bg-surface-container-lowest border-none py-3 px-4 rounded-lg text-sm font-medium text-on-surface cursor-pointer shadow-sm" readonly="" type="text" value="Oct 24, 2023 - Oct 31, 2023"/>
        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm" data-icon="calendar_today">calendar_today</span>
        </div>
        </div>
        </div>
        </div>
        <!-- Data Table Section -->
        <div class="bg-surface-container-lowest rounded-3xl overflow-hidden shadow-[0_20px_40px_-15px_rgba(62,0,7,0.06)]">
        <div class="overflow-x-auto">
        <table class="w-full border-collapse">
        <thead>
        <tr class="bg-surface-container text-left font-label">
        <th class="px-8 py-6 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Timestamp</th>
        <th class="px-6 py-6 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Visitor</th>
        <th class="px-6 py-6 text-xs font-bold uppercase tracking-widest text-on-surface-variant">ID / Passport</th>
        <th class="px-6 py-6 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Purpose</th>
        <th class="px-6 py-6 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Host Employee</th>
        <th class="px-8 py-6 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Status</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-surface-container">
        <!-- Entry 1 -->
        <tr class="hover:bg-surface-container-low/50 transition-colors">
        <td class="px-8 py-6">
        <div class="flex flex-col">
        <span class="font-bold text-on-surface">Oct 31, 2023</span>
        <span class="text-sm text-on-surface-variant">10:45 AM</span>
        </div>
        </td>
        <td class="px-6 py-6 font-semibold text-on-surface">Ahmad Ibrahim</td>
        <td class="px-6 py-6 text-sm font-mono text-on-surface-variant">880214-14-5541</td>
        <td class="px-6 py-6 text-sm text-on-surface">Maintenance Check</td>
        <td class="px-6 py-6 text-sm font-medium">Siti Nurhaliza (Ops)</td>
        <td class="px-8 py-6">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 uppercase tracking-tighter">
        <span class="w-1.5 h-1.5 rounded-full bg-green-600 mr-2"></span>
                                                Checked Out
                                            </span>
        </td>
        </tr>
        <!-- Entry 2 -->
        <tr class="hover:bg-surface-container-low/50 transition-colors">
        <td class="px-8 py-6">
        <div class="flex flex-col">
        <span class="font-bold text-on-surface">Oct 31, 2023</span>
        <span class="text-sm text-on-surface-variant">02:15 PM</span>
        </div>
        </td>
        <td class="px-6 py-6 font-semibold text-on-surface">Julianne Moore</td>
        <td class="px-6 py-6 text-sm font-mono text-on-surface-variant">USA P99827361</td>
        <td class="px-6 py-6 text-sm text-on-surface">VVIP Tour</td>
        <td class="px-6 py-6 text-sm font-medium">David Tan (Curator)</td>
        <td class="px-8 py-6">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 uppercase tracking-tighter">
        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mr-2"></span>
                                                Active
                                            </span>
        </td>
        </tr>
        <!-- Entry 3 -->
        <tr class="hover:bg-surface-container-low/50 transition-colors">
        <td class="px-8 py-6">
        <div class="flex flex-col">
        <span class="font-bold text-on-surface">Oct 31, 2023</span>
        <span class="text-sm text-on-surface-variant">09:00 AM</span>
        </div>
        </td>
        <td class="px-6 py-6 font-semibold text-on-surface">Kevin Zhang</td>
        <td class="px-6 py-6 text-sm font-mono text-on-surface-variant">CN 5542190</td>
        <td class="px-6 py-6 text-sm text-on-surface">Delivery</td>
        <td class="px-6 py-6 text-sm font-medium">Reception Desk</td>
        <td class="px-8 py-6">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-error-container text-red-900 uppercase tracking-tighter">
        <span class="w-1.5 h-1.5 rounded-full bg-error mr-2"></span>
                                                Overstayed
                                            </span>
        </td>
        </tr>
        <!-- Entry 4 -->
        <tr class="hover:bg-surface-container-low/50 transition-colors">
        <td class="px-8 py-6">
        <div class="flex flex-col">
        <span class="font-bold text-on-surface">Oct 30, 2023</span>
        <span class="text-sm text-on-surface-variant">11:30 AM</span>
        </div>
        </td>
        <td class="px-6 py-6 font-semibold text-on-surface">Sarah Connor</td>
        <td class="px-6 py-6 text-sm font-mono text-on-surface-variant">UK 1299883</td>
        <td class="px-6 py-6 text-sm text-on-surface">Media Interview</td>
        <td class="px-6 py-6 text-sm font-medium">Director's Office</td>
        <td class="px-8 py-6">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 uppercase tracking-tighter">
        <span class="w-1.5 h-1.5 rounded-full bg-green-600 mr-2"></span>
                                                Checked Out
                                            </span>
        </td>
        </tr>
        <!-- Entry 5 -->
        <tr class="hover:bg-surface-container-low/50 transition-colors">
        <td class="px-8 py-6">
        <div class="flex flex-col">
        <span class="font-bold text-on-surface">Oct 30, 2023</span>
        <span class="text-sm text-on-surface-variant">04:00 PM</span>
        </div>
        </td>
        <td class="px-6 py-6 font-semibold text-on-surface">Lim Wei Seng</td>
        <td class="px-6 py-6 text-sm font-mono text-on-surface-variant">920512-01-4433</td>
        <td class="px-6 py-6 text-sm text-on-surface">IT Audit</td>
        <td class="px-6 py-6 text-sm font-medium">Zul Ariffin (IT)</td>
        <td class="px-8 py-6">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 uppercase tracking-tighter">
        <span class="w-1.5 h-1.5 rounded-full bg-green-600 mr-2"></span>
                                                Checked Out
                                            </span>
        </td>
        </tr>
        </tbody>
        </table>
        </div>
        <!-- Pagination -->
        <div class="px-8 py-6 bg-surface-container-low flex items-center justify-between">
        <p class="text-sm text-on-surface-variant font-medium">Showing 1 to 5 of 124 records</p>
        <div class="flex gap-2">
        <button class="w-10 h-10 rounded-lg flex items-center justify-center text-on-surface-variant hover:bg-surface-container transition-colors">
        <span class="material-symbols-outlined" data-icon="chevron_left">chevron_left</span>
        </button>
        <button class="w-10 h-10 rounded-lg bg-primary text-white font-bold text-sm">1</button>
        <button class="w-10 h-10 rounded-lg flex items-center justify-center text-on-surface-variant hover:bg-surface-container transition-colors font-bold text-sm">2</button>
        <button class="w-10 h-10 rounded-lg flex items-center justify-center text-on-surface-variant hover:bg-surface-container transition-colors font-bold text-sm">3</button>
        <button class="w-10 h-10 rounded-lg flex items-center justify-center text-on-surface-variant hover:bg-surface-container transition-colors">
        <span class="material-symbols-outlined" data-icon="chevron_right">chevron_right</span>
        </button>
        </div>
        </div>
        </div>
        <!-- Visual Breakdown / Quick Stats -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="relative h-[200px] rounded-3xl overflow-hidden group">
        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDhuCwQlqAKAb6OCkg_3ExqNJv0swO2gmmm3KEvWtbMrDu00eBgesprs0i181X0WuViced_C7fxhCYds89Xn_L-K6wI1jOd_IZNvUcTtOCHeWPM5QDvVPo6V6JgO9fK6vid_W_e28L9efqaqpU7GljYAxQ7WZ7oypnzM3z4mnEhl0BcOP159sMAJ-00kYuR_-0Nl3iZkjN-B9ZN4CpdL7zc0FHOK7ArdsttopxkNEzZFGSsQ6FcTfYTOH-ck0OxibTlid5utPPh8sgq"/>
        <div class="absolute inset-0 bg-primary/40 backdrop-blur-[2px] p-8 flex flex-col justify-end">
        <span class="text-white/80 text-xs font-bold uppercase tracking-widest mb-1 font-label">Peak Hours</span>
        <h4 class="text-white text-3xl font-extrabold tracking-tight font-headline">10:00 AM</h4>
        <p class="text-white/60 text-sm mt-2">Highest visitor density recorded today</p>
        </div>
        </div>
        <div class="relative h-[200px] rounded-3xl overflow-hidden group">
        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDXPXSZ4qJaEDdmpBaALWv0lhbAPnGJnNOaEixE4t4bueviCdzoJ4s3nsysEw3yxhges67xBO2OF21YMyD_xh8t9fabhmkBaowdBrzktkbBm-_IKcFND6d8Szyq8s8bSXY7K9baVvRuMTfEGrLWM3C6oGGU2F37rOE3UniK6yRZ6v9jD_z_NbAhOidBKrAWoJYhhWQu05SqsGbtFlPCMkdCI2rE2Q81sMnT-21jK9N_-IP-vO84jnPcFTzVAuPxrI514T4LxNXSjtfr"/>
        <div class="absolute inset-0 bg-secondary/40 backdrop-blur-[2px] p-8 flex flex-col justify-end">
        <span class="text-white/80 text-xs font-bold uppercase tracking-widest mb-1 font-label">Avg Duration</span>
        <h4 class="text-white text-3xl font-extrabold tracking-tight font-headline">1h 45m</h4>
        <p class="text-white/60 text-sm mt-2">Average time spent per visitor session</p>
        </div>
        </div>
        <div class="relative h-[200px] rounded-3xl overflow-hidden group bg-surface-container-high flex flex-col justify-center items-center text-center p-8">
        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4">
        <span class="material-symbols-outlined text-primary text-3xl" data-icon="auto_awesome">auto_awesome</span>
        </div>
        <h4 class="text-primary font-bold font-headline">Predictive Alert</h4>
        <p class="text-on-surface-variant text-sm mt-2">Expecting 25% higher volume next Friday for Heritage Gala.</p>
        </div>
        </div>
        </div>
        </main>
    </div>
</template>

<style scoped>
</style>
