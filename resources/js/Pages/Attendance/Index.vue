<script setup>
import { ref, computed, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link, router } from '@inertiajs/vue3';
import { Combobox, ComboboxInput, ComboboxButton, ComboboxOptions, ComboboxOption } from '@headlessui/vue';

const props = defineProps({
    attendances: Array,
    allStaff: Array, 
    stats: Object,
});

const form = useForm({
    employee_id: null,
    vehicle_plate: '',
    check_in_time: '',
    check_out_time: '', // Added Check-Out Time
});

const showManualTime = ref(false);

const staffForm = useForm({
    name: '',
    plate_number: '',
});

const isRegisterMode = ref(false);
const query = ref('');

// Computed property to filter staff based on the search query
const filteredStaff = computed(() => {
    return query.value === ''
        ? props.allStaff
        : props.allStaff.filter((staff) =>
            staff.name.toLowerCase().includes(query.value.toLowerCase().trim())
        );
});

// Switch to register mode and pre-fill the typed query
const enableRegisterMode = (searchQuery = '') => {
    isRegisterMode.value = true;
    if (searchQuery) {
        query.value = searchQuery;
    }
    // Clear employee selection since it's a new person
    form.employee_id = null; 
};

// Submits the registration using the main form's inputs
const submitRegisterStaff = () => {
    staffForm.name = query.value;
    staffForm.plate_number = form.vehicle_plate;

    staffForm.post(route('attendance.register-staff'), {
        onSuccess: () => {
            staffForm.reset();
            form.reset();
            query.value = '';
            isRegisterMode.value = false; // Turn toggle back off
        },
    });
};

const deleteStaff = (employeeId) => {
    if (confirm('Are you sure you want to delete this staff member?')) {
        router.delete(route('attendance.destroy-staff', { employee: employeeId }), {
            preserveScroll: true,
            onSuccess: () => {
                if (form.employee_id === employeeId) {
                    form.employee_id = null;
                }
            }
        });
    }
};

// Calculate button states dynamically based on selection
const selectedStaffIsCheckedIn = computed(() => {
    if (!form.employee_id) return false;
    return props.attendances.some(a => a.employee_id === form.employee_id && !a.check_out_time);
});

const selectedStaff = computed(() => {
    return props.allStaff.find(s => s.employee_id === form.employee_id) || null;
});

// Watch for Combobox selection changes
watch(() => form.employee_id, (newVal) => {
    handleStaffChange();
});

const handleStaffChange = () => {
    // Reset the manual time toggle when switching staff to prevent accidental overrides
    showManualTime.value = false;

    if (!form.employee_id) {
        if (!isRegisterMode.value) form.vehicle_plate = '';
        return;
    }
    
    // Auto-fill vehicle plate from an active attendance, OR from their Employee profile
    const activeAtt = props.attendances.find(a => a.employee_id === form.employee_id && !a.check_out_time);
    if (activeAtt && activeAtt.vehicle_plate) {
        form.vehicle_plate = activeAtt.vehicle_plate;
    } else {
        const employee = props.allStaff.find(e => e.employee_id === form.employee_id);
        if (employee && employee.plate_number) {
            form.vehicle_plate = employee.plate_number;
        } else {
            form.vehicle_plate = '';
        }
    }
};

const submitCheckIn = () => {
    if (!showManualTime.value) {
        form.check_in_time = '';
    }
    form.post(route('attendance.checkin'), {
        onSuccess: () => {
            form.reset();
            query.value = '';
            showManualTime.value = false;
        },
    });
};

const submitCheckOut = () => {
    // Clear out the manual time if the toggle is disabled
    if (!showManualTime.value) {
        form.check_out_time = '';
    }
    form.post(route('attendance.checkout'), {
        onSuccess: () => {
            form.reset();
            query.value = '';
            showManualTime.value = false; // Reset the toggle
        },
    });
};

// Clears the selected staff member when clicking outside
const clearSelection = () => {
    form.employee_id = null;
};

// Handle clicking an active staff member in the table
const selectActiveStaff = (employeeId) => {
    // If they click the already selected row, toggle it off (deselect)
    if (form.employee_id === employeeId) {
        clearSelection();
        return;
    }

    isRegisterMode.value = false; // Ensure we are not in register mode
    form.employee_id = employeeId;
};

const formatTime = (timeString) => {
    if (!timeString) return '-';
    return new Date(timeString).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
};

const calculateDuration = (checkInTime) => {
    if (!checkInTime) return '-';
    const start = new Date(checkInTime);
    const end = new Date();
    const diffMs = end - start;
    if (diffMs < 0) return '0h 0m';
    const diffHrs = Math.floor(diffMs / 3600000);
    const diffMins = Math.floor((diffMs % 3600000) / 60000);
    return `${diffHrs}h ${diffMins}m`;
};
</script>

<template>
    <Head title="Staff Attendance - Architectural Concierge" />
    <AuthenticatedLayout>
        <div class="p-8 space-y-8 max-w-7xl mx-auto w-full font-body min-h-[calc(100vh-4rem)]" @click="clearSelection">
            <section class="mb-12">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-extrabold text-primary tracking-tight mb-2">Attendance Terminal</h1>
                        <p class="text-on-surface-variant max-w-xl text-lg leading-relaxed">
                            Monitor real-time personnel flow and manage site entry protocols with our heritage-grade tracking system.
                        </p>
                    </div>
                    <div class="flex gap-4">
                        <div class="bg-surface-container-lowest px-6 py-4 rounded-xl shadow-sm min-w-[140px] cursor-default" @click.stop>
                            <span class="block text-xs uppercase tracking-widest text-on-surface-variant font-bold mb-1">On-Site</span>
                            <span class="text-3xl font-black text-primary">{{ stats.presentToday }}</span>
                        </div>
                        <div class="bg-surface-container-lowest px-6 py-4 rounded-xl shadow-sm min-w-[140px] cursor-default" @click.stop>
                            <span class="block text-xs uppercase tracking-widest text-on-surface-variant font-bold mb-1">Total Staff</span>
                            <span class="text-3xl font-black text-secondary">{{ stats.totalStaff }}</span>
                        </div>
                    </div>
                </div>
            </section>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <div class="lg:col-span-4 space-y-8" @click.stop>
                    <div class="bg-surface-container-lowest p-8 rounded-2xl shadow-sm space-y-6">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xl font-bold text-primary">Check-In Terminal</h3>
                            <span class="material-symbols-outlined text-primary/40" data-icon="fingerprint">fingerprint</span>
                        </div>

                        <form @submit.prevent class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant px-1">
                                    {{ isRegisterMode ? 'New Staff Name' : 'Staff Member' }}
                                </label>
                                
                                <div class="relative min-h-[48px]">
                                    <input 
                                        v-if="isRegisterMode" 
                                        v-model="query" 
                                        class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3.5 text-sm focus:ring-2 focus:ring-primary/20 text-on-surface transition-all outline-none" 
                                        placeholder="Type full name..." 
                                        type="text" 
                                        autofocus
                                    />

                                    <Combobox v-else v-model="form.employee_id">
                                        <div class="relative w-full overflow-hidden rounded-lg bg-surface-container-low text-left focus-within:ring-2 focus-within:ring-primary/20 transition-all">
                                            <ComboboxInput
                                                class="w-full border-none py-3.5 pl-4 pr-10 text-sm leading-5 text-on-surface bg-transparent focus:outline-none focus:ring-0"
                                                :displayValue="(id) => props.allStaff.find(s => s.employee_id === id)?.name || ''"
                                                @change="query = $event.target.value"
                                                placeholder="Search or select staff member..."
                                            />
                                            <ComboboxButton class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <span class="material-symbols-outlined text-stone-400">expand_more</span>
                                            </ComboboxButton>
                                        </div>

                                        <transition
                                            enter-active-class="transition duration-100 ease-out"
                                            enter-from-class="transform scale-95 opacity-0"
                                            enter-to-class="transform scale-100 opacity-100"
                                            leave-active-class="transition duration-75 ease-in"
                                            leave-from-class="transform scale-100 opacity-100"
                                            leave-to-class="transform scale-95 opacity-0"
                                        >
                                            <ComboboxOptions class="absolute z-[100] mt-1 max-h-60 w-full overflow-auto rounded-xl bg-white py-2 shadow-2xl ring-1 ring-black/5 focus:outline-none sm:text-sm">
                                                
                                                <div v-if="filteredStaff.length === 0 && query !== ''" class="relative cursor-default select-none py-3 px-4 text-stone-600 font-medium flex items-center justify-between hover:bg-surface-container-low transition-colors" @click.prevent="enableRegisterMode(query)">
                                                    <span>No staff found.</span>
                                                    <span class="text-xs font-bold text-primary underline cursor-pointer">
                                                        Register "{{ query }}"
                                                    </span>
                                                </div>

                                                <ComboboxOption
                                                    v-for="staff in filteredStaff"
                                                    :key="staff.employee_id"
                                                    :value="staff.employee_id"
                                                    as="template"
                                                    v-slot="{ active, selected }"
                                                >
                                                    <li :class="[active ? 'bg-surface-container-low text-primary' : 'text-stone-600', 'relative cursor-pointer select-none py-3 pl-10 pr-12 transition-colors font-medium flex items-center justify-between group/item']">
                                                        <div class="flex items-center w-full">
                                                            <span :class="[selected ? 'font-bold' : 'font-normal', 'block truncate']">{{ staff.name }}</span>
                                                            <span v-if="selected" class="absolute inset-y-0 left-0 flex items-center pl-3 text-primary">
                                                                <span class="material-symbols-outlined text-sm">check</span>
                                                            </span>
                                                        </div>
                                                        <button type="button" @click.stop="deleteStaff(staff.employee_id)" class="opacity-0 group-hover/item:opacity-100 hover:text-error transition-all font-bold p-1 absolute right-2" title="Delete Staff">
                                                            <span class="material-symbols-outlined text-[16px]">delete</span>
                                                        </button>
                                                    </li>
                                                </ComboboxOption>
                                            </ComboboxOptions>
                                        </transition>
                                    </Combobox>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant px-1">Vehicle Plate (Optional)</label>
                                <input v-model="form.vehicle_plate" class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 text-on-surface font-mono tracking-wider transition-all outline-none" placeholder="e.g. DXB 9928" type="text" />
                            </div>

                            <div class="space-y-4 pt-2">
                                <div class="flex items-center justify-between px-1">
                                    <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">
                                        {{ selectedStaffIsCheckedIn ? 'Manual Check-Out Time' : 'Manual Check-In Time' }}
                                    </label>
                                    <button @click="showManualTime = !showManualTime" class="w-10 h-5 rounded-full relative transition-colors duration-200" :class="showManualTime ? 'bg-primary' : 'bg-stone-200'" type="button">
                                        <span class="absolute top-1 bg-white w-3 h-3 rounded-full transition-all duration-200" :class="showManualTime ? 'left-6' : 'left-1'"></span>
                                    </button>
                                </div>
                                <transition
                                    enter-active-class="transition duration-200 ease-out"
                                    enter-from-class="opacity-0 -translate-y-2"
                                    enter-to-class="opacity-100 translate-y-0"
                                    leave-active-class="transition duration-150 ease-in"
                                    leave-from-class="opacity-100 translate-y-0"
                                    leave-to-class="opacity-0 -translate-y-2"
                                >
                                    <div v-if="showManualTime" class="relative">
                                        <input v-if="selectedStaffIsCheckedIn" v-model="form.check_out_time" type="time" class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 text-on-surface transition-all outline-none font-medium" />
                                        <input v-else v-model="form.check_in_time" type="time" class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 text-on-surface transition-all outline-none font-medium" />
                                        
                                        <div class="mt-2 text-[10px] text-on-surface-variant font-medium flex items-center gap-1.5 opacity-70">
                                            <span class="material-symbols-outlined text-sm">history</span>
                                            Overrides automatic system timestamp
                                        </div>
                                    </div>
                                </transition>
                            </div>
                            
                            <div class="flex items-center gap-3 py-2">
                                <button @click="isRegisterMode = !isRegisterMode" class="w-10 h-5 rounded-full relative transition-colors duration-200" :class="isRegisterMode ? 'bg-primary' : 'bg-stone-200'" type="button">
                                    <span class="absolute top-1 bg-white w-3 h-3 rounded-full transition-all duration-200" :class="isRegisterMode ? 'left-6' : 'left-1'"></span>
                                </button>
                                <span class="text-sm font-medium text-on-surface-variant cursor-pointer select-none" @click="isRegisterMode = !isRegisterMode">
                                    Register New Staff Member
                                </span>
                            </div>

                            <div v-if="Object.keys(form.errors).length > 0 || Object.keys(staffForm.errors).length > 0" class="text-xs text-error font-medium bg-error-container/20 p-3 rounded-lg">
                                <p v-for="(error, key) in form.errors" :key="'f-'+key">{{ error }}</p>
                                <p v-for="(error, key) in staffForm.errors" :key="'s-'+key">{{ error }}</p>
                            </div>
                            
                            <div class="pt-4">
                                <button 
                                    v-if="!selectedStaffIsCheckedIn" 
                                    @click="isRegisterMode ? submitRegisterStaff() : submitCheckIn()" 
                                    :disabled="isRegisterMode ? (!query || staffForm.processing) : (!form.employee_id || form.processing)" 
                                    class="w-full bg-emerald-600 text-white py-4 rounded-lg font-bold text-lg shadow-lg hover:bg-emerald-700 transition-all active:scale-[0.98] disabled:opacity-50" 
                                    type="button"
                                >
                                    {{ isRegisterMode ? 'Register & Check In' : 'Check In' }}
                                </button>
                                
                                <button 
                                    v-else 
                                    @click="submitCheckOut" 
                                    :disabled="form.processing" 
                                    class="w-full bg-red-600 text-white py-4 rounded-lg font-bold text-lg shadow-lg hover:bg-red-700 transition-all active:scale-[0.98]" 
                                    type="button"
                                >
                                    Check Out
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="relative h-64 rounded-2xl overflow-hidden group shadow-md">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" data-alt="Close up of intricate traditional textile patterns with deep reds and gold embroidery in soft museum lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBx5GPMjNxsLi4yjglQTZqcy5Y0FtFUAS3nyNOESGhI1krKbyL48VhS_x6a6X3uIxt0msM7d9zbAByR2v1DXtIJUP8ZvooQP6HAhgBtV2rp_1dTGW8v2UcxG7Ih55F2X0zFxUXDtq09zylOGPvNvrVmjf5ZSQ4tQtjx-1naip02XyuT35q27JNuz2l4xWRzWXeDN9GP18vXu_p1tCwi1LoNCNhaf9FRJ4tM_VVmqXOYJyE9LpnkcnVyALHyxjLZydoe9CLITuSCYsqj" />
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/90 to-transparent flex flex-col justify-end p-8 text-left">
                            <p class="text-white text-2xl font-bold tracking-tight leading-none mb-2">Elevating Every Interaction.</p>
                            <p class="text-white/70 text-sm font-medium">Concierge Standard Protocol v4.2</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-8 bg-surface-container-low rounded-xl overflow-hidden shadow-sm flex flex-col h-full max-h-[850px] border border-transparent sticky top-8">
                    <div class="p-6 md:p-8 flex justify-between items-center bg-surface-container-lowest border-b border-outline-variant/10 shrink-0" @click.stop>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary" data-icon="sensors">sensors</span>
                            <h3 class="font-headline font-bold text-lg text-on-surface">Live Visitor Feed</h3>
                        </div>
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                    </div>

                    <div class="flex-1 overflow-y-auto px-4 py-4 bg-surface-container-low/50">
                        <div v-if="attendances.length === 0" class="flex flex-col items-center justify-center h-full min-h-[400px] text-outline gap-3 text-center px-4" @click.stop>
                            <span class="material-symbols-outlined text-4xl opacity-50" data-icon="meeting_room">meeting_room</span>
                            <p class="font-medium text-sm">No active staff records found today.<br>Check in personnel on the left.</p>
                        </div>

                        <div v-else class="space-y-3 pb-8">
                            <div v-for="record in attendances" :key="record.attendance_id" 
                                @click.stop="!record.check_out_time && selectActiveStaff(record.employee_id)"
                                class="bg-surface-container-lowest border p-5 rounded-xl transition-all group relative"
                                :class="{
                                    'opacity-50 pointer-events-none border-outline-variant/10': record.check_out_time,
                                    'cursor-pointer hover:shadow-md hover:bg-stone-50 active:bg-stone-100 border-outline-variant/10': !record.check_out_time && form.employee_id !== record.employee_id,
                                    'bg-stone-100 border-primary/30 shadow-inner': form.employee_id === record.employee_id && !record.check_out_time
                                }"
                            >
                                
                                <div class="absolute left-0 top-0 bottom-0 w-1.5 rounded-l-xl" 
                                     :class="!record.check_out_time ? 'bg-primary' : 'bg-stone-300'">
                                </div>

                                <div class="pl-3 flex flex-col md:flex-row gap-4 items-start md:items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full border-2 border-primary/10 flex items-center justify-center font-bold text-primary bg-primary/5 uppercase ring-2 ring-white z-10"
                                             :class="record.check_out_time ? 'bg-surface-dim text-outline ring-surface-dim/20' : 'bg-primary/5 text-primary'">
                                            {{ record.employee ? record.employee.name.substring(0,2) : 'ST' }}
                                        </div>
                                        
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-bold text-on-surface text-sm transition-colors"
                                                    :class="{'underline decoration-primary/30 underline-offset-4 group-hover:text-primary': !record.check_out_time && form.employee_id !== record.employee_id}">
                                                    {{ record.employee ? record.employee.name : 'Unknown Profile' }}
                                                </h4>
                                            </div>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span v-if="record.vehicle_plate" class="font-mono text-[10px] font-bold text-secondary tracking-widest bg-secondary/10 px-1.5 py-0.5 rounded">{{ record.vehicle_plate }}</span>
                                                <span v-else class="text-[10px] text-outline font-medium italic">No Vehicle</span>
                                                <span class="text-[10px] text-outline font-medium">• Duration: {{ calculateDuration(record.check_in_time) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-4 w-full md:w-auto mt-2 md:mt-0 pt-2 md:pt-0 border-t md:border-t-0 border-outline-variant/10 md:justify-end">
                                        
                                        <div v-if="record.check_in_time" class="flex flex-col items-end md:mr-2">
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-outline">Arrival</span>
                                            <span class="text-xs font-mono font-medium text-on-surface">{{ formatTime(record.check_in_time) }}</span>
                                        </div>
                                        <div v-if="record.check_out_time" class="flex flex-col items-end md:mr-2">
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-outline">Departure</span>
                                            <span class="text-xs font-mono font-bold text-stone-500">{{ formatTime(record.check_out_time) }}</span>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <div v-if="record.check_out_time" class="px-3 py-1.5 rounded-lg bg-stone-100 text-stone-500 text-[9px] font-black uppercase tracking-widest border border-stone-200 shadow-inner">
                                                Ended
                                            </div>
                                            <div v-else class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-widest border border-emerald-100 shadow-inner">
                                                Active
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-stone-50/50 flex justify-center border-t border-stone-100 shrink-0" @click.stop>
                        <Link :href="route('history.index')" class="text-xs font-bold text-on-surface-variant hover:text-primary transition-colors flex items-center gap-1">
                            VIEW ALL RECENT ACTIVITY
                            <span class="material-symbols-outlined text-sm" data-icon="arrow_forward">arrow_forward</span>
                        </Link>
                    </div>
                </div>
            </div>
            
            <section class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 pb-12" @click.stop>
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border-l-4 border-primary/20">
                    <div class="flex justify-between items-start mb-4">
                        <span class="material-symbols-outlined text-stone-400" data-icon="schedule">schedule</span>
                        <span class="text-[10px] font-bold text-emerald-600 uppercase bg-emerald-50 px-2 py-0.5 rounded">-12% vs last wk</span>
                    </div>
                    <div class="text-3xl font-black text-primary mb-1">{{ new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) }}</div>
                    <div class="text-sm font-bold text-on-surface-variant uppercase tracking-tight">Active Terminal Time</div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border-l-4 border-secondary/20">
                    <div class="flex justify-between items-start mb-4">
                        <span class="material-symbols-outlined text-stone-400" data-icon="directions_car">directions_car</span>
                        <div class="w-12 h-1.5 bg-stone-100 rounded-full overflow-hidden">
                            <div class="w-[68%] h-full bg-secondary"></div>
                        </div>
                    </div>
                    <div class="text-3xl font-black text-primary mb-1">68%</div>
                    <div class="text-sm font-bold text-on-surface-variant uppercase tracking-tight">Fleet Availability</div>
                </div>
                <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border-l-4 border-tertiary/20">
                    <div class="flex justify-between items-start mb-4">
                        <span class="material-symbols-outlined text-stone-400" data-icon="verified_user">verified_user</span>
                        <span class="text-[10px] font-bold text-on-surface-variant uppercase bg-stone-100 px-2 py-0.5 rounded">99.9% Uptime</span>
                    </div>
                    <div class="text-3xl font-black text-primary mb-1">Active</div>
                    <div class="text-sm font-bold text-on-surface-variant uppercase tracking-tight">Security Protocol</div>
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.signature-gradient {
    background: linear-gradient(135deg, #3e0007 0%, #620814 100%);
}
</style>