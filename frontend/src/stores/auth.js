import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { authApi } from '@/services/api'

export const useAuthStore = defineStore('auth', () => {
  const token = ref(localStorage.getItem('bssahty_token') || null)
  const user  = ref(null)
  const loading = ref(false)
  const error   = ref(null)

  const isLoggedIn = computed(() => !!token.value)

  async function fetchMe() {
    try {
      const res = await authApi.me()
      user.value = res.data.data
    } catch {
      user.value = null
    }
  }

  async function login(credentials) {
    loading.value = true
    error.value   = null
    try {
      const res = await authApi.login(credentials)
      token.value = res.data.access_token
      localStorage.setItem('bssahty_token', token.value)
      await fetchMe()
      return true
    } catch (err) {
      if (err.response?.data?.errors) {
        error.value = Object.values(err.response.data.errors).flat().join(' ')
      } else {
        error.value = err.response?.data?.message || 'Login failed.'
      }
      return false
    } finally {
      loading.value = false
    }
  }

  async function register(data) {
    loading.value = true
    error.value   = null
    try {
      const res = await authApi.register(data)
      token.value = res.data.access_token
      localStorage.setItem('bssahty_token', token.value)
      await fetchMe()
      return true
    } catch (err) {
      if (err.response?.data?.errors) {
        error.value = Object.values(err.response.data.errors).flat().join(' ')
      } else {
        error.value = err.response?.data?.message || 'Registration failed.'
      }
      return false
    } finally {
      loading.value = false
    }
  }

  async function logout() {
    try { await authApi.logout() } catch {}
    token.value = null
    user.value  = null
    localStorage.removeItem('bssahty_token')
  }

  // On app boot, hydrate user if token exists
  if (token.value) fetchMe()

  return { token, user, loading, error, isLoggedIn, login, register, logout, fetchMe }
})
