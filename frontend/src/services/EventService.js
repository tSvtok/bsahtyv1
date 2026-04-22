import api from './api'

export const EventService = {
  async getAll() {
    const response = await api.get('/events')
    return response.data
  },

  async getById(id) {
    const response = await api.get(`/events/${id}`)
    return response.data
  },

  async create(eventData) {
    const response = await api.post('/events', eventData)
    return response.data
  },

  async join(id) {
    const response = await api.post(`/events/${id}/join`)
    return response.data
  }
}
