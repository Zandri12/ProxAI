<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Role Management
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <h1 class="text-3xl font-bold tracking-tight">Roles</h1>
              <p class="text-gray-600">Manage application roles and their permissions</p>
            </div>
            <button @click="openCreateModal" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 w-full sm:w-auto">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
              </svg>
              Create Role
            </button>
          </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid gap-4 md:grid-cols-3 mb-8">
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

          <div class="rounded-lg border bg-white shadow-sm p-6">
            <div class="flex flex-row items-center justify-between space-y-0 pb-2">
              <h3 class="text-sm font-medium">Active Users</h3>
              <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
              </svg>
            </div>
            <div class="text-2xl font-bold">{{ usersWithRoles.length || 0 }}</div>
            <p class="text-xs text-gray-500">Users with roles</p>
          </div>
        </div>

        <!-- Main Content -->
        <div class="rounded-lg border bg-white shadow-sm p-6">
          <h3 class="text-2xl font-semibold mb-2">Role List</h3>
          <p class="text-sm text-gray-600 mb-4">Manage all roles and their associated permissions</p>
          
          <!-- Loading State -->
          <div v-if="loading" class="text-center py-12">
            <div class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12H4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Loading roles...
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
                <button @click="retryLoad" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">Retry</button>
              </div>
            </div>
          </div>

          <!-- Roles Data -->
          <div v-else class="space-y-4">
            <!-- Empty State -->
            <div v-if="roles.length === 0" class="text-center py-12">
              <div class="text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <h3 class="text-lg font-semibold mb-2">No roles found</h3>
                <p class="text-sm mb-6">Get started by creating a new role.</p>
                <button @click="openCreateModal" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                  </svg>
                  Create Role
                </button>
              </div>
            </div>

            <!-- Roles List -->
            <div v-else class="space-y-4">
              <div v-for="role in roles" :key="role.id" class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50 transition-colors">
                <div class="flex items-center space-x-4">
                  <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                  </div>
                  <div>
                    <h4 class="font-semibold">{{ role.display_name || role.name }}</h4>
                    <p class="text-sm text-gray-600">{{ role.description || 'No description' }}</p>
                    <div class="flex gap-2 mt-1">
                      <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-indigo-100 text-indigo-800">
                        {{ role.name }}
                      </span>
                      <span v-if="role.permissions" class="text-xs text-gray-500">
                        {{ role.permissions.length }} permissions
                      </span>
                    </div>
                  </div>
                </div>
                <div class="flex items-center space-x-2">
                  <button @click="openEditModal(role)" class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-50 text-sm">
                    Edit
                  </button>
                  <button @click="deleteRole(role.id)" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">
                    Delete
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Role Modal -->
    <RoleModal
      :show="showModal"
      :role="editingRole"
      :permissions="permissions"
      @close="closeModal"
      @saved="onRoleSaved"
    />
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import RoleModal from '@/Components/RoleModal.vue'
import axios from '@/lib/axios'

const page = usePage()

const roles = ref([])
const permissions = ref([])
const usersWithRoles = ref(0)
const showModal = ref(false)
const editingRole = ref(null)
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
  try {
    loading.value = true
    error.value = null
    
    await Promise.all([loadRoles(), loadPermissions(), loadUsersWithRoles()])
  } catch (err) {
    error.value = `Error loading data: ${err.message}`
  } finally {
    loading.value = false
  }
})

const loadRoles = async () => {
  try {
    const response = await axios.get('/api/roles')
    roles.value = response.data.data || []
  } catch (err) {
    // Dummy data if API doesn't exist
    roles.value = [
      { id: 1, name: 'admin', display_name: 'Administrator', description: 'Full system access', permissions: [] },
      { id: 2, name: 'user', display_name: 'User', description: 'Basic user access', permissions: [] },
      { id: 3, name: 'moderator', display_name: 'Moderator', description: 'Content moderation access', permissions: [] }
    ]
  }
}

const loadPermissions = async () => {
  try {
    const response = await axios.get('/api/permissions')
    permissions.value = response.data.data || []
  } catch (err) {
    // Dummy data if API doesn't exist
    permissions.value = [
      { id: 1, name: 'user.view', display_name: 'View Users', description: 'Can view user list', module: 'user', action: 'view' },
      { id: 2, name: 'user.create', display_name: 'Create Users', description: 'Can create new users', module: 'user', action: 'create' },
      { id: 3, name: 'user.edit', display_name: 'Edit Users', description: 'Can edit existing users', module: 'user', action: 'edit' },
      { id: 4, name: 'user.delete', display_name: 'Delete Users', description: 'Can delete users', module: 'user', action: 'delete' }
    ]
  }
}

const loadUsersWithRoles = async () => {
  try {
    const response = await axios.get('/api/users')
    usersWithRoles.value = response.data.data?.filter(user => user.roles && user.roles.length > 0).length || 0
  } catch (err) {
    usersWithRoles.value = 0
  }
}

const openCreateModal = () => {
  editingRole.value = null
  showModal.value = true
}

const openEditModal = (role) => {
  editingRole.value = { ...role }
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  editingRole.value = null
}

const onRoleSaved = async () => {
  closeModal()
  await loadRoles()
}

const deleteRole = async (roleId) => {
  if (confirm('Are you sure you want to delete this role?')) {
    try {
      await axios.delete(`/api/roles/${roleId}`)
      await loadRoles()
    } catch (error) {
      alert('Error deleting role')
    }
  }
}

const retryLoad = async () => {
  try {
    loading.value = true
    error.value = null
    await Promise.all([loadRoles(), loadPermissions(), loadUsersWithRoles()])
  } catch (err) {
    error.value = err.message
  } finally {
    loading.value = false
  }
}
</script>
