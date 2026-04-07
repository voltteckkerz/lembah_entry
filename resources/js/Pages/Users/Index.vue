<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    users: Array,
});

const isResetModalOpen = ref(false);
const selectedUser = ref(null);

const form = useForm({
    password: '',
    password_confirmation: '',
});

const openResetModal = (user) => {
    selectedUser.value = user;
    form.reset();
    isResetModalOpen.value = true;
};

const closeResetModal = () => {
    isResetModalOpen.value = false;
    selectedUser.value = null;
    form.reset();
    form.clearErrors();
};

const submitReset = () => {
    form.patch(route('users.reset-password', selectedUser.value.user_id), {
        onSuccess: () => {
            closeResetModal();
        },
    });
};
</script>

<template>
    <Head title="User Management - Lembah Entry" />
    <AuthenticatedLayout>
        <div class="px-6 py-8 bg-[#f8f6f5] min-h-screen">
            <div class="max-w-[1440px] mx-auto space-y-8">
                
                <header class="mb-8 flex flex-col md:flex-row justify-between md:items-center gap-4">
                    <div>
                        <h2 class="text-3xl font-headline font-extrabold text-primary tracking-tight">System Personnel</h2>
                        <p class="text-stone-500 mt-1">Manage Guard access credentials securely.</p>
                    </div>
                </header>

                <div class="bg-white rounded-3xl p-8 shadow-sm border border-stone-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="user in users" :key="user.user_id" class="p-6 rounded-2xl bg-stone-50 border border-stone-100 shadow-sm relative group overflow-hidden">
                            <div class="flex items-start justify-between mb-4 relative z-10">
                                <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-lg mb-2">
                                    {{ user.name.substring(0, 2).toUpperCase() }}
                                </div>
                                <span class="bg-stone-200 text-stone-600 text-[9px] font-black uppercase px-2 py-1 rounded tracking-widest">{{ user.role }}</span>
                            </div>
                            
                            <h3 class="text-lg font-bold text-stone-800 tracking-tight relative z-10">{{ user.name }}</h3>
                            <p class="text-sm font-mono text-stone-500 mb-6 relative z-10">@{{ user.username }}</p>

                            <button @click="openResetModal(user)" class="w-full py-3 bg-white text-stone-700 font-bold text-xs uppercase tracking-widest rounded-xl hover:bg-stone-100 border border-stone-200 transition-all shadow-sm flex items-center justify-center gap-2 relative z-10">
                                <span class="material-symbols-outlined text-sm">key</span>
                                Reset Password
                            </button>
                            
                            <!-- decorative background -->
                            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-primary/5 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                        </div>
                        
                        <div v-if="users.length === 0" class="col-span-full py-12 text-center text-stone-400">
                            No guards recognized in the system database.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Password Reset Modal -->
        <transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0" enter-to-class="opacity-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="isResetModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
                <div class="absolute inset-0 bg-stone-900/40 backdrop-blur-sm" @click="closeResetModal"></div>
                
                <div class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
                    <div class="p-8">
                        <div class="w-12 h-12 bg-red-50 text-error rounded-full flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined">key</span>
                        </div>
                        <h3 class="text-2xl font-headline font-bold text-stone-800 tracking-tight leading-tight mb-2">Reset Password</h3>
                        <p class="text-stone-500 text-sm mb-6">Create a temporary secure password for <strong class="text-primary">{{ selectedUser?.name }}</strong>.</p>
                        
                        <form @submit.prevent="submitReset" class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1.5 ml-1">New Password</label>
                                <input v-model="form.password" type="password" required minlength="8" class="w-full bg-stone-50 border border-stone-200 py-3.5 px-4 rounded-xl focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all text-sm shadow-inner" placeholder="Enter new password">
                                <p v-if="form.errors.password" class="text-error text-xs mt-1.5 ml-1 font-medium">{{ form.errors.password }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1.5 ml-1">Confirm Password</label>
                                <input v-model="form.password_confirmation" type="password" required minlength="8" class="w-full bg-stone-50 border border-stone-200 py-3.5 px-4 rounded-xl focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all text-sm shadow-inner" placeholder="Confirm new password">
                            </div>

                            <div class="pt-4 flex gap-3">
                                <button type="button" @click="closeResetModal" class="flex-1 py-3.5 bg-stone-100 text-stone-600 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-stone-200 transition-all active:scale-95">Cancel</button>
                                <button type="submit" :disabled="form.processing" class="flex-1 py-3.5 bg-primary text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:opacity-90 transition-all disabled:opacity-50 active:scale-95 flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-white/70">save</span>
                                    <span>Save Password</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </transition>
    </AuthenticatedLayout>
</template>
