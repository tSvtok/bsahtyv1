import { defineStore } from 'pinia'
import { ref } from 'vue'
import { feedApi, eventsApi, spotsApi } from '@/services/api'

export const useAppStore = defineStore('app', () => {
  // Feed
  const posts   = ref([])
  const feedLoading = ref(false)
  const feedPagination = ref({ current_page: 1, last_page: 1, total: 0 })

  async function fetchFeed(params = {}, append = false) {
    if (!append) feedLoading.value = true
    try {
      const res = await feedApi.list({ ...params, page: params.page || 1 })
      const data = res.data.data
      
      if (append) {
        posts.value = [...posts.value, ...(data.data || [])]
      } else {
        posts.value = data.data || []
      }
      
      feedPagination.value = {
        current_page: data.current_page,
        last_page: data.last_page,
        total: data.total
      }
    } catch { 
      if (!append) posts.value = [] 
    } finally  { 
      feedLoading.value = false 
    }
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
  const eventsPagination = ref({ current_page: 1, last_page: 1, total: 0 })

  async function fetchEvents(params = {}, append = false) {
    if (!append) eventsLoading.value = true
    try {
      const res = await eventsApi.list({ ...params, page: params.page || 1 })
      const data = res.data.data
      
      if (append) {
        events.value = [...events.value, ...(data.data || [])]
      } else {
        events.value = data.data || []
      }

      eventsPagination.value = {
        current_page: data.current_page,
        last_page: data.last_page,
        total: data.total
      }
    } catch { 
      if (!append) events.value = [] 
    } finally  { 
      eventsLoading.value = false 
    }
  }

  async function createEvent(data) {
    const res = await eventsApi.create(data)
    events.value.unshift(res.data.data)
  }

  // Spots
  const spots = ref([])
  const spotsLoading = ref(false)

  async function fetchSpots() {
    spotsLoading.value = true
    try {
      const res = await spotsApi.list()
      spots.value = res.data.data
    } catch { spots.value = [] }
    finally  { spotsLoading.value = false }
  }

  async function fetchNearby(lat, lng) {
    spotsLoading.value = true
    try {
      const res = await spotsApi.nearby(lat, lng)
      spots.value = res.data.data
    } catch { spots.value = [] }
    finally  { spotsLoading.value = false }
  }

  return {
    posts, feedLoading, feedPagination, fetchFeed, createPost, reactToPost,
    events, eventsLoading, eventsPagination, fetchEvents, createEvent,
    spots, spotsLoading, fetchSpots, fetchNearby,
  }
})
