import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [  
    { path: '/login', component: Login },

    // ⭐ NEW — Reset Password
    { 
      path: '/reset-password', 
      name: 'reset-password',
      component: () => import('../views/ResetPassword.vue')
    },

    // Home page (protected)
    { 
      path: '/', 
      component: Home, 
      meta: { requiresAuth: true } 
    },
  ],
}) 

export default router
