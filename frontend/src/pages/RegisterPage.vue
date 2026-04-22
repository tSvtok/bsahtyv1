<template>
  <div class="bg-background text-on-background min-h-screen flex flex-col font-body overflow-x-hidden">
    <!-- TopAppBar -->
    <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 shadow-sm top-0 flex justify-between items-center w-full px-6 py-4 z-50 fixed">
      <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-primary">sports_score</span>
        <router-link to="/" class="text-2xl font-black text-primary tracking-tighter font-headline">B-SSAHTY</router-link>
      </div>
    </header>

    <!-- Main Registration Canvas -->
    <main class="flex-grow flex items-center justify-center pt-32 pb-32 px-4 registration-bg relative">
      <div class="absolute inset-0 z-0">
        <img alt="Athlete Background" class="w-full h-full object-cover grayscale opacity-20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDBf1kmnslF2tQ9-JQwqNS-loKVj20lmtY2yHXsFC6WUYqau3Zk-O06-yJ1gTiuqxwomUGVUWV2rJzwobEWirvzZ31yKUzGFQLYNXuy_u1la_3mK49itekQG_AGaYhzf77Twyj5uzTcXUa1w_1NulD-47MdybWrqbEeY0fiF-Bsj8OAueASbuW6by1Z3eSwZ3aYSGrUgrGAYAHE0AZfJcrGuf-UjZpRSL2MWXoEdvy6TSl6ZuG48tSkxWOYt2cNdN6jOKg7JZ38OIVU"/>
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 to-slate-900/60"></div>
      </div>

      <div class="z-10 w-full max-w-md bg-white/95 backdrop-blur-xl rounded-2xl p-8 shadow-2xl border border-white/20">
        <!-- Header -->
        <div class="mb-8 text-center">
          <h2 class="font-headline text-3xl font-bold text-on-surface mb-2">Join the Team</h2>
          <p class="text-sm text-slate-500">Start connecting with your local sports community.</p>
        </div>

        <!-- API Error Message -->
        <div v-if="apiError" class="mb-6 p-4 bg-red-50 border border-red-100 rounded-xl flex items-center gap-3 text-red-600 text-xs font-bold animate-shake">
          <span class="material-symbols-outlined text-sm">error</span>
          {{ apiError }}
        </div>

        <!-- Registration Form -->
        <form @submit.prevent="handleRegister" class="space-y-4">
          <!-- Full Name -->
          <div class="space-y-1">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Full Name</label>
            <div class="relative group">
              <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">person</span>
              <input v-model="form.name" class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-sm" placeholder="Enter your full name" type="text" required/>
            </div>
            <p v-if="v$.name.$error" class="text-[10px] text-red-500 font-bold ml-1">{{ v$.name.$errors[0].$message }}</p>
          </div>
          <!-- Email -->
          <div class="space-y-1">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Email</label>
            <div class="relative group">
              <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">email</span>
              <input v-model="form.email" class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-sm" placeholder="athlete@bssahty.com" type="email" required/>
            </div>
            <p v-if="v$.email.$error" class="text-[10px] text-red-500 font-bold ml-1">{{ v$.email.$errors[0].$message }}</p>
          </div>
          <!-- City -->
          <div class="space-y-1">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">City</label>
            <div class="relative group">
              <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">location_on</span>
              <input v-model="form.city" class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-sm" placeholder="Where do you play?" type="text" required/>
            </div>
            <p v-if="v$.city.$error" class="text-[10px] text-red-500 font-bold ml-1">{{ v$.city.$errors[0].$message }}</p>
          </div>
          <!-- Password -->
          <div class="space-y-1">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Password</label>
            <div class="relative group">
              <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">lock</span>
              <input v-model="form.password" :type="showPassword ? 'text' : 'password'" class="w-full pl-10 pr-12 py-3 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-sm" placeholder="••••••••" required/>
              <button @click="showPassword = !showPassword" type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary">
                <span class="material-symbols-outlined">{{ showPassword ? 'visibility_off' : 'visibility' }}</span>
              </button>
            </div>
            <p v-if="v$.password.$error" class="text-[10px] text-red-500 font-bold ml-1">{{ v$.password.$errors[0].$message }}</p>
          </div>
          <!-- Confirm Password -->
          <div class="space-y-1">
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Confirm Password</label>
            <div class="relative group">
              <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">lock</span>
              <input v-model="form.confirmPassword" :type="showPassword ? 'text' : 'password'" class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-sm" placeholder="••••••••" required/>
            </div>
            <p v-if="v$.confirmPassword.$error" class="text-[10px] text-red-500 font-bold ml-1">{{ v$.confirmPassword.$errors[0].$message }}</p>
          </div>
          <!-- Terms -->
          <div class="flex items-start gap-3 pt-2">
            <input class="mt-1 w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary cursor-pointer transition-colors" id="terms" type="checkbox" required/>
            <label class="text-[10px] font-bold text-slate-500 leading-relaxed" for="terms">
              I agree to the <a class="text-primary hover:underline" href="#">Terms and Conditions</a> and the <a class="text-primary hover:underline" href="#">Privacy Policy</a>.
            </label>
          </div>
          <!-- CTA -->
          <button 
            class="w-full bg-primary text-white font-bold py-4 rounded-full shadow-lg hover:shadow-orange-200 active:scale-95 transition-all uppercase tracking-widest mt-6 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed" 
            type="submit"
            :disabled="loading"
          >
            <span v-if="loading" class="material-symbols-outlined animate-spin">sync</span>
            {{ loading ? 'Joining...' : 'JOIN B-SSAHTY' }}
          </button>
        </form>
        <!-- Footer -->
        <div class="mt-8 text-center border-t border-slate-100 pt-6">
          <p class="text-sm text-slate-500">
            Already have an account? 
            <router-link to="/login" class="text-primary font-bold hover:underline">Log in</router-link>
          </p>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useVuelidate } from '@vuelidate/core'
import { required, email, minLength, sameAs } from '@vuelidate/validators'
import { AuthService } from '../services/AuthService'
import { useUserStore } from '../stores/user'

const router = useRouter()
const userStore = useUserStore()
const showPassword = ref(false)
const loading = ref(false)
const apiError = ref('')
const form = reactive({
  name: '',
  email: '',
  city: '',
  password: '',
  confirmPassword: ''
})

const rules = computed(() => ({
  name: { required },
  email: { required, email },
  city: { required },
  password: { required, minLength: minLength(8) },
  confirmPassword: { required, sameAs: sameAs(form.password) }
}))

const v$ = useVuelidate(rules, form)

const handleRegister = async () => {
  const result = await v$.value.$validate()
  if (!result) return

  loading.value = true
  apiError.value = ''
  
  try {
    const data = await AuthService.register({
      name: form.name,
      email: form.email,
      password: form.password,
      password_confirmation: form.confirmPassword,
      city: form.city
    })
    
    if (data.user) {
      userStore.setUser(data.user)
    } else {
      // If user data is not in registration response, fetch from /me
      const userData = await AuthService.me()
      userStore.setUser(userData)
    }
    
    router.push('/feed')
  } catch (error) {
    console.error('Registration failed:', error)
    apiError.value = error.response?.data?.message || 'Registration failed. Please try again.'
  } finally {
    loading.value = false
  }
}
</script>
