<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="bg-background font-body text-on-surface min-h-screen flex flex-col">
        <!-- Top Navigation Bar -->
        <header class="fixed top-0 left-0 w-full z-50 bg-[#fbf9f8]/80 backdrop-blur-xl shadow-[0_20px_40px_rgba(0,0,0,0.06)]">
            <div class="flex justify-between items-center w-full px-8 py-4 mx-auto max-w-7xl">
                <div class="text-xl font-bold tracking-tighter text-[#3e0007] font-headline">
                    Lembah Entry VMS
                </div>
                <!-- Guest specific nav -->
                <nav class="hidden md:flex gap-8 items-center">
                    <a href="#" class="text-stone-500 hover:text-[#620814] transition-colors duration-300 font-medium text-sm">Support</a>
                    <a href="#" class="text-stone-500 hover:text-[#620814] transition-colors duration-300 font-medium text-sm">Guidelines</a>
                    <Link :href="route('welcome')" class="ml-4 px-5 py-2 bg-primary text-white text-sm font-semibold rounded-full hover:shadow-lg active:scale-95 transition-all">
                        Back
                    </Link>
                </nav>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-grow flex items-center justify-center relative px-6 py-24">
            <!-- Injected Page Content -->
            <slot />
        </main>

        <!-- Footer -->
        <footer class="w-full py-12 px-8 bg-[#f6f3f2] border-t border-stone-200/50 mt-auto">
            <div class="grid grid-cols-1 md:flex md:justify-between items-center max-w-7xl mx-auto gap-6">
                <div>
                    <p class="font-['Manrope'] text-sm tracking-wide text-stone-500">
                        © 2026 Lembah Entry VMS. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
</style>
