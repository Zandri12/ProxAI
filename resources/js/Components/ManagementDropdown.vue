<template>
  <div class="relative">
    <button
      @click="open = !open"
      :class="[
        'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out',
        active
          ? 'border-indigo-400 text-gray-900 focus:outline-none focus:border-indigo-700'
          : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300'
      ]"
    >
      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4" />
      </svg>
      {{ buttonText }}
      <svg class="w-4 h-4 ml-2 transition-transform duration-150 ease-in-out" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </button>

    <div
      v-show="open"
      class="absolute right-0 z-50 mt-2 w-64 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 border border-gray-200"
    >
      <div class="py-2" role="menu" aria-orientation="vertical">
        <!-- User Management -->
        <a
          :href="route('user-management.index')"
          class="group flex items-center px-4 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition duration-150 ease-in-out"
          role="menuitem"
        >
          <svg class="mr-3 h-4 w-4 text-gray-400 group-hover:text-gray-500 transition duration-150 ease-in-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
          </svg>
          User Management
        </a>

        <!-- Role Management -->
        <a
          :href="route('role-management.index')"
          class="group flex items-center px-4 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition duration-150 ease-in-out"
          role="menuitem"
        >
          <svg class="mr-3 h-4 w-4 text-gray-400 group-hover:text-gray-500 transition duration-150 ease-in-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
          </svg>
          Role Management
        </a>

        <!-- Permission Management -->
        <a
          :href="route('permission-management.index')"
          class="group flex items-center px-4 py-2 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition duration-150 ease-in-out"
          role="menuitem"
        >
          <svg class="mr-3 h-4 w-4 text-gray-400 group-hover:text-gray-500 transition duration-150 ease-in-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
          </svg>
          Permission Management
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  buttonText: {
    type: String,
    default: 'Admin Panel'
  },
  active: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits([])

const open = ref(false)

const closeOnEscape = (e) => {
  if (open.value && e.key === 'Escape') {
    open.value = false
  }
}

const closeOnClickOutside = (e) => {
  if (open.value && !e.target.closest('.relative')) {
    open.value = false
  }
}

onMounted(() => {
  document.addEventListener('keydown', closeOnEscape)
  document.addEventListener('click', closeOnClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('keydown', closeOnEscape)
  document.removeEventListener('click', closeOnClickOutside)
})
</script>
