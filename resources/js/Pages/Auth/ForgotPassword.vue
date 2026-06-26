<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    username: '',
});

const submit = () => {
    form.post(route('support.password_reset'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password Assistance" />

        <!-- Background Architectural Motif -->
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-[#620814] rounded-full blur-[140px] opacity-[0.07]"></div>
            <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-[#63b0fd] rounded-full blur-[140px] opacity-[0.07]"></div>
        </div>

        <!-- Auth Card Container -->
        <div class="relative z-10 w-full max-w-lg bg-white/70 backdrop-blur-2xl rounded-[2rem] shadow-[0_32px_64px_rgba(62,0,7,0.08)] overflow-hidden border border-white/40">
            <div class="p-8 md:p-12">
                <!-- Header: Elegant Branding -->
                <header class="text-center mb-10">
                    <div class="flex justify-center mb-5">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#3e0007] to-[#620814] flex items-center justify-center rounded-2xl rotate-3 shadow-xl shadow-primary/20">
                            <span class="material-symbols-outlined text-white text-3xl">support_agent</span>
                        </div>
                    </div>
                    <h1 class="font-headline font-extrabold text-3xl tracking-tight text-[#3e0007]">Password Reset</h1>
                    <p class="text-stone-500 font-medium mt-2 text-sm">Security & Management Portal</p>
                </header>

                <!-- Alert Box: Guard Assistance -->
                <div class="bg-[#3e0007]/[0.03] rounded-2xl p-5 mb-8 border border-[#3e0007]/[0.06] flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-[#3e0007]/10 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#3e0007] text-xl">shield_person</span>
                    </div>
                    <div class="space-y-1">
                        <h4 class="font-headline font-bold text-[#3e0007] text-sm">Guard Assistance</h4>
                        <p class="text-stone-500 text-sm leading-relaxed">
                            Provide your username below. The system will notify the building administrator to facilitate a manual identity verification and password reset.
                        </p>
                    </div>
                </div>

                <!-- Success Status -->
                <div
                    v-if="status"
                    class="flex items-center gap-3 bg-emerald-50 text-emerald-700 p-4 rounded-xl mb-6 border border-emerald-100"
                >
                    <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    <span class="text-sm font-semibold">{{ status }}</span>
                </div>

                <!-- Form Section -->
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold uppercase tracking-[0.15em] text-stone-400 ml-1" for="username">Your Username</label>
                        <div class="relative">
                            <input
                                id="username"
                                v-model="form.username"
                                class="w-full bg-stone-100/80 border-0 rounded-xl px-5 py-4 text-stone-800 placeholder:text-stone-400/70 focus:ring-2 focus:ring-[#3e0007]/20 focus:bg-white transition-all duration-300 font-medium text-sm outline-none"
                                placeholder="Enter system ID"
                                type="text"
                                required
                                autofocus
                            />
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 text-stone-300">
                                <span class="material-symbols-outlined text-xl">badge</span>
                            </div>
                        </div>
                        <InputError class="mt-2" :message="form.errors.username" />
                    </div>

                    <!-- Primary Action -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full group relative overflow-hidden bg-gradient-to-br from-[#3e0007] to-[#620814] text-white py-4 px-6 rounded-xl font-headline font-bold flex items-center justify-center gap-2 shadow-lg shadow-[#3e0007]/20 active:scale-[0.97] transition-all duration-200 disabled:opacity-50 text-sm tracking-wide"
                    >
                        <span>Notify System Admin</span>
                        <span class="material-symbols-outlined text-lg transition-transform group-hover:translate-x-1">send</span>
                    </button>
                </form>

                <!-- Navigation -->
                <div class="mt-10 text-center">
                    <Link
                        :href="route('login')"
                        class="inline-flex items-center gap-2 text-sm font-bold text-stone-400 hover:text-[#3e0007] transition-colors duration-200"
                    >
                        <span class="material-symbols-outlined text-lg">arrow_back</span>
                        Back to Login
                    </Link>
                </div>
            </div>

            <!-- Bottom Footer Text -->
            <div class="bg-stone-50/80 py-4 text-center border-t border-stone-100">
                <p class="text-[10px] font-bold tracking-[0.2em] uppercase text-stone-400/60">Lembah Entry Security Protocol v1.0</p>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
</style>
