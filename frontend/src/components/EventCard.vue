<template>
  <article class="card overflow-hidden group">
    <router-link :to="'/events/' + event.id">
      <div class="relative h-56 overflow-hidden">
        <img :src="event.image" :alt="event.title" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"/>
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
        <div class="absolute top-4 right-4 px-3 py-1 bg-white/90 backdrop-blur-md rounded-full text-[10px] font-bold uppercase tracking-widest shadow-sm" :class="event.status === 'Full' ? 'text-slate-400' : 'text-primary'">
          {{ event.status }}
        </div>
        <div class="absolute bottom-4 left-4 text-white">
          <p class="text-[10px] font-bold uppercase tracking-widest opacity-80">{{ event.date }} • {{ event.time }}</p>
          <h3 class="font-headline text-lg font-bold">{{ event.title }}</h3>
        </div>
      </div>
    </router-link>
    
    <div class="p-6 space-y-4">
      <div class="flex items-center gap-2 text-slate-500">
        <span class="material-symbols-outlined text-lg">location_on</span>
        <span class="text-xs font-medium">{{ event.location }}</span>
      </div>

      <!-- Progress Bar -->
      <div class="space-y-2">
        <div class="flex justify-between items-center text-[10px] font-bold uppercase tracking-wider">
          <span class="text-slate-400">{{ event.participants }}/{{ event.maxParticipants }} Participants</span>
          <span :class="event.participants >= event.maxParticipants * 0.8 ? 'text-primary' : 'text-slate-400'">
            {{ event.participants >= event.maxParticipants ? 'Registration Closed' : (event.maxParticipants - event.participants) + ' Slots Left' }}
          </span>
        </div>
        <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
          <div 
            class="h-full bg-primary transition-all duration-500" 
            :style="{ width: (event.participants / event.maxParticipants * 100) + '%' }"
          ></div>
        </div>
      </div>

      <button 
        @click="$emit('join', event.id)"
        :disabled="event.status === 'Full'"
        class="w-full py-4 rounded-2xl font-bold text-sm transition-all active:scale-95 flex items-center justify-center gap-2"
        :class="event.status === 'Full' ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-slate-50 text-primary hover:bg-primary hover:text-white'"
      >
        {{ event.status === 'Full' ? 'FULL HOUSE' : 'JOIN MATCH' }}
        <span v-if="event.status !== 'Full'" class="material-symbols-outlined text-sm">arrow_forward</span>
      </button>
    </div>
  </article>
</template>

<script setup>
defineProps({
  event: {
    type: Object,
    required: true
  }
})

defineEmits(['join'])
</script>
