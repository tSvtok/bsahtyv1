import { onMounted, onUnmounted } from 'vue'
import echo from '@/services/echo'
import { useToastStore } from '@/stores/toast'
import { useAuthStore } from '@/stores/auth'

export function useNotifications() {
  const toastStore = useToastStore()
  const auth = useAuthStore()

  function setup() {
    if (!auth.isLoggedIn || !auth.user) return

    echo.private(`user.${auth.user.id}`)
      .listen('.friend.request', (e) => {
        toastStore.show('New Friend Request', `You received a friend request!`, 'info')
      })
      .listen('.message.received', (e) => {
        toastStore.show('New Message', `${e.message.user.name}: ${e.message.content}`, 'info')
      })
  }

  function teardown() {
    if (auth.user) {
      echo.leave(`user.${auth.user.id}`)
    }
  }

  return { setup, teardown }
}
