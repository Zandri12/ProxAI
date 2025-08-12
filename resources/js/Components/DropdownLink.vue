<template>
  <a
    :href="href"
    :class="[
      'block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out cursor-pointer',
      $attrs.class
    ]"
    v-bind="$attrs"
    @click="handleClick"
  >
    <slot />
  </a>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  href: {
    type: String,
    required: true
  },
  method: {
    type: String,
    default: 'get'
  },
  as: {
    type: String,
    default: 'a'
  }
})

const emit = defineEmits(['click'])

const handleClick = (e) => {
  if (props.method === 'post') {
    e.preventDefault()
    const form = useForm({})
    form.post(props.href)
  }
  
  emit('click', e)
}
</script>
