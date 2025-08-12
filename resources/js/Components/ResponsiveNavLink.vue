<template>
  <Link
    :href="href"
    :class="[
      'block w-full pl-3 pr-4 py-2 border-l-4 text-left text-base font-medium leading-6 transition duration-150 ease-in-out',
      $attrs.class,
      active
        ? 'bg-indigo-50 border-indigo-400 text-indigo-700 focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700'
        : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300'
    ]"
    v-bind="$attrs"
  >
    <slot />
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  href: {
    type: String,
    required: true
  },
  active: {
    type: Boolean,
    default: false
  }
})
</script>
