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
        <Head title="Staff Login - Lembah Entry VMS" />

        <!-- Main Content Canvas -->
        <main class="w-full relative z-10 py-12 md:py-24">
            <!-- Central Login Card Cluster -->
            <div class="w-full max-w-5xl mx-auto grid md:grid-cols-2 bg-surface-container-low rounded-xl overflow-hidden shadow-2xl relative">
                <!-- Side Image / Editorial Panel -->
                <div class="hidden md:block relative h-full min-h-[600px]">
                    <img class="absolute inset-0 w-full h-full object-cover" alt="Modern corporate lobby" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCt88VvHVdoIEhIaodOZm_rrNgX_nF6JUB0BbFfVxvK5zVAstNpgKUU7r1zl9xpLnouuYTKSZw_t5HnzuwCMdBozxtauKJ553ThThMys9jrRyZ5ds0RvjV5bQFn-L3YigJCttQ2sb-B20PbneF59EWwf87q_tMkwh7cV-A4sgbAdht-Z5RszY40nThbEYwzzwd9xbvQLIwnZR3VmvJ_RYbbDt0trQ9H2zqENQE11_LJacPV9XaHeR0G_imPkwPf7f91CC9UVhYiC95J"/>
                    <div class="absolute inset-0 editorial-gradient opacity-60"></div>
                    <div class="absolute inset-0 flex flex-col justify-end p-12 text-white">
                        <h2 class="font-headline text-4xl font-bold tracking-tight mb-4 text-white">Securing Every Entry point.</h2>
                        <p class="font-body text-lg opacity-90 leading-relaxed max-w-md text-white/90">The terminal for Lembah Entry VMS provides seamless visitor management with heritage-inspired precision.</p>
                    </div>
                </div>

                <!-- Login Form Panel -->
                <div class="bg-surface-container-lowest p-8 md:p-16 flex flex-col justify-center">
                    <div class="mb-10">
                        <h1 class="font-headline text-3xl font-extrabold text-primary tracking-tight mb-2">Staff Login / Sign In</h1>
                        <p class="text-on-surface-variant text-sm font-medium">Please enter your credentials to access the terminal.</p>
                        
                        <div v-if="status" class="mt-4 text-sm font-medium text-emerald-600 bg-emerald-50 p-4 rounded-lg border border-emerald-100">
                            {{ status }}
                        </div>
                    </div>

                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="space-y-2">
                            <label class="font-label text-xs uppercase tracking-widest font-bold text-on-surface-variant">Username</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">person</span>
                                <input 
                                    v-model="form.username"
                                    class="w-full pl-12 pr-4 py-4 bg-surface-container-low border-none rounded-lg focus:ring-2 focus:ring-primary/20 transition-all font-body text-sm outline-none" 
                                    placeholder="e.g. jsmith_staff" 
                                    type="text"
                                    required
                                    autofocus
                                />
                            </div>
                            <InputError class="mt-2" :message="form.errors.username" />
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <label class="font-label text-xs uppercase tracking-widest font-bold text-on-surface-variant">Password</label>
                                <Link v-if="canResetPassword" :href="route('password.request')" class="text-xs font-medium text-secondary hover:underline">Forgot Password?</Link>
                            </div>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">lock</span>
                                <input 
                                    v-model="form.password"
                                    class="w-full pl-12 pr-4 py-4 bg-surface-container-low border-none rounded-lg focus:ring-2 focus:ring-primary/20 transition-all font-body text-sm outline-none" 
                                    placeholder="••••••••" 
                                    type="password"
                                    required
                                />
                            </div>
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="flex items-center gap-3">
                            <input 
                                id="remember" 
                                v-model="form.remember"
                                class="w-4 h-4 text-primary bg-surface-container-low border-none rounded focus:ring-primary/40" 
                                type="checkbox"
                            />
                            <label class="text-sm font-medium text-on-surface-variant cursor-pointer" for="remember">Remember Me</label>
                        </div>

                        <button 
                            class="w-full editorial-gradient text-white font-headline font-bold py-4 rounded-lg flex items-center justify-center gap-2 hover:opacity-90 transition-opacity group disabled:opacity-50" 
                            type="submit"
                            :disabled="form.processing"
                        >
                            Login
                            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </button>
                    </form>

                    <div class="mt-12 pt-8 border-t border-outline-variant/30 text-center">
                        <p class="text-sm font-medium text-on-surface-variant">
                            New Employee? <Link :href="route('register')" class="text-primary font-bold hover:underline">Register Now</Link>
                        </p>
                    </div>

                    <!-- Accessibility/Status Bar -->
                    <div class="mt-12 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-2 text-[10px] uppercase tracking-widest font-bold text-outline">
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">encrypted</span>
                            Encrypted Connection
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-1 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant cursor-pointer hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-sm">language</span>
                                English (US)
                            </div>
                            <div class="flex items-center gap-1 text-[10px] uppercase tracking-widest font-bold text-on-surface-variant cursor-pointer hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-sm">help_outline</span>
                                Need Help?
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </GuestLayout>
</template>

<style scoped>
.editorial-gradient {
    background: linear-gradient(135deg, #3e0007 0%, #620814 100%);
}
</style>
