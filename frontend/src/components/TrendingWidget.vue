<template>
  <div class="card p-5 mb-6">
    <h3 class="font-display font-bold text-slate-900 mb-4">Trending Sports</h3>
    <div class="space-y-4">
      <div v-for="trend in trends" :key="trend.name" class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <span :class="trend.bg" class="p-2 rounded-lg material-symbols-outlined">{{ trend.icon }}</span>
          <span class="text-sm font-bold text-slate-700">{{ trend.name }}</span>
        </div>
        <span class="text-xs font-medium text-slate-400">{{ trend.count }}</span>
      </div>
    </div>
    <button class="w-full mt-6 py-2 text-sm font-bold text-primary hover:bg-orange-50 rounded-lg transition-colors">View All Trends</button>
  </div>
</template>

<script setup>
defineProps({
  trends: {
    type: Array,
    required: true
  }
})
</script>
