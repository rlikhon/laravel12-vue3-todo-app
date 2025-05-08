import axios from 'axios'

// Set base URL
axios.defaults.baseURL = 'http://127.0.0.1:8000'

// Automatically send credentials (cookies) with every request
axios.defaults.withCredentials = true

// Check if a token is stored and add it to the Authorization header
const token = localStorage.getItem('auth_token')
if (token) {
  axios.defaults.headers['Authorization'] = `Bearer ${token}`
}

export default axios