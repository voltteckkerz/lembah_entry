<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Visitor Management - Approval Portal" />
    <div class="bg-surface selection:bg-primary/10 font-body text-on-surface min-h-screen flex">
        <!-- SideNavBar (Authority: JSON) -->
        <aside class="fixed left-0 top-0 h-full w-72 pt-24 flex flex-col gap-2 bg-[#fbf9f8] dark:bg-stone-950 z-40 border-r-0 font-['Plus_Jakarta_Sans'] tracking-tighter">
        <!-- Logo Area -->
        <div class="absolute top-8 left-8 flex items-center gap-3">
        <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary-container rounded-lg flex items-center justify-center text-white shadow-lg">
        <span class="material-symbols-outlined">shield_person</span>
        </div>
        <div>
        <h1 class="text-lg font-bold text-[#3e0007] dark:text-white leading-none font-headline">The Curator</h1>
        <p class="text-[10px] uppercase tracking-widest text-stone-500 font-bold mt-1">VMS Portal</p>
        </div>
        </div>
        <nav class="flex flex-col gap-1 pr-4">
        <a class="text-stone-500 dark:text-stone-400 py-3 px-6 hover:bg-[#f6f3f2] dark:hover:bg-stone-900 transition-all duration-300 scale-100 active:scale-[0.98] flex items-center gap-4" href="#">
        <span class="material-symbols-outlined">dashboard</span>
        <span>Dashboard</span>
        </a>
        <a class="text-stone-500 dark:text-stone-400 py-3 px-6 hover:bg-[#f6f3f2] dark:hover:bg-stone-900 transition-all duration-300 scale-100 active:scale-[0.98] flex items-center gap-4" href="#">
        <span class="material-symbols-outlined">person_add</span>
        <span>Register Visit</span>
        </a>
        <a class="text-stone-500 dark:text-stone-400 py-3 px-6 hover:bg-[#f6f3f2] dark:hover:bg-stone-900 transition-all duration-300 scale-100 active:scale-[0.98] flex items-center gap-4" href="#">
        <span class="material-symbols-outlined">calendar_today</span>
        <span>Attendance</span>
        </a>
        <!-- Active State: Approval (Contextual Logic) -->
        <a class="text-[#3e0007] dark:text-white font-bold bg-[#f6f3f2] dark:bg-stone-900 rounded-r-full py-3 px-6 transition-all duration-300 flex items-center gap-4" href="#">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">verified_user</span>
        <span>Approval</span>
        </a>
        <a class="text-stone-500 dark:text-stone-400 py-3 px-6 hover:bg-[#f6f3f2] dark:hover:bg-stone-900 transition-all duration-300 scale-100 active:scale-[0.98] flex items-center gap-4" href="#">
        <span class="material-symbols-outlined">history</span>
        <span>History</span>
        </a>
        <a class="text-stone-500 dark:text-stone-400 py-3 px-6 hover:bg-[#f6f3f2] dark:hover:bg-stone-900 transition-all duration-300 scale-100 active:scale-[0.98] flex items-center gap-4" href="#">
        <span class="material-symbols-outlined">notifications</span>
        <span>Notifications</span>
        </a>
        </nav>
        <div class="mt-auto p-8">
        <div class="p-4 bg-surface-container-low rounded-xl">
        <p class="text-xs font-bold text-on-surface-variant uppercase tracking-tighter mb-2">Admin View</p>
        <div class="flex items-center gap-3">
        <img class="w-10 h-10 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBCIK5XX0SPrFklEzLm6doaGVVj3lV9hAnIYusbu4FOi4eGUBzaAqsX64G1-cWIKrK5EsdXZTHPevpMVV5M_O2n6YzQec76_VcwhGV60rBRqEoGI5aDLGXgZZ1HuoiFVYN2GAPLYR10Jblh8Vx17q3ZxfQTiLO213gGJbptNczdp7v-6IGiNy4iO_Lrr-V-TiwUkIZEWBC0vFdKclKeUlt0p3T55xWtNNbzepnDD_f5M_zJa898_Du8q1bAhDS0LivFkQdoESSYC_7e"/>
        <div>
        <p class="text-sm font-bold text-primary">VMS Admin</p>
        <p class="text-[10px] text-stone-500">Super User</p>
        </div>
        </div>
        </div>
        </div>
        </aside>
        <!-- TopAppBar (Authority: JSON) -->
        <header class="flex justify-between items-center w-full px-8 h-20 sticky top-0 z-50 bg-[#fbf9f8]/80 dark:bg-stone-950/80 backdrop-blur-xl font-['Plus_Jakarta_Sans'] tracking-tight font-medium">
        <div class="flex items-center gap-12 ml-72">
        <div class="relative group">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-stone-400 group-focus-within:text-primary transition-colors">search</span>
        <input class="bg-surface-container-low border-none rounded-full py-2 pl-10 pr-6 text-sm w-80 focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="Search visitor passes..." type="text"/>
        </div>
        </div>
        <div class="flex items-center gap-6">
        <div class="flex items-center gap-2">
        <button class="w-10 h-10 flex items-center justify-center text-stone-500 hover:text-primary transition-all active:opacity-70">
        <span class="material-symbols-outlined">notifications</span>
        </button>
        <button class="w-10 h-10 flex items-center justify-center text-stone-500 hover:text-primary transition-all active:opacity-70">
        <span class="material-symbols-outlined">settings</span>
        </button>
        </div>
        <div class="h-8 w-[1px] bg-outline-variant/30"></div>
        <div class="flex items-center gap-3 cursor-pointer">
        <img class="w-8 h-8 rounded-full border border-outline-variant" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC3bfeRa5BytCJAurpWjPg3DtJ9tiQghmMLrKl5VwwFdbja97WjP7ukaTp32xMchHXrMOFPgAXUuSHfcPVGpf2Fp-cXuRoqVUl5pOQ58EGZ16Ibmtuk6F9hBjqFU3CKL5w78LDx3Fy7V9Izl7vmrRPSABuYSZXilc49VjfIdzwXX_9U3aPVIS27gnoozVLnsPjqJ8AOrZ3RFN9xIpScRix3TJKmj746EwrrDolzzIr40upoUfzftVaC07Xh_LYO7W4EQKmIxaCnIzl2"/>
        <span class="text-sm font-bold text-[#3e0007]">Visitor Management</span>
        </div>
        </div>
        </header>
        <!-- Main Content Canvas -->
        <main class="ml-72 p-12 max-w-7xl mx-auto flex-1">
        <!-- Editorial Header -->
        <header class="mb-12 flex justify-between items-end">
        <div>
        <span class="text-primary font-bold text-sm tracking-[0.2em] uppercase mb-2 block">Control Center</span>
        <h2 class="text-4xl font-headline font-black text-primary tracking-tighter leading-none">Access Approval</h2>
        <p class="text-on-surface-variant mt-4 max-w-md font-body">Review and manage site access requests. Decisions made here are logged and synchronized across the heritage security network.</p>
        </div>
        <!-- Filter Pills (Design System: Secondary Tones) -->
        <div class="flex gap-2 p-1 bg-surface-container-low rounded-xl">
        <button class="px-6 py-2 rounded-lg text-sm font-bold bg-white text-primary shadow-sm transition-all">All Requests</button>
        <button class="px-6 py-2 rounded-lg text-sm font-medium text-on-surface-variant hover:text-primary transition-all">Pending</button>
        <button class="px-6 py-2 rounded-lg text-sm font-medium text-on-surface-variant hover:text-primary transition-all">Approved</button>
        </div>
        </header>
        <!-- Dynamic Feedback Message (Success) -->
        <div class="mb-8 flex items-center gap-4 p-4 bg-emerald-50 text-emerald-800 rounded-xl border-l-4 border-emerald-500 animate-pulse">
        <span class="material-symbols-outlined text-emerald-600" style="font-variation-settings: 'FILL' 1;">check_circle</span>
        <div class="flex-1">
        <p class="text-sm font-bold">DB Updated</p>
        <p class="text-xs opacity-80 font-medium">Visitor V-2026001 has been granted access. Access badge is now active.</p>
        </div>
        <button class="text-emerald-400 hover:text-emerald-600 transition-colors">
        <span class="material-symbols-outlined text-lg">close</span>
        </button>
        </div>
        <!-- Approval Table (Design System: Editorial Content) -->
        <div class="bg-surface-container-lowest rounded-2xl shadow-[0_20px_40px_rgba(62,0,7,0.04)] overflow-hidden">
        <table class="w-full text-left border-collapse">
        <thead>
        <tr class="bg-surface-container-low/50">
        <th class="px-8 py-5 text-xs font-black text-on-surface-variant uppercase tracking-widest">Pass No</th>
        <th class="px-8 py-5 text-xs font-black text-on-surface-variant uppercase tracking-widest">Visitor</th>
        <th class="px-8 py-5 text-xs font-black text-on-surface-variant uppercase tracking-widest">Purpose</th>
        <th class="px-8 py-5 text-xs font-black text-on-surface-variant uppercase tracking-widest text-center">Status</th>
        <th class="px-8 py-5 text-xs font-black text-on-surface-variant uppercase tracking-widest text-right">Action</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-outline-variant/10 font-body">
        <!-- Row 1 -->
        <tr class="group hover:bg-surface-container-low/30 transition-colors">
        <td class="px-8 py-6">
        <span class="font-headline font-bold text-primary tracking-tight">V-2026001</span>
        </td>
        <td class="px-8 py-6">
        <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-primary/5 flex items-center justify-center text-primary font-black text-xs">AR</div>
        <div>
        <p class="font-bold text-on-surface leading-none">Ahmad Rosli</p>
        <p class="text-xs text-on-surface-variant mt-1">Tech Solutions Inc.</p>
        </div>
        </div>
        </td>
        <td class="px-8 py-6">
        <p class="text-sm text-on-surface-variant italic">"Server Maintenance - Phase 2"</p>
        </td>
        <td class="px-8 py-6 text-center">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter bg-amber-100 text-amber-800">
                                        Pending
                                    </span>
        </td>
        <td class="px-8 py-6 text-right">
        <div class="flex justify-end gap-3">
        <button class="px-5 py-2 bg-gradient-to-br from-primary to-primary-container text-white text-xs font-bold rounded-lg hover:shadow-lg hover:shadow-primary/20 transition-all active:scale-95">
                                            Approve
                                        </button>
        <button class="px-5 py-2 border border-outline-variant/30 text-on-surface-variant text-xs font-bold rounded-lg hover:bg-error/5 hover:text-error hover:border-error/20 transition-all">
                                            Reject
                                        </button>
        </div>
        </td>
        </tr>
        <!-- Row 2 -->
        <tr class="group hover:bg-surface-container-low/30 transition-colors">
        <td class="px-8 py-6">
        <span class="font-headline font-bold text-primary tracking-tight">V-2026002</span>
        </td>
        <td class="px-8 py-6">
        <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-secondary/5 flex items-center justify-center text-secondary font-black text-xs">SA</div>
        <div>
        <p class="font-bold text-on-surface leading-none">Siti Aminah</p>
        <p class="text-xs text-on-surface-variant mt-1">Heritage Foundation</p>
        </div>
        </div>
        </td>
        <td class="px-8 py-6">
        <p class="text-sm text-on-surface-variant italic">"Artifact Inspection"</p>
        </td>
        <td class="px-8 py-6 text-center">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter bg-blue-100 text-blue-800">
                                        In Progress
                                    </span>
        </td>
        <td class="px-8 py-6 text-right">
        <div class="flex justify-end gap-3">
        <button class="px-5 py-2 bg-gradient-to-br from-primary to-primary-container text-white text-xs font-bold rounded-lg hover:shadow-lg hover:shadow-primary/20 transition-all active:scale-95">
                                            Approve
                                        </button>
        <button class="px-5 py-2 border border-outline-variant/30 text-on-surface-variant text-xs font-bold rounded-lg hover:bg-error/5 hover:text-error hover:border-error/20 transition-all">
                                            Reject
                                        </button>
        </div>
        </td>
        </tr>
        <!-- Row 3 -->
        <tr class="group hover:bg-surface-container-low/30 transition-colors">
        <td class="px-8 py-6">
        <span class="font-headline font-bold text-primary tracking-tight">V-2026003</span>
        </td>
        <td class="px-8 py-6">
        <div class="flex items-center gap-3">
        <img class="w-10 h-10 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCe0ZZ68LpNpObSYl0BjVMNw2IsICi8hhri5977Llib9rr5wPpxyzm34XXjYspsM85K-qE093zy82v9QIYt0hqZ5VgK1C62NZjJ8a1NkwdB8dy7mN6F1iKctmILBsa5VSEgJU8WKIDmQsRwck7DkiW2yveg6Zc1vo3NGPqLpx1Xg2rPHQi8vALUmagBRbxdlb1mSkqoXcGCmh8qsBjxjorp5aMW-q2unrb2yoDKwvQjc68an4saTACj_iVrxhUCzHPo-3axZ_SK_Q-Z"/>
        <div>
        <p class="font-bold text-on-surface leading-none">Robert Chen</p>
        <p class="text-xs text-on-surface-variant mt-1">Global Audit Partners</p>
        </div>
        </div>
        </td>
        <td class="px-8 py-6">
        <p class="text-sm text-on-surface-variant italic">"Annual Security Review"</p>
        </td>
        <td class="px-8 py-6 text-center">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter bg-amber-100 text-amber-800">
                                        Pending
                                    </span>
        </td>
        <td class="px-8 py-6 text-right">
        <div class="flex justify-end gap-3">
        <button class="px-5 py-2 bg-gradient-to-br from-primary to-primary-container text-white text-xs font-bold rounded-lg hover:shadow-lg hover:shadow-primary/20 transition-all active:scale-95">
                                            Approve
                                        </button>
        <button class="px-5 py-2 border border-outline-variant/30 text-on-surface-variant text-xs font-bold rounded-lg hover:bg-error/5 hover:text-error hover:border-error/20 transition-all">
                                            Reject
                                        </button>
        </div>
        </td>
        </tr>
        </tbody>
        </table>
        <!-- Pagination / Summary Bar -->
        <div class="px-8 py-5 bg-surface-container-low/20 flex justify-between items-center">
        <p class="text-xs text-on-surface-variant font-medium">Showing 3 of 42 pending approvals</p>
        <div class="flex gap-1">
        <button class="w-8 h-8 rounded flex items-center justify-center hover:bg-surface-container-high transition-colors">
        <span class="material-symbols-outlined text-lg">chevron_left</span>
        </button>
        <button class="w-8 h-8 rounded flex items-center justify-center bg-primary text-white text-xs font-bold">1</button>
        <button class="w-8 h-8 rounded flex items-center justify-center hover:bg-surface-container-high transition-colors text-xs font-bold text-on-surface-variant">2</button>
        <button class="w-8 h-8 rounded flex items-center justify-center hover:bg-surface-container-high transition-colors">
        <span class="material-symbols-outlined text-lg">chevron_right</span>
        </button>
        </div>
        </div>
        </div>
        <!-- Secondary Informational Section (Bento Style) -->
        <section class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="col-span-1 bg-secondary-container/10 p-8 rounded-2xl relative overflow-hidden group">
        <div class="relative z-10">
        <h3 class="font-headline font-black text-primary text-xl mb-2">Approval Trends</h3>
        <p class="text-on-secondary-container text-sm font-medium">Daily throughput has increased by 12% since the system update.</p>
        </div>
        <div class="absolute -right-4 -bottom-4 opacity-10 scale-150 transition-transform group-hover:scale-[1.7]">
        <span class="material-symbols-outlined text-primary text-9xl">trending_up</span>
        </div>
        </div>
        <div class="col-span-1 md:col-span-2 bg-surface-container-low p-8 rounded-2xl flex items-center justify-between border border-outline-variant/10">
        <div class="max-w-md">
        <h3 class="font-headline font-bold text-primary text-lg mb-2">Security Note</h3>
        <p class="text-on-surface-variant text-sm font-body">Remember to verify secondary identification for all 'Phase 2' server maintenance requests before clicking final approval.</p>
        </div>
        <div class="flex -space-x-3">
        <img class="w-12 h-12 rounded-full border-2 border-white object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC8-jDaqryV0h-cEfyT9F2cO1gdFKbDO1tRLD_Fcsj1fwjMZbP8TceASeks2IXcMpyp8X9k52l_V_x4-GhzU3pBNgd6C43kFSQCDHipxsEIH_mC6MttzXG3qW6YLAcObBWkmLCJJtsdIkj8Lrd1H-TJZsuB8VHPciem0SQX57hqn7QmZgmQIB6JvMS6AQOGWmywhpl9UGIiPxGiZLjfdwRrsmXfJkxKEJAL3I-zCmqNm2uRHZsH7PVuPKE_ZiOVpsId_Stp_oG80RpM"/>
        <img class="w-12 h-12 rounded-full border-2 border-white object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAB2od-ZlPoYq2EYobuKJrsTXu9AoujIEQVnN8qMC_nyu1csN5nTao0BRYkR7HeW9ckPNZaVsgktklgJ1qUEKRdTphpWZQLchyZ4Cy279DODtQ2j_7GzvuYB6kR43Sqaz2c3w-VFqOPYFepgAca07sVRPeisRYstaC02xgbnRw3K-QSWC3qTNxbGIQWE6v6l2tV--vuMQryfORw9I1VeBMxMkUYwqd3nNgv1nKvVYmkiuluJRdZYnQv20j6_ZXk2wmJxWT3Y75xbyjl"/>
        <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center text-white text-[10px] font-black border-2 border-white">+8</div>
        </div>
        </div>
        </section>
        </main>
    </div>
</template>

<style scoped>
</style>
