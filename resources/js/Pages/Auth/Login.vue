<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    username: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Staff Login" />

        <div class="relative z-10 w-full max-w-[440px]">
            <!-- Brand Identity -->
            <div class="mb-10 text-center md:text-left">
                <span class="text-[10px] font-label font-bold tracking-[0.25em] uppercase text-secondary mb-3 block">Lembah Entry VMS</span>
                <h1 class="font-headline text-4xl font-extrabold tracking-tight text-primary leading-tight">Staff Login</h1>
            </div>

            <!-- Status Indicator -->
            <div v-if="status" class="mb-4 text-sm font-medium text-green-600 bg-green-50 p-3 rounded-lg border border-green-200">
                {{ status }}
            </div>

            <!-- Login Card -->
            <div class="bg-white/80 backdrop-blur-md rounded-xl p-10 shadow-[0_32px_64px_rgba(62,0,7,0.08)] border border-white">
                <div class="mb-8">
                    <h2 class="text-xl font-headline font-bold text-on-surface">Sign In</h2>
                    <p class="text-on-surface-variant text-sm mt-1 font-medium">Please enter your credentials to access the terminal.</p>
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Username -->
                    <div class="space-y-2">
                        <label for="username" class="block text-xs font-label font-bold text-on-surface-variant uppercase tracking-widest">Username</label>
                        <input
                            id="username"
                            type="text"
                            class="w-full px-4 py-3 bg-surface-container/50 border border-outline-variant rounded-lg text-on-surface placeholder-stone-400 focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none"
                            v-model="form.username"
                            required
                            autofocus
                            placeholder="e.g. alex.heritage"
                        />
                        <InputError class="mt-2" :message="form.errors.username" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2 flex flex-col">
                        <label for="password" class="block text-xs font-label font-bold text-on-surface-variant uppercase tracking-widest">Password</label>
                        <input
                            id="password"
                            type="password"
                            class="w-full px-4 py-3 bg-surface-container/50 border border-outline-variant rounded-lg text-on-surface placeholder-stone-400 focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none"
                            v-model="form.password"
                            required
                            placeholder="••••••••"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>
                    
                    <!-- Remember Me Option -->
                    <div class="flex items-center">
                        <input
                            id="remember"
                            type="checkbox"
                            v-model="form.remember"
                            class="rounded border-outline-variant text-primary focus:ring-primary h-4 w-4 bg-surface-container/50"
                        />
                        <label for="remember" class="ml-2 block text-sm text-on-surface-variant font-medium">
                            Remember Me
                        </label>
                    </div>

                    <!-- Login Button -->
                    <button
                        type="submit"
                        :class="{'opacity-50 cursor-not-allowed': form.processing}"
                        :disabled="form.processing"
                        class="brand-gradient w-full py-4 text-white font-headline font-bold text-sm uppercase tracking-[0.15em] rounded-lg shadow-xl shadow-primary/20 hover:shadow-primary/30 active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 group"
                    >
                        Login
                        <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </button>
                </form>

                <div class="mt-8 flex flex-col items-center space-y-6">
                    <div class="flex flex-col items-center gap-4">
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-xs font-label font-semibold text-secondary hover:text-primary transition-colors uppercase tracking-widest border-b border-transparent hover:border-primary pb-0.5"
                        >
                            Forgot Password?
                        </Link>

                        <p class="text-[11px] font-medium text-stone-500 uppercase tracking-wide">
                            New Employee? 
                            <Link :href="route('register')" class="text-secondary font-bold hover:text-primary hover:underline transition-colors ml-1">
                                Register Profile
                            </Link>
                        </p>
                    </div>

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
    </GuestLayout>
</template>

<style scoped>
.brand-gradient {
    background: linear-gradient(135deg, #620814 0%, #3e0007 100%)
}
</style>
