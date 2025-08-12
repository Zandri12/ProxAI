<template>
  <Head title="Permission Management" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Permission Management
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <!-- Header with Add Permission Button -->
            <div class="flex justify-between items-center mb-6">
              <div>
                <h3 class="text-lg font-medium text-gray-900">Permissions</h3>
                <p class="text-sm text-gray-600">Manage system permissions and access control</p>
              </div>
              <button
                @click="openCreateModal"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add Permission
              </button>
            </div>

            <!-- DataTable -->
            <div v-if="loading" class="text-center py-12">
              <div class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12H4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading permissions from database...
              </div>
            </div>
            
            <DataTable
              v-else
              :data="permissions"
              :columns="columns"
              @edit="openEditModal"
              @delete="confirmDelete"
              @selection-change="handleSelectionChange"
            >
              <!-- Custom cell for Module -->
              <template #cell-module="{ item }">
                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                >
                  {{ item.module }}
                </span>
              </template>

              <!-- Custom cell for Action -->
              <template #cell-action="{ item }">
                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                >
                  {{ item.action }}
                </span>
              </template>

              <!-- Custom cell for Status -->
              <template #cell-status="{ item }">
                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                  :class="item.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                >
                  {{ item.is_active ? 'Active' : 'Inactive' }}
                </span>
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
            <div v-if="selectedPermissions.length > 0" class="mt-4 p-4 bg-gray-50 rounded-lg">
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-700">
                  {{ selectedPermissions.length }} permission(s) selected
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

    <!-- Permission Modal -->
    <PermissionModal
      :show="showModal"
      :permission="editingPermission"
      @close="closeModal"
      @saved="handlePermissionSaved"
    />
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import DataTable from '@/Components/DataTable.vue'
import PermissionModal from '@/Components/PermissionModal.vue'
import axios from '@/lib/axios'

// Props
const props = defineProps({
  permissions: {
    type: Array,
    default: () => []
  }
})

// Reactive data
const permissions = ref([])
const showModal = ref(false)
const editingPermission = ref(null)
const selectedPermissions = ref([])
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
    key: 'display_name',
    label: 'Display Name',
    type: 'text'
  },
  {
    key: 'description',
    label: 'Description',
    type: 'text'
  },
  {
    key: 'module',
    label: 'Module',
    type: 'badge'
  },
  {
    key: 'action',
    label: 'Action',
    type: 'badge'
  },
  {
    key: 'status',
    label: 'Status',
    type: 'status'
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
const loadPermissions = async () => {
  try {
    loading.value = true
    console.log('Loading permissions...')
    const response = await axios.get('/api/permissions')
    console.log('API Response:', response)
    permissions.value = response.data.data || response.data // Handle both paginated and non-paginated responses
    console.log('Permissions loaded:', permissions.value)
  } catch (error) {
    console.error('Error loading permissions:', error)
    // Show user-friendly error message
    alert('Error loading permissions. Please refresh the page.')
  } finally {
    loading.value = false
    console.log('Loading finished, permissions count:', permissions.value.length)
  }
}

const openCreateModal = () => {
  editingPermission.value = null
  showModal.value = true
}

const openEditModal = (permission) => {
  editingPermission.value = { ...permission }
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  editingPermission.value = null
}

const handlePermissionSaved = async () => {
  closeModal()
  // Force refresh data from database
  await loadPermissions()
}

const confirmDelete = (permission) => {
  if (confirm(`Are you sure you want to delete permission "${permission.display_name}"?`)) {
    deletePermission(permission.id)
  }
}

const deletePermission = async (permissionId) => {
  try {
    loading.value = true
    await axios.delete(`/api/permissions/${permissionId}`)
    // Force refresh data from database
    await loadPermissions()
    console.log('Permission deleted and data refreshed from database')
  } catch (error) {
    console.error('Error deleting permission:', error)
    alert('Error deleting permission. Please try again.')
  } finally {
    loading.value = false
  }
}

const handleSelectionChange = (selection) => {
  selectedPermissions.value = selection
}

const bulkActivate = async () => {
  try {
    loading.value = true
    await Promise.all(
      selectedPermissions.value.map(permissionId =>
        axios.put(`/api/permissions/${permissionId}`, { is_active: true })
      )
    )
    // Force refresh data from database
    await loadPermissions()
    selectedPermissions.value = []
    console.log('Permissions activated and data refreshed from database')
  } catch (error) {
    console.error('Error activating permissions:', error)
    alert('Error activating permissions. Please try again.')
  } finally {
    loading.value = false
  }
}

const bulkDeactivate = async () => {
  try {
    loading.value = true
    await Promise.all(
      selectedPermissions.value.map(permissionId =>
        axios.put(`/api/permissions/${permissionId}`, { is_active: false })
      )
    )
    // Force refresh data from database
    await loadPermissions()
    selectedPermissions.value = []
    console.log('Permissions deactivated and data refreshed from database')
  } catch (error) {
    console.error('Error deactivating permissions:', error)
    alert('Error deactivating permissions. Please try again.')
  } finally {
    loading.value = false
  }
}

const bulkDelete = async () => {
  if (confirm(`Are you sure you want to delete ${selectedPermissions.value.length} permissions?`)) {
    try {
      loading.value = true
      await Promise.all(
        selectedPermissions.value.map(permissionId =>
          axios.delete(`/api/permissions/${permissionId}`)
        )
      )
      // Force refresh data from database
      await loadPermissions()
      selectedPermissions.value = []
      console.log('Permissions deleted and data refreshed from database')
    } catch (error) {
      console.error('Error deleting permissions:', error)
      alert('Error deleting permissions. Please try again.')
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
  loadPermissions()
  
  // Auto-refresh data every 30 seconds to ensure it's always fresh from database
  const interval = setInterval(() => {
    if (!showModal.value) { // Don't refresh if modal is open
      console.log('Auto-refreshing permissions from database...')
      loadPermissions()
    }
  }, 30000) // 30 seconds
  
  // Cleanup interval on component unmount
  onUnmounted(() => {
    clearInterval(interval)
  })
})
</script>

