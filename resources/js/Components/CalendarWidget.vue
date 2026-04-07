<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    visits: Array, // Expected to be visits for the current month
    modelValue: String, // Selected date (YYYY-MM-DD)
});

const emit = defineEmits(['update:modelValue', 'dateSelected']);

// Calendar logic
const today = new Date();
const currentMonth = ref(today.getMonth());
const currentYear = ref(today.getFullYear());

const monthNames = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

const daysInMonth = computed(() => {
    return new Date(currentYear.value, currentMonth.value + 1, 0).getDate();
});

const firstDayOfMonth = computed(() => {
    return new Date(currentYear.value, currentMonth.value, 1).getDay();
});

const calendarDays = computed(() => {
    const days = [];
    // Padding for the first week
    for (let i = 0; i < firstDayOfMonth.value; i++) {
        days.push({ day: null });
    }
    // Days of the month
    for (let i = 1; i <= daysInMonth.value; i++) {
        const dateStr = `${currentYear.value}-${String(currentMonth.value + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
        const hasVisits = props.visits?.some(v => v.visit_date === dateStr);
        days.push({ 
            day: i, 
            date: dateStr,
            hasVisits,
            isToday: dateStr === today.toISOString().split('T')[0]
        });
    }
    return days;
});

const selectDate = (date) => {
    if (!date) return;
    emit('update:modelValue', date);
    emit('dateSelected', date);
};

const nextMonth = () => {
    if (currentMonth.value === 11) {
        currentMonth.value = 0;
        currentYear.value++;
    } else {
        currentMonth.value++;
    }
};

const prevMonth = () => {
    if (currentMonth.value === 0) {
        currentMonth.value = 11;
        currentYear.value--;
    } else {
        currentMonth.value--;
    }
};
</script>

<template>
    <div class="bg-surface-container-lowest rounded-xl p-6 border border-primary/5 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-sm font-headline font-extrabold text-primary uppercase tracking-widest">
                {{ monthNames[currentMonth] }} {{ currentYear }}
            </h3>
            <div class="flex gap-2">
                <button @click="prevMonth" class="p-1.5 rounded-lg hover:bg-surface-container transition-colors text-on-surface-variant flex items-center justify-center">
                    <span class="material-symbols-outlined text-base">chevron_left</span>
                </button>
                <button @click="nextMonth" class="p-1.5 rounded-lg hover:bg-surface-container transition-colors text-on-surface-variant flex items-center justify-center">
                    <span class="material-symbols-outlined text-base">chevron_right</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-7 gap-y-2 text-center text-[10px] font-bold text-on-surface-variant uppercase tracking-tighter mb-4 opacity-40">
            <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
        </div>

        <div class="grid grid-cols-7 gap-1">
            <template v-for="(dayObj, idx) in calendarDays" :key="idx">
                <div v-if="!dayObj.day" class="p-2"></div>
                <button 
                    v-else
                    @click="selectDate(dayObj.date)"
                    :class="[
                        'w-full aspect-square flex flex-col items-center justify-center rounded-lg transition-all duration-300 relative group',
                        modelValue === dayObj.date 
                            ? 'bg-primary text-white font-bold shadow-md' 
                            : 'hover:bg-surface-container-high text-on-surface',
                        dayObj.isToday && modelValue !== dayObj.date ? 'border border-primary/30 text-primary font-bold' : ''
                    ]"
                >
                    <span class="text-xs">{{ dayObj.day }}</span>
                    <!-- Indicator for visits -->
                    <span 
                        v-if="dayObj.hasVisits" 
                        :class="[
                            'w-1 h-1 rounded-full absolute bottom-1.5 transition-colors',
                            modelValue === dayObj.date ? 'bg-white' : 'bg-primary'
                        ]"
                    ></span>
                </button>
            </template>
        </div>

        <div class="mt-4 pt-4 border-t border-primary/5 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-1.5 h-1.5 rounded-full bg-primary"></div>
                <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Scheduled Visits</span>
            </div>
            <button @click="selectDate(today.toISOString().split('T')[0])" class="text-[10px] font-bold text-secondary uppercase tracking-widest hover:underline">
                Today
            </button>
        </div>
    </div>
</template>

<style scoped>
/* Optional: specific styles for the architectural look */
</style>
