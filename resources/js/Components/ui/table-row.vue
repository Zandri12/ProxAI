<template>
  <tr
    :class="[
      'border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted',
      className
    ]"
    v-bind="$attrs"
  >
    <slot />
  </tr>
</template>

<script setup>
defineProps({
  className: {
    type: String,
    default: ''
  }
})
</script>
