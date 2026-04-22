<template>
  <BaseModal :show="show" title="Organize New Match" @close="$emit('close')">
    <form @submit.prevent="handleSubmit" class="space-y-4">
      <div class="space-y-1">
        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Event Title</label>
        <input v-model="form.title" type="text" class="w-full bg-slate-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary" placeholder="e.g. 5v5 Friendly Scrimmage" required/>
      </div>
      
      <div class="grid grid-cols-2 gap-4">
        <div class="space-y-1">
          <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Sport</label>
          <select v-model="form.sport" class="w-full bg-slate-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary">
            <option v-for="s in sports" :key="s" :value="s">{{ s }}</option>
          </select>
        </div>
        <div class="space-y-1">
          <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Location</label>
          <input v-model="form.location" type="text" class="w-full bg-slate-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary" placeholder="e.g. Central Park Courts" required/>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div class="space-y-1">
          <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Date</label>
          <input v-model="form.date" type="date" class="w-full bg-slate-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary" required/>
        </div>
        <div class="space-y-1">
          <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Time</label>
          <input v-model="form.time" type="time" class="w-full bg-slate-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary" required/>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div class="space-y-1">
          <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Max Participants</label>
          <input v-model.number="form.maxParticipants" type="number" min="2" class="w-full bg-slate-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary" required/>
        </div>
        <div class="space-y-1">
          <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Image URL</label>
          <input v-model="form.image" type="url" class="w-full bg-slate-50 border-none rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary" placeholder="https://..."/>
        </div>
      </div>

      <button 
        type="submit" 
        :disabled="loading"
        class="w-full btn-primary py-4 rounded-2xl"
      >
        {{ loading ? 'CREATING...' : 'CREATE EVENT' }}
      </button>
    </form>
  </BaseModal>
</template>

<script setup>
import { ref, reactive } from 'vue'
import BaseModal from './BaseModal.vue'
import { EventService } from '../services/EventService'

const props = defineProps({
  show: Boolean
})

const emit = defineEmits(['close', 'created'])

const sports = ['Basketball', 'Soccer', 'Running', 'Tennis', 'Padel', 'Volleyball']
const loading = ref(false)

const form = reactive({
  title: '',
  sport: 'Basketball',
  location: '',
  date: '',
  time: '',
  maxParticipants: 10,
  image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCHupKhVEFLaH1eNDM_AnoTbaye6u0Ugk6CcHttQwI_oEifMApcbureNauu9DpfgnuCCgXFSynbEK27XiBsWXirXvx-FpDTAQpQQPCE3eU2dGoySbl4UZtZ-GO3iF-oGwisuCOhCdVqwLAdWjYQlB06ubRIdUVrNr3CjMneEW9aiq-_OcizxwJQpH1k_ovil-Wrj8UBDj5OHbX8YaVXSIR02GvQ9PDsxQDH8nU_oKtLG-x3QIyPruWeE9fELM0lYEB3x-vhJUXbXF7S'
})

const handleSubmit = async () => {
  loading.value = true
  try {
    const data = await EventService.create({
      title: form.title,
      sport: form.sport,
      location: form.location,
      date: `${form.date} ${form.time}`,
      max_participants: form.maxParticipants,
      status: 'OPEN'
    })
    
    emit('created', {
      id: data.data.id,
      title: data.data.title || form.title,
      sport: data.data.sport || form.sport,
      date: form.date,
      time: form.time,
      location: form.location,
      participants: 1,
      maxParticipants: form.maxParticipants,
      image: form.image,
      status: 'OPEN'
    })
    
    emit('close')
    // Reset form
    Object.assign(form, {
      title: '',
      sport: 'Basketball',
      location: '',
      date: '',
      time: '',
      maxParticipants: 10
    })
  } catch (error) {
    console.error('Failed to create event:', error)
    alert('Failed to organize match. Please check if all fields are correct.')
  } finally {
    loading.value = false
  }
}
</script>
