<template>
  <header class="h-16 bg-white/90 dark:bg-slate-950/90 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800 shadow-sm fixed top-0 left-0 right-0 z-50">
    <nav class="flex justify-between items-center w-full px-6 h-full max-w-screen-2xl mx-auto font-display antialiased">
      <div class="flex items-center gap-8">
        <router-link to="/" class="text-2xl font-black tracking-tighter text-[#FF5C00]">B-SSAHTY</router-link>
        <div class="hidden md:flex items-center gap-6">
          <router-link to="/feed" class="text-slate-600 dark:text-slate-400 hover:text-[#FF5C00] transition-colors" active-class="text-[#FF5C00] font-bold border-b-2 border-[#FF5C00] pb-1">Feed</router-link>
          <router-link to="/map" class="text-slate-600 dark:text-slate-400 hover:text-[#FF5C00] transition-colors" active-class="text-[#FF5C00] font-bold border-b-2 border-[#FF5C00] pb-1">Map</router-link>
          <router-link to="/events" class="text-slate-600 dark:text-slate-400 hover:text-[#FF5C00] transition-colors" active-class="text-[#FF5C00] font-bold border-b-2 border-[#FF5C00] pb-1">Events</router-link>
          <router-link to="/messages" class="text-slate-600 dark:text-slate-400 hover:text-[#FF5C00] transition-colors" active-class="text-[#FF5C00] font-bold border-b-2 border-[#FF5C00] pb-1">Messages</router-link>
        </div>
      </div>
      
      <div class="flex items-center gap-4">
        <div class="relative hidden sm:block">
          <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
          <input class="pl-10 pr-4 py-2 bg-slate-100 border-none rounded-full text-sm w-64 focus:ring-2 focus:ring-[#FF5C00] transition-all" placeholder="Search athletes..." type="text"/>
        </div>
        
        <div class="flex items-center gap-2">
          <router-link to="/messages" class="material-symbols-outlined text-slate-500 p-2 hover:bg-slate-50 rounded-full transition-all active:scale-95 duration-200">chat</router-link>
          <button class="material-symbols-outlined text-slate-500 p-2 hover:bg-slate-50 rounded-full transition-all active:scale-95 duration-200">notifications</button>
          <template v-if="userStore.currentUser">
            <button class="hidden lg:block btn-primary px-8 py-2.5">Create</button>
            <router-link to="/profile" class="h-9 w-9 rounded-full border-2 border-primary overflow-hidden ml-2 active:scale-95 transition-transform">
              <img :alt="userStore.currentUser?.name" class="w-full h-full object-cover" :src="userStore.currentUser?.avatar"/>
            </router-link>
          </template>
          <template v-else>
            <router-link to="/login" class="btn-primary px-8 py-2.5">Login</router-link>
          </template>
        </div>
      </div>
    </nav>
  </header>
</template>

<script setup>
import { useUserStore } from '../stores/user'

const userStore = useUserStore()
</script>
