<template>
  <div class="bg-background text-on-background font-body min-h-screen flex flex-col">
    <!-- TopAppBar -->
    <header class="fixed top-0 z-50 w-full flex items-center justify-between px-6 py-4 bg-white/80 backdrop-blur-md border-b border-slate-200">
      <router-link to="/" class="text-2xl font-black italic tracking-tighter text-primary">
        B-SSAHTY
      </router-link>
      <router-link to="/" class="p-2 text-slate-500 hover:bg-orange-50 transition-colors rounded-full">
        <span class="material-symbols-outlined">close</span>
      </router-link>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center relative overflow-hidden pt-16">
      <!-- Background Atmosphere -->
      <div class="absolute inset-0 z-0">
        <img alt="Sports Atmosphere" class="w-full h-full object-cover grayscale opacity-10" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAZXChzffgrMuArmgU3_o5x11rs6QHviV6GNXnNjuUzPRCLzoSv9GJbGJR89qgneIMEclLAKf-GoWNfNRdJUqf9xy1XJ-qzh1yAf2qMIO5ekg3JV4blwfYSJG11s4J9vO_J4nHuDd5FEBbDBPuW8hmBczvhZxlF5X1SWCBvsQ_Ti0ZC6E0Os8d89e0jwGzUe8kN1RW6HBMRe0Q23VztmsLLXYC2R30alLkKOv8YCARLA_WAwPwGhlxeJ2EB62XVdNidPKCaag9lceTA"/>
        <div class="absolute inset-0 bg-gradient-to-tr from-slate-100/60 to-transparent"></div>
      </div>

      <!-- Login Card -->
      <div class="z-10 w-full max-w-md px-6">
        <div class="bg-white/90 backdrop-blur-xl border border-outline-variant p-10 rounded-2xl shadow-2xl space-y-8">
          <!-- Headline Section -->
          <div class="text-center space-y-2">
            <h1 class="font-headline text-3xl font-bold text-on-surface tracking-tight">
              Welcome Back, Athlete
            </h1>
            <p class="text-sm text-slate-500">
              Log in to your B-SSAHTY account
            </p>
          </div>

          <!-- API Error Message -->
          <div v-if="apiError" class="p-4 bg-red-50 border border-red-100 rounded-xl flex items-center gap-3 text-red-600 text-xs font-bold animate-shake">
            <span class="material-symbols-outlined text-sm">error</span>
            {{ apiError }}
          </div>

          <!-- Form Section -->
          <form @submit.prevent="handleLogin" class="space-y-6">
            <!-- Email Field -->
            <div class="space-y-2">
              <label class="text-xs font-bold text-on-surface uppercase tracking-wider" for="email">
                Email Address
              </label>
              <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                  <span class="material-symbols-outlined">mail</span>
                </div>
                <input v-model="email" class="block w-full pl-10 pr-4 py-3 bg-white border border-outline-variant rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" id="email" placeholder="coach@bssahty.com" required type="email"/>
              </div>
            </div>

            <!-- Password Field -->
            <div class="space-y-2">
              <div class="flex justify-between items-center">
                <label class="text-xs font-bold text-on-surface uppercase tracking-wider" for="password">
                  Password
                </label>
              </div>
              <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                  <span class="material-symbols-outlined">lock</span>
                </div>
                <input v-model="password" :type="showPassword ? 'text' : 'password'" class="block w-full pl-10 pr-12 py-3 bg-white border border-outline-variant rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" id="password" placeholder="••••••••" required/>
                <button @click="showPassword = !showPassword" type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-primary">
                  <span class="material-symbols-outlined">{{ showPassword ? 'visibility_off' : 'visibility' }}</span>
                </button>
              </div>
            </div>

            <!-- Remember & Forgot -->
            <div class="flex items-center justify-between">
              <label class="flex items-center space-x-2 cursor-pointer group">
                <input type="checkbox" class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary"/>
                <span class="text-xs font-bold text-slate-500 group-hover:text-primary transition-colors">Remember me</span>
              </label>
              <a class="text-xs font-bold text-primary hover:underline transition-all" href="#">
                Forgot password?
              </a>
            </div>

            <!-- Login Button -->
            <button 
              class="w-full py-4 bg-primary text-white font-bold rounded-full shadow-lg hover:shadow-orange-200 active:scale-95 transition-all duration-150 uppercase tracking-widest flex items-center justify-center gap-2 disabled:opacity-50" 
              type="submit"
              :disabled="loading"
            >
              <span v-if="loading" class="material-symbols-outlined animate-spin">sync</span>
              {{ loading ? 'Logging in...' : 'Login' }}
              <span v-if="!loading" class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">bolt</span>
            </button>
          </form>

          <!-- Social/Register Redirect -->
          <div class="pt-6 border-t border-slate-100 text-center">
            <p class="text-sm text-slate-500">
              New to the team? 
              <router-link to="/register" class="font-bold text-primary hover:underline ml-1">
                Create an account
              </router-link>
            </p>
          </div>
        </div>
      </div>
    </main>

    <!-- Footer Component -->
    <footer class="bg-slate-50 border-t border-slate-200 w-full mt-auto">
      <div class="flex flex-col md:flex-row justify-between items-center px-8 py-8 w-full max-w-7xl mx-auto space-y-4 md:space-y-0">
        <div class="text-[10px] uppercase tracking-widest font-bold text-slate-400">
          © 2024 B-SSAHTY. ALL RIGHTS RESERVED.
        </div>
        <nav class="flex space-x-6">
          <a class="text-[10px] uppercase tracking-widest font-bold text-slate-400 hover:text-primary underline" href="#">Terms</a>
          <a class="text-[10px] uppercase tracking-widest font-bold text-slate-400 hover:text-primary underline" href="#">Privacy</a>
          <a class="text-[10px] uppercase tracking-widest font-bold text-slate-400 hover:text-primary underline" href="#">Support</a>
        </nav>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { AuthService } from '../services/AuthService'
import { useUserStore } from '../stores/user'

const router = useRouter()
const userStore = useUserStore()
const email = ref('')
const password = ref('')
const showPassword = ref(false)
const loading = ref(false)
const apiError = ref('')

const handleLogin = async () => {
  loading.value = true
  apiError.value = ''
  
  try {
    const data = await AuthService.login({
      email: email.value,
      password: password.value
    })
    
    if (data.user) {
      userStore.setUser(data.user)
    } else {
      // If user data is not in login response, fetch from /me
      const userData = await AuthService.me()
      userStore.setUser(userData)
    }
    
    router.push('/feed')
  } catch (error) {
    console.error('Login failed:', error)
    apiError.value = error.response?.data?.message || 'Invalid credentials. Please try again.'
  } finally {
    loading.value = false
  }
}
</script>
