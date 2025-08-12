<template>
  <input
    :type="type"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    :class="[
      'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
      $attrs.class
    ]"
    v-bind="$attrs"
  />
</template>

<script setup>
defineProps({
  modelValue: {
    type: [String, Number],
    default: ''
  },
  type: {
    type: String,
    default: 'text'
  }
})

defineEmits(['update:modelValue'])
</script>
