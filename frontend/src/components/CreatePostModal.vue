<template>
  <BaseModal :show="show" title="Create New Post" @close="$emit('close')">
    <form @submit.prevent="handleSubmit" class="space-y-4">
      <div class="space-y-1">
        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">What's on your mind?</label>
        <textarea 
          v-model="form.content"
          class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-primary transition-all resize-none h-32"
          placeholder="Share an update or ask a question..."
          required
        ></textarea>
      </div>
      
      <div class="grid grid-cols-2 gap-4">
        <div class="space-y-1">
          <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Category</label>
          <select v-model="form.category" class="w-full bg-slate-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary">
            <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
          </select>
        </div>
        <div class="space-y-1">
          <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Image URL (Optional)</label>
          <input v-model="form.image" type="url" class="w-full bg-slate-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary" placeholder="https://..."/>
        </div>
      </div>

      <div class="flex items-center gap-3 pt-2">
        <input v-model="form.joinable" type="checkbox" id="joinable" class="w-4 h-4 text-primary rounded focus:ring-primary border-slate-300"/>
        <label for="joinable" class="text-sm font-medium text-slate-600">Allow others to join this activity</label>
      </div>

      <button 
        type="submit" 
        :disabled="loading"
        class="w-full btn-primary py-4 rounded-2xl"
      >
        {{ loading ? 'POSTING...' : 'SHARE POST' }}
      </button>
    </form>
  </BaseModal>
</template>

<script setup>
import { ref, reactive } from 'vue'
import BaseModal from './BaseModal.vue'
import { PostService } from '../services/PostService'
import { useUserStore } from '../stores/user'

const userStore = useUserStore()

const props = defineProps({
  show: Boolean
})

const emit = defineEmits(['close', 'created'])

const categories = ['Basketball', 'Soccer', 'Running', 'Tennis', 'Padel', 'General']
const loading = ref(false)

const form = reactive({
  content: '',
  category: 'General',
  image: '',
  joinable: false
})

const handleSubmit = async () => {
  loading.value = true
  try {
    // Generate a title from content for the backend
    const title = form.content.split('\n')[0].substring(0, 50)
    
    const data = await PostService.create({
      title: title,
      content: form.content,
      sport_category: form.category.toUpperCase(),
    })
    
    emit('created', {
      id: data.data.id,
      user: userStore.currentUser,
      time: 'Just now',
      content: data.data.content,
      likes: 0,
      comments: 0,
      tags: [data.data.sport_category || 'General'],
      isQuestion: true
    })
    
    emit('close')
    // Reset form
    form.content = ''
    form.image = ''
    form.joinable = false
  } catch (error) {
    console.error('Failed to create post:', error)
    alert('Failed to share post. Please try again.')
  } finally {
    loading.value = false
  }
}
</script>
