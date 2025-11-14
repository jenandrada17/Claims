<template>
  <Toast :toast="toast" />
  <RouterView />
</template>

<script setup>
import { provide, ref } from "vue"
import Toast from "./components/Toast.vue"

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
  }, 2500)
}

provide("showToast", showToast)
</script>
  
<style>  
</style>
