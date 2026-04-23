import { defineStore } from 'pinia'
import { ref } from 'vue'
import { feedApi, eventsApi, spotsApi } from '@/services/api'

export const useAppStore = defineStore('app', () => {
  // Feed
  const posts   = ref([])
  const feedLoading = ref(false)

  async function fetchFeed(params = {}) {
    feedLoading.value = true
    try {
      const res = await feedApi.list(params)
      // Standardize for paginated responses (data.data)
      posts.value = res.data.data?.data || res.data.data || []
    } catch { posts.value = [] }
    finally  { feedLoading.value = false }
  }

  async function createPost(data) {
    const res = await feedApi.create(data)
    posts.value.unshift(res.data.data)
  }

  async function reactToPost(postId) {
    await feedApi.react({ question_id: postId })
  }

  // Events
  const events = ref([])
  const eventsLoading = ref(false)

  async function fetchEvents(params = {}) {
    eventsLoading.value = true
    try {
      const res = await eventsApi.list(params)
      // Standardize for paginated responses (data.data)
      events.value = res.data.data?.data || res.data.data || []
    } catch { events.value = [] }
    finally  { eventsLoading.value = false }
  }

  async function createEvent(data) {
    const res = await eventsApi.create(data)
    events.value.unshift(res.data)
  }

  // Spots
  const spots = ref([])
  const spotsLoading = ref(false)

  async function fetchSpots() {
    spotsLoading.value = true
    try {
      const res = await spotsApi.list()
      spots.value = res.data
    } catch { spots.value = [] }
    finally  { spotsLoading.value = false }
  }

  async function fetchNearby(lat, lng) {
    spotsLoading.value = true
    try {
      const res = await spotsApi.nearby(lat, lng)
      spots.value = res.data
    } catch { spots.value = [] }
    finally  { spotsLoading.value = false }
  }

  return {
    posts, feedLoading, fetchFeed, createPost, reactToPost,
    events, eventsLoading, fetchEvents, createEvent,
    spots, spotsLoading, fetchSpots, fetchNearby,
  }
})
