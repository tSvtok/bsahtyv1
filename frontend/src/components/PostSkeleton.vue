<template>
  <div class="bg-white rounded-2xl p-6 shadow-sm border border-[#E2E8F0] space-y-4">
    <div class="flex items-center gap-3">
      <SkeletonLoader width="w-12" height="h-12" className="rounded-full" />
      <div class="space-y-2 flex-1">
        <SkeletonLoader width="w-32" height="h-4" />
        <SkeletonLoader width="w-24" height="h-3" />
      </div>
    </div>
    <div class="space-y-2">
      <SkeletonLoader width="w-full" height="h-4" />
      <SkeletonLoader width="w-5/6" height="h-4" />
      <SkeletonLoader width="w-4/6" height="h-4" />
    </div>
    <SkeletonLoader width="w-full" height="h-64" className="rounded-xl" />
    <div class="flex justify-between pt-4 border-t border-slate-50">
      <div class="flex gap-4">
        <SkeletonLoader width="w-10" height="h-6" />
        <SkeletonLoader width="w-10" height="h-6" />
      </div>
      <SkeletonLoader width="w-24" height="h-8" className="rounded-full" />
    </div>
  </div>
</template>

<script setup>
import SkeletonLoader from './SkeletonLoader.vue'
</script>
