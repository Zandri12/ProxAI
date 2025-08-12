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
                {{ editingRole ? 'Edit Role' : 'Create New Role' }}
              </h3>
              
              <form @submit.prevent="saveRole" class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700">Role Name</label>
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
                  <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                  <div class="max-h-48 overflow-y-auto border border-gray-300 rounded-md p-3">
                    <div class="space-y-2">
                      <div v-for="permission in availablePermissions" :key="permission.id" class="flex items-center">
                        <input
                          :id="'permission-' + permission.id"
                          type="checkbox"
                          :value="permission.id"
                          v-model="form.permissions"
                          class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        />
                        <label :for="'permission-' + permission.id" class="ml-2 text-sm text-gray-700">
                          {{ permission.name }}
                          <span class="text-gray-500 text-xs block">{{ permission.description }}</span>
                        </label>
                      </div>
                    </div>
                  </div>
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
                    {{ loading ? 'Saving...' : (editingRole ? 'Update Role' : 'Create Role') }}
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
import { ref, watch, computed } from 'vue'
import axios from '@/lib/axios'

const props = defineProps({
  show: Boolean,
  role: Object,
  permissions: Array
})

const emit = defineEmits(['close', 'saved'])

const form = ref({
  name: '',
  display_name: '',
  description: '',
  permissions: []
})

const editingRole = ref(null)
const loading = ref(false)

watch(() => props.role, (newRole) => {
  editingRole.value = newRole
  if (newRole) {
    form.value = {
      name: newRole.name,
      display_name: newRole.display_name || newRole.name,
      description: newRole.description || '',
      permissions: newRole.permissions?.map(p => p.id) || []
    }
  } else {
    form.value = {
      name: '',
      display_name: '',
      description: '',
      permissions: []
    }
  }
}, { immediate: true })

const availablePermissions = computed(() => {
  return props.permissions || []
})

const saveRole = async () => {
  try {
    loading.value = true
    
    if (editingRole.value) {
      // Update existing role
      const url = `/api/roles/${editingRole.value.id}`
      await axios.put(url, form.value)
    } else {
      // Create new role
      await axios.post('/api/roles', form.value)
    }
    
    emit('saved')
  } catch (error) {
    console.error('Error saving role:', error)
    if (error.response?.data?.errors) {
      // Handle validation errors
      const errors = error.response.data.errors
      Object.keys(errors).forEach(field => {
        alert(`${field}: ${errors[field][0]}`)
      })
    } else {
      alert(error.response?.data?.message || 'Error saving role')
    }
  } finally {
    loading.value = false
  }
}
</script>
