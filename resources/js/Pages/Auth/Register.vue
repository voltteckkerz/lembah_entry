<script setup>
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    username: '',
    role: '',
    department: '',
    plate_number: '',
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
    <Head title="Register - Sari Heritage" />

    <div class="bg-surface font-body text-on-surface min-h-screen flex flex-col">
        <!-- Minimalist Branding Header -->
        <header class="w-full flex justify-center pt-12 pb-8">
            <div class="text-center">
                <h1 class="font-headline font-bold tracking-tighter text-3xl text-primary">Sari Heritage</h1>
                <p class="font-label text-xs uppercase tracking-[0.2em] text-on-surface-variant/60 mt-2">Visitor Management System</p>
            </div>
        </header>

        <main class="flex-grow flex items-center justify-center px-6 py-12">
            <div class="max-w-xl w-full">
                <!-- Editorial Content Intro -->
                <div class="mb-10 text-center">
                    <h2 class="font-headline text-4xl font-bold tracking-tight text-primary mb-3">Create Access Profile</h2>
                    <p class="text-on-surface-variant font-body leading-relaxed max-w-sm mx-auto">
                        Join the digital registry of Sari Heritage to ensure seamless hospitality and elevated security for our guests.
                    </p>
                </div>

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

                        <!-- Access Role -->
                        <div class="space-y-2">
                            <label class="font-label text-xs font-bold uppercase tracking-widest text-on-surface-variant/80 ml-1">Access Role</label>
                            <div class="relative">
                                <select v-model="form.role" required class="w-full px-5 py-4 bg-surface border-none rounded-lg appearance-none focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all text-on-surface-variant outline-none">
                                    <option disabled value="">Select Role</option>
                                    <option value="guard">Security Guard</option>
                                    <option value="host">Employee / Host</option>
                                    <option value="supervisor">Duty Supervisor</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant/50 pointer-events-none">expand_more</span>
                            </div>
                            <InputError class="mt-1" :message="form.errors.role" />
                        </div>

                        <!-- Dynamic Staff Fields (Hosts/Supervisors only) -->
                        <transition enter-active-class="transition ease-out duration-300 transform origin-top" enter-from-class="opacity-0 scale-y-95 -translate-y-2" enter-to-class="opacity-100 scale-y-100 translate-y-0" leave-active-class="transition ease-in duration-200 transform origin-top" leave-from-class="opacity-100 scale-y-100 translate-y-0" leave-to-class="opacity-0 scale-y-95 -translate-y-2">
                            <div v-show="form.role === 'host' || form.role === 'supervisor'" class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-[#fbf9f8]/50 p-6 rounded-xl border border-[#3e0007]/5 mt-4">
                                <!-- Department / Floor -->
                                <div class="space-y-2">
                                    <label class="font-label text-xs font-bold uppercase tracking-widest text-on-surface-variant/80 ml-1">Department / Floor</label>
                                    <input v-model="form.department" :required="form.role === 'host' || form.role === 'supervisor'" class="w-full px-5 py-4 bg-white border-none rounded-lg focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-on-surface-variant/40 shadow-sm outline-none" placeholder="Grand Lobby / Level 4" type="text"/>
                                    <InputError class="mt-1" :message="form.errors.department" />
                                </div>
                                
                                <!-- Personal Vehicle Plate -->
                                <div class="space-y-2">
                                    <label class="font-label text-xs font-bold uppercase tracking-widest text-on-surface-variant/80 ml-1 flex justify-between items-center">
                                        Vehicle Plate
                                        <span class="text-[9px] font-medium lowercase tracking-normal italic opacity-50 bg-[#3e0007]/5 px-2 py-0.5 rounded">Optional</span>
                                    </label>
                                    <input v-model="form.plate_number" class="w-full px-5 py-4 bg-white border-none rounded-lg focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-on-surface-variant/40 shadow-sm outline-none" placeholder="ABC 1234" type="text"/>
                                    <InputError class="mt-1" :message="form.errors.plate_number" />
                                </div>
                            </div>
                        </transition>

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
                                Register Profile
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

                    <!-- Editorial Accent Image -->
                    <div class="mt-12 opacity-90 grayscale hover:grayscale-0 transition-all duration-700">
                        <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuD4o5FKBet75r9jpUQsK771xu8BZM8IxAvsYhYQ_Ge8J6SkXjTysKNA1m8dI3uDDZN-6wiyLtTXVnMrkGG8o8jSzxPfARjBMHMy46pyJmnUs6wM8vGC1r7xMaGMOKMtn8h8m_KX6BkeWolc1NdCyMRoUk8Znj1LdgHf-_avTo-yoV2fxT5PFnGoyKLs7cA6LCzI6TTNM6YquN_4sPDTqV2GyQgibaoHqXczdw2pUeen1Od038bFF5L3NhMfnzDdwfQVFPxOfwYmTzIf" alt="Minimalist architectural heritage interior" class="w-full h-48 object-cover rounded-xl grayscale-[0.5]"/>
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
                © 2024 Sari Heritage. Elevated Security & Hospitality.
            </div>
            <div class="flex gap-8">
                <a href="#" class="font-label text-xs uppercase tracking-widest text-primary/50 hover:text-secondary transition-colors">Privacy Policy</a>
                <a href="#" class="font-label text-xs uppercase tracking-widest text-primary/50 hover:text-secondary transition-colors">Terms of Use</a>
                <a href="#" class="font-label text-xs uppercase tracking-widest text-primary/50 hover:text-secondary transition-colors">Regulatory Compliance</a>
            </div>
        </footer>
    </div>
</template>

<style scoped>
/* Inherit global CSS vars implicitly via Tailwind classes */
</style>
