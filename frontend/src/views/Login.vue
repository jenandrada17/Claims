<template>
  <div class="min-vh-100 d-flex align-items-center justify-content-center px-3">
    <div class="login-box shadow-sm p-4 text-start">
      <!-- 🔹 Logo Placeholder -->
      <!-- <div class="text-center mb-4">
        <div class="logo-placeholder mx-auto"></div>
      </div> --> 

      <!-- 🔹 Login Form -->
      <form @submit.prevent="handleLogin">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input v-model.trim="email" type="email" class="form-control" required />
        </div>

      <div class="mb-3 position-relative">
        <label class="form-label">Password</label>

        <input
          :type="showPassword ? 'text' : 'password'"
          v-model="password"
          class="form-control pe-5"
          required
        />

        <!-- Eye Icon -->
        <i
          class="bi"
          :class="showPassword ? 'bi-eye-slash' : 'bi-eye'"
          @click="showPassword = !showPassword"
          style="
            position: absolute;
            right: 12px;
            top: 38px;
            cursor: pointer;
            font-size: 1.1rem;
            color: #6b7280;
          "
        ></i>
      </div>

        <!-- Remember me + Forgot password -->
        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="rememberMe" v-model="rememberMe" />
            <label class="form-check-label small" for="rememberMe" style="color: #747981;">
              Remember Me
            </label>
          </div>
          <!-- <a href="#" class="small text-primary text-decoration-none ms-auto ms-sm-0" @click.prevent="forgotPassword">
            Forgot Password?
          </a> --> 

          <a 
            href="#" 
            class="small text-primary text-decoration-none ms-auto ms-sm-0"
            style="cursor:pointer;"
            @click.prevent="forgotPassword"
          >
            <template v-if="!forgotLoading">
              Forgot Password?
            </template>

            <template v-else>
              <span class="spinner-border spinner-border-sm"></span>
              <span class="ms-1">Sending...</span>
            </template>
          </a> 

        </div> 

        <button type="submit" class="btn btn-primary w-100" :disabled="loading">
          <span v-if="!loading">Login</span>
          <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </button>

        <!-- <p class="text-center text-muted small mt-3 mb-0">
          © 2025 Claims System
        </p> -->
      </form>
    </div>
  </div>
</template> 

<script setup>
import { ref, inject } from 'vue'
import { useRouter } from 'vue-router'
import { backend, api } from '../lib/api'   // we created these earlier

const router = useRouter()
const email = ref('')
const password = ref('')
const rememberMe = ref(false)
const loading = ref(false)
const error = ref('')
const showPassword = ref(false)
const showToast = inject("showToast")
const forgotLoading = ref(false)

async function handleLogin () {
  error.value = ''

  // 1) Simple front-end validation
  if (!email.value || !password.value) {
    error.value = 'Please enter email and password.'
    return
  }

  loading.value = true
  try {
    console.log('Login clicked, starting CSRF flow')
 
    await backend.get('/sanctum/csrf-cookie')
 
    await backend.post('/login', {
      email: email.value,
      password: password.value,   
      remember: rememberMe.value,
    })
 
    // await api.get('/me') 
    console.log("Toast Injected:", showToast)
    showToast("Successfully Login!", "success") 
    router.push('/')

  } catch (e) { 
    const status = e?.response?.status
    let msg = ''

    if (status === 419) {
      msg = 'Session/CSRF error. Please refresh the page and try again.'
    } else if (status === 429) {
      msg = e?.response?.data?.message || 'Too many attempts. Please try again later.'
    } else if (status === 422) {
      msg = 'Invalid email or password.'
    } else {
      msg = e?.response?.data?.message || 'Login failed. Check your credentials.'
    }

    error.value = msg
    showToast(msg, "error")
  } finally {
    loading.value = false
  }
} 

async function forgotPassword() {
  if (!email.value) {
    showToast("Please enter your email first.", "error")
    return
  }

  forgotLoading.value = true

  try {
    await backend.get('/sanctum/csrf-cookie') 

    await backend.post('/forgot-password', {
      email: email.value
    }) 

    showToast("Password reset link has been sent to your email.", "success")
    forgotLoading.value = false
  } catch (e) {
    forgotLoading.value = false 
    showToast("Unable to send reset email.", "error")
  }
} 
</script>


<style scoped>  
*, *::before, *::after { 
  box-sizing: border-box; 
}  

.login-box {
  width: clamp(320px, 90vw, 420px);
  max-width: 90vw;
  margin-inline: auto;
  padding: clamp(16px, 4vw, 24px);
  border-radius: 12px;
  background: #fff; 
  box-shadow: 0 0 20px rgba(0,0,0,0.3) !important;
}

@media (min-width: 992px) {
  .login-box {
    max-width: 640px;
  }
}

/* Logo placeholder (empty for now) */
.logo-placeholder {
  width: 100px;
  height: 50px;
  background: #f3f4f6;
  border-radius: 6px;
}
/* Labels */
.form-label {
  font-weight: 600;
  color: #374151;
  font-size: 14px;
  text-align: left;
}
/* Inputs */
.form-control {
  border: 1px solid #d1d5db;
  height: 42px;
  border-radius: 8px;
  color: #374151;
}
.form-control::placeholder {
  color: #9ca3af;
}
/* Focus effect */
.form-control:focus {
  border-color: #4f46e5;
  box-shadow: 0 0 0 0.15rem rgba(79, 70, 229, 0.15);
}
/* Button */
.btn-primary {
  background-color: #3b82f6;
  border: none;
  font-weight: 600;
  height: 42px;
  border-radius: 8px;
  transition: background-color 0.2s ease, box-shadow 0.2s ease;
}
.btn-primary:hover {
  background-color: #2563eb;
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
} 
/* Link hover */
a.text-primary:hover {
  text-decoration: underline;
}
/* Footer */
.text-muted {
  color: #9ca3af !important;
} 

</style>
