<template>
  <section class="p-6">
    <h1 class="text-xl font-bold mb-4">Home</h1>
    <button @click="ping" class="px-3 py-2 rounded bg-gray-200">Button</button>
    <pre class="mt-4 bg-gray-50 p-3 rounded border" v-if="result">{{ result }}</pre>
    <p class="mt-4 text-red-600" v-if="error">{{ error }}</p>
    <p class="mt-6"><router-link to="/login">Logout</router-link></p>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import { api } from '../lib/api'
const result = ref(''); const error = ref('');
async function ping() {
  result.value = ''; error.value = '';
  try { const { data } = await api.get('/ping'); result.value = JSON.stringify(data, null, 2); }
  catch (e) { error.value = e?.response?.data?.message || e.message; }
}
</script>
