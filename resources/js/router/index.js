import { createRouter, createWebHistory } from 'vue-router'
import axios from '../axios'
import Login from '../components/Login.vue'
import Register from '../components/Register.vue'
import Dashboard from '../components/Dashboard.vue'
import TaskForm from '../components/TaskForm.vue'

const routes = [
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { 
    path: '/dashboard',
    component: Dashboard,
    meta: { requiresAuth: true }
  },
  {
    path: '/tasks/new',
    component: TaskForm,
    meta: { requiresAuth: true }
  },
  { path: '/', redirect: '/login' }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Route guard
router.beforeEach(async (to, from, next) => {
  const requiresAuth = to.meta.requiresAuth
  let isAuthenticated = false

  try {
    const res = await axios.get('/api/user')
    isAuthenticated = !!res.data
  } catch (err) {
    isAuthenticated = false
  }

  if (requiresAuth && !isAuthenticated) {
    next('/login')
  } else if ((to.path === '/login' || to.path === '/register') && isAuthenticated) {
    next('/dashboard')
  } else {
    next()
  }
})

export default router