<template>
  <thead class="[&_tr]:border-b" :class="className">
    <slot />
  </thead>
</template>

<script setup>
defineProps({
  className: {
    type: String,
    default: ''
  }
})
</script>
