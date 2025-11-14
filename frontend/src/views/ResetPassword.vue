<template>
  <div class="min-vh-100 d-flex align-items-center justify-content-center px-3">
    <div class="reset-box shadow-sm p-4">

      <h5 class="mb-4 text-center">Reset Password</h5>

      <form @submit.prevent="submitNewPassword">

        <!-- Email -->
        <div class="mb-4 text-start">
          <label class="form-label fw-semibold">Email</label>
          <input 
            v-model="email"
            type="email"
            class="form-control"
            disabled
          />
        </div>

        <!-- New Password -->
        <div class="mb-4 text-start">
          <label class="form-label fw-semibold">New Password</label>
          <input 
            v-model="password"
            type="password"
            class="form-control"
            required
          />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4 text-start">
          <label class="form-label fw-semibold">Confirm Password</label>
          <input 
            v-model="password_confirmation"
            type="password"
            class="form-control"
            required
          />
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-2" :disabled="loading">
          <span v-if="!loading">Reset Password</span>
          <span v-else class="spinner-border spinner-border-sm"></span>
        </button>

      </form> 
    </div>
  </div>
</template>


<script setup>
import { ref, inject } from "vue"
import { useRoute, useRouter } from "vue-router"
import { backend } from "../lib/api"

const showToast = inject("showToast")
const route = useRoute()
const router = useRouter()

// Get token + email from URL
const token = route.query.token
const email = ref(route.query.email || "")

const password = ref("")
const password_confirmation = ref("")
const loading = ref(false)

const showPass = ref(false)
const showConfirmPass = ref(false)

async function submitNewPassword() {
  loading.value = true

  try {
    await backend.get("/sanctum/csrf-cookie")

    const res = await backend.post("/reset-password", {
      token,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value
    })

    showToast("Password updated successfully!", "success")

    setTimeout(() => router.push("/login"), 1500)

  } catch (e) {
    console.log("Reset error", e)
    const msg = e?.response?.data?.message || "Unable to reset password."
    showToast(msg, "error")
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.reset-box {
  width: clamp(320px, 90vw, 420px);
  background: #fff;
  border-radius: 12px;
  padding: 24px;
  box-shadow: 0 0 20px rgba(0,0,0,0.3) !important;
} 

.form-label {
  font-size: 14px;
  color: #374151;
  display: block;
  text-align: left !important;
}

.form-control {
  height: 42px;
  border-radius: 8px;
  border: 1px solid #d1d5db; 
}

.form-control:focus {
  border-color: #4f46e5;
  box-shadow: 0 0 0 0.15rem rgba(79, 70, 229, 0.15);
}
</style>
