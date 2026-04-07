<script setup>
import { ref, onMounted, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link, router } from '@inertiajs/vue3';
import { Menu, MenuButton, MenuItem, MenuItems, Listbox, ListboxButton, ListboxOptions, ListboxOption } from '@headlessui/vue';

const props = defineProps({
    employees: Array,
    allVisitors: Array, // Pre-fetched visitors for lookup
    todayVisits: Array,
});

const form = useForm({
    pass_number: '',
    purpose: '',
    employee_id: '',
    vehicle_plate: '',
    visitors: [
        { name: '', ic_number: '', company: '' }
    ],
    items: [],
    check_in_time: '',
    check_out_time: '',
});

const showManualTime = ref(false);
const selectedVisitForCheckout = ref(null);

const visitorSearchQuery = ref('');

const filteredLookupVisitors = computed(() => {
    if (!visitorSearchQuery.value) return props.allVisitors.slice(0, 10); // Limit initial view
    const q = visitorSearchQuery.value.toLowerCase();
    return props.allVisitors.filter(v =>
        v.name.toLowerCase().includes(q) ||
        v.ic_number.toLowerCase().includes(q)
    ).slice(0, 10);
});

const actionForm = useForm({});

const selectedEmployee = computed(() => {
    return props.employees.find(emp => emp.employee_id === form.employee_id) || null;
});


const addVisitor = () => {
    if (form.visitors.length < 5) {
        form.visitors.push({ name: '', ic_number: '', company: '' });
    }
};

const selectReturningVisitor = (index, visitor) => {
    form.visitors[index].name = visitor.name;
    form.visitors[index].ic_number = visitor.ic_number;
    form.visitors[index].company = visitor.company || '';
};

const removeVisitor = (index) => {
    if (form.visitors.length > 1) {
        form.visitors.splice(index, 1);
    }
};

const deleteVisitor = (visitorId) => {
    if (confirm('Are you sure you want to permanently delete this visitor profile?')) {
        router.delete(route('visitors.destroy', { visitor: visitorId }), {
            preserveScroll: true
        });
    }
};

const addItem = () => {
    form.items.push({ item_name: '', quantity: 1, remarks: '' });
};

const removeItem = (index) => {
    form.items.splice(index, 1);
};

const submit = () => {
    if (selectedVisitForCheckout.value) {
        if (!showManualTime.value) form.check_out_time = '';
        
        let data = {};
        if (form.check_out_time) data.check_out_time = form.check_out_time;

        actionForm.patch(route('visits.checkout', selectedVisitForCheckout.value.visit_id), {
            data: data,
            onSuccess: () => {
                form.reset();
                selectedVisitForCheckout.value = null;
                showManualTime.value = false;
            }
        });
    } else {
        if (!showManualTime.value) form.check_in_time = '';
        form.post(route('visits.store'), {
            onSuccess: () => {
                form.reset();
                showManualTime.value = false;
            }
        });
    }
};

const handleLiveFeedClick = (visit) => {
    if (visit.status !== 'Active') return;
    
    if (selectedVisitForCheckout.value && selectedVisitForCheckout.value.visit_id === visit.visit_id) {
        selectedVisitForCheckout.value = null;
        form.reset();
        showManualTime.value = false;
        return;
    }
    
    selectedVisitForCheckout.value = visit;
    showManualTime.value = false;
    
    form.pass_number = visit.pass_number || '';
    form.purpose = visit.purpose || '';
    form.employee_id = visit.employee_id;
    form.vehicle_plate = visit.vehicles?.[0]?.plate_number || '';
    
    if (visit.visitors && visit.visitors.length > 0) {
        form.visitors = visit.visitors.map(v => ({ name: v.name, ic_number: v.ic_number, company: v.company }));
    }
};

const clearSelection = () => {
    if (selectedVisitForCheckout.value) {
        selectedVisitForCheckout.value = null;
        form.reset();
        showManualTime.value = false;
    }
};


const formatTime = (timeString) => {
    if (!timeString) return '-';
    const normalized = timeString.replace(' ', 'T');
    const date = new Date(normalized);
    if (isNaN(date.getTime())) return '-';
    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
};
</script>

<template>
    <Head title="Register Visit - Lembah Entry" />
    <AuthenticatedLayout>
        <div class="px-6 py-8 bg-[#f8f6f5] min-h-screen" @click="clearSelection">
            <div class="max-w-[1440px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 h-full items-start">

                <div class="lg:col-span-7 space-y-8">
                    <header class="mb-8">
                        <h2 class="text-3xl font-headline font-extrabold text-primary tracking-tight">Register Visit</h2>
                        <p class="text-stone-500 mt-1">Initiate a new curated entry for the Heritage Portal.</p>
                    </header>

                    <form @submit.prevent="submit" class="space-y-6 pb-12" @click.stop>
                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-stone-100">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-3">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-primary/60">Manual Pass Identifier</label>
                                    <div class="relative">
                                        <input
                                            v-model="form.pass_number"
                                            required
                                            class="w-full bg-stone-50 border-stone-200 border-2 rounded-xl focus:ring-primary focus:border-primary py-4 px-5 font-mono font-bold text-lg text-primary tracking-wider transition-all placeholder:text-stone-300"
                                            placeholder="e.g. PO-11"
                                            type="text"
                                        />
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-primary/30" data-icon="fingerprint">fingerprint</span>
                                    </div>
                                    <p v-if="form.errors.pass_number" class="text-xs text-error mt-1">{{ form.errors.pass_number }}</p>
                                </div>
                                <div class="space-y-3">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-stone-500">Purpose / Need</label>
                                    <div class="relative">
                                        <input
                                            v-model="form.purpose"
                                            required
                                            class="w-full bg-stone-50 border-stone-100 rounded-xl focus:ring-primary focus:border-primary py-4 px-5 font-medium text-stone-700 transition-all placeholder:text-stone-300"
                                            placeholder="Purpose of visit"
                                            type="text"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 space-y-3">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-stone-500">Person to Meet</label>
                                <Listbox v-model="form.employee_id">
                                    <div class="relative">
                                        <ListboxButton class="w-full text-left">
                                            <div class="flex items-center gap-3 p-4 bg-stone-50 rounded-2xl border border-stone-100 group cursor-pointer hover:border-primary/20 transition-all">
                                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold overflow-hidden shrink-0 border-2 border-white uppercase text-xs">
                                                    {{ selectedEmployee ? selectedEmployee.name.substring(0,2) : '?' }}
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-bold" :class="selectedEmployee ? 'text-primary' : 'text-stone-400 italic'">
                                                        {{ selectedEmployee ? selectedEmployee.name : 'Select Person to Meet' }}
                                                    </p>
                                                    <p class="text-[10px] text-stone-400 capitalize">Lembah Sari Staff</p>
                                                </div>
                                                <span class="material-symbols-outlined text-stone-300" data-icon="expand_more">expand_more</span>
                                            </div>
                                        </ListboxButton>

                                        <transition
                                            enter-active-class="transition duration-100 ease-out"
                                            enter-from-class="transform scale-95 opacity-0"
                                            enter-to-class="transform scale-100 opacity-100"
                                            leave-active-class="transition duration-75 ease-in"
                                            leave-from-class="transform scale-100 opacity-100"
                                            leave-to-class="transform scale-95 opacity-0"
                                        >
                                            <ListboxOptions class="absolute z-[100] mt-1 max-h-60 w-full overflow-auto rounded-2xl bg-white/95 backdrop-blur-xl py-2 shadow-2xl ring-1 ring-black/5 focus:outline-none sm:text-sm">
                                                <ListboxOption
                                                    v-for="emp in employees"
                                                    :key="emp.employee_id"
                                                    :value="emp.employee_id"
                                                    as="template"
                                                    v-slot="{ active, selected }"
                                                >
                                                    <li :class="[active ? 'bg-primary/5 text-primary font-bold' : 'text-stone-600', 'relative cursor-pointer select-none py-3 pl-10 pr-4 transition-all']">
                                                        <span :class="[selected ? 'font-bold' : 'font-normal', 'block truncate']">{{ emp.name }}</span>
                                                        <span v-if="selected" class="absolute inset-y-0 left-0 flex items-center pl-3 text-primary">
                                                            <span class="material-symbols-outlined text-sm">check</span>
                                                        </span>
                                                    </li>
                                                </ListboxOption>
                                            </ListboxOptions>
                                        </transition>
                                    </div>
                                </Listbox>
                                <p v-if="form.errors.employee_id" class="text-xs text-error mt-1">{{ form.errors.employee_id }}</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-stone-100">
                            <div class="flex justify-between items-center mb-6">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary" data-icon="person">person</span>
                                    <h3 class="font-headline font-bold text-stone-800 uppercase tracking-wider text-sm">Guest Profiles</h3>
                                </div>
                                <button @click="addVisitor" v-if="form.visitors.length < 5" class="text-xs font-bold text-secondary flex items-center gap-1 hover:underline" type="button">
                                    <span class="material-symbols-outlined text-sm" data-icon="add_circle">add_circle</span>
                                    Add Another Guest
                                </button>
                            </div>

                            <div class="space-y-4">
                                <div v-for="(visitor, index) in form.visitors" :key="index" class="p-6 bg-stone-50/50 rounded-2xl border border-stone-100 grid grid-cols-1 md:grid-cols-3 gap-4 relative group transition-all hover:bg-stone-50">
                                    <div class="space-y-1">
                                        <label class="text-[9px] font-bold uppercase text-stone-400">Full Name</label>
                                        <input v-model="visitor.name" required class="w-full bg-white border-stone-200 rounded-lg text-sm transition-all focus:ring-primary/20 focus:border-primary" placeholder="John Doe" type="text"/>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[9px] font-bold uppercase text-stone-400">Identification (IC)</label>
                                        <input v-model="visitor.ic_number" required class="w-full bg-white border-stone-200 rounded-lg text-sm transition-all focus:ring-primary/20 focus:border-primary" placeholder="000000-00-0000" type="text"/>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[9px] font-bold uppercase text-stone-400">Organization / Company</label>
                                        <div class="flex gap-2">
                                            <input v-model="visitor.company" class="flex-1 bg-white border-stone-200 rounded-lg text-sm transition-all focus:ring-primary/20 focus:border-primary" placeholder="Self-employed" type="text"/>

                                            <Menu as="div" class="relative inline-block text-left">
                                                <MenuButton class="p-2 bg-white border border-stone-200 rounded-lg hover:bg-stone-50 transition-colors" title="Lookup Visitor">
                                                    <span class="material-symbols-outlined text-stone-400 text-sm" data-icon="person_search">person_search</span>
                                                </MenuButton>
                                                <transition
                                                    enter-active-class="transition duration-100 ease-out"
                                                    enter-from-class="transform scale-95 opacity-0"
                                                    enter-to-class="transform scale-100 opacity-100"
                                                    leave-active-class="transition duration-75 ease-in"
                                                    leave-from-class="transform scale-100 opacity-100"
                                                    leave-to-class="transform scale-95 opacity-0"
                                                >
                                                    <MenuItems class="absolute right-0 z-[120] mt-1 max-h-60 w-72 overflow-auto rounded-xl bg-white border border-stone-200 py-2 shadow-2xl focus:outline-none scrollbar-hide">
                                                        <div class="px-3 py-1 border-b border-stone-50 mb-1 sticky top-0 bg-white z-10">
                                                            <input v-model="visitorSearchQuery" type="text" placeholder="Search by name or IC..." class="w-full text-xs border border-stone-100 rounded px-2 py-1.5 focus:ring-1 focus:ring-primary/20 outline-none" @click.stop />
                                                        </div>
                                                        <MenuItem v-for="v in filteredLookupVisitors" :key="v.visitor_id" v-slot="{ active }">
                                                            <div :class="[active ? 'bg-primary/5 text-primary font-bold' : '', 'relative flex items-center justify-between group/item transition-colors w-full px-3 py-2']">
                                                                <button
                                                                    type="button"
                                                                    @click="selectReturningVisitor(index, v)"
                                                                    class="flex-1 flex flex-col text-left"
                                                                >
                                                                    <span class="text-xs font-bold">{{ v.name }}</span>
                                                                    <span class="text-[10px] opacity-60 font-mono">{{ v.ic_number }} | {{ v.company }}</span>
                                                                </button>
                                                                <button type="button" @click.stop="deleteVisitor(v.visitor_id)" class="opacity-0 group-hover/item:opacity-100 hover:text-error transition-all font-bold p-1 absolute right-2 bg-white rounded-md shadow-sm" title="Delete Visitor">
                                                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                                                </button>
                                                            </div>
                                                        </MenuItem>
                                                        <div v-if="filteredLookupVisitors.length === 0" class="px-3 py-4 text-center text-xs text-stone-400 italic">
                                                            No matching records found.
                                                        </div>
                                                    </MenuItems>
                                                </transition>
                                            </Menu>
                                        </div>
                                    </div>

                                    <button v-if="form.visitors.length > 1" @click="removeVisitor(index)" class="absolute -top-2 -right-2 w-6 h-6 bg-white border border-stone-200 rounded-full flex items-center justify-center text-stone-400 hover:text-error hover:border-error transition-all shadow-sm group-hover:opacity-100" type="button">
                                        <span class="material-symbols-outlined text-[10px] font-bold">close</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-3xl p-8 shadow-sm border border-stone-100">
                            <div class="flex items-center gap-2 mb-6">
                                <span class="material-symbols-outlined text-primary" data-icon="local_shipping">local_shipping</span>
                                <h3 class="font-headline font-bold text-stone-800 uppercase tracking-wider text-sm">Logistics & Hardware</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold uppercase tracking-widest text-stone-500">Vehicle Plate Number</label>
                                        <input
                                            v-model="form.vehicle_plate"
                                            class="w-full bg-stone-50 border-stone-100 rounded-xl py-4 px-5 text-lg font-bold tracking-widest text-primary focus:ring-primary focus:border-primary transition-all placeholder:font-normal placeholder:tracking-normal placeholder:text-stone-300"
                                            placeholder="ABC 1234"
                                            type="text"
                                        />
                                    </div>
                                    <div class="p-4 rounded-2xl bg-primary/5 border border-primary/10">
                                        <p class="text-[10px] font-bold text-primary mb-1 uppercase tracking-tight">Security Protocol</p>
                                        <p class="text-xs font-medium text-on-surface-variant leading-relaxed italic opacity-80">Check-in items to ensure secure site exit processing at conclusion of visit.</p>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-stone-500">Hardware Declaration</label>
                                    <div class="space-y-2">
                                        <div v-for="(item, index) in form.items" :key="'item'+index" class="flex items-center gap-2 p-3 bg-stone-50 rounded-xl border border-stone-100 group">
                                            <div class="flex-1 min-w-0">
                                                <input v-model="item.item_name" class="w-full bg-transparent border-none p-0 text-xs font-bold text-stone-800 focus:ring-0 truncate" placeholder="Item Name"/>
                                                <div class="flex items-center gap-2 mt-0.5">
                                                    <input v-model="item.quantity" type="number" min="1" class="w-8 bg-white border border-stone-200 rounded px-1 py-0.5 text-[10px] font-bold text-center"/>
                                                    <input v-model="item.remarks" class="flex-1 bg-transparent border-none p-0 text-[10px] text-stone-500 focus:ring-0 italic" placeholder="SN / Remarks"/>
                                                </div>
                                            </div>
                                            <button @click="removeItem(index)" class="text-stone-300 hover:text-error transition-colors" type="button">
                                                <span class="material-symbols-outlined text-lg" data-icon="cancel">cancel</span>
                                            </button>
                                        </div>
                                        <button @click="addItem" class="w-full py-3 border-2 border-dashed border-stone-200 rounded-xl text-stone-400 text-[10px] font-black uppercase tracking-widest hover:bg-stone-50 hover:border-primary/20 hover:text-primary transition-all" type="button">
                                            + Declare Item
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 pt-4 border-t border-stone-100 mt-6">
                            <div class="flex items-center justify-between px-1">
                                <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">
                                    {{ selectedVisitForCheckout ? 'Manual Check-Out Time' : 'Manual Check-In Time' }}
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
                                    <input v-if="selectedVisitForCheckout" v-model="form.check_out_time" type="time" class="w-full bg-stone-50 border-stone-100 rounded-xl px-4 py-3 text-sm focus:ring-primary focus:border-primary transition-all font-medium" />
                                    <input v-else v-model="form.check_in_time" type="time" class="w-full bg-stone-50 border-stone-100 rounded-xl px-4 py-3 text-sm focus:ring-primary focus:border-primary transition-all font-medium" />
                                    
                                    <div class="mt-2 text-[10px] text-stone-500 font-medium flex items-center gap-1.5 opacity-70">
                                        <span class="material-symbols-outlined text-sm">history</span>
                                        Overrides automatic system timestamp
                                    </div>
                                </div>
                            </transition>
                        </div>

                        <div class="flex items-center justify-between gap-4 pt-4 mt-2">
                            <button @click="form.reset(); selectedVisitForCheckout = null; showManualTime = false;" class="px-8 py-4 text-stone-500 font-bold text-sm hover:text-primary transition-colors uppercase tracking-widest" type="button">Reset Entry</button>
                            <button
                                type="submit"
                                :disabled="form.processing || actionForm.processing"
                                class="px-10 py-5 text-white font-bold rounded-2xl shadow-xl flex items-center gap-3 group transition-all active:scale-95 disabled:opacity-50"
                                :class="selectedVisitForCheckout ? 'bg-gradient-to-br from-red-500 to-red-600 shadow-red-500/20 hover:scale-[1.02]' : 'bg-gradient-to-br from-[#72d473] to-[#72d473] shadow-primary/20 hover:scale-[1.02]'"
                            >
                                <span class="font-headline tracking-wider uppercase text-sm">{{ selectedVisitForCheckout ? 'Check Out' : 'Register & Check In' }}</span>
                                <span v-if="!selectedVisitForCheckout" class="material-symbols-outlined text-white/50 group-hover:translate-x-1 group-hover:text-white transition-all" data-icon="check_circle">check_circle</span>
                                <span v-else class="material-symbols-outlined text-white/50 group-hover:translate-x-1 group-hover:text-white transition-all" data-icon="logout">logout</span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="lg:col-span-5 flex flex-col h-full max-h-[calc(100vh-10rem)] sticky top-24">
                    <div class="bg-white/90 backdrop-blur-xl rounded-[2rem] flex-1 flex flex-col overflow-hidden shadow-xl shadow-stone-200/50 border border-stone-200/60">
                        <div class="p-8 border-b border-stone-100 flex items-center justify-between bg-stone-50/50">
                            <div>
                                <h3 class="text-stone-800 font-headline font-bold text-lg tracking-tight">Live Feed</h3>
                                <p class="text-stone-400 text-[10px] uppercase tracking-widest font-black">Active Engagements</p>
                            </div>
                            <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-full border border-stone-100 shadow-sm">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.4)]"></span>
                                <span class="text-[11px] font-black text-stone-600 uppercase tracking-tighter">{{ todayVisits.filter(v => v.status === 'Active').length }} Onsite</span>
                            </div>
                        </div>

                        <div class="flex-1 overflow-y-auto p-6 space-y-4 scrollbar-hide">
                            <div v-if="todayVisits.length === 0" class="flex flex-col items-center justify-center h-48 text-stone-300 gap-4">
                                <span class="material-symbols-outlined text-5xl">sensors_off</span>
                                <p class="text-xs font-bold uppercase tracking-widest">No active visitors</p>
                            </div>

                            <div v-for="visit in todayVisits" :key="visit.visit_id"
                                @click.stop="handleLiveFeedClick(visit)"
                                class="group relative flex gap-4 p-5 bg-white rounded-2xl transition-all border border-l-4 shadow-sm"
                                :class="{
                                    'border-l-emerald-500 cursor-pointer hover:bg-stone-50 hover:shadow-md': visit.status === 'Active' && (!selectedVisitForCheckout || selectedVisitForCheckout.visit_id !== visit.visit_id),
                                    'bg-emerald-50 border-emerald-500 shadow-md ring-2 ring-emerald-500/20': selectedVisitForCheckout && selectedVisitForCheckout.visit_id === visit.visit_id,
                                    'border-l-amber-400': visit.status === 'Approved',
                                    'border-l-stone-200 opacity-60 grayscale': visit.status === 'Checked Out'
                                }"
                            >
                                <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold shrink-0 text-xs shadow-inner"
                                     :class="visit.status === 'Active' ? 'bg-emerald-50 text-emerald-600' : (visit.status === 'Checked Out' ? 'bg-stone-100 text-stone-400' : 'bg-amber-50 text-amber-600')">
                                    {{ visit.visitors && visit.visitors.length > 0 ? visit.visitors[0].name.substring(0,2).toUpperCase() : 'V' }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <h4 class="text-stone-800 font-bold text-sm truncate tracking-tight">{{ visit.visitors && visit.visitors.length > 0 ? visit.visitors[0].name : 'Unknown Guest' }}</h4>
                                        <span class="text-[10px] font-mono font-bold text-stone-400 tracking-widest">{{ visit.pass_number }}</span>
                                    </div>
                                    <p class="text-stone-500 text-[10px] mt-0.5 font-bold uppercase tracking-wide">Host: {{ visit.employee ? visit.employee.name : 'Unknown' }}</p>

                                    <div class="flex items-center gap-4 mt-3">
                                        <div class="text-[10px]">
                                            <span class="text-stone-400 font-black uppercase mr-1.5 tracking-tighter">In</span>
                                            <span class="text-stone-600 font-mono font-bold">{{ formatTime(visit.check_in_time) }}</span>
                                        </div>
                                        <div v-if="visit.check_out_time" class="text-[10px]">
                                            <span class="text-stone-400 font-black uppercase mr-1.5 tracking-tighter">Out</span>
                                            <span class="text-stone-600 font-mono font-bold">{{ formatTime(visit.check_out_time) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 bg-stone-50/50 border-t border-stone-100">
                            <Link :href="route('history.index')" class="w-full py-4 bg-white text-stone-600 border border-stone-200 font-black text-xs rounded-2xl hover:bg-stone-50 hover:text-stone-800 transition-all uppercase tracking-[0.2em] flex items-center justify-center gap-2 shadow-sm">
                                Archive Vault
                                <span class="material-symbols-outlined text-sm">history_edu</span>
                            </Link>
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
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.bento-glass {
    backdrop-filter: blur(20px);
}
</style>
