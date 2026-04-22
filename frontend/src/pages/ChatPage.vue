<template>
  <div class="bg-background text-on-surface min-h-screen flex flex-col">
    <!-- Header -->
    <header v-if="conversation" class="fixed top-0 left-0 w-full z-50 flex items-center px-6 h-16 bg-white/80 backdrop-blur-xl border-b border-slate-100 shadow-sm">
      <div class="flex items-center justify-between max-w-4xl mx-auto w-full">
        <div class="flex items-center gap-4">
          <button @click="router.back()" class="p-2 rounded-full hover:bg-slate-50 transition-all active:scale-90">
            <span class="material-symbols-outlined text-primary">arrow_back</span>
          </button>
          <div class="flex items-center gap-3">
            <div class="relative">
              <img :src="conversation.avatar" class="w-10 h-10 rounded-full border-2 border-primary shadow-sm" />
              <div :class="[conversation.status === 'Online' ? 'bg-green-500' : 'bg-slate-400']" class="absolute bottom-0 right-0 w-3 h-3 border-2 border-white rounded-full"></div>
            </div>
            <div>
              <h2 class="font-headline font-bold text-on-surface leading-none">{{ conversation.name }}</h2>
              <p :class="[conversation.status === 'Online' ? 'text-green-500' : 'text-slate-400']" class="text-[10px] font-black uppercase tracking-widest mt-0.5">{{ conversation.status }}</p>
            </div>
          </div>
        </div>
        <div class="flex gap-2">
          <button class="p-2 hover:bg-slate-50 rounded-full text-slate-400"><span class="material-symbols-outlined">videocam</span></button>
          <button class="p-2 hover:bg-slate-50 rounded-full text-slate-400"><span class="material-symbols-outlined">call</span></button>
        </div>
      </div>
    </header>

    <main v-if="conversation" class="flex-1 max-w-4xl mx-auto w-full pt-20 pb-40 px-6 overflow-y-auto space-y-8 hide-scrollbar">
      <div class="flex justify-center">
        <span class="text-[10px] font-black text-slate-400 bg-slate-50 px-4 py-1.5 rounded-full uppercase tracking-[0.2em]">Conversation History</span>
      </div>

      <div v-for="msg in conversation.messages" :key="msg.id" :class="[msg.sender === 'me' ? 'items-end' : 'items-start']" class="flex flex-col space-y-2">
        <div class="flex items-end gap-3" :class="msg.sender === 'me' ? 'flex-row-reverse' : ''">
          <img v-if="msg.sender !== 'me'" :src="conversation.avatar" class="w-8 h-8 rounded-full border border-slate-100 shadow-sm" />
          <div :class="[msg.sender === 'me' ? 'bg-primary text-white rounded-tr-none shadow-orange-100' : 'bg-white text-on-surface rounded-tl-none border border-slate-50 shadow-sm']" class="max-w-[80%] p-5 rounded-[28px]">
            <p class="text-sm leading-relaxed">{{ msg.text }}</p>
          </div>
        </div>
        <span :class="[msg.sender === 'me' ? 'mr-2' : 'ml-11']" class="text-[10px] font-bold text-slate-400">{{ msg.time }}</span>
      </div>
    </main>

    <!-- Bottom Input -->
    <div class="fixed bottom-0 left-0 w-full bg-white/80 backdrop-blur-xl border-t border-slate-100 p-6 z-40">
      <div class="max-w-4xl mx-auto space-y-4">
        <div class="flex gap-2 overflow-x-auto hide-scrollbar pb-1">
          <span v-for="tag in ['On my way! 🏃‍♂️', 'Can\'t wait! 🔥', 'Who else is coming? 🏀']" :key="tag" class="px-4 py-2 bg-slate-50 text-slate-500 text-[10px] font-bold rounded-full border border-slate-100 cursor-pointer hover:bg-primary hover:text-white hover:border-primary transition-all whitespace-nowrap">{{ tag }}</span>
        </div>
        <div class="flex items-center gap-4">
          <button class="w-14 h-14 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center hover:bg-slate-100 transition-all"><span class="material-symbols-outlined">add_circle</span></button>
          <div class="flex-1 relative">
            <input 
              v-model="newMessage" 
              @keyup.enter="handleSendMessage"
              type="text" 
              placeholder="Type a message..." 
              class="w-full h-14 bg-slate-50 border-none rounded-2xl px-6 focus:ring-4 focus:ring-orange-50 text-sm font-medium" 
            />
          </div>
          <button 
            @click="handleSendMessage"
            class="w-14 h-14 bg-primary text-white rounded-2xl shadow-xl shadow-orange-200 flex items-center justify-center hover:scale-105 active:scale-95 transition-all"
          >
            <span class="material-symbols-outlined">send</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useMessageStore } from '../stores/messages'

const route = useRoute()
const router = useRouter()
const messageStore = useMessageStore()

const newMessage = ref('')

const conversation = computed(() => {
  return messageStore.conversations.find(c => c.id === parseInt(route.params.id))
})

const handleSendMessage = () => {
  if (!newMessage.value.trim()) return
  messageStore.sendMessage(route.params.id, newMessage.value)
  newMessage.value = ''
}
</script>

<style scoped>
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}
.hide-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
