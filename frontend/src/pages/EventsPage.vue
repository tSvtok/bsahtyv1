<template>
  <div class="bg-background text-on-surface min-h-screen">
    <Navbar />
    
    <div class="flex pt-16 max-w-screen-2xl mx-auto">
      <AppSidebar />
      
      <main class="flex-1 lg:ml-64 px-4 md:px-8 py-8 lg:pb-8 pb-32">
        <!-- Header & Filters -->
        <header class="mb-10">
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
            <div>
              <h1 class="font-headline text-4xl font-bold tracking-tight text-on-surface">Discover Events</h1>
              <p class="text-slate-500 mt-2">Find and join local sports matches near you.</p>
            </div>
            <button 
              @click="showCreateModal = true"
              class="btn-primary flex items-center gap-2 self-start md:self-center"
            >
              <span class="material-symbols-outlined">add</span>
              CREATE EVENT
            </button>
          </div>
          
          <CreateEventModal :show="showCreateModal" @close="showCreateModal = false" @created="handleEventCreated" />

        <!-- Sport Filter Bar -->
        <div class="flex flex-col gap-4">
          <div class="flex gap-3 overflow-x-auto hide-scrollbar py-2">
            <button 
              v-for="sport in sports" 
              :key="sport"
              @click="activeSport = sport"
              :class="[
                'flex-shrink-0 px-6 py-3 rounded-full font-bold text-sm transition-all active:scale-95',
                activeSport === sport ? 'bg-primary text-white shadow-md shadow-orange-100' : 'bg-white border border-slate-200 text-slate-500 hover:bg-slate-50'
              ]"
            >
              {{ sport }}
            </button>
          </div>
          <div class="flex gap-3">
            <button 
              v-for="status in ['Open', 'Almost Full', 'Closed']" 
              :key="status"
              class="px-4 py-1.5 rounded-lg border border-slate-200 text-[10px] font-bold uppercase tracking-widest text-slate-500 hover:border-primary hover:text-primary transition-colors"
            >
              {{ status }}
            </button>
          </div>
        </div>
      </header>

      <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <template v-if="loading">
          <EventSkeleton v-for="i in 6" :key="i" />
        </template>
        <template v-else>
          <EventCard 
            v-for="event in filteredEvents" 
            :key="event.id" 
            :event="event"
            @join="joinEvent"
          />
        </template>
      </section>
    </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import Navbar from '../components/Navbar.vue'
import AppSidebar from '../components/AppSidebar.vue'
import EventCard from '../components/EventCard.vue'
import CreateEventModal from '../components/CreateEventModal.vue'
import EventSkeleton from '../components/EventSkeleton.vue'
import { EventService } from '../services/EventService'

const showCreateModal = ref(false)
const loading = ref(true)

const activeSport = ref('All')
const sports = ['All', 'Football', 'Basketball', 'Tennis', 'Padel', 'Volleyball', 'Running']

const handleEventCreated = (newEvent) => {
  events.value.unshift(newEvent)
}

onMounted(async () => {
  try {
    const response = await EventService.getAll()
    if (response.data && response.data.length > 0) {
      events.value = response.data.map(e => ({
        id: e.id,
        title: e.title || 'Community Match',
        sport: e.sport || 'General',
        location: e.location || 'Local Court',
        date: e.date ? new Date(e.date).toLocaleDateString('en-US', { month: 'SHORT', day: 'numeric' }) : 'TBD',
        time: e.date ? new Date(e.date).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: false }) : '00:00',
        participants: e.participants_count || 1,
        maxParticipants: e.max_participants,
        status: e.status || 'Open',
        image: e.image || 'https://images.unsplash.com/photo-1546519638-68e109498ffc?auto=format&fit=crop&q=80&w=800'
      }))
    }
  } catch (error) {
    console.error('Failed to fetch real events, using mocks:', error)
  } finally {
    loading.value = false
  }
})

const events = ref([
  {
    id: 1,
    title: 'Sunset Pro-Am Pickup',
    sport: 'Basketball',
    location: 'Riverside Community Court',
    date: 'OCT 24',
    time: '18:30',
    participants: 8,
    maxParticipants: 10,
    status: 'Open',
    image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDjRJGLv8FnHiPB7WnmAyoXPt9AFrKwJFhtpvlcJy2R81tFu8vWrGv3MzBbV_6QXtDSuarjRjwADizQpVXO2YkQ7Waz-vtlHD_YFC3cMIQmFGN6kFvb8A609eUVAbTPcw1eGscdSJcK96jl_g5rOn7yqAmvfWchdnI3Vexx_frQ9iDjUvrAtx8269O2KAC_H-syjTHrKAGis5nWQoD5FJZAMj4HsO_rAyspTbaqVG6R_XAdA_Lij-O1uayiktfn5R5u2HhoVLs1Lq3Z'
  },
  {
    id: 2,
    title: 'Champions League Night',
    sport: 'Football',
    location: 'Starlight Arena Pitch 4',
    date: 'OCT 25',
    time: '20:00',
    participants: 12,
    maxParticipants: 22,
    status: 'Open',
    image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBhtgjR5VyCMWY8kX6aI9ZiuH38gM9yOcUY6Irca7DD0jlTvnU-LgU2F67L4avhWiIU38Ol4PQaRevzcJO0K9B-A4gu4Ag8KOh4qFYCaX7Ned0nH7dKzBNyzXbcpU5zqlehz1b83fpIEvvBJ7w5hghFHT1MHNDM0PMQ7gg6CGr-pNkHE6dyZxjcTXcKlQYXECEEH9MSlpa_00xQy6EzJGwmltNpJqE9phLZioSLr20FlGcjTlQd0X7ce-baU2me85OKsTTE_Rc-lk0k'
  },
  {
    id: 3,
    title: 'Doubles Warm-up Session',
    sport: 'Tennis',
    location: 'Grand Slam Club Courts',
    date: 'OCT 26',
    time: '09:00',
    participants: 4,
    maxParticipants: 4,
    status: 'Full',
    image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBN1Q-p9Q3sZcTXnGUaZOrrIAUPXz4sUq_EBwSfxaoGf1TyTITf7mduuEHqHHD3Y942-GMPQIFQyQG_1FW3xEIogJjLJf4oREFuNeG2SSBFZQQ3vQSSo5Ja6RO19HzmWglTjVMy-1PGua2UgmVXHC2dbjYkX0ma7GZNtBuPQN0UWI3ElzohpXnqnflEqat1SQLaIbrVJngQqpm6cDxHrNTVr6C6NLT1bhSZdHtdy4QUu5VO3pMiYyVw6LPoAXYahksP-4LM2lZ6xmSy'
  },
  {
    id: 4,
    title: 'Morning Beach Volley',
    sport: 'Volleyball',
    location: 'Sunny Beach Court 2',
    date: 'OCT 27',
    time: '08:00',
    participants: 6,
    maxParticipants: 12,
    status: 'Open',
    image: 'https://images.unsplash.com/photo-1592656670411-2918d7db425a?auto=format&fit=crop&q=80&w=800'
  }
])

const filteredEvents = computed(() => {
  if (activeSport.value === 'All') return events.value
  return events.value.filter(e => e.sport === activeSport.value)
})

const joinEvent = (id) => {
  console.log('Joining event:', id)
}
</script>

<style scoped>
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}
.hide-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
