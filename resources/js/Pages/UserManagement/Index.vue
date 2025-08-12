<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        User Management
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <h1 class="text-3xl font-bold tracking-tight">Users</h1>
              <p class="text-gray-600">Manage your application users and their roles</p>
            </div>
            <button @click="openCreateModal" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 w-full sm:w-auto">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
              </svg>
              Add User
            </button>
          </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid gap-4 md:grid-cols-3 mb-8">
          <div class="rounded-lg border bg-white shadow-sm p-6">
            <div class="flex flex-row items-center justify-between space-y-0 pb-2">
              <h3 class="text-sm font-medium">Total Users</h3>
              <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
              </svg>
            </div>
            <div class="text-2xl font-bold">{{ users.data?.length || 0 }}</div>
            <p class="text-xs text-gray-500">Active users in system</p>
          </div>

          <div class="rounded-lg border bg-white shadow-sm p-6">
            <div class="flex flex-row items-center justify-between space-y-0 pb-2">
              <h3 class="text-sm font-medium">Total Roles</h3>
              <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
              </svg>
            </div>
            <div class="text-2xl font-bold">{{ roles.length || 0 }}</div>
            <p class="text-xs text-gray-500">Available roles</p>
          </div>

          <div class="rounded-lg border bg-white shadow-sm p-6">
            <div class="flex flex-row items-center justify-between space-y-0 pb-2">
              <h3 class="text-sm font-medium">Total Permissions</h3>
              <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
            </div>
            <div class="text-2xl font-bold">{{ permissions.length || 0 }}</div>
            <p class="text-xs text-gray-500">System permissions</p>
          </div>
        </div>

        <!-- Main Content -->
        <div class="rounded-lg border bg-white shadow-sm p-6">
          <h3 class="text-2xl font-semibold mb-2">User List</h3>
          <p class="text-sm text-gray-600 mb-4">A comprehensive list of all users in your system</p>
          
          <!-- Loading State -->
          <div v-if="loading" class="text-center py-12">
            <div class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12H4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Loading users...
            </div>
          </div>

          <!-- Error State -->
          <div v-else-if="error" class="text-center py-12">
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
              <div class="flex flex-col items-center">
                <svg class="h-12 w-12 text-red-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <h3 class="text-lg font-semibold text-red-800 mb-2">Error loading data</h3>
                <p class="text-red-700 mb-4">{{ error }}</p>
                <div class="flex gap-2">
                  <button @click="retryLoad" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">Retry</button>
                  <button v-if="!page.props.auth.user" @click="goToLogin" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Go to Login</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Users Data -->
          <div v-else class="space-y-4">
            <!-- Empty State -->
            <div v-if="users.data?.length === 0" class="text-center py-12">
              <div class="text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                </svg>
                <h3 class="text-lg font-semibold mb-2">No users found</h3>
                <p class="text-sm mb-6">Get started by creating a new user.</p>
                <button @click="openCreateModal" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                  </svg>
                  Add User
                </button>
              </div>
            </div>

            <!-- Users List -->
            <div v-else class="space-y-4">
              <div v-for="user in users.data" :key="user.id" class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                <div class="flex items-center space-x-4">
                  <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-blue-600 font-semibold text-lg">{{ user.name.charAt(0).toUpperCase() }}</span>
                  </div>
                  <div>
                    <h4 class="font-semibold">{{ user.name }}</h4>
                    <p class="text-sm text-gray-600">{{ user.email }}</p>
                    <div class="flex gap-2 mt-1">
                      <span v-for="role in user.roles" :key="role.id" class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-gray-100 text-gray-800">
                        {{ role.name }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="flex items-center space-x-2">
                  <span class="text-sm text-gray-500">{{ formatDate(user.created_at) }}</span>
                  <button @click="openEditModal(user)" class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-50 text-sm">
                    Edit
                  </button>
                  <button @click="deleteUser(user.id)" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">
                    Delete
                  </button>
                </div>
              </div>
            </div>

            <!-- Pagination -->
            <div v-if="users.links && users.links.length > 3" class="flex justify-center pt-6">
              <nav class="flex space-x-1">
                <button
                  v-for="(link, index) in users.links"
                  :key="index"
                  :disabled="link.url === null"
                  :class="[
                    'px-3 py-2 text-sm font-medium rounded-md border',
                    link.active ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'
                  ]"
                  @click="loadPage(link.url)"
                  v-html="link.label"
                />
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Create/Edit User Modal -->
    <UserModal
      :show="showModal"
      :user="editingUser"
      :roles="roles"
      @close="closeModal"
      @saved="onUserSaved"
    />
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import UserModal from '@/Components/UserModal.vue'
import axios from '@/lib/axios'

const page = usePage()

const users = ref({ data: [], links: [] })
const roles = ref([])
const permissions = ref([])
const showModal = ref(false)
const editingUser = ref(null)
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
  try {
    loading.value = true
    error.value = null
    
    // Test authentication first
    if (!page.props.auth.user) {
      error.value = 'User not authenticated. Please login first.'
      loading.value = false
      return
    }
    
    // Test API authentication with session-based auth
    try {
      // Test authentication using web routes
      const authTest = await axios.get('/api/auth-test')
    } catch (authErr) {
      if (authErr.response?.status === 401) {
        error.value = 'Authentication failed. Please login again.'
        loading.value = false
        return
      }
    }
    
    await Promise.all([loadUsers(), loadRoles(), loadPermissions()])
  } catch (err) {
    if (err.response?.status === 401) {
      error.value = 'Authentication required. Please login again.'
    } else if (err.response?.status === 403) {
      error.value = 'Access denied. You do not have permission to view users.'
    } else if (err.response?.status === 500) {
      error.value = 'Server error. Please try again later.'
    } else {
      error.value = `Error loading users: ${err.response?.data?.message || err.message}`
    }
    throw err
  } finally {
    loading.value = false
  }
})

const loadUsers = async (page = null) => {
  try {
    const url = page || '/api/users'
    const response = await axios.get(url)
    users.value = response.data.data
  } catch (err) {
    if (err.response?.status === 401) {
      error.value = 'Authentication required. Please login again.'
    } else if (err.response?.status === 403) {
      error.value = 'Access denied. You do not have permission to view users.'
    } else if (err.response?.status === 500) {
      error.value = 'Server error. Please try again later.'
    } else {
      error.value = `Error loading users: ${err.response?.data?.message || err.message}`
    }
    throw err
  }
}

const loadRoles = async () => {
  try {
    const url = '/api/roles'
    const response = await axios.get(url)
    roles.value = response.data.data
  } catch (err) {
    if (err.response?.status === 401) {
      error.value = 'Authentication required. Please login again.'
    } else if (err.response?.status === 403) {
      error.value = 'Access denied. You do not have permission to view roles.'
    } else if (err.response?.status === 500) {
      error.value = 'Server error. Please try again later.'
    } else {
      error.value = `Error loading roles: ${err.response?.data?.message || err.message}`
    }
    throw err
  }
}

const loadPermissions = async () => {
  try {
    const url = '/api/permissions'
    const response = await axios.get(url)
    permissions.value = response.data.data || []
  } catch (err) {
    // If permissions endpoint doesn't exist, create dummy data
    permissions.value = [
      { id: 1, name: 'user.view', display_name: 'View Users', description: 'Can view user list', module: 'user', action: 'view' },
      { id: 2, name: 'user.create', display_name: 'Create Users', description: 'Can create new users', module: 'user', action: 'create' },
      { id: 3, name: 'user.edit', display_name: 'Edit Users', description: 'Can edit existing users', module: 'user', action: 'edit' },
      { id: 4, name: 'user.delete', display_name: 'Delete Users', description: 'Can delete users', module: 'user', action: 'delete' },
      { id: 5, name: 'role.view', display_name: 'View Roles', description: 'Can view role list', module: 'role', action: 'view' },
      { id: 6, name: 'role.create', display_name: 'Create Roles', description: 'Can create new roles', module: 'role', action: 'create' },
      { id: 7, name: 'role.edit', display_name: 'Edit Roles', description: 'Can edit existing roles', module: 'role', action: 'edit' },
      { id: 8, name: 'role.delete', display_name: 'Delete Roles', description: 'Can delete roles', module: 'role', action: 'delete' }
    ]
  }
}

const loadPage = async (url) => {
  if (url) {
    await loadUsers(url)
  }
}

const openCreateModal = () => {
  editingUser.value = null
  showModal.value = true
}

const openEditModal = (user) => {
  editingUser.value = { ...user }
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  editingUser.value = null
}

const onUserSaved = async () => {
  closeModal()
  await loadUsers()
}

const deleteUser = async (userId) => {
  if (confirm('Are you sure you want to delete this user?')) {
    try {
      const url = `/api/users/${userId}`
      await axios.delete(url)
      await loadUsers()
    } catch (error) {
      alert('Error deleting user')
    }
  }
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString()
}

const retryLoad = async () => {
  try {
    loading.value = true
    error.value = null
    await Promise.all([loadUsers(), loadRoles(), loadPermissions()])
  } catch (err) {
    error.value = err.message
  } finally {
    loading.value = false
  }
}

const goToLogin = () => {
  window.location.href = '/login'
}
</script>
