<template>
  <aside class="hidden lg:flex flex-col fixed left-0 top-16 h-[calc(100vh-64px)] w-64 p-4 bg-white dark:bg-slate-950 border-r border-slate-100 dark:border-slate-800 z-40">
    <!-- User Info Section -->
    <div class="mb-8 px-2 flex items-center gap-3">
      <img :alt="userStore.currentUser?.name" class="w-10 h-10 rounded-full object-cover border-2 border-primary" :src="userStore.currentUser?.avatar || 'https://lh3.googleusercontent.com/a/default-user'"/>
      <div>
        <h3 class="font-display text-sm font-bold text-slate-900 dark:text-white">{{ userStore.currentUser?.name || 'Guest User' }}</h3>
        <p class="text-xs text-slate-500 font-medium">{{ userStore.currentUser?.role || 'Community Member' }}</p>
      </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 space-y-1 font-display text-sm font-medium">
      <router-link 
        v-for="item in menuItems" 
        :key="item.name" 
        :to="item.path" 
        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all hover:translate-x-1"
        active-class="bg-orange-50 dark:bg-orange-950/30 text-[#FF5C00] border-r-4 border-[#FF5C00]"
        :class="[route.path === item.path ? '' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-900']"
      >
        <span class="material-symbols-outlined">{{ item.icon }}</span>
        {{ item.name }}
      </router-link>
    </nav>

    <!-- Bottom Actions -->
    <div class="mt-auto space-y-1 pt-4 border-t border-slate-100 dark:border-slate-800">
      <router-link to="/profile" class="flex items-center gap-3 px-4 py-2 rounded-xl text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-900 transition-all">
        <span class="material-symbols-outlined">settings</span>
        Settings
      </router-link>
      <a class="flex items-center gap-3 px-4 py-2 rounded-xl text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-900 transition-all cursor-pointer" href="#">
        <span class="material-symbols-outlined">help</span>
        Support
      </a>
      <button @click="handleLogout" class="w-full flex items-center gap-3 px-4 py-2 rounded-xl text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 transition-all">
        <span class="material-symbols-outlined">logout</span>
        Logout
      </button>
    </div>
  </aside>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router'
import { useUserStore } from '../stores/user'
import { AuthService } from '../services/AuthService'

const route = useRoute()
const router = useRouter()
const userStore = useUserStore()

const menuItems = [
  { name: 'Feed', icon: 'dynamic_feed', path: '/feed' },
  { name: 'Map', icon: 'map', path: '/map' },
  { name: 'Events', icon: 'event', path: '/events' },
  { name: 'Messages', icon: 'chat', path: '/messages' },
  { name: 'My Profile', icon: 'person', path: '/profile' },
]

const handleLogout = async () => {
  try {
    await AuthService.logout()
    userStore.logout()
    router.push('/login')
  } catch (error) {
    console.error('Logout error:', error)
    userStore.logout()
    router.push('/login')
  }
}
</script>
