import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'   // JS for components that need it; harmless if unused

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import router from './router'
import App from './App.vue'
import './style.css'

createApp(App).use(createPinia()).use(router).mount('#app')
