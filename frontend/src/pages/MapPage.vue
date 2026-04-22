<template>
  <div class="h-screen flex flex-col overflow-hidden">
    <Navbar />
    <div class="flex flex-1 pt-[64px] overflow-hidden">
    <!-- SideNavBar - Nearby Spots -->
    <aside class="w-[400px] bg-white border-r border-slate-200 z-40 overflow-y-auto hidden lg:block shadow-xl">
      <div class="p-6">
        <div class="flex items-center justify-between mb-6">
          <h2 class="font-headline text-2xl font-bold text-on-surface">Nearby Spots</h2>
          <button class="text-primary font-bold flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">tune</span>
            Filter
          </button>
        </div>
        <!-- Spot Categories -->
        <div class="flex gap-2 mb-8 overflow-x-auto pb-2 scrollbar-hide">
          <span v-for="category in categories" :key="category" :class="[category === 'All Sports' ? 'bg-primary-container text-on-primary' : 'bg-surface border border-outline-variant text-on-surface-variant hover:bg-slate-100']" class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap cursor-pointer transition-colors">
            {{ category }}
          </span>
        </div>
        <!-- Spot List -->
        <div class="space-y-4">
          <div v-for="spot in spots" :key="spot.id" :class="[spot.active ? 'border-2 border-primary bg-orange-50/50' : 'border border-outline-variant hover:border-primary bg-white']" class="p-4 rounded-xl transition-all cursor-pointer group">
            <div class="flex gap-4">
              <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0">
                <img :alt="spot.name" class="w-full h-full object-cover" :src="spot.image"/>
              </div>
              <div class="flex-1">
                <div class="flex justify-between items-start">
                  <h3 :class="[spot.active ? 'text-primary' : 'text-on-surface']" class="font-bold text-sm">{{ spot.name }}</h3>
                  <span class="text-primary text-xs font-bold">{{ spot.distance }}</span>
                </div>
                <p class="text-xs text-secondary flex items-center gap-1 mt-1">
                  <span class="material-symbols-outlined text-xs">location_on</span> {{ spot.address }}
                </p>
                <div class="flex items-center justify-between mt-2">
                  <span v-if="spot.hot" class="px-2 py-0.5 bg-green-100 text-green-700 text-[10px] font-bold rounded uppercase">HOT GAME</span>
                  <div v-else class="flex -space-x-2">
                    <div v-for="i in 3" :key="i" class="w-6 h-6 rounded-full border-2 border-white bg-slate-200"></div>
                  </div>
                  <span class="text-[10px] text-secondary font-medium">{{ spot.status }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </aside>

    <!-- Map Interface -->
    <section class="flex-1 relative bg-slate-200 overflow-hidden">
      <div id="map" class="absolute inset-0 z-0"></div>

      <!-- Map Controls Overlay -->
      <div class="absolute bottom-10 right-10 flex flex-col gap-3 z-30">
        <button class="w-12 h-12 bg-white rounded-xl shadow-lg flex items-center justify-center text-on-surface hover:bg-slate-50 transition-colors">
          <span class="material-symbols-outlined">add</span>
        </button>
        <button class="w-12 h-12 bg-white rounded-xl shadow-lg flex items-center justify-center text-on-surface hover:bg-slate-50 transition-colors">
          <span class="material-symbols-outlined">remove</span>
        </button>
        <button class="w-12 h-12 bg-primary text-white rounded-xl shadow-lg flex items-center justify-center hover:opacity-90 transition-opacity">
          <span class="material-symbols-outlined">my_location</span>
        </button>
      </div>

      <!-- Spot Detail Overlay -->
      <div v-if="selectedSpot" class="absolute top-10 right-10 w-96 bg-white rounded-2xl shadow-2xl border border-outline-variant overflow-hidden z-40">
        <div class="h-48 relative">
          <img :alt="selectedSpot.name" class="w-full h-full object-cover" :src="selectedSpot.image"/>
          <button @click="selectedSpot = null" class="absolute top-4 right-4 w-10 h-10 bg-black/30 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:bg-black/50 transition-colors">
            <span class="material-symbols-outlined">close</span>
          </button>
          <div class="absolute bottom-4 left-4">
            <span class="px-3 py-1 bg-primary text-white rounded-full text-xs font-bold shadow-lg">Tennis</span>
          </div>
        </div>
        <div class="p-6">
          <h2 class="font-headline text-2xl font-bold text-on-surface mb-1">{{ selectedSpot.name }}</h2>
          <p class="text-sm text-secondary flex items-center gap-2 mb-6">
            <span class="material-symbols-outlined text-primary">location_on</span>
            {{ selectedSpot.fullAddress }}
          </p>
          <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-slate-50 p-3 rounded-xl text-center">
              <p class="text-xs text-secondary">Courts</p>
              <p class="font-headline text-2xl font-bold text-primary">12</p>
            </div>
            <div class="bg-slate-50 p-3 rounded-xl text-center">
              <p class="text-xs text-secondary">Rating</p>
              <p class="font-headline text-2xl font-bold text-primary">4.8</p>
            </div>
          </div>
          <div class="mb-6">
            <h3 class="font-bold text-on-surface mb-3 flex items-center gap-2">
              <span class="material-symbols-outlined text-primary">question_answer</span>
              Recent Questions
            </h3>
            <div class="space-y-3">
              <div v-for="q in selectedSpot.questions" :key="q.id" class="bg-slate-50 p-3 rounded-lg border border-outline-variant">
                <p class="text-xs font-bold text-on-surface mb-1">{{ q.text }}</p>
                <p class="text-[10px] text-secondary">Asked by {{ q.author }} • {{ q.time }}</p>
                <div v-if="q.answer" class="mt-2 flex items-center gap-2">
                  <span class="material-symbols-outlined text-green-600 text-xs">check_circle</span>
                  <span class="text-[10px] text-green-700 font-bold uppercase">Answered: {{ q.answer }}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="flex gap-3">
            <button class="flex-1 bg-primary text-white py-3 rounded-full font-bold shadow-lg shadow-orange-100 hover:opacity-90 active:scale-95 transition-all">
              Join Game
            </button>
            <button class="w-12 h-12 border-2 border-outline rounded-full flex items-center justify-center text-primary hover:bg-orange-50 transition-colors">
              <span class="material-symbols-outlined">share</span>
            </button>
          </div>
        </div>
      </div>
    </section>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'
import Navbar from '../components/Navbar.vue'

const categories = ['All Sports', 'Basketball', 'Tennis', 'Soccer']
const selectedSpot = ref(null)

const spots = [
  {
    id: 1,
    name: 'Brooklyn Bridge Courts',
    lat: 40.7018,
    lng: -73.9968,
    distance: '0.4 mi',
    address: 'Pier 2, Brooklyn',
    image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCE1MmJ1-TbpmFp0a5R0hPrYXVJU7LgoTCsmLqg1D7dkqXxSAo2ZFilad_O-i4-NyXgIiHk-GkIzam63i0khDEfIjTwBRz_4KgwV2je56ZQJzabtEPHRoTBT1lReMIlUJPWjI5ekBxElT652hZK5fDf2blPw9mmqMk-_dhcSvS_q-Ookz_c8_Fnnyx6PzPkJ5Y5gzfiNvidIuh8HCwP67e-IF19Vcx3sofMo2o4xUAXnJmBiJ_Qdt81O91C5SaWY-tx-Vrr7vTkMOLZ',
    active: false,
    hot: false,
    status: '12 active now',
    fullAddress: 'Pier 2, Brooklyn, NY 11201',
    questions: [
      { id: 1, text: 'Are the lights working today?', author: 'Mike R.', time: '2h ago', answer: 'Yes' }
    ]
  },
  {
    id: 2,
    name: 'McCarren Park Tennis',
    lat: 40.7215,
    lng: -73.9515,
    distance: '1.2 mi',
    address: 'Williamsburg, Brooklyn',
    image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAz4yJf5uA0Iam6f5W6NMsMZt-SFHl42GQYnBVMnIgnKA2JjP2miqXTEIbxtuMv8zyHzNQRwp_a3OWj1gk1LXm1zij8OMq6InaihqRQtYNMVhN3NZ-RSQQT966VPbYIe9WkwjCbJTY0o-lpjzifvIF-Gwa9YfWmQcsLDSqjfth5-YXZuiv0fbdpviI6FY8DyCakPFTl6IW9S0tR1qsEzBCsO9vyUQ2vFgxDxrD3g8iHC45Q6BPr0HSuk4t-yaq2l9PHcA6lIZt5X1j6',
    active: true,
    hot: true,
    status: '8 slots available',
    fullAddress: 'North 12th St, Brooklyn, NY 11211',
    questions: [
      { id: 1, text: 'Are the lights working today?', author: 'Mike R.', time: '2h ago', answer: 'Yes' },
      { id: 2, text: 'Is there a waitlist for court 4?', author: 'Sarah L.', time: '5h ago' }
    ]
  },
  {
    id: 3,
    name: 'Astoria Soccer Hub',
    lat: 40.7762,
    lng: -73.9242,
    distance: '2.8 mi',
    address: 'Astoria Park, Queens',
    image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCHupKhVEFLaH1eNDM_AnoTbaye6u0Ugk6CcHttQwI_oEifMApcbureNauu9DpfgnuCCgXFSynbEK27XiBsWXirXvx-FpDTAQpQQPCE3eU2dGoySbl4UZtZ-GO3iF-oGwisuCOhCdVqwLAdWjYQlB06ubRIdUVrNr3CjMneEW9aiq-_OcizxwJQpH1k_ovil-Wrj8UBDj5OHbX8YaVXSIR02GvQ9PDsxQDH8nU_oKtLG-x3QIyPruWeE9fELM0lYEB3x-vhJUXbXF7S',
    active: false,
    hot: false,
    status: 'Next match: 6:00 PM',
    fullAddress: '19th St, Astoria, NY 11105',
    questions: []
  }
]

let map = null

onMounted(() => {
  map = L.map('map').setView([40.72, -73.96], 13)

  L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
    subdomains: 'abcd',
    maxZoom: 20
  }).addTo(map)

  spots.forEach(spot => {
    const marker = L.marker([spot.lat, spot.lng]).addTo(map)
    marker.on('click', () => {
      selectedSpot.value = spot
    })
  })
})
</script>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
