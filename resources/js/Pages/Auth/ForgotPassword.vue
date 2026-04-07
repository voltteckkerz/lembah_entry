<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
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

        <div class="mb-8 overflow-hidden rounded-2xl bg-primary/5 border border-primary/10 p-6 relative group">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-3">
                    <span class="material-symbols-outlined text-primary" data-icon="support_agent">support_agent</span>
                    <h2 class="text-sm font-bold uppercase tracking-widest text-[#3e0007]">Guard Assistance</h2>
                </div>
                <p class="text-sm text-stone-600 leading-relaxed">
                    Forgot your password? Enter your **Username** below to notify the System Admin. They will manually reset your access.
                </p>
            </div>
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-primary/5 rounded-full blur-2xl group-hover:scale-120 transition-transform duration-700"></div>
        </div>

        <div
            v-if="status"
            class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-sm font-bold text-emerald-600 flex items-center gap-3"
        >
            <span class="material-symbols-outlined text-lg">check_circle</span>
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <InputLabel for="username" value="Your Username" class="text-[10px] font-black uppercase tracking-widest text-stone-400 mb-2" />

                <TextInput
                    id="username"
                    type="text"
                    class="mt-1 block w-full bg-stone-50 border-stone-200 focus:ring-primary/20 focus:border-primary rounded-xl"
                    v-model="form.username"
                    required
                    autofocus
                    placeholder="Enter your login username"
                />

                <InputError class="mt-2" :message="form.errors.username" />
            </div>

            <div class="flex flex-col gap-3">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full py-4 bg-[#3e0007] text-white rounded-xl font-bold text-xs uppercase tracking-[0.2em] shadow-lg shadow-primary/20 transition-all hover:bg-[#620814] active:scale-95 disabled:opacity-50 flex items-center justify-center gap-2"
                >
                    <span class="material-symbols-outlined text-sm">send</span>
                    Notify System Admin
                </button>
                
                <div class="relative py-4 flex items-center">
                    <div class="flex-grow border-t border-stone-100"></div>
                    <span class="flex-shrink mx-4 text-[10px] font-black uppercase tracking-widest text-stone-300">Or Immediate Help</span>
                    <div class="flex-grow border-t border-stone-100"></div>
                </div>

                <a 
                    href="https://wa.me/60123456789" 
                    target="_blank"
                    class="w-full py-4 bg-emerald-500 text-white rounded-xl font-bold text-xs uppercase tracking-[0.2em] shadow-lg shadow-emerald-500/20 transition-all hover:bg-emerald-600 active:scale-95 flex items-center justify-center gap-2"
                >
                    <span class="material-symbols-outlined text-sm">chat</span>
                    Chat with Overseer
                </a>
            </div>

            <div class="pt-4 text-center">
                <Link
                    :href="route('login')"
                    class="text-xs font-bold text-stone-400 hover:text-primary transition-colors uppercase tracking-widest"
                >
                    Back to Login
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
