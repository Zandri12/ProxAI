<template>
  <div
    :class="[
      'inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors',
      {
        'border-transparent bg-blue-600 text-white': variant === 'default',
        'border-transparent bg-gray-100 text-gray-800': variant === 'secondary',
        'border-transparent bg-red-600 text-white': variant === 'destructive',
        'border-gray-300 bg-white text-gray-700': variant === 'outline'
      }
    ]"
  >
    <slot />
  </div>
</template>

<script setup>
defineProps({
  variant: {
    type: String,
    default: 'default',
    validator: (value) => ['default', 'secondary', 'destructive', 'outline'].includes(value)
  }
})
</script>
