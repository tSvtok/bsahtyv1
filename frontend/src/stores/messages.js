import { defineStore } from 'pinia'

export const useMessageStore = defineStore('messages', {
  state: () => ({
    conversations: [
      {
        id: 1,
        name: 'Marcus Rodriguez',
        avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuD8SB2go5hBs0jHJxWlt8Na0FaeF84oq-A2MabVICG_mQnD2u_jujy43ulPZHd6tUaaC7IPs9zO286yJYzU2Rzqxo9tymST2hHaZR2GqpqmzXhhYvg1uZOA2kdFopdW0alYQxxt3vYV3n12Jl0OuuOaaBv4e8xFyygPvxMfnX3c-oFlyjko7vhrUxU2jKdvEZd9oB994iwz07x9IZojSBHsZIG2-1pUteJ7CpxPZA24irUqBkTHGh2sEYJ1SdGNSb1jawALvKapeax6',
        status: 'Online',
        messages: [
          { id: 1, text: 'Are we still on for the 5v5 tonight at Riverside?', sender: 'me', time: '10:15 AM' },
          { id: 2, text: 'Definitely! I\'m bringing two more guys. See you at 8 PM?', sender: 'them', time: '10:17 AM' }
        ]
      },
      {
        id: 2,
        name: 'Sarah Miller',
        avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBOYNL6J4kvjKUyYiZjPBFsChM59fqVJTu36LRqy0Ayi1F9mowxiQzBJ-jxJHUGa5fBqU_toe7PcCLo4vQ0FGb1AwodS0OstYYnSPFEG63oCLLR4CO7b9bwhgiDHDJVPmyvxJuK2-WSHbITrUVWutKsEj91YAWqXBKhwkCFRrhf0z5fQvN1WXyvyO_bTp308mJWSgHlkkErZlQDRRYsKkpT7nNMzQ7IKaARjhvQvMbJmotw6hxY33AbKipPYPk0Xb9PMxvKM5qkThfx',
        status: 'Away',
        messages: [
          { id: 1, text: 'Hey Alex, do you have any tips for a new tennis racket?', sender: 'them', time: 'Yesterday' },
          { id: 2, text: 'Sure! I recommend the Wilson Pro Staff if you want control.', sender: 'me', time: 'Yesterday' }
        ]
      }
    ]
  }),
  actions: {
    sendMessage(conversationId, text) {
      const conv = this.conversations.find(c => c.id === parseInt(conversationId))
      if (conv) {
        conv.messages.push({
          id: Date.now(),
          text,
          sender: 'me',
          time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
        })
      }
    }
  }
})
