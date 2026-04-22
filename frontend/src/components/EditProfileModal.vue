<template>
  <BaseModal :show="show" title="Edit Profile" @close="$emit('close')">
    <form @submit.prevent="handleSubmit" class="space-y-6">
      <!-- Profile Picture -->
      <div class="flex flex-col items-center gap-4">
        <div class="relative">
          <img :src="form.avatar" alt="Profile" class="w-24 h-24 rounded-full object-cover border-4 border-slate-50 shadow-md"/>
          <button type="button" class="absolute bottom-0 right-0 bg-primary text-white p-2 rounded-full shadow-lg hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-sm">photo_camera</span>
          </button>
        </div>
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Change Profile Picture</p>
      </div>

      <div class="space-y-4">
        <div class="space-y-1">
          <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Full Name</label>
          <input v-model="form.name" type="text" class="w-full bg-slate-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary" required/>
        </div>

        <div class="space-y-1">
          <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Bio</label>
          <textarea v-model="form.bio" class="w-full bg-slate-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary h-24 resize-none" placeholder="Tell us about your athletic journey..."></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Location</label>
            <input v-model="form.location" type="text" class="w-full bg-slate-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary" required/>
          </div>
          <div class="space-y-1">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Skill Level</label>
            <select v-model="form.level" class="w-full bg-slate-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary">
              <option value="Beginner">Beginner</option>
              <option value="Intermediate">Intermediate</option>
              <option value="Advanced">Advanced</option>
              <option value="Pro">Pro</option>
            </select>
          </div>
        </div>
      </div>

      <button 
        type="submit" 
        :disabled="loading"
        class="w-full btn-primary py-4 rounded-2xl"
      >
        {{ loading ? 'SAVING...' : 'SAVE CHANGES' }}
      </button>
    </form>
  </BaseModal>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue'
import BaseModal from './BaseModal.vue'
import { useUserStore } from '../stores/user'

const props = defineProps({
  show: Boolean
})

const emit = defineEmits(['close', 'updated'])
const userStore = useUserStore()
const loading = ref(false)

const form = reactive({
  name: '',
  bio: '',
  location: '',
  level: '',
  avatar: ''
})

onMounted(() => {
  if (userStore.currentUser) {
    Object.assign(form, {
      name: userStore.currentUser.name,
      bio: userStore.currentUser.bio || "Basketball enthusiast & casual runner. Always down for a pickup game! 🏀🏃‍♂️",
      location: userStore.currentUser.location,
      level: userStore.currentUser.level,
      avatar: userStore.currentUser.avatar
    })
  }
})

const handleSubmit = async () => {
  loading.value = true
  // Simulate API call
  setTimeout(() => {
    userStore.updateUser(form)
    loading.value = false
    emit('updated')
    emit('close')
  }, 1000)
}
</script>
