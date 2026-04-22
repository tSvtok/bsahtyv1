<template>
  <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden space-y-4">
    <SkeletonLoader width="w-full" height="h-56" />
    <div class="p-6 space-y-4">
      <SkeletonLoader width="w-48" height="h-4" />
      <div class="space-y-2">
        <div class="flex justify-between">
          <SkeletonLoader width="w-20" height="h-3" />
          <SkeletonLoader width="w-20" height="h-3" />
        </div>
        <SkeletonLoader width="w-full" height="h-2" className="rounded-full" />
      </div>
      <SkeletonLoader width="w-full" height="h-12" className="rounded-2xl" />
    </div>
  </div>
</template>

<script setup>
import SkeletonLoader from './SkeletonLoader.vue'
</script>
