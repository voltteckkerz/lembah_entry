<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Secure Login" />
    <div class="organic-texture font-body text-on-surface min-h-screen flex flex-col">
    <!-- Top Navigation Bar (Shared Component Strategy) -->
    <header class="fixed top-0 left-0 w-full z-50 bg-[#fbf9f8]/80 backdrop-blur-xl shadow-[0_20px_40px_rgba(0,0,0,0.06)]">
    <div class="flex justify-between items-center w-full px-8 py-4 mx-auto max-w-7xl">
    <div class="text-xl font-bold tracking-tighter text-[#3e0007] font-headline">
                VMS Global
            </div>
    <nav class="hidden md:flex gap-8 items-center">
    <a class="text-stone-500 hover:text-[#620814] transition-colors duration-300 font-medium text-sm" href="#">Support</a>
    <a class="text-stone-500 hover:text-[#620814] transition-colors duration-300 font-medium text-sm" href="#">Guidelines</a>
    <button class="ml-4 px-5 py-2 bg-primary text-white text-sm font-semibold rounded-full hover:shadow-lg active:scale-95 transition-all">
                    Staff Login
                </button>
    </nav>
    </div>
    </header>
    <main class="flex-grow flex items-center justify-center relative px-6 py-24">
    <!-- Subtle Background Element -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none opacity-40">
    <div class="absolute top-0 right-0 w-1/2 h-full bg-[#f6f3f2] skew-x-[-12deg] translate-x-32"></div>
    </div>
    <!-- Login Container -->
    <div class="relative z-10 w-full max-w-[440px]">
    <!-- Brand Identity -->
    <div class="mb-10 text-center md:text-left">
    <span class="text-[10px] font-label font-bold tracking-[0.25em] uppercase text-secondary mb-3 block">Sari Heritage VMS</span>
    <h1 class="font-headline text-4xl font-extrabold tracking-tight text-primary leading-tight">Visitor Portal</h1>
    </div>
    <!-- Login Card -->
    <div class="bg-white/80 backdrop-blur-md rounded-xl p-10 shadow-[0_32px_64px_rgba(62,0,7,0.08)] border border-white">
    <div class="mb-8">
    <h2 class="text-xl font-headline font-bold text-on-surface">Sign In</h2>
    <p class="text-on-surface-variant text-sm mt-1 font-medium">Please enter your credentials to access the terminal.</p>
    </div>
    <form class="space-y-6">
    <!-- Username -->
    <div class="space-y-2">
    <label class="block text-xs font-label font-bold text-on-surface-variant uppercase tracking-widest" for="username">Username</label>
    <input class="w-full px-4 py-3 bg-surface-container/50 border border-outline-variant rounded-lg text-on-surface placeholder-stone-400 focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none" id="username" name="username" placeholder="e.g. alex.heritage" type="text"/>
    </div>
    <!-- Password -->
    <div class="space-y-2">
    <label class="block text-xs font-label font-bold text-on-surface-variant uppercase tracking-widest" for="password">Password</label>
    <input class="w-full px-4 py-3 bg-surface-container/50 border border-outline-variant rounded-lg text-on-surface placeholder-stone-400 focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none" id="password" name="password" placeholder="••••••••" type="password"/>
    </div>
    <!-- Login Button -->
    <button class="brand-gradient w-full py-4 text-white font-headline font-bold text-sm uppercase tracking-[0.15em] rounded-lg shadow-xl shadow-primary/20 hover:shadow-primary/30 active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 group" type="submit">
                        Authenticate
                        <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
    </button>
    </form>
    <div class="mt-8 flex flex-col items-center space-y-6">
    <a class="text-xs font-label font-semibold text-secondary hover:text-primary transition-colors uppercase tracking-widest border-b border-transparent hover:border-primary pb-0.5" href="#">
                        Forgot Credentials?
                    </a>
    <div class="pt-6 w-full border-t border-stone-100 flex justify-center">
    <div class="flex items-center gap-2 text-stone-400">
    <span class="material-symbols-outlined text-[16px]">verified_user</span>
    <span class="text-[10px] font-label font-bold uppercase tracking-wider">Encrypted Connection</span>
    </div>
    </div>
    </div>
    </div>
    <!-- Secondary Actions -->
    <div class="mt-8 flex justify-between items-center px-4">
    <button class="flex items-center gap-2 text-xs font-medium text-stone-500 hover:text-primary transition-colors">
    <span class="material-symbols-outlined text-[18px]">language</span>
    <span>English (US)</span>
    </button>
    <button class="flex items-center gap-2 text-xs font-medium text-stone-500 hover:text-primary transition-colors">
    <span class="material-symbols-outlined text-[18px]">contact_support</span>
    <span>Need Help?</span>
    </button>
    </div>
    </div>
    </main>
    <!-- Footer (Shared Component) -->
    <footer class="w-full py-12 px-8 bg-[#f6f3f2] border-t border-stone-200/50 mt-auto">
    <div class="grid grid-cols-1 md:flex md:justify-between items-center max-w-7xl mx-auto gap-6">
    <div>
    <p class="font-['Manrope'] text-sm tracking-wide text-stone-500">
                    © 2024 Organic Editorial VMS. All rights reserved.
                </p>
    </div>
    <nav class="flex flex-wrap gap-x-8 gap-y-2">
    <a class="font-['Manrope'] text-sm tracking-wide text-stone-500 hover:text-[#3e0007] transition-opacity cursor-pointer" href="#">Privacy Policy</a>
    <a class="font-['Manrope'] text-sm tracking-wide text-stone-500 hover:text-[#3e0007] transition-opacity cursor-pointer" href="#">Terms of Service</a>
    <a class="font-['Manrope'] text-sm tracking-wide text-stone-500 hover:text-[#3e0007] transition-opacity cursor-pointer" href="#">Help Center</a>
    <a class="font-['Manrope'] text-sm tracking-wide text-stone-500 hover:text-[#3e0007] transition-opacity cursor-pointer" href="#">Contact</a>
    </nav>
    </div>
    </footer>
    </div>
</template>

<style scoped>
.brand-gradient {
    background: linear-gradient(135deg, #620814 0%, #3e0007 100%)
}
.organic-texture {
    background-image: url(https://lh3.googleusercontent.com/aida-public/AB6AXuCMzZ2pvAwGDFD6hQ-iw_Gu22G14FigpxZ2I_E3rIK-EBlfUdrGOClJLcOViCCIgZN0Ibj58sKXCxFoTONSfR1AtKDCsciyG6Ce747_5uhAM43nC4J63awoU-4AJ5sCCedKx5JjE35AlQY4UQoXlatuhMwMSkGQSkC3UWG8IVuKryhKD18UqPWClQqpT8fJfQOOwlVeR5WarZXx7x-a0TwISPcuPovvsJAF826kTbTfO4CsBaq1seBrv9Ud_lgHQwS7b5tDuSelbQ4o);
    background-color: #fbf9f8
}
.soft-glass {
    background-color: rgba(251, 249, 248, 0.7);
    backdrop-filter: blur(12px)
}
</style>
