<template>
  <div class="w-full">
    <!-- Search Bar -->
    <div class="mb-4">
      <div class="relative">
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Search..."
          class="w-64 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
        />
        <svg
          class="absolute right-3 top-2.5 h-4 w-4 text-gray-400"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
          />
        </svg>
      </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left">
              <input
                v-model="selectAll"
                type="checkbox"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
              />
            </th>
            <th
              v-for="column in columns"
              :key="column.key"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100"
              @click="sortBy(column.key)"
            >
              <div class="flex items-center space-x-1">
                <span>{{ column.label }}</span>
                <svg
                  v-if="sortKey === column.key"
                  class="h-4 w-4"
                  :class="sortOrder === 'asc' ? 'rotate-180' : ''"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
              </div>
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Actions
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr
            v-for="item in filteredData"
            :key="item.id"
            class="hover:bg-gray-50"
          >
            <td class="px-6 py-4 whitespace-nowrap">
              <input
                v-model="selectedItems"
                :value="item.id"
                type="checkbox"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
              />
            </td>
            <td
              v-for="column in columns"
              :key="column.key"
              class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
            >
              <slot
                :name="`cell-${column.key}`"
                :item="item"
                :value="item[column.key]"
              >
                <span v-if="column.type === 'badge'">
                  <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                  >
                    {{ item[column.key] }}
                  </span>
                </span>
                <span v-else-if="column.type === 'status'">
                  <div class="flex items-center space-x-2">
                    <span
                      class="inline-flex items-center justify-center w-2 h-2 rounded-full"
                      :class="getStatusColor(item[column.key])"
                    ></span>
                    <span>{{ item[column.key] }}</span>
                  </div>
                </span>
                <span v-else>
                  {{ item[column.key] }}
                </span>
              </slot>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <slot name="actions" :item="item">
                <div class="flex items-center space-x-2">
                  <button
                    @click="$emit('edit', item)"
                    class="text-blue-600 hover:text-blue-900"
                  >
                    Edit
                  </button>
                  <button
                    @click="$emit('delete', item)"
                    class="text-red-600 hover:text-red-900"
                  >
                    Delete
                  </button>
                </div>
              </slot>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Selection Info -->
    <div class="mt-4 p-4 bg-gray-50 rounded-lg" v-if="selectedItems.length > 0">
      <div class="flex items-center justify-between">
        <span class="text-sm text-gray-700">
          {{ selectedItems.length }} of {{ totalItems }} row(s) selected.
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const props = defineProps({
  data: {
    type: Array,
    required: true
  },
  columns: {
    type: Array,
    required: true
  }
})

const emit = defineEmits(['edit', 'delete', 'selection-change'])

// Reactive data
const searchQuery = ref('')
const sortKey = ref('')
const sortOrder = ref('asc')
const selectedItems = ref([])

// Computed properties
const filteredData = computed(() => {
  let filtered = [...props.data]
  
  if (searchQuery.value) {
    filtered = filtered.filter(item =>
      Object.values(item).some(value =>
        String(value).toLowerCase().includes(searchQuery.value.toLowerCase())
      )
    )
  }
  
  if (sortKey.value) {
    filtered.sort((a, b) => {
      const aVal = a[sortKey.value]
      const bVal = b[sortKey.value]
      
      if (sortOrder.value === 'asc') {
        return aVal > bVal ? 1 : -1
      } else {
        return aVal < bVal ? 1 : -1
      }
    })
  }
  
  return filtered
})

const totalItems = computed(() => filteredData.value.length)

const selectAll = computed({
  get() {
    return selectedItems.value.length === filteredData.value.length && filteredData.value.length > 0
  },
  set(value) {
    if (value) {
      selectedItems.value = filteredData.value.map(item => item.id)
    } else {
      selectedItems.value = []
    }
    emit('selection-change', selectedItems.value)
  }
})

// Methods
const sortBy = (key) => {
  if (sortKey.value === key) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc'
  } else {
    sortKey.value = key
    sortOrder.value = 'asc'
  }
}

const getStatusColor = (status) => {
  const colors = {
    'Active': 'bg-green-500',
    'Inactive': 'bg-red-500',
    'Pending': 'bg-yellow-500'
  }
  return colors[status] || 'bg-gray-500'
}

// Watch for changes
watch(selectedItems, (newSelection) => {
  emit('selection-change', newSelection)
}, { deep: true })

watch(searchQuery, () => {
  // Reset selection when search changes
  selectedItems.value = []
})
</script>
