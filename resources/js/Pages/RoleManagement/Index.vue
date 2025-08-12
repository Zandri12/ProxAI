<template>
  <Head title="Role Management" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Role Management
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <!-- Header with Add Role Button -->
            <div class="flex justify-between items-center mb-6">
              <div>
                <h3 class="text-lg font-medium text-gray-900">Roles</h3>
                <p class="text-sm text-gray-600">Manage user roles and permissions</p>
              </div>
              <button
                @click="openCreateModal"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add Role
              </button>
            </div>

            <!-- DataTable -->
            <div v-if="loading" class="text-center py-12">
              <div class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12H4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading roles from database...
              </div>
            </div>
            
            <DataTable
              v-else
              :data="roles"
              :columns="columns"
              @edit="openEditModal"
              @delete="confirmDelete"
              @selection-change="handleSelectionChange"
            >
              <!-- Custom cell for Status -->
              <template #cell-status="{ item }">
                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                  :class="item.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                >
                  {{ item.is_active ? 'Active' : 'Inactive' }}
                </span>
              </template>

              <!-- Custom cell for Permissions -->
              <template #cell-permissions="{ item }">
                <div class="flex flex-wrap gap-1">
                  <span
                    v-for="permission in item.permissions"
                    :key="permission.id"
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800"
                  >
                    {{ permission.display_name }}
                  </span>
                </div>
              </template>

              <!-- Custom cell for Created Date -->
              <template #cell-created_at="{ item }">
                {{ formatDate(item.created_at) }}
              </template>

              <!-- Custom cell for Updated Date -->
              <template #cell-updated_at="{ item }">
                {{ formatDate(item.updated_at) }}
              </template>

              <!-- Custom Actions -->
              <template #actions="{ item }">
                <div class="flex items-center space-x-2">
                  <button
                    @click="openEditModal(item)"
                    class="text-blue-600 hover:text-blue-900 text-sm font-medium"
                  >
                    Edit
                  </button>
                  <button
                    @click="confirmDelete(item)"
                    class="text-red-600 hover:text-red-900 text-sm font-medium"
                  >
                    Delete
                  </button>
                </div>
              </template>
            </DataTable>

            <!-- Bulk Actions -->
            <div v-if="selectedRoles.length > 0" class="mt-4 p-4 bg-gray-50 rounded-lg">
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-700">
                  {{ selectedRoles.length }} role(s) selected
                </span>
                <div class="flex space-x-2">
                  <button
                    @click="bulkActivate"
                    class="px-3 py-1 text-sm font-medium text-green-700 bg-green-100 border border-green-300 rounded-md hover:bg-green-200"
                  >
                    Activate
                  </button>
                  <button
                    @click="bulkDeactivate"
                    class="px-3 py-1 text-sm font-medium text-red-700 bg-red-100 border border-red-300 rounded-md hover:bg-red-200"
                  >
                    Deactivate
                  </button>
                  <button
                    @click="bulkDelete"
                    class="px-3 py-1 text-sm font-medium text-red-700 bg-red-100 border border-red-300 rounded-md hover:bg-red-200"
                  >
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
      @close="closeModal"
      @saved="handleRoleSaved"
    />
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import DataTable from '@/Components/DataTable.vue'
import RoleModal from '@/Components/RoleModal.vue'
import axios from '@/lib/axios'

// Props
const props = defineProps({
  roles: {
    type: Array,
    default: () => []
  }
})

// Reactive data
const roles = ref([])
const showModal = ref(false)
const editingRole = ref(null)
const selectedRoles = ref([])
const loading = ref(false)

// Table columns configuration
const columns = [
  {
    key: 'id',
    label: 'ID',
    type: 'text'
  },
  {
    key: 'name',
    label: 'Name',
    type: 'text'
  },
  {
    key: 'slug',
    label: 'Slug',
    type: 'text'
  },
  {
    key: 'description',
    label: 'Description',
    type: 'text'
  },
  {
    key: 'status',
    label: 'Status',
    type: 'status'
  },
  {
    key: 'permissions',
    label: 'Permissions',
    type: 'text'
  },
  {
    key: 'created_at',
    label: 'Created',
    type: 'date'
  },
  {
    key: 'updated_at',
    label: 'Updated',
    type: 'date'
  }
]

// Methods
const loadRoles = async () => {
  try {
    loading.value = true
    console.log('Loading roles...')
    const response = await axios.get('/api/roles')
    console.log('API Response:', response)
    roles.value = response.data.data || response.data // Handle both paginated and non-paginated responses
    console.log('Roles loaded:', roles.value)
  } catch (error) {
    console.error('Error loading roles:', error)
    // Show user-friendly error message
    alert('Error loading roles. Please refresh the page.')
  } finally {
    loading.value = false
    console.log('Loading finished, roles count:', roles.value.length)
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

const handleRoleSaved = async () => {
  closeModal()
  // Force refresh data from database
  await loadRoles()
}

const confirmDelete = (role) => {
  if (confirm(`Are you sure you want to delete role "${role.name}"?`)) {
    deleteRole(role.id)
  }
}

const deleteRole = async (roleId) => {
  try {
    loading.value = true
    await axios.delete(`/api/roles/${roleId}`)
    // Force refresh data from database
    await loadRoles()
    console.log('Role deleted and data refreshed from database')
  } catch (error) {
    console.error('Error deleting role:', error)
    alert('Error deleting role. Please try again.')
  } finally {
    loading.value = false
  }
}

const handleSelectionChange = (selection) => {
  selectedRoles.value = selection
}

const bulkActivate = async () => {
  try {
    loading.value = true
    await Promise.all(
      selectedRoles.value.map(roleId =>
        axios.put(`/api/roles/${roleId}`, { is_active: true })
      )
    )
    // Force refresh data from database
    await loadRoles()
    selectedRoles.value = []
    console.log('Roles activated and data refreshed from database')
  } catch (error) {
    console.error('Error activating roles:', error)
    alert('Error activating roles. Please try again.')
  } finally {
    loading.value = false
  }
}

const bulkDeactivate = async () => {
  try {
    loading.value = true
    await Promise.all(
      selectedRoles.value.map(roleId =>
        axios.put(`/api/roles/${roleId}`, { is_active: false })
      )
    )
    // Force refresh data from database
    await loadRoles()
    selectedRoles.value = []
    console.log('Roles deactivated and data refreshed from database')
  } catch (error) {
    console.error('Error deactivating roles:', error)
    alert('Error deactivating roles. Please try again.')
  } finally {
    loading.value = false
  }
}

const bulkDelete = async () => {
  if (confirm(`Are you sure you want to delete ${selectedRoles.value.length} roles?`)) {
    try {
      loading.value = true
      await Promise.all(
        selectedRoles.value.map(roleId =>
          axios.delete(`/api/roles/${roleId}`)
        )
      )
      // Force refresh data from database
      await loadRoles()
      selectedRoles.value = []
      console.log('Roles deleted and data refreshed from database')
    } catch (error) {
      console.error('Error deleting roles:', error)
      alert('Error deleting roles. Please try again.')
    } finally {
      loading.value = false
    }
  }
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

// Lifecycle
onMounted(() => {
  loadRoles()
  
  // Auto-refresh data every 30 seconds to ensure it's always fresh from database
  const interval = setInterval(() => {
    if (!showModal.value) { // Don't refresh if modal is open
      console.log('Auto-refreshing roles from database...')
      loadRoles()
    }
  }, 30000) // 30 seconds
  
  // Cleanup interval on component unmount
  onUnmounted(() => {
    clearInterval(interval)
  })
})
</script>

