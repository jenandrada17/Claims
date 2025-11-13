<template>
  <div class="reset-box">
    <h3>Reset Password</h3>

    <form @submit.prevent="resetPassword">
      <input v-model="password" type="password" placeholder="New Password" required>
      <input v-model="password_confirmation" type="password" placeholder="Confirm Password" required>

      <button type="submit">Reset Password</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { backend } from '../lib/api'

const route = useRoute()
const router = useRouter()

const password = ref("")
const password_confirmation = ref("")
const showToast = inject("showToast")

async function resetPassword() {
  try {
    await backend.post('/reset-password', {
      token: route.query.token,
      email: route.query.email,
      password: password.value,
      password_confirmation: password_confirmation.value
    })

    showToast("Password reset successfully!", "success")
    router.push("/login")

  } catch (e) {
    showToast("Error resetting password.", "error")
  }
}
</script>
