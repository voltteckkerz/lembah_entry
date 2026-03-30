<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    title: String,
    role: String,
    visitId: Number,
    existingSignature: String,
    headerClass: {
        type: String,
        default: 'bg-stone-100 text-stone-500'
    },
    containerClass: {
        type: String,
        default: 'bg-white'
    },
    footerText: String
});

const canvasRef = ref(null);
const ctx = ref(null);
const isDrawing = ref(false);
const hasDrawn = ref(false);

const form = useForm({
    role: props.role,
    signature: ''
});

onMounted(() => {
    if (!props.existingSignature && canvasRef.value) {
        initCanvas();
        window.addEventListener('resize', resizeCanvas);
    }
});

onUnmounted(() => {
    window.removeEventListener('resize', resizeCanvas);
});

const initCanvas = () => {
    const canvas = canvasRef.value;
    // Set actual size in memory (scaled to account for pixel ratio).
    // To make it easy, we just match the CSS display size explicitly.
    canvas.width = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight;
    
    ctx.value = canvas.getContext('2d');
    ctx.value.lineWidth = 2;
    ctx.value.lineCap = 'round';
    ctx.value.strokeStyle = '#000000'; // Black ink
};

const resizeCanvas = () => {
    if (!props.existingSignature && canvasRef.value) {
        const canvas = canvasRef.value;
        const tempCanvas = document.createElement('canvas');
        tempCanvas.width = canvas.width;
        tempCanvas.height = canvas.height;
        const tempCtx = tempCanvas.getContext('2d');
        tempCtx.drawImage(canvas, 0, 0);
        
        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;
        
        ctx.value.lineWidth = 2;
        ctx.value.lineCap = 'round';
        ctx.value.strokeStyle = '#000000';
        ctx.value.drawImage(tempCanvas, 0, 0);
    }
};

const getCoordinates = (e) => {
    const canvas = canvasRef.value;
    const rect = canvas.getBoundingClientRect();
    if (e.touches && e.touches.length > 0) {
        return {
            x: e.touches[0].clientX - rect.left,
            y: e.touches[0].clientY - rect.top
        };
    }
    return {
        x: e.clientX - rect.left,
        y: e.clientY - rect.top
    };
};

const startDrawing = (e) => {
    e.preventDefault(); // Prevent scrolling on touch
    isDrawing.value = true;
    hasDrawn.value = true;
    const { x, y } = getCoordinates(e);
    ctx.value.beginPath();
    ctx.value.moveTo(x, y);
};

const draw = (e) => {
    e.preventDefault(); // Prevent scrolling on touch
    if (!isDrawing.value) return;
    const { x, y } = getCoordinates(e);
    ctx.value.lineTo(x, y);
    ctx.value.stroke();
};

const stopDrawing = () => {
    if (isDrawing.value) {
        ctx.value.closePath();
        isDrawing.value = false;
    }
};

const clearCanvas = () => {
    if (!canvasRef.value) return;
    const canvas = canvasRef.value;
    ctx.value.clearRect(0, 0, canvas.width, canvas.height);
    hasDrawn.value = false;
};

const saveSignature = () => {
    if (!hasDrawn.value) return;
    form.signature = canvasRef.value.toDataURL('image/png');
    form.patch(route('visits.sign', props.visitId), {
        onSuccess: () => {
            // parent will re-render seamlessly providing existingSignature
        }
    });
};
</script>

<template>
    <div :class="['flex flex-col border border-stone-200 rounded-lg overflow-hidden h-40 relative', containerClass]">
        
        <!-- Header -->
        <div :class="['py-1.5 px-3 border-b border-stone-200 text-center z-10', headerClass]">
            <p class="text-[9px] font-extrabold uppercase tracking-widest">{{ title }}</p>
        </div>
        
        <!-- Signature Area -->
        <div class="flex-1 relative bg-white">
            
            <!-- If fully signed -->
            <div v-if="existingSignature" class="absolute inset-0 flex flex-col items-center justify-center p-2 bg-white z-10">
                <img :src="existingSignature" class="max-h-full max-w-full object-contain" />
                <div class="absolute bottom-1 right-1 bg-green-500 text-white rounded-full w-4 h-4 flex items-center justify-center shadow print:hidden">
                    <span class="material-symbols-outlined text-[10px]">check</span>
                </div>
            </div>

            <!-- If unsigned (Canvas Pad) -->
            <div v-else class="absolute inset-0 flex flex-col">
                <canvas 
                    ref="canvasRef"
                    class="w-full h-full cursor-crosshair touch-none"
                    @mousedown="startDrawing"
                    @mousemove="draw"
                    @mouseup="stopDrawing"
                    @mouseleave="stopDrawing"
                    @touchstart="startDrawing"
                    @touchmove="draw"
                    @touchend="stopDrawing"
                ></canvas>
                
                <!-- Action Controls (Hidden in Print) -->
                <div v-if="hasDrawn" class="absolute top-1 right-1 flex gap-1 print:hidden z-20">
                    <button @click="clearCanvas" type="button" class="w-6 h-6 bg-stone-100 hover:bg-stone-200 text-stone-600 rounded flex items-center justify-center shadow-sm transition-colors border border-stone-200">
                        <span class="material-symbols-outlined text-[12px]">refresh</span>
                    </button>
                    <button @click="saveSignature" type="button" :disabled="form.processing" class="h-6 px-2 bg-green-500 hover:bg-green-600 text-white font-bold text-[9px] uppercase tracking-wider rounded shadow-sm transition-colors flex items-center">
                        <span v-if="form.processing" class="material-symbols-outlined text-[12px] animate-spin">refresh</span>
                        <span v-else>Save</span>
                    </button>
                </div>
                
                <!-- Placeholder text -->
                <div v-if="!hasDrawn" class="absolute inset-0 pointer-events-none flex items-center justify-center print:hidden">
                    <span class="text-stone-300 text-xs font-medium italic opacity-50">Sign here...</span>
                </div>
            </div>
            
        </div>
        
        <!-- Footer -->
        <div class="bg-white/90 z-10 pb-1 pt-1 pointer-events-none">
            <p class="text-[8px] text-stone-400 text-center">{{ footerText }}</p>
        </div>
        
    </div>
</template>
