<template>
  <div class="container">
    <div class="card">
      <h2>Create Task</h2>
      <form @submit.prevent="submitTask">
        <input type="text" v-model="title" placeholder="Task Title" required />
        <textarea v-model="body" placeholder="Task Description" required></textarea>
        <button type="submit">Save Task</button>
      </form>

      <p v-if="error" class="error">{{ error }}</p>
      <p v-if="success" class="success">{{ success }}</p>

      <div class="back-link">
        <router-link to="/dashboard">← Back to Dashboard</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from '../axios'

const title = ref('')
const body = ref('')
const error = ref(null)
const success = ref(null)
const router = useRouter()

const submitTask = async () => {
  error.value = null
  success.value = null
  try {
    await axios.post('/api/tasks', {
      title: title.value,
      body: body.value
    })
    success.value = 'Task created successfully!'
    setTimeout(() => {
      router.push('/dashboard')
    }, 1500)
  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to create task.'
  }
}
</script>

<style scoped>
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #ffe4e1;
}

.card {
  background: white;
  padding: 2rem;
  border-radius: 16px;
  box-shadow: 0 0 10px rgba(255, 105, 180, 0.3);
  width: 400px;
  text-align: center;
}

h2 {
  color: #d63384;
  margin-bottom: 1rem;
}

input,
textarea {
  width: 100%;
  padding: 0.6rem;
  margin-bottom: 1rem;
  border: 1px solid #d63384;
  border-radius: 8px;
  outline: none;
}

textarea {
  resize: none;
  min-height: 100px;
}

button {
  width: 100%;
  padding: 0.6rem;
  background-color: #d63384;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: bold;
  transition: background 0.3s;
}

button:hover {
  background-color: #c2185b;
}

.error {
  color: red;
  margin-top: 1rem;
}

.success {
  color: green;
  margin-top: 1rem;
}

.back-link {
  margin-top: 1.5rem;
}

.back-link a {
  text-decoration: none;
  color: #d63384;
  font-weight: bold;
}
</style>