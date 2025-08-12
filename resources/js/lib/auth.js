import axios from 'axios'

// Set up axios defaults
// axios.defaults.baseURL = '/api' // Commented out to avoid double /api
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

// Add request interceptor to include token
axios.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

// Add response interceptor to handle token expiration
axios.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      // Token expired or invalid, redirect to login
      localStorage.removeItem('token')
      window.location.href = '/login'
    }
    return Promise.reject(error)
  }
)

export const authService = {
  // Set token after successful login
  setToken(token) {
    localStorage.setItem('token', token)
  },

  // Get current token
  getToken() {
    return localStorage.getItem('token')
  },

  // Remove token on logout
  removeToken() {
    localStorage.removeItem('token')
  },

  // Check if user is authenticated
  isAuthenticated() {
    return !!this.getToken()
  },

  // Login with email and password
  async login(email, password) {
    try {
      const response = await axios.post('/login', { email, password })
      if (response.data.token) {
        this.setToken(response.data.token)
        return response.data
      }
      throw new Error('No token received')
    } catch (error) {
      throw error
    }
  },

  // Logout
  async logout() {
    try {
      await axios.post('/logout')
    } catch (error) {
      console.error('Logout error:', error)
    } finally {
      this.removeToken()
    }
  }
}

export default authService
