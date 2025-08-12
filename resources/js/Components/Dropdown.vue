<template>
  <div class="relative" ref="dropdownRef">
    <div @click="toggleDropdown">
      <slot name="trigger" />
    </div>

    <transition
      enter-active-class="transition ease-out duration-100"
      enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <div 
        v-if="open" 
        :class="[
          'absolute z-50 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5',
          align === 'right' ? 'right-0' : 'left-0'
        ]"
      >
        <slot />
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue'

const props = defineProps({
  align: {
    type: String,
    default: 'left'
  },
  width: {
    type: String,
    default: '48'
  }
})

const open = ref(false)
const dropdownRef = ref(null)

const toggleDropdown = () => {
  open.value = !open.value
  console.log('Dropdown toggled:', open.value)
}

const closeOnEscape = (e) => {
  if (open.value && e.key === 'Escape') {
    open.value = false
  }
}

const closeOnClickOutside = (e) => {
  if (open.value && dropdownRef.value && !dropdownRef.value.contains(e.target)) {
    open.value = false
  }
}

const closeDropdown = () => {
  open.value = false
}

onMounted(() => {
  document.addEventListener('keydown', closeOnEscape)
  document.addEventListener('click', closeOnClickOutside)
  
  console.log('Dropdown component mounted')
})

onUnmounted(() => {
  document.removeEventListener('keydown', closeOnEscape)
  document.removeEventListener('click', closeOnClickOutside)
})
</script>
