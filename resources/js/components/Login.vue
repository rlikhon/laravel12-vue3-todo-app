<template>
    <div class="container">
      <div class="card">
        <h2>Login</h2>
        <form @submit.prevent="login">
          <input v-model="form.email" type="email" placeholder="Email" required />
          <input v-model="form.password" type="password" placeholder="Password" required />
          <button type="submit">Login</button>
        </form>
  
        <p class="bottom-text">
          Don't have an account? <router-link to="/register">Register</router-link>
        </p>
  
        <p v-if="error" class="error">{{ error }}</p>
      </div>
    </div>
  </template>
  
  <script>
import axios from '../axios'

export default {
  data() {
    return {
      form: {
        email: '',
        password: ''
      },
      error: ''
    }
  },
  methods: {
    async login() {
      this.error = ''

      try {
        // Get CSRF cookie before submitting the login request
        await axios.get('/sanctum/csrf-cookie')

        // Submit login request
        const response = await axios.post('/api/login', this.form)

        // Store the token in localStorage
        localStorage.setItem('auth_token', response.data.token)

        // Redirect to dashboard after successful login
        this.$router.push('/dashboard')
      } catch (err) {
        this.error = 'Invalid credentials or server error.'
      }
    }
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
  </style>