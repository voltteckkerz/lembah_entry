<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="VisitorPass Dashboard" />
    <div class="font-body selection:bg-secondary-fixed selection:text-on-secondary-fixed">
    <!-- TopAppBar -->
    <header class="fixed top-0 w-full z-50 glass-header h-16 flex justify-between items-center px-6 no-border">
    <div class="flex items-center gap-4">
    <span class="text-xl font-headline font-bold tracking-tight text-primary">VisitorPass</span>
    </div>
    <div class="flex items-center gap-4">
    <div class="hidden md:flex items-center bg-surface-container-high px-4 py-1.5 rounded-full text-on-surface-variant">
    <span class="material-symbols-outlined text-lg mr-2">search</span>
    <input class="bg-transparent border-none focus:ring-0 text-sm w-64 placeholder-on-surface-variant/60" placeholder="Search visitors..." type="text"/>
    </div>
    <div class="flex items-center gap-3">
    <button class="p-2 rounded-full hover:bg-surface-container transition-colors duration-200 active:scale-95 text-on-surface-variant">
    <span class="material-symbols-outlined">notifications</span>
    </button>
    <button class="p-2 rounded-full hover:bg-surface-container transition-colors duration-200 active:scale-95 text-on-surface-variant">
    <span class="material-symbols-outlined">account_circle</span>
    </button>
    <div class="h-8 w-8 rounded-full overflow-hidden bg-surface-container-highest">
    <img alt="User profile avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuChJJYWq05dGOoZK29DZ10-npprpjvf7kE7IEmvP_jrw6aN0E1gVz-2-lc-ruSaG6mzzeySMMSiQnIDlswrYqXKVM6sYvpQVysLs3pEaXGxKjYIxlQycfWw3OZbI_45NKBpNt9K--D-0yeQnddgBo3vrR_6k6aYINNH_cfOoBlmZgMkxBB8K0EUw4f07UEVA4olC7bu2s1-5HZbd6e19yjeYhB5ERrN4A2z8P2hCaZ-bkwRt8G3Lk0gH1_0WAHe09Ooe13oHUm_FbEE"/>
    </div>
    </div>
    </div>
    </header>
    <!-- SideNavBar -->
    <aside class="h-screen w-64 fixed left-0 top-0 border-r border-primary/10 bg-surface flex flex-col pt-20 pb-8 px-4 z-40">
    <div class="mb-8 px-2">
    <div class="flex items-center gap-3 mb-1">
    <div class="w-8 h-8 editorial-gradient rounded-lg flex items-center justify-center text-white">
    <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">museum</span>
    </div>
    <h2 class="text-lg font-headline font-extrabold text-primary">Visitor Management</h2>
    </div>
    <p class="text-xs font-medium text-on-surface-variant/70 uppercase tracking-widest pl-11">Admin Portal</p>
    </div>
    <nav class="flex-1 space-y-1">
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant opacity-80 hover:bg-surface-container hover:opacity-100 transition-all duration-300" href="#">
    <span class="material-symbols-outlined">app_registration</span>
    <span class="font-medium text-sm">Register Visit</span>
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-primary font-bold border-r-4 border-primary bg-surface-container transition-all duration-300" href="#">
    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">fact_check</span>
    <span class="font-medium text-sm">Attendance</span>
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant opacity-80 hover:bg-surface-container hover:opacity-100 transition-all duration-300" href="#">
    <span class="material-symbols-outlined">verified_user</span>
    <span class="font-medium text-sm">Approval</span>
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant opacity-80 hover:bg-surface-container hover:opacity-100 transition-all duration-300" href="#">
    <span class="material-symbols-outlined">history</span>
    <span class="font-medium text-sm">History</span>
    </a>
    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant opacity-80 hover:bg-surface-container hover:opacity-100 transition-all duration-300" href="#">
    <span class="material-symbols-outlined">notifications_active</span>
    <span class="font-medium text-sm">Notifications</span>
    </a>
    </nav>
    <div class="mt-auto">
    <button class="w-full editorial-gradient text-white py-3 rounded-xl font-bold flex items-center justify-center gap-2 active:scale-95 transition-transform shadow-lg shadow-primary/20">
    <span class="material-symbols-outlined">add</span>
    <span>New Entry</span>
    </button>
    </div>
    </aside>
    <!-- Main Content -->
    <main class="pl-64 pt-16 min-h-screen bg-surface">
    <div class="max-w-7xl mx-auto p-8">
    <!-- Dashboard Header -->
    <div class="mb-10 flex justify-between items-end">
    <div>
    <h1 class="text-4xl font-headline font-extrabold text-primary tracking-tight mb-2">Welcome back, Arthur</h1>
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
    <span class="text-5xl font-headline font-extrabold text-primary">1,284</span>
    <span class="text-secondary font-bold text-sm">+12%</span>
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
    <span class="text-5xl font-headline font-extrabold text-primary">342</span>
    <span class="text-on-surface-variant font-medium text-sm">/ 500 capacity</span>
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
    <span class="text-5xl font-headline font-extrabold text-primary">86</span>
    <span class="text-on-surface-variant font-medium text-sm">present</span>
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
    <!-- Activity Item 1 -->
    <div class="bg-surface-container-lowest p-4 rounded-lg flex items-center justify-between group transition-all hover:translate-x-1">
    <div class="flex items-center gap-4">
    <div class="w-12 h-12 rounded-full overflow-hidden">
    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCrCaXvvaaM64-W00Wld-1mjpkBpsxhyiDMyduPY63I1H0xnqoV8RTQMer-Zc91U55huWzGmnt7L3-Dq323MSORAU1_DzlQWqQRa9e1nroSigfu313SBc9V9HwzQuypeuquiihqlN8AlacPV7AIjcx47v23ertwdcwGYufCudkf6DzWu8gcXdk2iyFNiOl_k3oWoVAtff-Q7c5b6cRHG9e18FKZI6XVJfgTJj708nLMP5ephIz0l8CQUCmfI5Wj0j9G7NwLWSJvSRrW"/>
    </div>
    <div>
    <h4 class="font-bold text-on-surface">Julian Marcotte</h4>
    <p class="text-xs text-on-surface-variant">Check-in: 10:45 AM • Purpose: Business Meeting</p>
    </div>
    </div>
    <div class="flex items-center gap-4">
    <span class="px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed text-xs font-bold uppercase tracking-wider">Active</span>
    <button class="p-2 text-on-surface-variant hover:text-primary transition-colors">
    <span class="material-symbols-outlined">more_vert</span>
    </button>
    </div>
    </div>
    <!-- Activity Item 2 -->
    <div class="bg-surface-container-lowest p-4 rounded-lg flex items-center justify-between group transition-all hover:translate-x-1">
    <div class="flex items-center gap-4">
    <div class="w-12 h-12 rounded-full overflow-hidden">
    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCtXQEPZf4JB1wh90RoT0exRKIrzCMHj5Ow28r-C88dL0nnuaQRormY8D5T2iZE3co-ji-7ubIY0q2ut1yvJ6awhyj4BDkSv3pl5cIcV0hDHnxLyNd9kTpcQd48uOrbUx3ADQY1TG56AiFvBmQMMo6gaTqrYOchJf5JMzxYBHhRVZd2PbXWGlr0sNyWnXWuM7raA668sipJj3ygPDDP7XD03dCacLMFX98ZVjKgckMxHXX6IWyKE6qC0WScsbj1w0GgDut83fZp7x01"/>
    </div>
    <div>
    <h4 class="font-bold text-on-surface">Elena Rodriguez</h4>
    <p class="text-xs text-on-surface-variant">Check-in: 09:12 AM • Purpose: Interview</p>
    </div>
    </div>
    <div class="flex items-center gap-4">
    <span class="px-3 py-1 rounded-full bg-surface-variant text-on-surface-variant text-xs font-bold uppercase tracking-wider">Checked Out</span>
    <button class="p-2 text-on-surface-variant hover:text-primary transition-colors">
    <span class="material-symbols-outlined">more_vert</span>
    </button>
    </div>
    </div>
    <!-- Activity Item 3 -->
    <div class="bg-surface-container-lowest p-4 rounded-lg flex items-center justify-between group transition-all hover:translate-x-1">
    <div class="flex items-center gap-4">
    <div class="w-12 h-12 rounded-full overflow-hidden">
    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDg45mNtPzv5YwJYb1QI0czd8beRtuLaH4OFyo72HZYVAszchN_PVsPBr_i3tKIO5-b7NOhstJf9_U5eAaBZPLwVbUfDcKaYOwE426jucqa04u8fihxRUm8OUy2clqjoEKsMMGszpUylyb5vC5sNSzddW55wUDFonDH1kx-yyi4yEqRFmumtotlyko427c-7t0HQPmb3RNfsewtsrLOU84dawD6tTboZ1KmkMTthpN5NomWIeGmCQ_3mmR2jsfvZeRzhSDFO0623OJT"/>
    </div>
    <div>
    <h4 class="font-bold text-on-surface">Marcus Thorne</h4>
    <p class="text-xs text-on-surface-variant">Check-in: 11:30 AM • Purpose: Delivery</p>
    </div>
    </div>
    <div class="flex items-center gap-4">
    <span class="px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed text-xs font-bold uppercase tracking-wider">Active</span>
    <button class="p-2 text-on-surface-variant hover:text-primary transition-colors">
    <span class="material-symbols-outlined">more_vert</span>
    </button>
    </div>
    </div>
    </div>
    </div>
    <!-- Editorial Break Section -->
    <div class="editorial-gradient rounded-xl p-8 flex flex-col md:flex-row items-center gap-8 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 mix-blend-overlay pointer-events-none">
    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAF1VN1GQIbqk8lLqnNxB2OAs3_x9hn-iQvDoYh9QYTdkHc9jZTjMkss951zNjH3lMVdxZsOBuLhFaEnFTMQSOEgxSLrVnkeVHaUP76M4Ro0G5uwyzXd5_kWWZprkKxk1qL2pgyp_WvqC8rwmCebWaiC28InzyBxXtaSKpFQpRaz359naR_sIaIvNJunz6lGXmI6Wmfnc6YVE4Ibr_bcFB0xx1kqUkpnEoSpYO7hf46FlqRGmWMgbA3fbahz_I77peLVk7u2-QeNHmV"/>
    </div>
    <div class="relative z-10 space-y-4 md:w-2/3">
    <h2 class="text-3xl font-headline font-extrabold text-white leading-tight">Streamlining Guest Access</h2>
    <p class="text-white/80 font-medium">New pre-registration tools are now available for all departments to reduce lobby wait times by 40%.</p>
    <button class="px-6 py-3 bg-white text-primary rounded-lg font-bold hover:bg-surface-bright transition-all active:scale-95">
                                    Learn More
                                </button>
    </div>
    <div class="hidden md:block w-1/3 relative z-10 transform translate-x-4 rotate-3">
    <div class="bg-white/10 backdrop-blur-md p-4 rounded-xl border border-white/20">
    <div class="flex items-center gap-3 mb-4">
    <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">qr_code_2</span>
    <span class="text-white text-xs font-bold tracking-widest uppercase">Smart Pass v2</span>
    </div>
    <div class="h-24 w-full bg-white/20 rounded-lg"></div>
    </div>
    </div>
    </div>
    </div>
    <!-- Right Sidebar / Quick Actions -->
    <div class="col-span-12 lg:col-span-4 space-y-8">
    <!-- Quick Actions -->
    <div class="bg-surface-container-lowest rounded-xl p-6">
    <h3 class="text-lg font-headline font-extrabold text-primary mb-6">Quick Actions</h3>
    <div class="grid grid-cols-2 gap-4">
    <button class="flex flex-col items-center gap-2 p-4 rounded-xl bg-surface-container-low hover:bg-secondary-fixed transition-colors group">
    <span class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">person_add</span>
    <span class="text-xs font-bold text-on-surface-variant">Pre-Register</span>
    </button>
    <button class="flex flex-col items-center gap-2 p-4 rounded-xl bg-surface-container-low hover:bg-secondary-fixed transition-colors group">
    <span class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">output</span>
    <span class="text-xs font-bold text-on-surface-variant">Bulk Checkout</span>
    </button>
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
    <div class="flex gap-4">
    <div class="flex-shrink-0 w-12 h-12 bg-surface-container-lowest rounded-lg flex flex-col items-center justify-center border-t-4 border-secondary shadow-sm">
    <span class="text-xs font-bold text-secondary leading-none">OCT</span>
    <span class="text-lg font-extrabold text-secondary">25</span>
    </div>
    <div>
    <h4 class="font-bold text-sm text-on-surface">Facility Inspection</h4>
    <p class="text-xs text-on-surface-variant">09:30 • 2 Inspectors</p>
    </div>
    </div>
    <div class="flex gap-4">
    <div class="flex-shrink-0 w-12 h-12 bg-surface-container-lowest rounded-lg flex flex-col items-center justify-center border-t-4 border-tertiary shadow-sm">
    <span class="text-xs font-bold text-on-tertiary-container leading-none">OCT</span>
    <span class="text-lg font-extrabold text-on-tertiary-container">25</span>
    </div>
    <div>
    <h4 class="font-bold text-sm text-on-surface">Vendor Onboarding</h4>
    <p class="text-xs text-on-surface-variant">11:00 • 4 Representatives</p>
    </div>
    </div>
    </div>
    <button class="w-full mt-8 py-3 bg-surface-container-lowest text-primary font-bold rounded-lg border border-primary/10 hover:bg-white transition-colors">
                                View Calendar
                            </button>
    </div>
    <!-- Small Map/Location Anchor -->
    <div class="rounded-xl overflow-hidden h-48 relative group">
    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD-TrvLTLkS07xOAN5ZtcS3R6sxpsE17CDBONFmFc0hsw5jmOqVYd2GoOSY2ALu369sVcs6MPf50pMBtJQrU4N_3xT0BthGc66l6NatByHsfkROCTmaNcIfklK1AWO29zKl_zW4hvJbc9doQFOe_nlDOi5lasRJRlCsyMyD5XjZ_Wa56JjckZpFIREje3txFd_TQZy67o_fBOlvsn3SxkqRMdTRr2mGpXV_1Tt9FHy9dSmrnvKEl2Gy_xEU7970Hqw5NuiffcGfugoB"/>
    <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent flex items-end p-4">
    <div class="flex items-center gap-2 text-white">
    <span class="material-symbols-outlined text-sm">location_on</span>
    <span class="text-xs font-bold tracking-wider uppercase">Heritage Center District</span>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </main>
    </div>
</template>

<style scoped>
.editorial-gradient {
    background: linear-gradient(135deg, #3e0007 0%, #620814 100%);
}
.glass-header {
    background: rgba(251, 249, 248, 0.8);
    backdrop-filter: blur(20px);
}
</style>
