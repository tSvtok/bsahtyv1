<template>
  <div class="card p-6 group">
    <div class="flex items-center justify-between mb-4">
      <div class="flex items-center gap-3">
        <div class="relative">
          <img :alt="post.author" class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm" :src="post.avatar"/>
          <div v-if="post.online" class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></div>
        </div>
        <div>
          <h4 class="font-display font-bold text-slate-900 group-hover:text-primary transition-colors cursor-pointer">{{ post.author }}</h4>
          <div class="flex items-center gap-2 text-xs text-slate-400 font-medium">
            <span>{{ post.time }}</span>
            <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
            <span class="px-2 py-0.5 bg-orange-50 text-primary rounded-full font-bold">#{{ post.category }}</span>
          </div>
        </div>
      </div>
      <button class="text-slate-400 hover:text-slate-600">
        <span class="material-symbols-outlined">more_horiz</span>
      </button>
    </div>
    
    <p class="text-slate-700 font-body mb-4 leading-relaxed">
      {{ post.content }}
    </p>
    
    <div v-if="post.image" class="w-full h-64 overflow-hidden rounded-xl mb-4">
      <img :alt="post.category" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" :src="post.image"/>
    </div>
    
    <div class="flex items-center justify-between pt-4 border-t border-slate-50">
      <div class="flex gap-4">
        <button 
          @click="$emit('like', post.id)"
          class="flex items-center gap-2 text-slate-500 hover:text-primary transition-colors group/btn"
        >
          <span class="material-symbols-outlined group-active/btn:scale-125 transition-transform">favorite</span>
          <span class="text-sm font-bold">{{ post.likes }}</span>
        </button>
        <button 
          @click="$emit('comment', post.id)"
          class="flex items-center gap-2 text-slate-500 hover:text-blue-500 transition-colors"
        >
          <span class="material-symbols-outlined">chat_bubble</span>
          <span class="text-sm font-bold">{{ post.comments }}</span>
        </button>
        <button class="flex items-center gap-2 text-slate-500 hover:text-slate-800 transition-colors">
          <span class="material-symbols-outlined">share</span>
        </button>
      </div>
      
      <button 
        v-if="post.joinable" 
        @click="$emit('join', post.id)"
        class="bg-orange-50 text-primary px-4 py-1.5 rounded-full text-sm font-bold hover:bg-primary hover:text-white transition-all active:scale-95"
      >
        Join Game
      </button>
      <button v-else class="text-slate-400 hover:text-slate-600 transition-colors">
        <span class="material-symbols-outlined">bookmark</span>
      </button>
    </div>
  </div>
</template>

<script setup>
defineProps({
  post: {
    type: Object,
    required: true
  }
})

defineEmits(['like', 'comment', 'join'])
</script>
