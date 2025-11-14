<template>
  <transition name="toast-fade">
    <div 
      v-if="toast.show" 
      class="toast-container"
      :class="toast.type"
    >
      <i class="bi" :class="toastIcon"></i>
      <span>{{ toast.message }}</span>
    </div>
  </transition>
</template>

<script setup>
import { computed } from "vue"

const props = defineProps({
  toast: Object
})

const toastIcon = computed(() => {
  return props.toast.type === "success"
    ? "bi-check-circle"
    : "bi-exclamation-circle"
})
</script>

<style scoped>
.toast-container {
  position: fixed;
  top: 20px;
  right: 20px;
  padding: 14px 18px;
  display: flex;
  align-items: center;
  gap: 10px;
  background: white;
  border-radius: 10px;
  font-weight: 500;
  min-width: 250px;
  max-width: 90vw;
  box-shadow: 0 4px 12px rgba(0,0,0,.15);
  z-index: 9999;
  border-left: 5px solid;
  word-break: break-word;
}

/* Success / Error Colors */
.toast-container.success {
  border-color: #10b981;
  color: #0f5132;
}

.toast-container.error {
  border-color: #ef4444;
  color: #7f1d1d;
}

/* Animation */
.toast-fade-enter-from,
.toast-fade-leave-to {
  opacity: 0;
  transform: translateY(-12px);
}

.toast-fade-enter-active,
.toast-fade-leave-active {
  transition: all 0.25s ease;
}

/* 📱 Mobile Responsive Enhancements */
@media (max-width: 640px) {
  .toast-container {
    top: 10px;
    right: 50%;
    transform: translateX(50%);
    width: 90%;
    padding: 12px;
    font-size: 0.9rem;
  }
}

@media (max-width: 400px) {
  .toast-container {
    border-radius: 8px;
    padding: 10px;
    font-size: 0.85rem;
  }
}

</style>
