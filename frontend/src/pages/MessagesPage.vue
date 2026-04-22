<template>
  <div class="bg-background text-on-surface min-h-screen">
    <Navbar />
    
    <div class="flex pt-16 max-w-screen-2xl mx-auto">
      <AppSidebar />
      
      <main class="flex-1 lg:ml-64 px-4 md:px-8 py-8 lg:pb-8 pb-32 space-y-8">
        <!-- Search -->
        <div class="relative group">
          <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none">
            <span class="material-symbols-outlined text-slate-400 group-focus-within:text-primary transition-colors">search</span>
          </div>
          <input 
            type="text" 
            placeholder="Search conversations..." 
            class="w-full h-16 pl-14 pr-6 bg-white border border-slate-100 rounded-3xl shadow-sm focus:ring-4 focus:ring-orange-50 focus:border-primary transition-all font-medium"
          />
        </div>

      <!-- Filters -->
      <div class="flex gap-3 overflow-x-auto hide-scrollbar py-2">
        <button 
          v-for="filter in ['All', 'Unread', 'Teams', 'Events']" 
          :key="filter"
          :class="[
            'px-6 py-2.5 rounded-full font-bold text-sm transition-all whitespace-nowrap',
            filter === 'All' ? 'bg-primary text-white shadow-md shadow-orange-100' : 'bg-white border border-slate-200 text-slate-500 hover:bg-slate-50'
          ]"
        >
          {{ filter }}
        </button>
      </div>

      <!-- Conversations List -->
      <section class="space-y-4">
        <div 
          v-for="chat in chats" 
          :key="chat.id"
          @click="goToChat(chat.id)"
          class="flex items-center p-5 bg-white rounded-[32px] border border-slate-50 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all cursor-pointer group"
        >
          <div class="relative">
            <img :src="chat.avatar" :alt="chat.name" class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-sm group-hover:border-primary transition-colors"/>
            <div v-if="chat.online" class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-4 border-white rounded-full"></div>
          </div>
          
          <div class="ml-5 flex-1 min-w-0">
            <div class="flex justify-between items-baseline mb-1">
              <h3 class="font-headline font-bold text-on-surface truncate">{{ chat.name }}</h3>
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ chat.time }}</span>
            </div>
            <p :class="[
              'text-sm truncate transition-colors',
              chat.unread ? 'font-bold text-on-surface' : 'text-slate-500'
            ]">
              {{ chat.lastMessage }}
            </p>
          </div>

          <div v-if="chat.unread" class="ml-4">
            <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center shadow-lg shadow-orange-200">
              <span class="text-[10px] text-white font-black">{{ chat.unreadCount }}</span>
            </div>
          </div>
          <div v-else class="ml-4 opacity-0 group-hover:opacity-100 transition-opacity">
             <span class="material-symbols-outlined text-slate-300">chevron_right</span>
          </div>
        </div>
      </section>

      <!-- Match Day Bento -->
      <div class="p-8 bg-slate-900 rounded-[40px] text-white overflow-hidden relative shadow-2xl group">
        <div class="relative z-10 space-y-4">
          <div class="inline-block px-3 py-1 bg-primary text-white text-[10px] font-black rounded-full uppercase tracking-widest">Live Updates</div>
          <h4 class="font-headline text-3xl font-bold leading-tight">Match Day<br/>is Here!</h4>
          <p class="text-slate-400 text-sm">You have 2 games scheduled for today at Riverside.</p>
          <button class="bg-white text-slate-900 px-6 py-3 rounded-2xl font-bold text-xs hover:bg-primary hover:text-white transition-all">VIEW SCHEDULE</button>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-20 group-hover:scale-110 group-hover:rotate-12 transition-transform duration-1000">
          <span class="material-symbols-outlined text-[200px]">sports_basketball</span>
        </div>
      </div>
    </main>

    <!-- FAB -->
    <button class="fixed right-8 bottom-28 w-16 h-16 bg-primary text-white rounded-2xl shadow-2xl shadow-orange-200 flex items-center justify-center hover:scale-110 active:scale-95 transition-all z-40">
      <span class="material-symbols-outlined text-3xl">edit_square</span>
    </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import Navbar from '../components/Navbar.vue'
import AppSidebar from '../components/AppSidebar.vue'

const router = useRouter()

const chats = ref([
  {
    id: 1,
    name: 'Marcus Chen',
    avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB8SB2go5hBs0jHJxWlt8Na0FaeF84oq-A2MabVICG_mQnD2u_jujy43ulPZHd6tUaaC7IPs9zO286yJYzU2Rzqxo9tymST2hHaZR2GqpqmzXhhYvg1uZOA2kdFopdW0alYQxxt3vYV3n12Jl0OuuOaaBv4e8xFyygPvxMfnX3c-oFlyjko7vhrUxU2jKdvEZd9oB994iwz07x9IZojSBHsZIG2-1pUteJ7CpxPZA24irUqBkTHGh2sEYJ1SdGNSb1jawALvKapeax6',
    lastMessage: 'Are we still playing tonight at 8?',
    time: '2m ago',
    unread: true,
    unreadCount: 1,
    online: true
  },
  {
    id: 2,
    name: 'Sarah Miller',
    avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBOYNL6J4kvjKUyYiZjPBFsChM59fqVJTu36LRqy0Ayi1F9mowxiQzBJ-jxJHUGa5fBqU_toe7PcCLo4vQ0FGb1AwodS0OstYYnSPFEG63oCLLR4CO7b9bwhgiDHDJVPmyvxJuK2-WSHbITrUVWutKsEj91YAWqXBKhwkCFRrhf0z5fQvN1WXyvyO_bTp308mJWSgHlkkErZlQDRRYsKkpT7nNMzQ7IKaARjhvQvMbJmotw6hxY33AbKipPYPk0Xb9PMxvKM5qkThfx',
    lastMessage: 'Thanks for the tips on the tennis racket!',
    time: '1h ago',
    unread: false,
    online: false
  },
  {
    id: 3,
    name: 'Elena Rodriguez',
    avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDoYPDYeKUjoRpudqnPBFZUx4qvCrcGLAhGw9AuVnBBLYEX4uMb5WMeyJPmjse57Hurm-51ZiBdTcBrAiO7jCXrHcnBsqNzVMPNp4dbcslvzmhwFcXOfLFMAnsLpniVhH8S7Zt30paciAK5t9QnSqsTgm7-cdL3tf5aSzaLmxL-WjeGJa6xHEBc-dElBzIpV4r5f9Y0bwh3KJ10waNuTBZxatCb1SIi4kmZcXr4QULVu70Yb0-IoOqIyoNiY2HShAXZ31UVQVKjtpr6',
    lastMessage: 'Joined your 3v3 basketball event.',
    time: '3h ago',
    unread: false,
    online: true
  }
])

const goToChat = (id) => {
  router.push(`/messages/${id}`)
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
