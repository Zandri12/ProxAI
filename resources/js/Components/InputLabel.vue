<template>
  <label :for="for" class="block font-medium text-sm text-gray-700">
    <slot />
  </label>
</template>

<script setup>
defineProps({
  for: {
    type: String,
    default: ''
  }
})
</script>
