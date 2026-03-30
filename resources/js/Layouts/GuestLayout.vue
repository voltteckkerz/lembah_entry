<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="organic-texture font-body text-on-surface min-h-screen flex flex-col">
        <!-- Top Navigation Bar -->
        <header class="fixed top-0 left-0 w-full z-50 bg-[#fbf9f8]/80 backdrop-blur-xl shadow-[0_20px_40px_rgba(0,0,0,0.06)]">
            <div class="flex justify-between items-center w-full px-8 py-4 mx-auto max-w-7xl">
                <div class="text-xl font-bold tracking-tighter text-[#3e0007] font-headline">
                    VMS Global
                </div>
                <!-- Guest specific nav -->
                <nav class="hidden md:flex gap-8 items-center">
                    <a href="#" class="text-stone-500 hover:text-[#620814] transition-colors duration-300 font-medium text-sm">Support</a>
                    <a href="#" class="text-stone-500 hover:text-[#620814] transition-colors duration-300 font-medium text-sm">Guidelines</a>
                    <Link :href="route('login')" class="ml-4 px-5 py-2 bg-primary text-white text-sm font-semibold rounded-full hover:shadow-lg active:scale-95 transition-all">
                        Staff Login
                    </Link>
                </nav>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-grow flex items-center justify-center relative px-6 py-24">
            <!-- Subtle Background Element -->
            <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none opacity-40">
                <div class="absolute top-0 right-0 w-1/2 h-full bg-[#f6f3f2] skew-x-[-12deg] translate-x-32"></div>
            </div>

            <!-- Injected Page Content -->
            <slot />
        </main>

        <!-- Footer -->
        <footer class="w-full py-12 px-8 bg-[#f6f3f2] border-t border-stone-200/50 mt-auto">
            <div class="grid grid-cols-1 md:flex md:justify-between items-center max-w-7xl mx-auto gap-6">
                <div>
                    <p class="font-['Manrope'] text-sm tracking-wide text-stone-500">
                        © 2024 Organic Editorial VMS. All rights reserved.
                    </p>
                </div>
                <nav class="flex flex-wrap gap-x-8 gap-y-2">
                    <a href="#" class="font-['Manrope'] text-sm tracking-wide text-stone-500 hover:text-[#3e0007] transition-opacity cursor-pointer">Privacy Policy</a>
                    <a href="#" class="font-['Manrope'] text-sm tracking-wide text-stone-500 hover:text-[#3e0007] transition-opacity cursor-pointer">Terms of Service</a>
                    <a href="#" class="font-['Manrope'] text-sm tracking-wide text-stone-500 hover:text-[#3e0007] transition-opacity cursor-pointer">Help Center</a>
                    <a href="#" class="font-['Manrope'] text-sm tracking-wide text-stone-500 hover:text-[#3e0007] transition-opacity cursor-pointer">Contact</a>
                </nav>
            </div>
        </footer>
    </div>
</template>

<style scoped>
.organic-texture {
    background-image: url(https://lh3.googleusercontent.com/aida-public/AB6AXuCMzZ2pvAwGDFD6hQ-iw_Gu22G14FigpxZ2I_E3rIK-EBlfUdrGOClJLcOViCCIgZN0Ibj58sKXCxFoTONSfR1AtKDCsciyG6Ce747_5uhAM43nC4J63awoU-4AJ5sCCedKx5JjE35AlQY4UQoXlatuhMwMSkGQSkC3UWG8IVuKryhKD18UqPWClQqpT8fJfQOOwlVeR5WarZXx7x-a0TwISPcuPovvsJAF826kTbTfO4CsBaq1seBrv9Ud_lgHQwS7b5tDuSelbQ4o);
    background-color: #fbf9f8
}
</style>
