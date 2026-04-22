<template>
  <div class="bg-background min-h-screen">
    <Navbar />
    
    <div class="flex pt-16 max-w-screen-2xl mx-auto">
      <AppSidebar />

    <!-- Main Content -->
    <main class="flex-1 lg:ml-64 pb-24 md:pb-8">
      <div class="max-w-6xl mx-auto">
        <!-- Profile Header -->
        <div class="relative bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
          <!-- Cover Photo -->
          <div class="h-64 md:h-80 w-full relative overflow-hidden">
            <img alt="Cover photo" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBJz6S0BZF0KOuy-x5RegZuRm7tO1ZGO5YEnWHry0jPtsZZaZ3cZ3Iegr0W_i36PnCcJdNDt8gYrsPZVSaarXdIYOxA5wrAe2jWc2dhZmato10BlZ3gHEYFtRn2ynr0Lk5nHoV66vAFk85HXSZQ1RRNcIbMeQbBRyXI88NA9arEyKXyAA2-Bap9lh2IpRqfZkOLL-R2weEMsYxCavaSSEY1RHNbqiTLfYNmMNUksuRygsKdM2JtDn608kwZFHE7fb0ZGMmiO4xCyk3Y"/>
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
          </div>
          <!-- Profile Info Area -->
          <div class="px-6 pb-6 relative">
            <div class="flex flex-col md:flex-row md:items-end -mt-20 md:-mt-24 gap-6">
              <!-- Avatar -->
              <div class="relative inline-block">
                <div class="h-32 w-32 md:h-40 md:w-40 rounded-full border-4 border-white dark:border-slate-900 overflow-hidden shadow-xl bg-surface">
                  <img alt="Profile avatar" :src="userStore.currentUser?.avatar || 'https://lh3.googleusercontent.com/a/default-user'"/>
                </div>
                <div class="absolute bottom-2 right-2 h-6 w-6 bg-green-500 border-4 border-white dark:border-slate-900 rounded-full" title="Online Now"></div>
              </div>
              <!-- User Details -->
              <div class="flex-1 space-y-1 mb-2">
                <div class="flex items-center gap-3">
                  <h1 class="text-4xl font-bold text-on-surface">{{ userStore.currentUser?.name }}</h1>
                  <span class="bg-primary-container/10 text-primary-container px-3 py-1 rounded-full text-xs font-bold uppercase">{{ userStore.currentUser?.level || 'Intermediate' }} LEVEL</span>
                </div>
                <div class="flex flex-wrap items-center gap-4 text-slate-500 text-sm">
                  <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">location_on</span> {{ userStore.currentUser?.location || 'Local Athlete' }}</span>
                  <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">calendar_today</span> Joined {{ userStore.currentUser?.joined || 'April 2026' }}</span>
                  <span class="flex items-center gap-1 font-bold text-on-surface">{{ userStore.currentUser?.followers || 0 }} <span class="font-normal text-slate-500">Followers</span></span>
                </div>
              </div>
              <div class="flex gap-3 mb-2">
                <button 
                  @click="showEditModal = true"
                  class="flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-full font-bold hover:opacity-90 active:scale-95 transition-all shadow-lg shadow-orange-200"
                >
                  <span class="material-symbols-outlined text-[20px]">edit</span> Edit Profile
                </button>
                <button class="flex items-center gap-2 px-6 py-3 border-2 border-slate-200 text-slate-600 rounded-full font-bold hover:bg-slate-50 active:scale-95 transition-all">
                  <span class="material-symbols-outlined text-[20px]">share</span> Share
                </button>
              </div>
              
              <EditProfileModal :show="showEditModal" @close="showEditModal = false" />
            </div>
          </div>
        </div>
        <!-- Grid Layout for Feed & Sidebar -->
        <div class="p-6 md:p-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
          <!-- Sidebar -->
          <div class="lg:col-span-4 order-2 lg:order-2 space-y-6">
            <!-- Favorite Sports -->
            <section class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
              <h3 class="font-headline text-lg font-bold mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary-container">star</span> Favorite Sports
              </h3>
              <div class="flex flex-wrap gap-2">
                <span v-for="sport in favoriteSports" :key="sport.name" :class="sport.color" class="px-4 py-2 rounded-full text-xs font-bold border">
                  #{{ sport.name }}
                </span>
              </div>
            </section>
            <!-- Mutual Friends -->
            <section class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm">
              <div class="flex justify-between items-center mb-4">
                <h3 class="font-headline text-lg font-bold">Mutual Friends</h3>
                <a class="text-primary-container font-bold text-sm" href="#">See all</a>
              </div>
              <div class="grid grid-cols-4 gap-4">
                <div v-for="friend in friends" :key="friend.name" class="text-center group cursor-pointer">
                  <div class="w-full aspect-square rounded-xl overflow-hidden mb-1 ring-2 ring-transparent group-hover:ring-primary-container transition-all">
                    <img :alt="friend.name" class="w-full h-full object-cover" :src="friend.avatar"/>
                  </div>
                  <span class="text-[10px] font-bold block truncate">{{ friend.name }}</span>
                </div>
              </div>
            </section>
          </div>
          <!-- Activity Feed -->
          <div class="lg:col-span-8 order-1 lg:order-1 space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-4">
              <h2 class="font-headline text-2xl font-bold">Recent Activity</h2>
              <div class="flex gap-2">
                <button v-for="tab in tabs" :key="tab" :class="[tab === 'All' ? 'bg-slate-100 text-on-surface' : 'text-slate-500 hover:bg-slate-50']" class="px-4 py-1.5 rounded-full text-xs font-bold transition-colors">
                  {{ tab }}
                </button>
              </div>
            </div>
            <!-- Activity Cards -->
            <div v-for="activity in activities" :key="activity.id" :class="activity.type === 'post' ? 'bg-white rounded-xl overflow-hidden border border-slate-200 shadow-sm' : 'bg-white rounded-xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-all'">
              <div v-if="activity.type === 'question'" class="space-y-4">
                <div class="flex items-center gap-3 mb-4">
                  <div class="p-2 bg-orange-50 rounded-lg text-primary-container">
                    <span class="material-symbols-outlined">{{ activity.icon }}</span>
                  </div>
                  <div>
                    <p class="font-bold text-on-surface text-sm">{{ activity.action }}</p>
                    <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">{{ activity.time }}</p>
                  </div>
                </div>
                <h4 class="font-headline text-xl font-bold mb-2 leading-tight">{{ activity.title }}</h4>
                <p class="text-sm text-slate-600 mb-4">{{ activity.content }}</p>
                <div class="flex items-center gap-6 border-t border-slate-50 pt-4">
                  <button class="flex items-center gap-2 text-slate-500 hover:text-primary-container transition-colors">
                    <span class="material-symbols-outlined text-[20px]">thumb_up</span> <span class="text-xs font-bold">{{ activity.likes }}</span>
                  </button>
                  <button class="flex items-center gap-2 text-slate-500 hover:text-primary-container transition-colors">
                    <span class="material-symbols-outlined text-[20px]">chat_bubble</span> <span class="text-xs font-bold">{{ activity.comments }}</span>
                  </button>
                </div>
              </div>
              <div v-else-if="activity.type === 'event'" class="space-y-4">
                <div class="flex items-center gap-3 mb-4">
                  <div class="p-2 bg-blue-50 rounded-lg text-tertiary">
                    <span class="material-symbols-outlined">{{ activity.icon }}</span>
                  </div>
                  <div>
                    <p class="font-bold text-on-surface text-sm">{{ activity.action }}</p>
                    <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">{{ activity.time }}</p>
                  </div>
                </div>
                <div class="flex flex-col md:flex-row gap-4 bg-slate-50 p-4 rounded-xl">
                  <div class="w-full md:w-32 h-24 rounded-lg overflow-hidden shrink-0">
                    <img :alt="activity.eventTitle" class="w-full h-full object-cover" :src="activity.eventImage"/>
                  </div>
                  <div class="flex-1">
                    <h5 class="font-bold text-lg text-on-surface">{{ activity.eventTitle }}</h5>
                    <div class="flex flex-col gap-1 mt-1 text-xs text-slate-500">
                      <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">schedule</span> {{ activity.eventTime }}</span>
                      <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">location_on</span> {{ activity.eventLocation }}</span>
                    </div>
                  </div>
                  <div class="self-center">
                    <button class="px-4 py-2 border border-primary-container text-primary-container rounded-full text-xs font-bold hover:bg-orange-50">View Event</button>
                  </div>
                </div>
              </div>
              <div v-else-if="activity.type === 'post'">
                <div class="p-6 pb-0">
                  <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-green-50 rounded-lg text-green-600">
                      <span class="material-symbols-outlined">{{ activity.icon }}</span>
                    </div>
                    <div>
                      <p class="font-bold text-on-surface text-sm">{{ activity.action }}</p>
                      <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">{{ activity.time }}</p>
                    </div>
                  </div>
                  <p class="text-sm mb-4 text-on-surface">{{ activity.content }}</p>
                </div>
                <div class="h-80 w-full overflow-hidden">
                  <img :alt="activity.content" class="w-full h-full object-cover" :src="activity.image"/>
                </div>
                <div class="p-4 flex items-center gap-6">
                  <button class="flex items-center gap-2 text-primary-container">
                    <span class="material-symbols-outlined text-[20px]">favorite</span> <span class="text-xs font-bold">{{ activity.likes }}</span>
                  </button>
                  <button class="flex items-center gap-2 text-slate-500">
                    <span class="material-symbols-outlined text-[20px]">share</span> <span class="text-xs font-bold">Share</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Navbar from '../components/Navbar.vue'
import AppSidebar from '../components/AppSidebar.vue'
import EditProfileModal from '../components/EditProfileModal.vue'
import { useUserStore } from '../stores/user'

const userStore = useUserStore()
const showEditModal = ref(false)
const favoriteSports = ref(userStore.currentUser.favoriteSports)

const friends = [
  { name: 'Marcus', avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBhUiDa2Flc9X0eMgHndkEB3kDtguhV168NKnGuMmfNqcGAvviLlASNbWiTLYeULnELqNO0iGN8nN3lw1KfzT8wKBd5vjTFO5Zi0Rlfyu5aFDpFHHeLFNy2Tp0PZdA7m2lxw0-Zv8GhyDt3rmid-KdRoWRR4ke1-gqJYrazsZKFIywvnTQVC6oAP6yNTokW24c_Th1UFDv5j0H4UlT2vVEJEhXQ4a1KNWxAujP4ABGxeONbwbMUd5jMOIhJ5LYq1qjTVN65ndVFCXmL' },
  { name: 'Sarah', avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuC1KCikV2ghOAb1NCqwBnqQ9ytg3KtY964wXuACHmcmsa3_BJ4qxKNWJ2TimQW1RnsndDLdahhiLRT8TZBpxGgrK6KjeSfpFZYVFjihReYJqW8rjT4zK94atK2jmj55shdDcIe8RAEVfIZ2grF9fj_kBzCPnL3VgWtEapEfnRNUcue7-KtAIxSgF00QK4wwX5SUpUIG134OzcO0hVHvnMlayofaX4yrwsS5n_57jmCfD5wbqJ5GcKhhSvuN6psxZciIX5WyG9Meuhx5' },
  { name: 'David', avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuC9RNeU2MGq6U-YjgCUio3Zuk79a5wZWX_k72BY-fteuPqfJUyf9DVsodhAoxP9kmy2xHKmcrEy7WqDpjiXIgCy-FUGxZO18BpE53VVxYeyUXcQB1TePQ8cFmSxb_eLqCruHRBvRVUYMY7FOf21ItnXrIFPVSf0MQHboQilpyg-ooWEiZGbEHJIWJpvCWKaMYirt3CvBlVd9YeeJa0ftpyOwAG_LV_Ca6Mv9VYHfQbSLbIOvwjIawSEYyNNvHxg0dQ0d4sisc7AxZJM' },
  { name: 'Elena', avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCreUynhlHQyHzh7nO1v6HG25dNX5J0vPmlGCib5zJZSCOR_Qzkxh-Ufj6yOk8ActIKtPoGCzt_9tSBUB7O-mR5BOZ70IFsIVPTECV7DNEpWPD7qsuV92P2FYQJkEglVQLuHaEc3sxiUvnarNsLnnXm8X1v3AkNSAQfm4OsuFbFdNboH-PAidi8kGxyRBsYSr9X3EpMO11CPoz5AfpqgG4PvYwYj9BFYlvR8S8fM0QTMt8fym3KkG3Q_FmrsLVKXDUR_1Wld7xww5ba' },
]

const tabs = ['All', 'Events', 'Posts']

const activities = [
  {
    id: 1,
    type: 'question',
    icon: 'help_center',
    action: 'Asked a question',
    time: '2 hours ago',
    title: 'Best spots for outdoor tennis in Santa Monica with night lighting?',
    content: "Looking for something that isn't too crowded on Tuesday nights. Willing to drive up to 15 mins. Any recommendations for courts with good surface grip?",
    likes: 12,
    comments: 5
  },
  {
    id: 2,
    type: 'event',
    icon: 'event_available',
    action: 'Joined an event',
    time: 'Yesterday at 4:15 PM',
    eventTitle: 'Downtown 3x3 Streetball Challenge',
    eventTime: 'Saturday, 10:00 AM',
    eventLocation: 'Staples Center Community Courts',
    eventImage: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDO4sruZQKwebpLOtvPoK-upqygg3f97g1A4cnqqQSI-fNo3WxZ9XpT4H0nAmhnA7zu2yuxxzPGfRvI7CA0wq5YcAiDjKfMMZXhMoL2W8t4nbxfYyW70gZiAdCzer-Qtcopvcy3iO1gfZ5xwckQGQ_Hka-ewYD3KKMVA2wt-I451WYh7RyPdeVjwA2veXoZfCGFasgudsK7cEiahP49cwe-9T7Q8KdS7MKej47ZpnjGSZomwMLgBMhxbX6NFr3R2vq3rjMz5dwK2-Zp'
  },
  {
    id: 3,
    type: 'post',
    icon: 'photo_library',
    action: 'Shared a post',
    time: '3 days ago',
    content: 'Morning grind at the beach. Nothing beats the sea breeze for a 10k run! 🏃‍♂️💨',
    image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCvW6kQyvBu47dYXWwW310--PYwvBh55RY8T8917whM0QDtdm0ScUw8pKiMy8NV14Y_AH30TkfKUZyUofNzbYYZ91Ve4YtWkE2LnfLIsmGG6XN_8QV6xWMJl6K1nfRRltoKCt9qsK0ix7RSLP-nyQcn4VndyWXJzfgl0mfyUc6Mq4uuv9MVBuu5VVvNG3a-tIHWd942c0rZhknFSU7pjf2xCyY906g637F-0nwS_A6kQlvJs1lSH5-Qi_O2gkbZt2BDg-pY-rUw_-2m',
    likes: 48
  }
]
</script>
