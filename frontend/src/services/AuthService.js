import api from './api'

export const AuthService = {
  async login(credentials) {
    const response = await api.post('/login', credentials)
    if (response.data.access_token) {
      localStorage.setItem('auth_token', response.data.access_token)
    }
    return response.data
  },

  async register(userData) {
    const response = await api.post('/register', userData)
    if (response.data.access_token) {
      localStorage.setItem('auth_token', response.data.access_token)
    }
    return response.data
  },

  async logout() {
    try {
      await api.post('/logout')
    } catch (error) {
      console.error('Logout error:', error)
    }
    localStorage.removeItem('auth_token')
  },

  async me() {
    try {
      const response = await api.get('/me')
      return response.data.data || response.data
    } catch (error) {
      console.error('Failed to fetch user:', error)
      throw error
    }
  },

  async getCurrentUser() {
    try {
      const token = localStorage.getItem('auth_token')
      if (!token) {
        return null
      }
      return await this.me()
    } catch (error) {
      localStorage.removeItem('auth_token')
      return null
    }
  }
}
