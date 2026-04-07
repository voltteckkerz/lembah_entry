<script setup>
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Listbox, ListboxButton, ListboxOptions, ListboxOption } from '@headlessui/vue';
import { computed } from 'vue';

const form = useForm({
    name: '',
    username: '',
    password: '',
    password_confirmation: '',
});


const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register - Lembah Entry" />

    <div class="bg-surface font-body text-on-surface min-h-screen flex flex-col">
        <!-- Minimalist Branding Header -->
        <header class="w-full flex flex-col items-center pt-8 pb-8">
            <img src="/images/lembah entry logo.png" alt="Lembah Entry Logo" class="h-24 w-auto object-contain mb-4" />
            <div class="text-center">
                <h1 class="font-headline font-bold tracking-tighter text-3xl text-primary">Lembah Entry</h1>
                <p class="font-label text-xs uppercase tracking-[0.2em] text-on-surface-variant/60 mt-2">Visitor Management System</p>
            </div>
        </header>

        <main class="flex-grow flex items-center justify-center px-6 py-12">
            <div class="max-w-xl w-full">
                <!-- Registration Form Card -->
                <div class="bg-surface-container-lowest p-10 rounded-xl shadow-[0_20px_40px_rgba(27,28,28,0.06)] relative overflow-hidden text-left">
                    <!-- Asymmetric Decor -->
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-secondary-container/10 rounded-full blur-3xl pointer-events-none"></div>
                    
                    <form @submit.prevent="submit" class="space-y-6 relative z-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div class="space-y-2">
                                <label class="font-label text-xs font-bold uppercase tracking-widest text-on-surface-variant/80 ml-1">Full Name</label>
                                <input v-model="form.name" required class="w-full px-5 py-4 bg-surface border-none rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all placeholder:text-on-surface-variant/40 outline-none" placeholder="E.g. Alexander Pierce" type="text"/>
                                <InputError class="mt-1" :message="form.errors.name" />
                            </div>
                            <!-- Username -->
                            <div class="space-y-2">
                                <label class="font-label text-xs font-bold uppercase tracking-widest text-on-surface-variant/80 ml-1">Username</label>
                                <input v-model="form.username" required class="w-full px-5 py-4 bg-surface border-none rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all placeholder:text-on-surface-variant/40 outline-none" placeholder="apierce_sh" type="text"/>
                                <InputError class="mt-1" :message="form.errors.username" />
                            </div>
                        </div>


                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <!-- Password -->
                            <div class="space-y-2">
                                <label class="font-label text-xs font-bold uppercase tracking-widest text-on-surface-variant/80 ml-1">Password</label>
                                <input v-model="form.password" required class="w-full px-5 py-4 bg-surface border-none rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all placeholder:text-on-surface-variant/40 outline-none" placeholder="••••••••" type="password"/>
                                <InputError class="mt-1" :message="form.errors.password" />
                            </div>
                            <!-- Confirm Password -->
                            <div class="space-y-2">
                                <label class="font-label text-xs font-bold uppercase tracking-widest text-on-surface-variant/80 ml-1">Confirm Password</label>
                                <input v-model="form.password_confirmation" required class="w-full px-5 py-4 bg-surface border-none rounded-lg focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all placeholder:text-on-surface-variant/40 outline-none" placeholder="••••••••" type="password"/>
                                <InputError class="mt-1" :message="form.errors.password_confirmation" />
                            </div>
                        </div>

                        <!-- Primary Action -->
                        <div class="pt-4">
                            <button type="submit" :disabled="form.processing" class="w-full bg-gradient-to-br from-[#3e0007] to-[#620814] py-5 rounded-lg text-white font-headline font-bold tracking-tight text-lg shadow-xl shadow-primary/20 hover:scale-[1.01] active:scale-[0.98] transition-all disabled:opacity-50">
                                Register Account
                            </button>
                        </div>
                    </form>

                    <!-- Secondary Action -->
                    <div class="mt-8 text-center">
                        <p class="font-body text-sm text-on-surface-variant">
                            Already registered? 
                            <Link :href="route('login')" class="text-secondary font-bold hover:underline ml-1 decoration-secondary/30 underline-offset-4">Login Securely</Link>
                        </p>
                    </div>

                    <div class="mt-12 opacity-90 grayscale hover:grayscale-0 transition-all duration-700">
                        <img src="/images/building.jpg" alt="Minimalist architectural heritage interior" class="w-full h-48 object-cover rounded-xl grayscale-[0.5]"/>
                        <div class="mt-4 flex justify-between items-center text-[10px] uppercase tracking-widest text-on-surface-variant/50 font-label">
                            <span>Registry Section 04</span>
                            <span>Hospitality Focused Security</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-surface flex flex-col md:flex-row justify-between items-center w-full border-t border-[#3e0007]/5 py-12 px-8 mt-auto">
            <div class="font-label text-xs uppercase tracking-widest text-primary/50 mb-4 md:mb-0">
                © 2026 Lembah Entry VMS. All rights reserved.
            </div>
        </footer>
    </div>
</template>

<style scoped>
/* Inherit global CSS vars implicitly via Tailwind classes */
</style>
