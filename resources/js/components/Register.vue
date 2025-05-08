<template>
    <div class="container">
      <div class="card">
        <h2>Register</h2>
  
        <form @submit.prevent="register">
          <input type="text" v-model="name" placeholder="Name" required />
          <input type="email" v-model="email" placeholder="Email" required />
          <input type="password" v-model="password" placeholder="Password" required />
          <input type="password" v-model="passwordConfirmation" placeholder="Confirm Password" required />
          <button type="submit">Register</button>
        </form>
  
        <p class="bottom-text">
          Already have an account?
          <router-link to="/login">Login</router-link>
        </p>
  
        <p v-if="error" class="error">{{ error }}</p>
        <p v-if="success" class="success">{{ success }}</p>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { useRouter } from 'vue-router'
  import axios from '../axios'
  
  const name = ref('')
  const email = ref('')
  const password = ref('')
  const passwordConfirmation = ref('')
  const error = ref(null)
  const success = ref(null)
  const router = useRouter()
  
  const register = async () => {
    error.value = null
    success.value = null
  
    if (password.value !== passwordConfirmation.value) {
      error.value = "Passwords do not match"
      return
    }
  
    try {
      await axios.post('/api/register', {
        name: name.value,
        email: email.value,
        password: password.value,
        password_confirmation: passwordConfirmation.value
      })
  
      success.value = 'Registered successfully! Redirecting to login...'
      setTimeout(() => {
        router.push('/login')
      }, 5000)
    } catch (err) {
      error.value = err.response?.data?.message || 'Registration failed.'
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
    width: 300px;
    text-align: center;
  }
  
  h2 {
    color: #d63384;
    margin-bottom: 1rem;
  }
  
  input {
    width: 100%;
    padding: 0.6rem;
    margin-bottom: 1rem;
    border: 1px solid #d63384;
    border-radius: 8px;
    outline: none;
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
  
  .bottom-text {
    margin-top: 1rem;
    font-size: 0.9rem;
  }
  
  .bottom-text a {
    color: #d63384;
    text-decoration: none;
    font-weight: bold;
  }
  
  .error {
    color: red;
    margin-top: 1rem;
  }
  
  .success {
    color: green;
    margin-top: 1rem;
  }
  </style>