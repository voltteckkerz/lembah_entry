<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    attendances: Array,
    allStaff: Array, // Note: This contains App\Models\Employee objects
    stats: Object,
});

const form = useForm({
    employee_id: null,
    vehicle_plate: '',
});

// Calculate button states dynamically based on selection
const selectedStaffIsCheckedIn = computed(() => {
    if (!form.employee_id) return false;
    // Find active attendance for this employee id
    return props.attendances.some(a => a.employee_id === form.employee_id && !a.check_out_time);
});

const handleStaffChange = () => {
    if (!form.employee_id) {
        form.vehicle_plate = '';
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
    form.post(route('attendance.checkin'), {
        onSuccess: () => form.reset(),
    });
};

const submitCheckOut = () => {
    form.post(route('attendance.checkout'), {
        onSuccess: () => form.reset(),
    });
};

const quickCheckOut = (employeeId) => {
    const tempForm = useForm({ employee_id: employeeId });
    tempForm.post(route('attendance.checkout'));
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
        <div class="p-8 space-y-8 max-w-7xl mx-auto w-full font-body">
            <!-- Hero Header Section -->
            <section class="flex flex-col md:flex-row justify-between items-end gap-6 mb-4">
                <div class="space-y-2">
                    <h2 class="text-4xl font-headline font-extrabold tracking-tight text-primary">Attendance Terminal</h2>
                    <p class="text-secondary font-medium">Manage on-site personnel and fleet movements with architectural precision.</p>
                </div>
                <div class="flex items-center gap-3 bg-surface-container-low p-2 rounded-xl">
                    <div class="px-4 py-2 bg-surface-container-lowest rounded-lg shadow-sm">
                        <p class="text-[10px] uppercase tracking-wider text-outline font-bold">Total On-Site</p>
                        <p class="text-2xl font-headline font-extrabold text-primary">{{ stats.presentToday }}</p>
                    </div>
                    <div class="px-4 py-2">
                        <p class="text-[10px] uppercase tracking-wider text-outline font-bold">Total Staff</p>
                        <p class="text-2xl font-headline font-extrabold text-secondary">{{ stats.totalStaff }}</p>
                    </div>
                </div>
            </section>

            <!-- Main Asymmetric Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Staff Entry Form (Bento Style) -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-surface-container-low rounded-xl p-8 space-y-6 transition-all border border-transparent hover:border-outline-variant/20">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="material-symbols-outlined text-primary" data-icon="how_to_reg">how_to_reg</span>
                            <h3 class="font-headline font-bold text-lg text-on-surface">Staff Check-In</h3>
                        </div>
                        <form @submit.prevent class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-widest text-outline ml-1">Staff Member</label>
                                <div class="relative">
                                    <select v-model="form.employee_id" @change="handleStaffChange" class="w-full bg-surface-container-lowest border-outline-variant/20 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/10 transition-all outline-none appearance-none">
                                        <option disabled :value="null">Select a registered staff member</option>
                                        <option v-for="staff in allStaff" :key="staff.employee_id" :value="staff.employee_id">
                                            {{ staff.name }} ({{ staff.department }})
                                        </option>
                                    </select>
                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center ml-1">
                                    <label class="text-xs font-bold uppercase tracking-widest text-outline">Vehicle Plate (Optional)</label>
                                </div>
                                <input v-model="form.vehicle_plate" class="w-full bg-surface-container-lowest border-outline-variant/20 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all outline-none placeholder:text-stone-300" placeholder="e.g. LN22 XYC" type="text" />
                                <p v-if="form.employee_id && !form.vehicle_plate" class="text-[10px] text-amber-600 font-bold ml-1 mt-1 transition-all">Entering without vehicle profile</p>
                            </div>
                            
                            <!-- Error Messages -->
                            <div v-if="Object.keys(form.errors).length > 0" class="text-xs text-error font-medium bg-error-container/20 p-3 rounded-lg">
                                <p v-for="(error, key) in form.errors" :key="key">{{ error }}</p>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 pt-4">
                                <button @click="submitCheckIn" :disabled="selectedStaffIsCheckedIn || form.processing" class="signature-gradient text-white font-label text-xs font-bold tracking-widest uppercase py-4 rounded-lg shadow-lg hover:scale-[1.02] active:scale-95 transition-all disabled:opacity-50 disabled:hover:scale-100 disabled:cursor-not-allowed" type="button" :class="selectedStaffIsCheckedIn ? 'shadow-none' : 'shadow-primary/20'">
                                    Check-in
                                </button>
                                <button @click="submitCheckOut" :disabled="!selectedStaffIsCheckedIn || form.processing" class="bg-surface-container-lowest border font-label text-xs font-bold tracking-widest uppercase py-4 rounded-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed" :class="selectedStaffIsCheckedIn ? 'border-primary text-primary hover:bg-primary/5' : 'border-outline-variant/20 text-outline'" type="button">
                                    Check-out
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Decorative Branding Image -->
                    <div class="relative h-64 rounded-xl overflow-hidden group">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" data-alt="luxury corporate office reception with minimalist architectural lines and soft natural lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCbuS0qg741znHefODl6AC9B_7jmKu4OOJpnLQMoK--HOiqRnk2zd22pVgbE976Qealyk9lU8Y3JiEslP1RwriNxKnq3HL1gANPb3RunREqf5_S_Nsaj9SCFphw8R0iNt52cUEAfTV6hYntabT6ScEFi6ii8z_vm7rHIhgPhASi6dpJxj7R30WZM7qe_ON8D7Pdz2KPTkqcD2Lcno009WcCyctUeB2yc2PY76t5GQUH-uanXKIqNxYCxYZJadStOnfgEIQeyaKW_G1R" />
                        <div class="absolute inset-0 bg-primary/40 mix-blend-multiply"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <p class="text-white font-headline font-bold text-lg leading-tight">Elevating Every Interaction.</p>
                            <p class="text-white/70 text-xs mt-1">Concierge Standard Protocol v4.2</p>
                        </div>
                    </div>
                </div>

                <!-- Live Status Table (Glass-morphism feel) -->
                <div class="lg:col-span-8 bg-surface-container-low rounded-xl overflow-hidden">
                    <div class="p-8 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary" data-icon="podium">podium</span>
                            <h3 class="font-headline font-bold text-lg text-on-surface">Live Status Table</h3>
                        </div>
                        <div class="flex gap-2">
                            <button class="px-3 py-1.5 text-xs font-bold text-primary bg-white rounded-lg shadow-sm border border-outline-variant/10">All Staff</button>
                            <!-- <button class="px-3 py-1.5 text-xs font-medium text-outline hover:text-primary transition-colors">By Vehicle</button> -->
                        </div>
                    </div>

                    <div class="overflow-x-auto px-4 pb-8 h-[600px] overflow-y-auto">
                        <table class="w-full text-left border-separate border-spacing-y-3">
                            <thead class="sticky top-0 bg-surface-container-low z-10">
                                <tr class="text-outline uppercase text-[10px] tracking-widest font-bold">
                                    <th class="px-4 pb-2">Staff Profile</th>
                                    <th class="px-4 pb-2">Vehicle Plate</th>
                                    <th class="px-4 pb-2">Check-in Time</th>
                                    <th class="px-4 pb-2">Duration</th>
                                    <th class="px-4 pb-2 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="space-y-4">
                                <tr v-for="record in attendances" :key="record.attendance_id" class="bg-surface-container-lowest group hover:translate-x-1 transition-all duration-300" :class="{'opacity-50': record.check_out_time}">
                                    <td class="px-4 py-5 rounded-l-xl">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center font-bold text-primary overflow-hidden uppercase text-xs">
                                                {{ record.employee ? record.employee.name.substring(0,2) : 'ST' }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-on-surface">{{ record.employee ? record.employee.name : 'Unknown Profile' }}</p>
                                                <p class="text-[10px] text-outline">{{ record.employee ? record.employee.department : 'Operations' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-5">
                                        <span v-if="record.vehicle_plate" class="font-mono text-xs font-bold text-secondary bg-secondary-container/20 px-2 py-1 rounded">{{ record.vehicle_plate || 'N/A' }}</span>
                                        <span v-else class="text-[10px] font-medium text-outline italic">No Vehicle Logging</span>
                                    </td>
                                    <td class="px-4 py-5 text-sm text-on-surface-variant font-medium">
                                        {{ formatTime(record.check_in_time) }}
                                        <div v-if="record.check_out_time" class="text-[10px] text-outline mt-1 font-normal">Out: {{ formatTime(record.check_out_time) }}</div>
                                    </td>
                                    <td class="px-4 py-5">
                                        <div class="flex items-center gap-2">
                                            <div class="w-1.5 h-1.5 rounded-full" :class="record.check_out_time ? 'bg-stone-300' : 'bg-green-500 animate-pulse'"></div>
                                            <span class="text-xs font-bold text-on-surface">{{ record.check_out_time ? 'Completed' : calculateDuration(record.check_in_time) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 rounded-r-xl text-right">
                                        <button @click="quickCheckOut(record.employee_id)" class="text-primary hover:bg-primary/5 p-2 rounded-lg transition-colors group" :disabled="!!record.check_out_time">
                                            <span class="material-symbols-outlined text-lg" data-icon="logout">logout</span>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="attendances.length === 0">
                                    <td colspan="5" class="px-4 py-12 text-center text-outline">No attendance records found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Table Footer / Pagination -->
                    <div class="p-6 border-t border-outline-variant/10 flex items-center justify-between">
                        <p class="text-xs text-outline font-medium">Showing latest staff check-ins</p>
                        <div class="flex gap-2">
                            <button class="w-8 h-8 rounded border border-outline-variant/20 flex items-center justify-center text-outline hover:bg-white transition-all"><span class="material-symbols-outlined text-sm" data-icon="chevron_left">chevron_left</span></button>
                            <button class="w-8 h-8 rounded border border-outline-variant/20 flex items-center justify-center text-primary bg-white shadow-sm font-bold text-xs">1</button>
                            <button class="w-8 h-8 rounded border border-outline-variant/20 flex items-center justify-center text-outline hover:bg-white transition-all"><span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span></button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Dashboard Stats Bento Footer -->
            <section class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 group cursor-pointer hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-primary/10 rounded-lg text-primary">
                            <span class="material-symbols-outlined" data-icon="schedule">schedule</span>
                        </div>
                        <span class="text-[10px] font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded">+12% vs Yesterday</span>
                    </div>
                    <p class="text-sm font-bold text-outline uppercase tracking-wider">Avg Check-in Time</p>
                    <p class="text-3xl font-headline font-extrabold text-on-surface mt-1">08:22 <span class="text-lg font-medium text-outline">AM</span></p>
                </div>

                <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 group cursor-pointer hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-secondary/10 rounded-lg text-secondary">
                            <span class="material-symbols-outlined" data-icon="local_parking">local_parking</span>
                        </div>
                        <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded">High Capacity</span>
                    </div>
                    <p class="text-sm font-bold text-outline uppercase tracking-wider">Parking Occupancy</p>
                    <p class="text-3xl font-headline font-extrabold text-on-surface mt-1">84<span class="text-lg font-medium text-outline">%</span></p>
                </div>

                <div class="bg-primary p-6 rounded-xl shadow-lg shadow-primary/20 flex items-center justify-between group overflow-hidden relative">
                    <div class="relative z-10">
                        <p class="text-white/60 text-xs font-bold uppercase tracking-widest">System Status</p>
                        <p class="text-xl font-headline font-bold text-white mt-1">Active &amp; Synced</p>
                        <button class="mt-4 text-[10px] font-bold text-white uppercase tracking-tighter flex items-center gap-1 group transition-colors">
                            View Logs <span class="material-symbols-outlined text-sm transition-transform group-hover:translate-x-1" data-icon="arrow_forward">arrow_forward</span>
                        </button>
                    </div>
                    <span class="material-symbols-outlined text-white/10 text-8xl absolute -right-4 -bottom-4 rotate-12" data-icon="verified">verified</span>
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
