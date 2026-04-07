<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, nextTick, watch } from 'vue';

const props = defineProps({
    role: String,
    guards: Array,
    activeGuardId: Number,
    adminId: Number,
    messages: Array,
});

const page = usePage();
const currentUser = page.props.auth.user;

const currentReceiverId = ref(props.role === 'Admin' ? props.activeGuardId : props.adminId);

const form = useForm({
    receiver_id: currentReceiverId.value,
    content: '',
});

const messagesContainer = ref(null);
let pollingInterval = null;
let lastMessageCount = props.messages ? props.messages.length : 0;

// To handle initial scroll and keep it scrolled to bottom when new messages arrive
const scrollToBottom = () => {
    nextTick(() => {
        if (messagesContainer.value) {
            messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
        }
    });
};

// Select a guard to chat with (Admin only)
const selectGuard = (guardId) => {
    currentReceiverId.value = guardId;
    form.receiver_id = guardId;
    router.get(route('chat.index'), { guard_id: guardId }, { preserveState: true });
};

// Play a short beep when receiving a message
const playPing = () => {
    // Basic web audio API beep to avoid needing a static asset file
    try {
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioCtx.createOscillator();
        const gainNode = audioCtx.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioCtx.destination);
        
        oscillator.type = 'sine';
        oscillator.frequency.value = 800; // 800hz
        
        gainNode.gain.setValueAtTime(0.1, audioCtx.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.5);
        
        oscillator.start(audioCtx.currentTime);
        oscillator.stop(audioCtx.currentTime + 0.5);
    } catch(e) {}
};

// Watch for incoming messages to play sound and scroll down
watch(() => props.messages, (newMessages) => {
    if (!newMessages) return;
    
    // Check if there are truly new messages and one of them is from someone else
    if (newMessages.length > lastMessageCount) {
        const lastMsg = newMessages[newMessages.length - 1];
        if (lastMsg.sender_id !== currentUser.user_id) {
            playPing();
        }
    }
    
    lastMessageCount = newMessages.length;
    scrollToBottom();
}, { deep: true });


const submitMessage = () => {
    if (!form.content.trim() || !form.receiver_id) return;
    
    form.post(route('chat.store'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            form.reset('content');
            scrollToBottom();
        }
    });
};

const formatTime = (timeStr) => {
    if (!timeStr) return '';
    return new Date(timeStr).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
};

onMounted(() => {
    scrollToBottom();
    // Poll every 5 seconds for new messages
    pollingInterval = setInterval(() => {
        const onlyFields = props.role === 'Admin' ? ['messages', 'guards'] : ['messages'];
        const params = props.role === 'Admin' && currentReceiverId.value ? { guard_id: currentReceiverId.value } : {};
        
        router.reload({
            only: onlyFields,
            data: params,
            preserveScroll: true,
            preserveState: true,
        });
    }, 5000);
});

onUnmounted(() => {
    if (pollingInterval) clearInterval(pollingInterval);
});

</script>

<template>
    <Head title="Support Channel - Lembah Entry" />
    <AuthenticatedLayout>
        <div class="px-6 py-8 bg-[#f8f6f5] min-h-[calc(100vh-4rem)] flex items-stretch h-full">
            <div class="max-w-[1440px] mx-auto w-full flex gap-6 h-[calc(100vh-10rem)]">
                
                <!-- Guards Catalog Sidebar (Admin Only) -->
                <div v-if="role === 'Admin'" class="w-80 bg-white rounded-3xl shadow-sm border border-stone-100 flex flex-col overflow-hidden shrink-0">
                    <div class="p-6 border-b border-stone-100 bg-stone-50/50">
                        <h2 class="text-xl font-headline font-extrabold text-primary tracking-tight">System Staff</h2>
                        <p class="text-[10px] uppercase tracking-widest text-stone-400 font-bold mt-1">Direct Comms</p>
                    </div>
                    
                    <div class="flex-1 overflow-y-auto p-4 space-y-2">
                        <div v-for="guard in guards" :key="guard.user_id"
                            @click="selectGuard(guard.user_id)"
                            class="p-4 rounded-2xl flex items-center gap-3 cursor-pointer transition-all border border-transparent group"
                            :class="currentReceiverId === guard.user_id ? 'bg-primary/5 border-primary/20 shadow-sm' : 'hover:bg-stone-50'"
                        >
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shrink-0"
                                 :class="currentReceiverId === guard.user_id ? 'bg-primary text-white' : 'bg-primary/10 text-primary'">
                                {{ guard.name.substring(0, 2).toUpperCase() }}
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <h4 class="text-sm font-bold truncate" :class="currentReceiverId === guard.user_id ? 'text-primary' : 'text-stone-700'">{{ guard.name }}</h4>
                                <p class="text-xs text-stone-400 truncate">@{{ guard.username }}</p>
                            </div>
                            <div v-if="guard.unread_count > 0" class="w-5 h-5 rounded-full bg-error text-white font-bold text-[10px] flex items-center justify-center shrink-0">
                                {{ guard.unread_count }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Thread Panel -->
                <div class="flex-1 bg-white rounded-3xl shadow-sm border border-stone-100 flex flex-col overflow-hidden relative">
                    
                    <div v-if="!currentReceiverId" class="absolute inset-0 bg-stone-50/80 backdrop-blur-[2px] z-20 flex flex-col items-center justify-center text-center p-8">
                        <div class="w-20 h-20 bg-primary/10 text-primary rounded-full flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-4xl">forum</span>
                        </div>
                        <h3 class="text-2xl font-headline font-bold text-stone-800 tracking-tight">Select a transmission thread</h3>
                        <p class="text-stone-500 mt-2">Open a channel on the left to begin communicating securely.</p>
                    </div>

                    <div class="p-6 border-b border-stone-100 bg-stone-50/50 flex justify-between items-center z-10 shrink-0">
                        <div>
                            <h2 class="text-xl font-headline font-extrabold text-stone-800 tracking-tight flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-lg">public</span>
                                {{ role === 'Admin' ? 'Direct Message' : 'System Overseer' }}
                            </h2>
                            <p class="text-[10px] uppercase tracking-widest text-stone-400 font-bold mt-1">End-to-End Encrypted Channel</p>
                        </div>
                    </div>

                    <!-- Messages Space -->
                    <div ref="messagesContainer" class="flex-1 overflow-y-auto p-6 space-y-6 bg-[#f8f6f5]/50 z-10 scroll-smooth">
                        <div v-if="messages && messages.length === 0" class="flex flex-col items-center justify-center h-full text-stone-300 gap-4 opacity-50">
                            <span class="material-symbols-outlined text-4xl">inventory_2</span>
                            <span class="text-xs uppercase font-bold tracking-widest">No previous comms</span>
                        </div>

                        <div v-for="msg in messages" :key="msg.message_id" 
                            class="flex flex-col max-w-[75%]"
                            :class="msg.sender_id === currentUser.user_id ? 'self-end items-end' : 'self-start items-start'"
                        >
                            <span class="text-[9px] font-bold text-stone-400 uppercase tracking-widest mb-1 mx-2">
                                {{ msg.sender_id === currentUser.user_id ? 'You' : msg.sender.name }} · {{ formatTime(msg.created_at) }}
                            </span>
                            <div 
                                class="px-5 py-3 rounded-2xl shadow-sm leading-relaxed text-sm"
                                :class="msg.sender_id === currentUser.user_id 
                                    ? 'bg-primary text-white rounded-tr-sm' 
                                    : 'bg-white border border-stone-200 text-stone-700 rounded-tl-sm'"
                            >
                                {{ msg.content }}
                            </div>
                        </div>
                    </div>

                    <!-- Input Composer -->
                    <div class="p-4 bg-white border-t border-stone-100 z-10 shrink-0">
                        <form @submit.prevent="submitMessage" class="flex items-end gap-3 max-w-4xl mx-auto">
                            <div class="flex-1 relative">
                                <textarea 
                                    v-model="form.content" 
                                    rows="1"
                                    maxlength="2000"
                                    @keydown.enter.prevent="submitMessage"
                                    class="w-full bg-stone-50 border border-stone-200 py-3.5 pl-4 pr-12 rounded-2xl focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all text-sm shadow-inner resize-none scrollbar-hide overflow-y-auto max-h-32"
                                    placeholder="Type your message..."
                                ></textarea>
                            </div>
                            <button 
                                type="submit" 
                                :disabled="form.processing || !form.content.trim()"
                                class="w-12 h-12 rounded-2xl bg-primary text-white flex items-center justify-center hover:opacity-90 transition-all disabled:opacity-50 active:scale-95 shadow-sm shrink-0"
                            >
                                <span class="material-symbols-outlined text-xl ml-1">send</span>
                            </button>
                        </form>
                        <p class="text-center text-[9px] text-stone-400 font-bold uppercase tracking-widest mt-3">Press Enter to dispatch transmission</p>
                    </div>

                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Optional: specific styles */
</style>
