<template> 
    <!-- 🔔 Toast Notification -->
  <div v-if="toast.show" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;" >
    <div class="toast-alert shadow px-4 py-3 rounded text-white fw-semibold" :class="toast.type === 'success' ? 'bg-success' : 'bg-danger'" >
      {{ toast.message }}
    </div>
  </div>

  <router-view />
</template>

<script setup>
  import { ref, provide } from "vue"

  const toast = ref({
    show: false,
    message: "",
    type: "" 
  })

  function showToast(message, type = "success") {
    toast.value.show = true
    toast.value.message = message
    toast.value.type = type

    setTimeout(() => {
      toast.value.show = false
    }, 3000)
  }

  // make it available to all components
  provide("showToast", showToast)
</script>

<style> 
/*PROMPT*/
.toast-alert {
  font-size: 1rem;
  min-width: 260px;
  box-shadow: 0 4px 12px rgba(0,0,0,.15);
  border-radius: 8px;
  animation: fade-slide 0.3s ease-out;
}

@keyframes fade-slide {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
} 
</style>
