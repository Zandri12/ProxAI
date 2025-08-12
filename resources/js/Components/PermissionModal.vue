<template>
  <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 transition-opacity" aria-hidden="true">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
      </div>

      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
              <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                {{ editingPermission ? 'Edit Permission' : 'Create New Permission' }}
              </h3>
              
              <form @submit.prevent="savePermission" class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700">Permission Name</label>
                  <input 
                    v-model="form.name" 
                    type="text" 
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" 
                    required 
                  />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700">Display Name</label>
                  <input 
                    v-model="form.display_name" 
                    type="text" 
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" 
                    required 
                  />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700">Description</label>
                  <textarea 
                    v-model="form.description" 
                    rows="3"
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                  ></textarea>
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700">Module</label>
                  <select 
                    v-model="form.module" 
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                  >
                    <option value="">Select Module</option>
                    <option value="user">User Management</option>
                    <option value="role">Role Management</option>
                    <option value="permission">Permission Management</option>
                    <option value="system">System Settings</option>
                    <option value="report">Reports</option>
                  </select>
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700">Action</label>
                  <select 
                    v-model="form.action" 
                    class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                  >
                    <option value="">Select Action</option>
                    <option value="view">View</option>
                    <option value="create">Create</option>
                    <option value="edit">Edit</option>
                    <option value="delete">Delete</option>
                    <option value="export">Export</option>
                    <option value="import">Import</option>
                  </select>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                  <button 
                    type="button" 
                    @click="$emit('close')" 
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                    :disabled="loading"
                  >
                    Cancel
                  </button>
                  <button 
                    type="submit" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="loading"
                  >
                    <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12H4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ loading ? 'Saving...' : (editingPermission ? 'Update Permission' : 'Create Permission') }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, nextTick } from 'vue'
import axios from '@/lib/axios'

const props = defineProps({
  show: Boolean,
  permission: Object
})

const emit = defineEmits(['close', 'saved'])

const form = ref({
  name: '',
  display_name: '',
  description: '',
  module: '',
  action: ''
})

const editingPermission = ref(null)
const loading = ref(false)

// Watch for changes in the permission prop
watch(() => props.permission, async (newPermission) => {
  console.log('PermissionModal - New permission received:', newPermission)
  
  if (newPermission) {
    // Wait for next tick to ensure modal is fully rendered
    await nextTick()
    
    editingPermission.value = newPermission
    form.value = {
      name: newPermission.name || '',
      display_name: newPermission.display_name || newPermission.name || '',
      description: newPermission.description || '',
      module: newPermission.module || '',
      action: newPermission.action || ''
    }
    console.log('PermissionModal - Form populated:', form.value)
  } else {
    editingPermission.value = null
    form.value = {
      name: '',
      display_name: '',
      description: '',
      module: '',
      action: ''
    }
    console.log('PermissionModal - Form reset')
  }
}, { immediate: true })

// Also watch for show prop changes to handle modal opening
watch(() => props.show, async (newShow) => {
  if (newShow && props.permission) {
    // When modal opens, ensure form is populated
    await nextTick()
    console.log('PermissionModal - Modal opened, populating form with:', props.permission)
    form.value = {
      name: props.permission.name || '',
      display_name: props.permission.display_name || props.permission.name || '',
      description: props.permission.description || '',
      module: props.permission.module || '',
      action: props.permission.action || ''
    }
    console.log('PermissionModal - Form populated after modal open:', form.value)
  }
})

const savePermission = async () => {
  try {
    loading.value = true
    
    if (editingPermission.value) {
      // Update existing permission
      const url = `/api/permissions/${editingPermission.value.id}`
      await axios.put(url, form.value)
    } else {
      // Create new permission
      await axios.post('/api/permissions', form.value)
    }
    
    emit('saved')
  } catch (error) {
    console.error('Error saving permission:', error)
    if (error.response?.data?.errors) {
      // Handle validation errors
      const errors = error.response.data.errors
      Object.keys(errors).forEach(field => {
        alert(`${field}: ${errors[field][0]}`)
      })
    } else {
      alert(error.response?.data?.message || 'Error saving permission')
    }
  } finally {
    loading.value = false
  }
}
</script>
