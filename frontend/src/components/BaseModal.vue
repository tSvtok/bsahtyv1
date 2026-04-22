<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="show" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" @click.self="$emit('close')">
        <Transition
          enter-active-class="transition duration-300 ease-out"
          enter-from-class="opacity-0 scale-95 translate-y-4"
          enter-to-class="opacity-100 scale-100 translate-y-0"
          leave-active-class="transition duration-200 ease-in"
          leave-from-class="opacity-100 scale-100 translate-y-0"
          leave-to-class="opacity-0 scale-95 translate-y-4"
        >
          <div v-if="show" class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden relative">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-slate-50 flex items-center justify-between">
              <h3 class="font-display font-bold text-slate-900 text-lg">{{ title }}</h3>
              <button @click="$emit('close')" class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all">
                <span class="material-symbols-outlined">close</span>
              </button>
            </div>
            
            <!-- Content -->
            <div class="p-6">
              <slot></slot>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
defineProps({
  show: Boolean,
  title: String
})

defineEmits(['close'])
</script>
