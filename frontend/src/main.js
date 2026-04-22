import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { createRouter, createWebHistory } from 'vue-router'
import App from './App.vue'
import './style.css'
import { useUserStore } from './stores/user'
import { AuthService } from './services/AuthService'

const routes = [
  { path: '/', component: () => import('./pages/LandingPage.vue'), meta: { requiresAuth: false } },
  { path: '/feed', component: () => import('./pages/FeedPage.vue'), meta: { requiresAuth: true } },
  { path: '/map', component: () => import('./pages/MapPage.vue'), meta: { requiresAuth: true } },
  { path: '/profile', component: () => import('./pages/ProfilePage.vue'), meta: { requiresAuth: true } },
  { path: '/login', component: () => import('./pages/LoginPage.vue'), meta: { requiresAuth: false } },
  { path: '/register', component: () => import('./pages/RegisterPage.vue'), meta: { requiresAuth: false } },
  { path: '/events', component: () => import('./pages/EventsPage.vue'), meta: { requiresAuth: true } },
  { path: '/events/:id', component: () => import('./pages/EventDetailPage.vue'), meta: { requiresAuth: true } },
  { path: '/messages', component: () => import('./pages/MessagesPage.vue'), meta: { requiresAuth: true } },
  { path: '/messages/:id', component: () => import('./pages/ChatPage.vue'), meta: { requiresAuth: true } },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Global route guard
router.beforeEach(async (to, from, next) => {
  const userStore = useUserStore()
  const requiresAuth = to.meta.requiresAuth

  // Check if user has token
  const token = localStorage.getItem('auth_token')
  
  if (requiresAuth) {
    if (!token) {
      // No token, redirect to login
      next('/login')
    } else if (!userStore.currentUser) {
      // Token exists but user not loaded, try to fetch
      try {
        const userData = await AuthService.me()
        userStore.setUser(userData)
        next()
      } catch (error) {
        // Token invalid, clear and redirect to login
        localStorage.removeItem('auth_token')
        userStore.clearUser()
        next('/login')
      }
    } else {
      // User already loaded
      next()
    }
  } else {
    // Route doesn't require auth
    if (token && !userStore.currentUser) {
      // Try to load user if token exists
      try {
        const userData = await AuthService.me()
        userStore.setUser(userData)
      } catch (error) {
        localStorage.removeItem('auth_token')
        userStore.clearUser()
      }
    }
    next()
  }
})

const app = createApp(App)
app.use(createPinia())
app.use(router)
app.mount('#app')
