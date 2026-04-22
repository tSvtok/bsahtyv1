import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', {
  state: () => ({
    currentUser: null,
    isLoggedIn: !!localStorage.getItem('auth_token')
  }),
  actions: {
    async logout() {
      this.isLoggedIn = false
      this.currentUser = null
      localStorage.removeItem('auth_token')
    },
    setUser(user) {
      this.currentUser = { 
        ...user,
        avatar: user.avatar || 'https://lh3.googleusercontent.com/a/default-user',
        favoriteSports: user.favoriteSports || []
      }
      this.isLoggedIn = true
    },
    updateUser(userData) {
      if (this.currentUser) {
        this.currentUser = { ...this.currentUser, ...userData }
      }
    },
    clearUser() {
      this.currentUser = null
      this.isLoggedIn = false
    }
  }
})
