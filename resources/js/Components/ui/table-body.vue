<template>
  <tbody class="[&_tr:last-child]:border-0" :class="className">
    <slot />
  </tbody>
</template>

<script setup>
defineProps({
  className: {
    type: String,
    default: ''
  }
})
</script>
