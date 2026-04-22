<template>
  <div class="landing-page">
    <Navbar />
    <main class="pt-24 pb-32">
      <!-- Hero Section -->
      <section class="relative px-6 max-w-7xl mx-auto mb-16">
        <div class="flex flex-col lg:flex-row items-center gap-10 py-16">
          <div class="lg:w-1/2 space-y-6">
            <div class="inline-flex items-center bg-orange-50 border border-orange-100 px-4 py-1 rounded-full mb-2">
              <span class="text-primary font-bold text-xs uppercase tracking-wider">Live Action in Your City</span>
            </div>
            <h1 class="font-display text-5xl font-bold text-on-surface leading-tight">Connect Athletes In Real Life</h1>
            <p class="font-body text-lg text-on-surface-variant max-w-lg">Find spots, join events, and build your local sports community with the world's most active athletic network.</p>
            <div class="flex flex-col sm:flex-row gap-4">
              <router-link to="/register" class="btn-primary text-xl px-10 py-5 flex items-center justify-center">Get Started</router-link>
              <router-link to="/map" class="btn-secondary text-xl px-10 py-5 border-slate-900 text-slate-900 flex items-center justify-center">Explore Map</router-link>
            </div>
          </div>
          <div class="lg:w-1/2 relative group">
            <div class="absolute -inset-4 bg-primary/20 rounded-[40px] blur-2xl group-hover:bg-primary/30 transition-all duration-700"></div>
            <img class="relative w-full h-[500px] object-cover rounded-[40px] shadow-2xl border-4 border-white transform hover:scale-[1.02] transition-all duration-700" src="/images/hero.png" alt="B-SSAHTY Experience"/>
            <div class="absolute -bottom-6 -right-6 bg-white p-6 rounded-[32px] shadow-2xl border border-slate-50">
              <div class="flex items-center gap-4">
                <div class="flex -space-x-4">
                  <img v-for="i in 3" :key="i" :src="`https://i.pravatar.cc/100?u=${i}`" class="w-12 h-12 rounded-full border-4 border-white shadow-sm"/>
                </div>
                <div>
                  <p class="text-[10px] font-black text-primary uppercase tracking-widest">Active Now</p>
                  <p class="font-bold text-on-surface">1,240+ Playing</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Bento Features Grid -->
      <section class="px-6 max-w-7xl mx-auto">
        <div class="text-center mb-16">
          <h2 class="font-headline text-4xl font-bold text-on-surface mb-2">Designed for High Performance</h2>
          <p class="font-body text-on-surface-variant">Everything you need to get off the screen and into the game.</p>
        </div>
        <div class="bento-grid">
          <!-- Feed Feature -->
          <div class="col-span-12 md:col-span-8 bg-white border border-outline-variant rounded-3xl p-6 overflow-hidden flex flex-col justify-between group">
            <div class="max-w-md">
              <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary bg-orange-100 p-2 rounded-xl">dynamic_feed</span>
                <h3 class="font-headline text-2xl font-bold">Social Feed</h3>
              </div>
              <p class="font-body text-on-surface-variant mb-6">Share your latest match highlights, gear reviews, and local athlete stories. Stay connected with your teammates and follow your favorite local pros.</p>
            </div>
            <div class="mt-auto translate-y-8 group-hover:translate-y-4 transition-transform duration-500">
              <img alt="community feed" class="rounded-t-2xl shadow-xl" src="https://lh3.googleusercontent.com/aida-public/AB6AXuATmIM7Kyy0rv2oQf_aHUHSRU0rIZgH4O1h18wk0izQUKLfn5x4bGsDwPoe8chLHUeiFiIgE8TT-1VRfIQ4kN0-CcAsQwfIo9_00tNtgaf4PRQhxyM8_nIbNAkFRwLNzDnUOr091rdVx9mdO9_iVwYmKmx3OVWwQPG8bkriCvQJk1Hlg6rc4iTcIq30J8zRmppRQb7UsYX_fjeYT4UiPHeRqg0XKQ6vb_dUxa2Z8LRAIB8iXJeBCWDcZ2JkkKXCtmC_5fArMqgF5rXp"/>
            </div>
          </div>
          <!-- Map Feature -->
          <div class="col-span-12 md:col-span-4 bg-inverse-surface text-white rounded-3xl p-6 relative overflow-hidden flex flex-col group">
            <div class="relative z-10">
              <span class="material-symbols-outlined text-white bg-primary-container p-2 rounded-xl mb-4">map</span>
              <h3 class="font-headline text-2xl font-bold mb-2">Interactive Map</h3>
              <p class="font-body text-white/70">Pinpoint active games and bookable courts in your neighborhood instantly.</p>
            </div>
            <div class="mt-16 flex-grow bg-slate-800 rounded-2xl overflow-hidden relative grayscale hover:grayscale-0 transition-all duration-700">
              <div class="absolute inset-0 bg-gradient-to-t from-inverse-surface via-transparent to-transparent z-10"></div>
              <img alt="map view" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC5G1OWGNmAwyRRszRN5fTEAfESQpI7il6ZLkggaIlmG9e7-6-Xsel-iip-ijqh9qlv8yh7soSc7GscBjJj5T6Kauazh1IOyhYkZZT8umpfaiUfA6XYs2OgeEuisxJTA7ouUs-f4alVcC-LssuGn-pfNoxtdWDoPN5viRLh28FF575BTP0-fJCILtR2fp37MZa5QmIFhVIKFwGSaIrY345oFUphq95ZeGFscQY9ezfMNVEFb8Ie_6WSkV3rUm_4ismKFPuAxmW5mukV"/>
            </div>
          </div>
          <!-- Events Feature -->
          <div class="col-span-12 md:col-span-4 bg-white border border-outline-variant rounded-3xl p-6 flex flex-col gap-6">
            <div>
              <span class="material-symbols-outlined text-tertiary bg-blue-50 p-2 rounded-xl mb-4">event</span>
              <h3 class="font-headline text-2xl font-bold">Live Events</h3>
              <p class="font-body text-on-surface-variant">From casual weekend kickabouts to semi-pro tournaments. Join what moves you.</p>
            </div>
            <div class="space-y-4">
              <div class="flex items-center gap-4 bg-surface p-4 rounded-xl border border-outline-variant">
                <div class="w-12 h-12 bg-primary-container rounded-lg flex flex-col items-center justify-center text-white">
                  <span class="text-[10px] font-bold">OCT</span>
                  <span class="text-lg font-black leading-none">24</span>
                </div>
                <div>
                  <p class="font-bold text-on-surface">3v3 Basketball Open</p>
                  <p class="text-xs text-on-surface-variant">Central Park Courts</p>
                </div>
              </div>
              <div class="flex items-center gap-4 bg-surface p-4 rounded-xl border border-outline-variant opacity-60">
                <div class="w-12 h-12 bg-slate-400 rounded-lg flex flex-col items-center justify-center text-white">
                  <span class="text-[10px] font-bold">OCT</span>
                  <span class="text-lg font-black leading-none">26</span>
                </div>
                <div>
                  <p class="font-bold text-on-surface">Morning Trail Run</p>
                  <p class="text-xs text-on-surface-variant">Skyline Loop</p>
                </div>
              </div>
            </div>
          </div>
          <!-- Athlete Profile Feature -->
          <div class="col-span-12 md:col-span-8 bg-surface border border-outline-variant rounded-3xl p-6 flex flex-col md:flex-row gap-8 items-center overflow-hidden">
            <div class="md:w-1/2">
              <h3 class="font-headline text-2xl font-bold mb-4">Pro Athlete Status</h3>
              <p class="font-body text-on-surface-variant mb-6">Track your stats, build your reputation, and earn badges based on your performance in local matches. Become the MVP of your neighborhood.</p>
              <button class="bg-inverse-surface text-white font-bold px-6 py-3 rounded-full hover:scale-105 transition-transform">View Demo Profile</button>
            </div>
            <div class="md:w-1/2 flex justify-center">
              <div class="relative">
                <img alt="Athlete profile" class="w-48 h-48 rounded-full border-8 border-white shadow-2xl object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCaD25u3L7bSThyizFd297Qo1ab5KXtqvudrrVAvsC2-SATo1ltzgXzFpNkQ9MdFBkTBhW_gl3gR09rWQ2Nyru7W2hRjv4M3iWsRp5yn_GA7m4ZU3wVzD6pC34tbjWmN6rdb1DZh83d8jfZ6LU-yQSExqsy3FdFFOsRCq7xrE37yzTxsuvjjNAlOjhNSMELaSo3z7GPfkgFfq9QPyUAqLiZrl1XfdWsgvw0y68ORN8UHRPz0_8TUO8I3gVbabe7X9kuXj_e5vg3Jwli"/>
                <div class="absolute -bottom-4 -right-4 bg-[#FF5C00] text-white p-4 rounded-2xl shadow-lg flex flex-col items-center">
                  <span class="material-symbols-outlined">sports_basketball</span>
                  <span class="text-xl font-black">Level 12</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Sports Category Ticker -->
      <section class="mt-16 overflow-hidden py-6">
        <div class="flex gap-6 whitespace-nowrap animate-marquee">
          <div v-for="sport in sports" :key="sport.name" class="inline-flex items-center gap-2 bg-orange-50 text-primary-container px-6 py-3 rounded-full font-bold text-lg border border-primary/20 shadow-sm">
            <span class="material-symbols-outlined">{{ sport.icon }}</span> {{ sport.name }}
          </div>
          <!-- Duplicate for seamless scroll -->
          <div v-for="sport in sports" :key="sport.name + '-dup'" class="inline-flex items-center gap-2 bg-orange-50 text-primary-container px-6 py-3 rounded-full font-bold text-lg border border-primary/20 shadow-sm">
            <span class="material-symbols-outlined">{{ sport.icon }}</span> {{ sport.name }}
          </div>
        </div>
      </section>
    </main>
    <Footer />
  </div>
</template>

<script setup>
import Navbar from '../components/Navbar.vue'
import Footer from '../components/Footer.vue'

const sports = [
  { name: 'Basketball', icon: 'sports_basketball' },
  { name: 'Tennis', icon: 'sports_tennis' },
  { name: 'Soccer', icon: 'sports_soccer' },
  { name: 'Running', icon: 'directions_run' },
  { name: 'Cycling', icon: 'directions_bike' },
  { name: 'Gym', icon: 'fitness_center' },
  { name: 'Surfing', icon: 'surfing' },
]
</script>

<style scoped>
.animate-marquee {
  display: flex;
  width: max-content;
}
</style>
