import api from './api'

export const PostService = {
  async getAll(page = 1) {
    const response = await api.get('/questions', { params: { page } })
    return response.data
  },

  async create(postData) {
    const response = await api.post('/questions', postData)
    return response.data
  },

  async like(id) {
    const response = await api.post(`/reactions`, { reactable_id: id, reactable_type: 'Question', type: 'like' })
    return response.data
  },

  async comment(id, commentData) {
    const response = await api.post(`/comments`, { question_id: id, ...commentData })
    return response.data
  }
}
