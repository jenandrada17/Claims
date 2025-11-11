<template>
  <div class="login-page d-flex flex-column align-items-center justify-content-center">
    <div class="login-box shadow-sm p-4">
      <form @submit.prevent="handleLogin">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input v-model.trim="email" type="email" class="form-control" required />
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input v-model="password" type="password" class="form-control" required />
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="rememberMe" v-model="rememberMe" />
            <label class="form-check-label small text-muted" for="rememberMe">Remember Me</label>
          </div>

          <a href="#" class="small text-primary text-decoration-none" @click.prevent="forgotPassword">
            Forgot Password?
          </a>
        </div>

        <button type="submit" class="btn btn-primary w-100" :disabled="loading">
          <span v-if="!loading">Login</span>
          <span v-else class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </button>

        <p v-if="error" class="text-danger small mt-2 mb-0">{{ error }}</p>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { backend, api } from '../lib/api'   // we created these earlier

const router = useRouter()
const email = ref('')
const password = ref('')
const rememberMe = ref(false)
const loading = ref(false)
const error = ref('')

async function handleLogin () {
  error.value = ''
  if (!email.value || !password.value) {
    error.value = 'Please enter email and password.'
    return
  }
  loading.value = true
  try {
    await backend.get('/sanctum/csrf-cookie')
    await api.post('/login', {
      email: email.value,
      password: password.value,
      remember: rememberMe.value
    })
    await api.get('/me')   // optional sanity check
    router.push('/')       // go to home/dashboard
  } catch (e) {
    error.value = e?.response?.data?.message || 'Login failed. Check your credentials.'
  } finally {
    loading.value = false
  }
}

function forgotPassword () {
  // later: route to your reset page or call API to send mail
  alert('Password reset instructions will be sent to your email.')
}
</script>

<style scoped>
.login-page {
  min-height: 100vh;
  background: linear-gradient(135deg, #eef5ff, #ffffff);
}
.login-box {
  background: #fff;
  border: 1px solid #d9e3f0;
  border-radius: 12px;
  width: 100%;
  max-width: 420px;
}
</style>
