<template>
  <div :class="[
    'animate-pulse bg-slate-200 rounded-lg',
    widthClass,
    heightClass,
    className
  ]"></div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  width: {
    type: String,
    default: 'w-full'
  },
  height: {
    type: String,
    default: 'h-4'
  },
  className: {
    type: String,
    default: ''
  }
})

const widthClass = computed(() => props.width)
const heightClass = computed(() => props.height)
</script>
