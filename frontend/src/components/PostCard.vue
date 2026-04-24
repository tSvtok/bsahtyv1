<template>
  <article class="card p-5 flex flex-col gap-4">
    <!-- Header -->
    <div class="flex items-start justify-between gap-3">
      <router-link :to="`/profile/${post.user?.id}`" class="flex items-center gap-3 group">
        <img :src="userAvatar" :alt="post.user?.name" class="w-10 h-10 rounded-full object-cover group-hover:ring-2 group-hover:ring-orange-400 transition-all" />
        <div>
          <p class="font-semibold text-sm group-hover:text-orange-500 transition-colors">{{ post.user?.name || 'Athlete' }}</p>
          <p class="text-xs text-gray-500">{{ formattedDate }}</p>
        </div>
      </router-link>
      <!-- Sport badge -->
      <span v-if="post.sport_category" class="badge badge-primary shrink-0">{{ post.sport_category }}</span>
    </div>

    <!-- Content -->
    <p class="text-gray-800 leading-relaxed text-sm">{{ post.body || post.content }}</p>

    <!-- Image -->
    <img
      v-if="post.image_url"
      :src="post.image_url"
      :alt="post.body"
      class="w-full rounded-2xl object-cover max-h-64 cursor-pointer hover:opacity-95 transition-opacity"
    />

    <!-- Divider -->
    <div class="divider !my-0" />

    <!-- Actions -->
    <div class="flex items-center gap-2">
      <!-- Like -->
      <button
        @click="handleLike"
        class="flex items-center gap-1.5 text-sm font-medium px-3 py-1.5 rounded-full transition-all"
        :class="liked ? 'bg-orange-50 text-orange-500' : 'text-gray-500 hover:bg-gray-50'"
      >
        <svg class="w-4.5 h-4.5" :fill="liked ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
        <span>{{ likeCount }}</span>
      </button>

      <!-- Dislike -->
      <button
        @click="handleDislike"
        class="flex items-center gap-1.5 text-sm font-medium px-3 py-1.5 rounded-full transition-all"
        :class="disliked ? 'bg-red-50 text-red-500' : 'text-gray-500 hover:bg-gray-50'"
      >
        <svg class="w-4.5 h-4.5" :fill="disliked ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7.263 10l3.76 9.401M10 14h4a2 2 0 002-2V9.401M10 14V3" />
        </svg>
        <span>{{ dislikeCount }}</span>
      </button>

      <!-- Comment -->
      <button
        @click="showComments = !showComments"
        class="flex items-center gap-1.5 text-sm font-medium px-3 py-1.5 rounded-full text-gray-500 hover:bg-gray-50 transition-all"
      >
        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <span>{{ post.comments_count || 0 }}</span>
      </button>

    </div>

    <!-- Comments -->
    <transition name="slide-down">
      <div v-if="showComments" class="flex flex-col gap-3 pt-2 border-t border-gray-100">
        <!-- Existing comments -->
        <div v-for="c in post.comments" :key="c.id" class="flex gap-2.5">
          <img :src="c.user?.avatar_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(c.user?.name || 'A')}&background=f97316&color=fff&size=40`" class="w-7 h-7 rounded-full object-cover shrink-0 mt-0.5" />
          <div class="bg-gray-50 rounded-xl px-3 py-2 flex-1">
            <p class="text-xs font-semibold text-gray-700">{{ c.user?.name }}</p>
            <p class="text-sm text-gray-600 mt-0.5">{{ c.content }}</p>
          </div>
        </div>

        <!-- Comment input -->
        <div class="flex gap-2.5 items-center">
          <img :src="myAvatar" class="w-7 h-7 rounded-full object-cover shrink-0" />
          <form @submit.prevent="submitComment" class="flex-1 flex gap-2">
            <input
              v-model="commentText"
              type="text"
              placeholder="Write a comment..."
              class="flex-1 px-3 py-1.5 text-sm bg-gray-100 rounded-full border-none outline-none focus:bg-white focus:ring-2 focus:ring-orange-400/30 transition-all"
            />
            <button type="submit" class="w-7 h-7 rounded-full bg-orange-500 flex items-center justify-center text-white hover:bg-orange-600 transition-colors shrink-0">
              <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
              </svg>
            </button>
          </form>
        </div>
      </div>
    </transition>
  </article>
</template>

<script setup>
import { ref, computed } from 'vue'
import { feedApi } from '@/services/api'
import { useAuthStore } from '@/stores/auth'

const props = defineProps({ post: { type: Object, required: true } })

const auth = useAuthStore()
const liked = ref(props.post.liked_by_me || false)
const disliked = ref(props.post.disliked_by_me || false)
const likeCount = ref(props.post.reactions_count || 0)
const dislikeCount = ref(props.post.dislikes_count || 0)
const showComments = ref(false)
const commentText = ref('')

const userAvatar = computed(() =>
  props.post.user?.avatar_url ||
  `https://ui-avatars.com/api/?name=${encodeURIComponent(props.post.user?.name || 'A')}&background=f97316&color=fff&size=60`
)

const myAvatar = computed(() =>
  auth.user?.avatar_url ||
  `https://ui-avatars.com/api/?name=${encodeURIComponent(auth.user?.name || 'A')}&background=f97316&color=fff&size=40`
)

const formattedDate = computed(() => {
  if (!props.post.created_at) return ''
  const d = new Date(props.post.created_at)
  const diff = (Date.now() - d) / 1000
  if (diff < 60)     return 'just now'
  if (diff < 3600)   return `${Math.floor(diff / 60)}m ago`
  if (diff < 86400)  return `${Math.floor(diff / 3600)}h ago`
  return d.toLocaleDateString()
})

async function handleLike() {
  if (disliked.value) {
    disliked.value = false
    dislikeCount.value--
  }
  liked.value = !liked.value
  likeCount.value += liked.value ? 1 : -1
  try { await feedApi.react({ question_id: props.post.id, type: 'LIKE' }) } catch {}
}

async function handleDislike() {
  if (liked.value) {
    liked.value = false
    likeCount.value--
  }
  disliked.value = !disliked.value
  dislikeCount.value += disliked.value ? 1 : -1
  try { await feedApi.react({ question_id: props.post.id, type: 'DISLIKE' }) } catch {}
}

async function submitComment() {
  if (!commentText.value.trim()) return
  try {
    const res = await feedApi.comment({ question_id: props.post.id, content: commentText.value })
    if (!props.post.comments) props.post.comments = []
    props.post.comments.push(res.data.data)
    if (props.post.comments_count !== undefined) props.post.comments_count++
    commentText.value = ''
  } catch {}
}
</script>

<style scoped>
.slide-down-enter-active, .slide-down-leave-active { transition: all 0.3s ease; }
.slide-down-enter-from, .slide-down-leave-to { opacity: 0; transform: translateY(-8px); }
</style>
