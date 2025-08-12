import axios from 'axios'

// Set default configuration
axios.defaults.withCredentials = true
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['Accept'] = 'application/json'

// Add request interceptor to include CSRF token
axios.interceptors.request.use(function (config) {
    // Get CSRF token from meta tag
    const token = document.querySelector('meta[name="csrf-token"]')
    if (token) {
        config.headers['X-CSRF-TOKEN'] = token.getAttribute('content')
    }
    
    // Ensure credentials are included
    config.withCredentials = true
    
    return config
}, function (error) {
    return Promise.reject(error)
})

// Add response interceptor for better error handling
axios.interceptors.response.use(function (response) {
    return response
}, function (error) {
    // Handle authentication errors
    if (error.response?.status === 401) {
        // Redirect to login if unauthorized
        window.location.href = '/login'
    }
    
    return Promise.reject(error)
})

export default axios
