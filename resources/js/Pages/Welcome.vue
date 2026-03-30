<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Lembah Entry Visitor Management System" />

    <div class="bg-background text-on-background font-body overflow-x-hidden min-h-screen flex flex-col items-center">
        <!-- Top Navigation -->
        <nav class="fixed top-0 w-full z-50 bg-[#fbf9f8]/80 dark:bg-stone-900/80 backdrop-blur-xl">
            <div class="flex justify-between items-center px-8 py-6 max-w-screen-2xl mx-auto w-full">
                <div class="text-2xl font-headline font-bold tracking-tighter text-[#3e0007] dark:text-[#f6f3f2]">
                    LEMBAH SARI
                </div>
                <div class="hidden md:flex space-x-8 items-center">
                    
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="editorial-gradient text-white px-6 py-2.5 rounded-md font-headline font-semibold scale-95 active:scale-90 transition-transform shadow-lg shadow-primary/10">
                        Dashboard
                    </Link>
                    <Link v-else :href="route('login')" class="editorial-gradient text-white px-6 py-2.5 rounded-md font-headline font-semibold scale-95 active:scale-90 transition-transform shadow-lg shadow-primary/10">
                        Access Portal
                    </Link>
                </div>
                <button class="md:hidden text-primary">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </nav>

        <main class="relative flex flex-col items-center justify-center px-6 pt-32 w-full max-w-screen-2xl flex-grow">
            <!-- Subtle Pattern Overlay -->
            <div class="absolute inset-0 organic-bg pointer-events-none"></div>

            <section class="relative z-10 w-full max-w-4xl text-center space-y-12">
                <!-- Brand Identity Cluster -->
                <div class="space-y-4">
                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 rounded-full bg-primary-container flex items-center justify-center text-white shadow-xl">
                            <span class="material-symbols-outlined text-4xl" data-weight="fill" style="font-variation-settings: 'FILL' 1;">account_balance</span>
                        </div>
                    </div>
                    <h1 class="font-headline text-5xl md:text-7xl font-extrabold tracking-tighter text-primary">
                        Lembah Entry
                    </h1>
                    <p class="font-headline text-xl md:text-2xl font-light text-on-surface-variant tracking-wide">
                        Visitor Management System
                    </p>
                </div>

                <!-- Descriptive Text -->
                <div class="max-w-2xl mx-auto">
                    <p class="text-lg md:text-xl text-on-surface-variant leading-relaxed">
                        A sophisticated portal for managing the heartbeat of our sites. Seamless access control, secure staff oversight, and administrative excellence—tailored for the modern guardian.
                    </p>
                </div>

                <!-- Primary Action -->
                <div class="flex flex-col items-center gap-6 md:flex-row justify-center flex-wrap" v-if="!$page.props.auth.user">
                    <Link :href="route('login')" class="group relative editorial-gradient text-white px-12 py-5 rounded-lg font-headline font-bold text-lg tracking-tight scale-100 hover:scale-105 active:scale-95 transition-all duration-300 shadow-2xl flex items-center gap-3">
                        Login
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </Link>
                    <Link v-if="canRegister" :href="route('register')" class="group relative border-2 border-primary text-primary px-12 py-5 rounded-lg font-headline font-bold text-lg tracking-tight scale-100 hover:scale-105 active:scale-95 transition-all duration-300 shadow-xl flex items-center gap-3 bg-white hover:bg-primary/5">
                        Register
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">person_add</span>
                    </Link>
                    <p class="text-xs uppercase tracking-[0.2em] text-outline font-semibold w-full md:basis-full text-stone-500 mt-4">
                        Authorized Personnel Only
                    </p>
                </div>
                <div class="flex flex-col items-center gap-6 md:flex-row justify-center flex-wrap" v-else>
                    <Link :href="route('dashboard')" class="group relative editorial-gradient text-white px-12 py-5 rounded-lg font-headline font-bold text-lg tracking-tight scale-100 hover:scale-105 active:scale-95 transition-all duration-300 shadow-2xl flex items-center gap-3">
                        Enter Dashboard
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </Link>
                </div>

                <!-- Editorial Feature Image (Decorative/Atmospheric) -->
                <div class="mt-20 relative w-full aspect-[21/9] rounded-2xl overflow-hidden shadow-2xl">
                    <img alt="Sari Heritage Ambiance" class="w-full h-full object-cover" data-alt="Close-up of intricate stone carvings in a heritage building with warm, soft afternoon sunlight and deep shadows creating high contrast" src="https://www.lpu.in/blog/wp-content/uploads/2025/06/What-is-Cyber-Security-The-Different-Types-of-Cybersecurity.png"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/40 to-transparent"></div>
                </div>
            </section>
        </main>

        <!-- Content Section: Tonal Layering -->
        <section class="bg-surface-container-low py-24 px-6 relative z-10 w-full mt-20">
            <div class="max-w-screen-xl mx-auto grid md:grid-cols-3 gap-12">
                <!-- Feature Card 1 -->
                <div class="bg-white p-8 rounded-xl space-y-4 shadow-sm border border-stone-100">
                    <div class="text-primary">
                        <span class="material-symbols-outlined text-3xl">shield_person</span>
                    </div>
                    <h3 class="font-headline text-xl font-bold text-primary">Secure Entry</h3>
                    <p class="text-on-surface-variant text-sm leading-relaxed">
                        Integrated security protocols designed to safeguard institutional integrity while providing a seamless visitor experience.
                    </p>
                </div>

                <!-- Feature Card 2 -->
                <div class="bg-white p-8 rounded-xl space-y-4 shadow-sm border border-stone-100">
                    <div class="text-primary">
                        <span class="material-symbols-outlined text-3xl">query_stats</span>
                    </div>
                    <h3 class="font-headline text-xl font-bold text-primary">Live Archives</h3>
                    <p class="text-on-surface-variant text-sm leading-relaxed">
                        Real-time data synchronization with Heritage curator systems, ensuring every visit is documented with precision.
                    </p>
                </div>

                <!-- Feature Card 3 -->
                <div class="bg-white p-8 rounded-xl space-y-4 shadow-sm border border-stone-100">
                    <div class="text-primary">
                        <span class="material-symbols-outlined text-3xl">history_edu</span>
                    </div>
                    <h3 class="font-headline text-xl font-bold text-primary">Staff Oversight</h3>
                    <p class="text-on-surface-variant text-sm leading-relaxed">
                        Administrative controls that allow for dynamic scheduling and detailed reporting across all heritage checkpoints.
                    </p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="w-full border-t border-[#3e0007]/5 bg-[#f6f3f2] dark:bg-stone-950 relative z-10 mt-auto">
            <div class="flex flex-col md:flex-row justify-between items-center px-12 py-16 w-full mx-auto max-w-screen-2xl">
                <div class="text-lg font-bold text-[#3e0007] dark:text-[#f6f3f2] font-headline mb-8 md:mb-0">
                    HERITAGE
                </div>
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="flex gap-8">
                        <a class="font-['Manrope'] text-sm uppercase tracking-widest text-[#3e0007]/50 dark:text-[#f6f3f2]/50 hover:text-[#0061a2] transition-colors" href="#">Privacy Policy</a>
                        <a class="font-['Manrope'] text-sm uppercase tracking-widest text-[#3e0007]/50 dark:text-[#f6f3f2]/50 hover:text-[#0061a2] transition-colors" href="#">Terms of Service</a>
                        <a class="font-['Manrope'] text-sm uppercase tracking-widest text-[#3e0007]/50 dark:text-[#f6f3f2]/50 hover:text-[#0061a2] transition-colors" href="#">Institutional Access</a>
                    </div>
                    <p class="font-['Manrope'] text-sm uppercase tracking-widest text-[#3e0007]/50 dark:text-[#f6f3f2]/50 mt-8 md:mt-0 text-center">
                        © 2024 Heritage Curator Systems. All rights preserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
.editorial-gradient {
    background: linear-gradient(135deg, #3e0007 0%, #620814 100%);
}
.organic-bg {
    background-color: #fbf9f8;
    background-image: radial-gradient(#3e0007 0.5px, transparent 0.5px);
    background-size: 24px 24px;
    opacity: 0.03;
}
</style>
