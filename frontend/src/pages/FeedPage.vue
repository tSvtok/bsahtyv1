<template>
  <div class="bg-background min-h-screen">
    <Navbar />
    
    <div class="flex pt-16 max-w-screen-2xl mx-auto">
      <AppSidebar />

    <!-- Main Content Area -->
    <main class="flex-1 lg:ml-64 px-4 md:px-8 py-8 lg:pb-8 pb-24">
      <div class="max-w-3xl mx-auto">
        <!-- Create Post Trigger -->
        <section class="bg-white rounded-xl p-4 shadow-sm border border-[#E2E8F0] mb-8 group cursor-pointer hover:border-primary/50 transition-all" @click="showCreateModal = true">
          <div class="flex gap-4 items-center">
            <img alt="User" class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm" :src="userStore.currentUser?.avatar || 'https://lh3.googleusercontent.com/a/default-user'"/>
            <div class="flex-1 bg-slate-50 rounded-full px-5 py-3 text-slate-400 text-sm font-medium">
              What's on your mind, {{ userStore.currentUser?.name?.split(' ')[0] }}?
            </div>
            <button class="bg-primary text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg shadow-orange-200 group-hover:scale-110 transition-transform">
              <span class="material-symbols-outlined">add</span>
            </button>
          </div>
        </section>

        <CreatePostModal :show="showCreateModal" @close="showCreateModal = false" @created="handlePostCreated" />

        <!-- Error Message -->
        <div v-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 flex items-center gap-2">
          <span class="material-symbols-outlined">error</span>
          {{ error }}
        </div>

        <!-- Filters for Mobile -->
        <section class="lg:hidden flex gap-3 overflow-x-auto pb-4 mb-4 scrollbar-hide">
          <button class="flex-shrink-0 px-4 py-2 rounded-full bg-[#FF5C00] text-white font-bold text-xs">All Sports</button>
          <button v-for="sport in sports" :key="sport.name" class="flex-shrink-0 px-4 py-2 rounded-full bg-white border border-slate-200 text-slate-600 font-bold text-xs flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">{{ sport.icon }}</span> {{ sport.name }}
          </button>
        </section>

        <!-- Feed Content -->
        <div class="space-y-6">
          <template v-if="loading">
            <PostSkeleton v-for="i in 3" :key="i" />
          </template>
          <template v-else>
            <PostCard 
              v-for="post in posts" 
              :key="post.id" 
              :post="post"
              @like="handleLike"
              @comment="handleComment"
              @join="handleJoin"
            />
          </template>
        </div>
      </div>
    </main>

    <!-- Right Side Stats/Trending -->
    <aside class="hidden xl:block w-80 p-8 sticky top-16 h-[calc(100vh-64px)] overflow-y-auto">
      <TrendingWidget :trends="trends" />
      <div class="bg-primary-container text-white rounded-xl p-5 shadow-lg shadow-orange-100 relative overflow-hidden">
        <div class="relative z-10">
          <h3 class="font-display font-bold text-lg mb-2">Upgrade to Pro</h3>
          <p class="text-sm opacity-90 mb-4">Get personalized training plans and connect with elite coaches.</p>
          <button class="bg-white text-[#FF5C00] px-4 py-2 rounded-lg font-bold text-xs uppercase tracking-wider">Start Trial</button>
        </div>
        <span class="material-symbols-outlined absolute -bottom-6 -right-6 text-white/10 text-9xl">workspace_premium</span>
      </div>
    </aside>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Navbar from '../components/Navbar.vue'
import AppSidebar from '../components/AppSidebar.vue'
import PostCard from '../components/PostCard.vue'
import TrendingWidget from '../components/TrendingWidget.vue'
import CreatePostModal from '../components/CreatePostModal.vue'
import PostSkeleton from '../components/PostSkeleton.vue'
import { useUserStore } from '../stores/user'
import { onMounted } from 'vue'
import { PostService } from '../services/PostService'

const userStore = useUserStore()
const showCreateModal = ref(false)
const loading = ref(true)
const error = ref('')

const posts = ref([
  {
    id: 1,
    author: 'Sarah Miller',
    avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAaClPuE9BaF-LhvS9bSSzzfkq4Fylk8oqxcggK5CPpFQIzmsZkOFDzWaNKxdlv0WeFTvsl-FtA6GBjWRmN9aCGUXcR3A0IymVOu1EEtv4PGN5OLfPVBJHSpB4Rby9nIqgeO1smdMA5Aa4rkdI4MkHC3jOruWRGiEN1c32HXR_ALmlVx82BCCHPTz6BtRURA8HjdOTL8F8P3To4NNrTmXmLQMG4epw3VdsPm8AU8BiM2lYmZwjGlCcaKLItNfCWCF-ELEdCu9AB5eLw',
    online: true,
    time: '2 hours ago',
    category: 'Running',
    content: "Does anyone have recommendations for high-altitude training masks? I'm preparing for the Colorado marathon and want to start integrating more resistance into my cardio sessions.",
    image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuC1V8Ic2sE2JEzFt6WhXGvmZVzxxIb-kuwnaNRlsmXOUmk96XKONENvOWnXG4GrY9M_HPmQfRtEef5eKYhxCE-HKwEGXPFopn8JiElZS9suIDBZsCypliqetgE2tFPGUjblD9D1vRmQM8kOTwN_YCVJZmc78kADp6vZ_eB9_fuQtNlS_GyvY8SDUKGKfS2DJKSNXB8oAWgPayVCRXkESWbJ-mDfrt14KoHQPDcwJHch8HiONsEyEiK-NKmIXzZKxoaMX1sP68sHiOmP',
    likes: 24,
    comments: 12,
    joinable: false
  },
  {
    id: 2,
    author: 'Marcus Chen',
    avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDZIsRfrmNon0smjxJjLu4P5c3Zw2XEZtLpSlxJy52orgQiNyFrMujkbKyxF6QJpvkZYFaSAnzsQ7w2wrA9G8rJNFbyUXQCm8wR1zWd5hKEi4PzpQV2KgG3nw1ei6Rt_hFGS0NKivQ7iU44OlTRqqM7bTru2Mz3F3TXkJNuzo8KV5uISNsviHVWr7hlNoiu3eGO6fIQG1PNt8ZS6QvjC9ZExmsGYO0F5JO_tb1RCGI_zZhcFKcZCjmVpjT3XFl757IxfyvcPZr6ttae',
    online: false,
    time: '5 hours ago',
    category: 'Basketball',
    content: "Hosting a 3v3 scrimmage this Saturday at the downtown courts. Looking for two more players to round out the bracket. Intermediate level. Who's in? 🏀",
    likes: 45,
    comments: 38,
    joinable: true
  }
])

const sports = [
  { name: 'Basketball', icon: 'sports_basketball' },
  { name: 'Soccer', icon: 'sports_soccer' },
  { name: 'Running', icon: 'directions_run' },
]

const handlePostCreated = (newPost) => {
  posts.value.unshift(newPost)
}

onMounted(async () => {
  loading.value = true
  error.value = ''
  try {
    const response = await PostService.getAll()
    if (response.data && response.data.length > 0) {
      posts.value = response.data.map(q => ({
        id: q.id,
        author: q.user?.name || 'Anonymous',
        avatar: q.user?.avatar || 'https://lh3.googleusercontent.com/a/default-user',
        time: q.created_at ? new Date(q.created_at).toLocaleDateString() : 'Just now',
        content: q.content,
        image: q.image,
        likes: q.reactions_count || 0,
        comments: q.comments_count || 0,
        category: q.sport_category || 'General',
        joinable: q.event_id ? true : false
      }))
    }
  } catch (err) {
    console.error('Failed to fetch posts:', err)
    error.value = 'Failed to load posts. Showing local feed.'
    // Keep mock data as fallback
  } finally {
    loading.value = false
  }
})

const trends = [
  { name: 'Soccer', icon: 'sports_soccer', count: '2.4k posts', bg: 'bg-blue-50 text-blue-600' },
  { name: 'Basketball', icon: 'sports_basketball', count: '1.8k posts', bg: 'bg-orange-50 text-[#FF5C00]' },
  { name: 'Running', icon: 'directions_run', count: '1.2k posts', bg: 'bg-green-50 text-green-600' },
]

const handleLike = async (id) => {
  const post = posts.value.find(p => p.id === id)
  if (post) {
    try {
      await PostService.like(id)
      post.likes++
    } catch (error) {
      console.error('Failed to like post:', error)
    }
  }
}

const handleComment = (id) => {
  console.log('Comment on post:', id)
  // TODO: Open comment modal
}

const handleJoin = (id) => {
  console.log('Join game from post:', id)
  // TODO: Handle joining event
}
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
