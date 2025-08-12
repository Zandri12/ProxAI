<template>
  <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 transition-opacity" aria-hidden="true">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
      </div>

      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
              <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                {{ editingUser ? 'Edit User' : 'Create User' }}
              </h3>
              
              <form @submit.prevent="saveUser" class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700">Name</label>
                  <input v-model="form.name" type="text" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" required />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700">Email</label>
                  <input v-model="form.email" type="email" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" required />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700">Password</label>
                  <input v-model="form.password" type="password" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" :required="!editingUser" />
                  <p v-if="editingUser" class="text-xs text-gray-500 mt-1">Leave blank to keep current password</p>
                </div>
                
                <div v-if="!editingUser">
                  <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                  <input v-model="form.password_confirmation" type="password" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" required />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700">Roles</label>
                  <select v-model="form.role_ids" multiple class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
                  </select>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                  <button type="button" @click="$emit('close')" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50" :disabled="loading">
                    Cancel
                  </button>
                  <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed" :disabled="loading">
                    <svg v-if="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12H4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ loading ? 'Saving...' : (editingUser ? 'Update' : 'Create') }}
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
import { ref, watch } from 'vue'
import axios from '@/lib/axios'

const props = defineProps({
  show: Boolean,
  user: Object,
  roles: Array
})

const emit = defineEmits(['close', 'saved'])

const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  role_ids: []
})

const editingUser = ref(null)
const loading = ref(false)

watch(() => props.user, (newUser) => {
  editingUser.value = newUser
  if (newUser) {
    form.value = {
      name: newUser.name,
      email: newUser.email,
      password: '',
      password_confirmation: '',
      role_ids: newUser.roles?.map(r => r.id) || []
    }
  } else {
    form.value = {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      role_ids: []
    }
  }
}, { immediate: true })

const saveUser = async () => {
  try {
    loading.value = true
    
    if (editingUser.value) {
      // Update existing user
      const url = `/api/users/${editingUser.value.id}`
      await axios.put(url, form.value)
    } else {
      // Create new user
      await axios.post('/api/users', form.value)
    }
    
    emit('saved')
  } catch (error) {
    console.error('Error saving user:', error)
    if (error.response?.data?.errors) {
      // Handle validation errors
      const errors = error.response.data.errors
      Object.keys(errors).forEach(field => {
        alert(`${field}: ${errors[field][0]}`)
      })
    } else {
      alert(error.response?.data?.message || 'Error saving user')
    }
  } finally {
    loading.value = false
  }
}
</script>
