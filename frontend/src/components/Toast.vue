<template>
  <TransitionGroup
    tag="div"
    enter-active-class="transition duration-300 ease-out"
    enter-from-class="transform translate-y-2 opacity-0"
    enter-to-class="transform translate-y-0 opacity-100"
    leave-active-class="transition duration-200 ease-in"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0"
    class="fixed bottom-6 right-6 z-[9999] flex flex-col gap-2 pointer-events-none"
  >
    <div
      v-for="toast in toastStore.toasts" :key="toast.id"
      class="pointer-events-auto min-w-[280px] card p-4 flex items-center gap-3 shadow-2xl border-l-4"
      :class="{
        'border-orange-500': toast.type === 'success',
        'border-red-500': toast.type === 'error',
        'border-blue-500': toast.type === 'info'
      }"
    >
      <div v-if="toast.type === 'success'" class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
      </div>
      <div v-else-if="toast.type === 'error'" class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </div>
      <div v-else class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      </div>
      
      <div class="flex-1 min-w-0">
        <p class="text-sm font-bold truncate">{{ toast.title }}</p>
        <p class="text-xs text-gray-500 truncate">{{ toast.message }}</p>
      </div>

      <button @click="toastStore.remove(toast.id)" class="text-gray-300 hover:text-gray-500">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
  </TransitionGroup>
</template>

<script setup>
import { useToastStore } from '@/stores/toast'

const toastStore = useToastStore()
</script>
