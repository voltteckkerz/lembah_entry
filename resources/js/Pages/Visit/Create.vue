<script setup>
import { ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    employees: Array,
    todayVisits: Array, // Array of today's visits from the Controller
});

const form = useForm({
    purpose: '',
    employee_id: '',
    vehicle_plate: '',
    vehicle_type: 'Car',
    visitors: [
        { name: '', ic_number: '' }
    ],
    items: [],
    guard_signature: '',
    visitor_signature: ''
});

const actionForm = useForm({});

// Canvas Refs for Inline Form Signing
const guardCanvasRef = ref(null);
const visitorCanvasRef = ref(null);
const padState = ref({
    guard: { isDrawing: false, hasDrawn: false, ctx: null },
    visitor: { isDrawing: false, hasDrawn: false, ctx: null }
});

onMounted(() => {
    initCanvases();
});

const initCanvases = () => {
    [ { ref: guardCanvasRef, key: 'guard' }, { ref: visitorCanvasRef, key: 'visitor' } ].forEach(pad => {
        if (!pad.ref.value) return;
        const canvas = pad.ref.value;
        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;
        const ctx = canvas.getContext('2d');
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000000';
        padState.value[pad.key].ctx = ctx;
    });
};

const getCoords = (e, canvas) => {
    const rect = canvas.getBoundingClientRect();
    if (e.touches && e.touches.length > 0) {
        return { x: e.touches[0].clientX - rect.left, y: e.touches[0].clientY - rect.top };
    }
    return { x: e.clientX - rect.left, y: e.clientY - rect.top };
};

const startDraw = (e, key) => {
    e.preventDefault();
    padState.value[key].isDrawing = true;
    padState.value[key].hasDrawn = true;
    const { x, y } = getCoords(e, (key === 'guard' ? guardCanvasRef : visitorCanvasRef).value);
    padState.value[key].ctx.beginPath();
    padState.value[key].ctx.moveTo(x, y);
};

const draw = (e, key) => {
    e.preventDefault();
    if (!padState.value[key].isDrawing) return;
    const { x, y } = getCoords(e, (key === 'guard' ? guardCanvasRef : visitorCanvasRef).value);
    padState.value[key].ctx.lineTo(x, y);
    padState.value[key].ctx.stroke();
};

const stopDraw = (key) => {
    if (padState.value[key].isDrawing) {
        padState.value[key].ctx.closePath();
        padState.value[key].isDrawing = false;
    }
};

const clearDraw = (key) => {
    const canvas = (key === 'guard' ? guardCanvasRef : visitorCanvasRef).value;
    padState.value[key].ctx.clearRect(0, 0, canvas.width, canvas.height);
    padState.value[key].hasDrawn = false;
};

const addVisitor = () => {
    if (form.visitors.length < 5) {
        form.visitors.push({ name: '', ic_number: '' });
    }
};

const removeVisitor = (index) => {
    if (form.visitors.length > 1) {
        form.visitors.splice(index, 1);
    }
};

const addItem = () => {
    form.items.push({ item_name: '', quantity: 1, remarks: '' });
};

const removeItem = (index) => {
    form.items.splice(index, 1);
};

const submit = () => {
    // Capture base64 from canvases
    if (padState.value.guard.hasDrawn) form.guard_signature = guardCanvasRef.value.toDataURL('image/png');
    if (padState.value.visitor.hasDrawn) form.visitor_signature = visitorCanvasRef.value.toDataURL('image/png');

    form.post(route('visits.store'), {
        onSuccess: () => {
            clearDraw('guard');
            clearDraw('visitor');
            form.reset();
        }
    });
};

const checkInVisitor = (visit) => {
    actionForm.patch(route('visits.checkin', visit.visit_id));
};

const checkOutVisitor = (visit) => {
    actionForm.patch(route('visits.checkout', visit.visit_id));
};

const formatTime = (timeString) => {
    if (!timeString) return '-';
    // Laravel returns "YYYY-MM-DD HH:MM:SS" or ISO. Normalize to ISO cross-browser.
    const normalized = timeString.replace(' ', 'T');
    const date = new Date(normalized);
    if (isNaN(date.getTime())) return '-';
    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
};

const calculateDuration = (checkInTime) => {
    if (!checkInTime) return '-';
    const start = new Date(checkInTime.replace(' ', 'T'));
    const now = new Date();
    let diffMs = now - start;
    if (diffMs < 0) diffMs = 0;
    const diffHrs = Math.floor(diffMs / 3600000);
    const diffMins = Math.floor((diffMs % 3600000) / 60000);
    return `${diffHrs}h ${diffMins}m`;
};
</script>

<template>
    <Head title="Register Visit - VMS Portal" />
    <AuthenticatedLayout>
        <div class="p-8 space-y-8 max-w-[1400px] mx-auto w-full font-body">
            <!-- Header Section -->
            <section class="flex flex-col md:flex-row justify-between items-end gap-6 mb-4">
                <div class="space-y-2">
                    <h2 class="text-4xl font-headline font-extrabold tracking-tight text-primary">Visitor Management Center</h2>
                    <p class="text-secondary font-medium">Pre-register visitors and manage the live security flow natively.</p>
                </div>
                <!-- Dynamic Quick Stats (Calculated on the fly) -->
                <div class="flex items-center gap-3 bg-surface-container-low p-2 rounded-xl">
                    <div class="px-4 py-2 bg-surface-container-lowest rounded-lg shadow-sm text-center">
                        <p class="text-[10px] uppercase tracking-wider text-outline font-bold">Today's Visits</p>
                        <p class="text-2xl font-headline font-extrabold text-primary">{{ todayVisits.length }}</p>
                    </div>
                </div>
            </section>

            <!-- Main Asymmetric Split Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- LEFT COLUMN: Registration Form -->
                <div class="lg:col-span-5 space-y-6">
                    <form @submit.prevent="submit" class="bg-surface-container-low rounded-xl p-6 md:p-8 space-y-8 shadow-sm transition-all border border-transparent">
                        <div class="flex items-center gap-3 mb-2 border-b border-outline-variant/20 pb-4">
                            <span class="material-symbols-outlined text-primary" data-icon="how_to_reg">how_to_reg</span>
                            <h3 class="font-headline font-bold text-lg text-on-surface">New Registration</h3>
                        </div>

                        <!-- Single Block 1: Visit & Host -->
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs font-bold uppercase tracking-widest text-outline ml-1">Purpose / Need</label>
                                <input v-model="form.purpose" required class="w-full bg-surface-container-lowest border-outline-variant/20 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all outline-none mt-2" placeholder="e.g. Server Maintenance" type="text" />
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase tracking-widest text-outline ml-1">Sponsoring Host</label>
                                <div class="relative mt-2">
                                    <select v-model="form.employee_id" required class="w-full bg-surface-container-lowest border-outline-variant/20 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all appearance-none cursor-pointer outline-none">
                                        <option value="" disabled>Select Department / Staff</option>
                                        <option v-for="emp in employees" :key="emp.employee_id" :value="emp.employee_id">
                                            {{ emp.name }} — {{ emp.department }}
                                        </option>
                                    </select>
                                    <span class="material-symbols-outlined absolute right-3 top-3 pointer-events-none text-outline">expand_more</span>
                                </div>
                            </div>
                        </div>

                        <!-- Single Block 2: Visitor Credentials -->
                        <div class="border-t border-outline-variant/20 pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <label class="text-xs font-bold uppercase tracking-widest text-outline ml-1">Guest Profiles</label>
                                <button type="button" @click="addVisitor" v-if="form.visitors.length < 5" class="text-[10px] text-primary font-bold uppercase tracking-widest hover:underline">+ Add Guest</button>
                            </div>
                            <div class="space-y-4">
                                <div v-for="(visitor, index) in form.visitors" :key="index" class="relative bg-surface-container-lowest border border-outline-variant/20 p-4 rounded-lg flex flex-col gap-3">
                                    <input v-model="visitor.name" required class="w-full bg-transparent border-b border-outline-variant/30 px-2 py-1 text-sm focus:border-primary transition-all outline-none placeholder:text-outline/50" placeholder="Full Legal Name" type="text"/>
                                    <input v-model="visitor.ic_number" required class="w-full bg-transparent border-b border-outline-variant/30 px-2 py-1 text-sm focus:border-primary transition-all outline-none placeholder:text-outline/50" placeholder="IC / Passport Identifier" type="text"/>
                                    <button type="button" @click="removeVisitor(index)" v-if="form.visitors.length > 1" class="absolute right-3 top-3 text-outline hover:text-error transition-colors">
                                        <span class="material-symbols-outlined text-sm">close</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Single Block 3: Logistics (Vehicle + Items) -->
                        <div class="border-t border-outline-variant/20 pt-6 space-y-4">
                            <label class="text-xs font-bold uppercase tracking-widest text-outline ml-1">Logistics & Items</label>
                            <div class="grid grid-cols-2 gap-3 mt-2">
                                <input v-model="form.vehicle_plate" class="bg-surface-container-lowest border-outline-variant/20 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:border-primary transition-all outline-none" placeholder="Plate (Optional)" type="text"/>
                                <select v-model="form.vehicle_type" class="bg-surface-container-lowest border-outline-variant/20 rounded-lg px-3 py-2 text-sm appearance-none outline-none">
                                    <option value="Car">Car</option>
                                    <option value="Motorcycle">Motorbike</option>
                                    <option value="Truck">Truck/Lorry</option>
                                </select>
                            </div>
                            <div class="flex items-center justify-between mt-4 mb-2">
                                <span class="text-[10px] text-outline italic">Declared Items</span>
                                <button type="button" @click="addItem" class="text-[10px] text-primary font-bold uppercase tracking-widest hover:underline">+ Hardware</button>
                            </div>
                            <div v-for="(item, index) in form.items" :key="'item'+index" class="flex items-center gap-2 bg-surface-container-lowest border border-outline-variant/20 rounded-lg p-2">
                                <input v-model="item.item_name" required class="flex-1 bg-transparent border-none text-xs focus:ring-0 p-1 placeholder:text-outline/50 outline-none" placeholder="Item Name" type="text"/>
                                <input v-model="item.quantity" min="1" required class="w-12 bg-transparent border-none text-xs focus:ring-0 p-1 outline-none text-center" type="number"/>
                                <button type="button" @click="removeItem(index)" class="text-outline hover:text-error mr-1">
                                    <span class="material-symbols-outlined text-xs">delete</span>
                                </button>
                            </div>
                        </div>

                        <!-- Single Block 4: Intake Signatures -->
                        <div class="border-t border-outline-variant/20 pt-6 space-y-4">
                            <label class="text-xs font-bold uppercase tracking-widest text-outline ml-1">Pre-Registration Signatures</label>
                            <p class="text-[10px] text-stone-500 italic ml-1 mb-2">Both the Duty Guard and Primary Visitor must acknowledge pre-registration before host verification.</p>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Guard Pad Inline -->
                                <div class="flex flex-col border border-stone-200 rounded-lg overflow-hidden relative bg-white h-32">
                                    <div class="bg-stone-100 py-1 border-b border-stone-200 text-center flex justify-between px-2 items-center">
                                        <p class="text-[9px] font-extrabold text-stone-500 uppercase tracking-widest">Post Guard</p>
                                        <button v-if="padState.guard.hasDrawn" @click="clearDraw('guard')" type="button" class="text-[10px] text-stone-400 hover:text-stone-600"><span class="material-symbols-outlined text-[12px]">refresh</span></button>
                                    </div>
                                    <div class="flex-1 relative">
                                        <canvas ref="guardCanvasRef" class="w-full h-full cursor-crosshair touch-none absolute inset-0" 
                                            @mousedown="startDraw($event, 'guard')" @mousemove="draw($event, 'guard')" @mouseup="stopDraw('guard')" @mouseleave="stopDraw('guard')"
                                            @touchstart="startDraw($event, 'guard')" @touchmove="draw($event, 'guard')" @touchend="stopDraw('guard')"></canvas>
                                        <span v-if="!padState.guard.hasDrawn" class="absolute inset-0 flex items-center justify-center text-[10px] text-stone-300 pointer-events-none italic">Guard Sign Here</span>
                                    </div>
                                </div>
                                <!-- Visitor Pad Inline -->
                                <div class="flex flex-col border border-stone-200 rounded-lg overflow-hidden relative bg-white h-32">
                                    <div class="bg-stone-100 py-1 border-b border-stone-200 text-center flex justify-between px-2 items-center">
                                        <p class="text-[9px] font-extrabold text-[#3e0007] uppercase tracking-widest">Visitor</p>
                                        <button v-if="padState.visitor.hasDrawn" @click="clearDraw('visitor')" type="button" class="text-[10px] text-stone-400 hover:text-stone-600"><span class="material-symbols-outlined text-[12px]">refresh</span></button>
                                    </div>
                                    <div class="flex-1 relative">
                                        <canvas ref="visitorCanvasRef" class="w-full h-full cursor-crosshair touch-none absolute inset-0" 
                                            @mousedown="startDraw($event, 'visitor')" @mousemove="draw($event, 'visitor')" @mouseup="stopDraw('visitor')" @mouseleave="stopDraw('visitor')"
                                            @touchstart="startDraw($event, 'visitor')" @touchmove="draw($event, 'visitor')" @touchend="stopDraw('visitor')"></canvas>
                                        <span v-if="!padState.visitor.hasDrawn" class="absolute inset-0 flex items-center justify-center text-[10px] text-stone-300 pointer-events-none italic">Visitor Sign Here</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Submit Button -->
                        <div class="pt-6 border-t border-outline-variant/20">
                            <button type="submit" :disabled="form.processing || !padState.guard.hasDrawn || !padState.visitor.hasDrawn" class="w-full signature-gradient text-white font-label text-sm font-bold tracking-widest uppercase py-4 rounded-xl shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all disabled:opacity-50">
                                Pre-Approve Registration
                            </button>
                        </div>
                    </form>
                </div>

                <!-- RIGHT COLUMN: Live Status Feed -->
                <div class="lg:col-span-7 bg-surface-container-low rounded-xl overflow-hidden shadow-sm flex flex-col h-full border border-transparent">
                    <div class="p-6 md:p-8 flex justify-between items-center bg-surface-container-lowest border-b border-outline-variant/10">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary" data-icon="sensors">sensors</span>
                            <h3 class="font-headline font-bold text-lg text-on-surface">Live Visitor Feed</h3>
                        </div>
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                        </span>
                    </div>

                    <div class="flex-1 overflow-x-auto px-4 py-4 h-[700px] overflow-y-auto bg-surface-container-low/50">
                        <div v-if="todayVisits.length === 0" class="flex flex-col items-center justify-center h-full text-outline gap-3 text-center px-4">
                            <span class="material-symbols-outlined text-4xl opacity-50" data-icon="meeting_room">meeting_room</span>
                            <p class="font-medium text-sm">No visitor passes generated today.<br>Pre-register someone on the left.</p>
                        </div>

                        <!-- Card style list to accomodate all actions beautifully without table constraint -->
                        <div v-else class="space-y-3 pb-8">
                            <div v-for="visit in todayVisits" :key="visit.visit_id" class="bg-surface-container-lowest border border-outline-variant/10 p-5 rounded-xl hover:shadow-md transition-all group relative overflow-hidden">
                                
                                <!-- Decorative pass side stripe -->
                                <div class="absolute left-0 top-0 bottom-0 w-1.5" 
                                     :class="visit.status === 'Active' ? 'bg-secondary' : (visit.status === 'Checked Out' ? 'bg-green-500' : (visit.status === 'Approved' ? 'bg-amber-500' : 'bg-surface-variant'))">
                                </div>

                                <div class="pl-3 flex flex-col md:flex-row gap-4 items-start md:items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full border-2 border-primary/10 flex items-center justify-center font-bold text-primary bg-primary/5 uppercase ring-2 ring-white z-10">
                                            {{ visit.visitors && visit.visitors.length > 0 ? visit.visitors[0].name.substring(0,2) : 'V' }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-bold text-on-surface text-sm">{{ visit.visitors && visit.visitors.length > 0 ? visit.visitors[0].name : 'Unknown Guest' }}</h4>
                                                <span v-if="visit.visitors.length > 1" class="text-[9px] font-bold text-primary bg-primary/10 px-1.5 py-0.5 rounded leading-none">+{{visit.visitors.length - 1}}</span>
                                            </div>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="font-mono text-[10px] font-bold text-secondary tracking-widest">{{ visit.pass_number }}</span>
                                                <span class="text-[10px] text-outline font-medium">• Host: {{ visit.employee ? visit.employee.name : 'Unknown' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right aligned Time metrics / Status -->
                                    <div class="flex items-center gap-4 w-full md:w-auto mt-2 md:mt-0 pt-2 md:pt-0 border-t md:border-t-0 border-outline-variant/10 md:justify-end">
                                        
                                        <!-- Timestamps if active/checked out -->
                                        <div v-if="visit.check_in_time" class="flex flex-col items-end md:mr-2">
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-outline">Arrival</span>
                                            <span class="text-xs font-mono font-medium text-on-surface">{{ formatTime(visit.check_in_time) }}</span>
                                        </div>
                                        <div v-if="visit.check_out_time" class="flex flex-col items-end">
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-outline">Departure</span>
                                            <span class="text-xs font-mono font-bold text-green-600">{{ formatTime(visit.check_out_time) }}</span>
                                        </div>

                                        <!-- The physical Action Buttons -->
                                        <div class="flex flex-col gap-1 items-end min-w-[100px]">
                                            <!-- Print Pass Button (Available for all generated passes) -->
                                            <Link :href="route('visits.pass', visit.visit_id)" class="w-full text-[10px] bg-stone-100 text-stone-600 px-3 py-1.5 rounded shadow-sm hover:bg-stone-200 transition-colors font-bold uppercase tracking-widest flex items-center justify-center gap-1 mb-1">
                                                <span class="material-symbols-outlined text-[14px]">print</span> Print Pass
                                            </Link>
                                            
                                            <button v-if="visit.status === 'Approved'" @click="checkInVisitor(visit)" :disabled="actionForm.processing" class="w-full text-[10px] bg-secondary text-white px-3 py-1.5 rounded shadow-sm hover:opacity-90 transition-opacity font-bold uppercase tracking-widest flex items-center justify-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">login</span> Check In
                                            </button>
                                            <button v-else-if="visit.status === 'Active'" @click="checkOutVisitor(visit)" :disabled="actionForm.processing" class="w-full text-[10px] border border-outline font-bold text-outline px-3 py-1.5 rounded hover:bg-surface-container transition-colors uppercase tracking-widest flex items-center justify-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">logout</span> Check Out
                                            </button>
                                            <span v-else class="text-[10px] font-bold uppercase tracking-widest px-2 py-1 bg-surface-container rounded border border-outline-variant/20 inline-block text-center w-full" :class="{'text-amber-600': visit.status==='Pending'}">
                                                {{ visit.status }}
                                            </span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.signature-gradient {
    background: linear-gradient(135deg, #3e0007 0%, #620814 100%);
}
.editorial-shadow {
    box-shadow: 0 10px 30px rgba(27, 28, 28, 0.05);
}
</style>
