<template>
  <div class="relative">
    <button 
      @click="toggleDropdown"
      type="button"
      class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
    >
      <slot name="trigger" />
    </button>

    <div 
      v-show="open" 
      class="absolute right-0 z-50 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5"
    >
      <slot />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const open = ref(false)

const toggleDropdown = () => {
  open.value = !open.value
}
</script>
