<template>
  <div class="bg-background text-on-surface min-h-screen">
    <Navbar />
    
    <div class="pt-16 max-w-screen-2xl mx-auto">

    <main class="max-w-4xl mx-auto pt-16">
      <!-- Hero Section -->
      <section class="relative h-[400px] w-full overflow-hidden md:rounded-b-[40px] shadow-2xl">
        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCbgqRAmhCdt3XUBpYxnwKAJo1-J1h3NZqedi0U2Cw2nVJYywjxg6RLCaTKyXV5oDVJxlhjyiuVRPOQTNEhlHbokPZepo_VEt1nHIQ3e_z2CIVDuf48ZESnarO7cIj64H9JDZt2UJIJfXHhIRzGs88JdrqYVFh4NqRWoG_55QTyJNuSfPlG7fUcspn5T74Rt_pFf9UopAz8GkOiErEKfRjODhmpzTC82AAfH-zyax6J4_wEUBVcYhfy_nnSr0IhcWR3cn1_nnr-Z2Hf"/>
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
        <div class="absolute bottom-10 left-10 right-10">
          <span class="inline-block px-4 py-1.5 bg-primary text-white font-bold text-[10px] tracking-widest uppercase rounded-full mb-4 shadow-lg">BASKETBALL</span>
          <h2 class="font-headline text-white text-5xl font-black leading-tight">Saturday Night Streetball</h2>
        </div>
      </section>

      <div class="px-6 md:px-10 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Left Column: Details -->
        <div class="lg:col-span-2 space-y-12">
          <!-- Quick Info Cards -->
          <div class="grid grid-cols-3 gap-4">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm text-center space-y-2">
              <span class="material-symbols-outlined text-primary">calendar_today</span>
              <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Date</p>
              <p class="font-bold text-on-surface">Oct 24</p>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm text-center space-y-2">
              <span class="material-symbols-outlined text-primary">schedule</span>
              <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Time</p>
              <p class="font-bold text-on-surface">18:30</p>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm text-center space-y-2">
              <span class="material-symbols-outlined text-primary">group</span>
              <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Joined</p>
              <p class="font-bold text-on-surface">8/10</p>
            </div>
          </div>

          <!-- Description -->
          <section class="space-y-4">
            <h3 class="font-headline text-2xl font-bold text-on-surface">About this Event</h3>
            <p class="text-slate-500 leading-relaxed text-lg">
              High-intensity 3v3 streetball. Bring your A-game. Water and snacks provided. Winner stays on court rules. 
              This is a pro-am level pickup game, so expect competitive play and great vibes under the lights.
            </p>
          </section>

          <!-- Location & Map -->
          <section class="space-y-6">
            <div class="flex items-center justify-between">
              <h3 class="font-headline text-2xl font-bold text-on-surface">Location</h3>
              <button class="text-primary font-bold text-sm hover:underline">Get Directions</button>
            </div>
            <div class="flex items-start gap-4">
              <div class="p-3 bg-orange-50 rounded-2xl">
                <span class="material-symbols-outlined text-primary">location_on</span>
              </div>
              <div>
                <h4 class="font-bold text-on-surface text-lg">Riverside Community Court</h4>
                <p class="text-slate-500">Downtown Sports Complex, Block 4</p>
              </div>
            </div>
            <div class="w-full h-64 rounded-[32px] overflow-hidden border border-slate-100 shadow-inner relative group">
              <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDs7OFZJvRe5QTBoiYuh1Gcwx5r_JasXJBY93zFhATvkZPBkWpTgR9D23SApiR0VDu5fGnFj9dlgwaVF7qY8W-QDRoNyGvjjXjd2sl3J14FBRWoZXsb3DoR0TA_qXE2BsaWeuMY7ThrBTIGr3vyzDrHBewpueo3pNEA0g9KX41M35gLrt0cRdE_Y3hPbC4s2HxaFKUoODBfWAT14w4n5UeKC6BwrUoAHLv9FrNnAAmS3Nb3MrxtbftvFCP4TnWMDwFHgDT-TzNnD9jk"/>
              <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center shadow-2xl animate-bounce">
                  <span class="material-symbols-outlined text-white text-3xl">sports_basketball</span>
                </div>
              </div>
            </div>
          </section>
        </div>

        <!-- Right Column: Sidebar -->
        <div class="space-y-8">
          <!-- Organizer Card -->
          <div class="bg-slate-50 p-8 rounded-[32px] border border-slate-100 space-y-6">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Organizer</p>
            <div class="flex items-center gap-4">
              <div class="relative">
                <img class="w-16 h-16 rounded-full border-4 border-white shadow-md object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCSPWZMkwtjtMCqZQh5v44sXVwkowW895pJ90UQ17CVhypnZZCmyrnkNbP5lCn2G1t_nZZJXdYGZN4WWZJKuhzzm_ViOXqbX5wgHCZuIzwAjqEf9BSLuybdgTrkWIEmH0-2YRJV33IISpocGq-iODil6abd_Dl5E5_o2dbVyfnf3U5aroZWdh7sjcwa4rSEmSoFwfc1j3DGlBhoo-_vE2qwunmbFduwIWHB-DV_lyfmVZ56XeF0Mx3Xz3G6szt8Z3Gkn1lgC3iFbYY8"/>
                <div class="absolute -bottom-1 -right-1 bg-blue-600 text-white text-[8px] font-black px-2 py-0.5 rounded-full border-2 border-white shadow-sm">PRO</div>
              </div>
              <div>
                <p class="font-headline font-bold text-on-surface text-xl">Marcus R.</p>
                <p class="text-xs text-slate-500">Elite Player • 4.9 ★</p>
              </div>
            </div>
            <button class="w-full py-4 bg-white text-on-surface border border-slate-200 rounded-2xl font-bold hover:bg-slate-100 transition-all flex items-center justify-center gap-2">
              <span class="material-symbols-outlined text-xl">chat</span>
              MESSAGE ORGANIZER
            </button>
          </div>

          <!-- Participants List -->
          <div class="space-y-6">
            <div class="flex justify-between items-center">
              <h3 class="font-headline text-xl font-bold text-on-surface">Participants</h3>
              <span class="text-[10px] font-black text-primary bg-orange-50 px-3 py-1 rounded-full uppercase tracking-tighter">2 slots left</span>
            </div>
            <div class="flex flex-wrap gap-3">
              <img v-for="i in 8" :key="i" class="w-12 h-12 rounded-full border-2 border-white shadow-sm object-cover" :src="`https://i.pravatar.cc/150?u=${i}`" />
              <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-bold border-2 border-dashed border-slate-200">+2</div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Sticky Bottom Actions -->
    <div class="fixed bottom-0 left-0 w-full bg-white/80 backdrop-blur-xl border-t border-slate-100 px-6 py-6 z-40">
      <div class="max-w-4xl mx-auto flex gap-4">
        <button class="flex-grow h-16 bg-primary text-white font-headline font-black text-xl rounded-2xl shadow-xl shadow-orange-200 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3">
          JOIN MATCH
          <span class="material-symbols-outlined text-2xl">sports_basketball</span>
        </button>
        <button class="w-16 h-16 bg-slate-100 text-on-surface rounded-2xl hover:bg-slate-200 transition-all flex items-center justify-center">
          <span class="material-symbols-outlined">share</span>
        </button>
      </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import Navbar from '../components/Navbar.vue'

const router = useRouter()
</script>
