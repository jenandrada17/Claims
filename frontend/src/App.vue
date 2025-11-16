<template>
  <Toast :toast="toast" />

  <!-- <div class="page-label mt-3">
    {{ pageLabel }}
  </div> -->

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

const pageLabel = ref("Patients"); 
function setPageLabel(label) {
  pageLabel.value = label;
}

provide("setPageLabel", setPageLabel); 
provide("showToast", showToast)
</script>
  
<style>  
</style>
