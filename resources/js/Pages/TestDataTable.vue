<template>
  <Head title="Test DataTable" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Test DataTable
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Testing DataTable Component</h3>
            
            <!-- Debug Info -->
            <div class="mb-4 p-4 bg-gray-50 rounded-lg">
              <h4 class="font-medium text-gray-900 mb-2">Debug Info:</h4>
              <p class="text-sm text-gray-600">Data count: {{ testData.length }}</p>
              <p class="text-sm text-gray-600">Columns count: {{ testColumns.length }}</p>
              <p class="text-sm text-gray-600">Selected items: {{ selectedItems.length }}</p>
            </div>
            
            <DataTable
              :data="testData"
              :columns="testColumns"
              @edit="handleEdit"
              @delete="handleDelete"
              @selection-change="handleSelectionChange"
            >
              <!-- Custom cell for Status -->
              <template #cell-status="{ item }">
                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                  :class="item.status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                >
                  {{ item.status }}
                </span>
              </template>

              <!-- Custom cell for Created Date -->
              <template #cell-created_at="{ item }">
                {{ formatDate(item.created_at) }}
              </template>

              <!-- Custom Actions -->
              <template #actions="{ item }">
                <div class="flex items-center space-x-2">
                  <button
                    @click="handleEdit(item)"
                    class="text-blue-600 hover:text-blue-900 text-sm font-medium"
                  >
                    Edit
                  </button>
                  <button
                    @click="handleDelete(item)"
                    class="text-red-600 hover:text-red-900 text-sm font-medium"
                  >
                    Delete
                  </button>
                </div>
              </template>
            </DataTable>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import DataTable from '@/Components/DataTable.vue'

// Test data
const testData = ref([
  {
    id: 1,
    name: 'John Doe',
    email: 'john@example.com',
    status: 'Active',
    created_at: '2025-01-01T00:00:00Z'
  },
  {
    id: 2,
    name: 'Jane Smith',
    email: 'jane@example.com',
    status: 'Inactive',
    created_at: '2025-01-02T00:00:00Z'
  },
  {
    id: 3,
    name: 'Bob Johnson',
    email: 'bob@example.com',
    status: 'Active',
    created_at: '2025-01-03T00:00:00Z'
  }
])

const selectedItems = ref([])

// Test columns
const testColumns = [
  {
    key: 'id',
    label: 'ID',
    type: 'text'
  },
  {
    key: 'name',
    label: 'Name',
    type: 'text'
  },
  {
    key: 'email',
    label: 'Email',
    type: 'text'
  },
  {
    key: 'status',
    label: 'Status',
    type: 'status'
  },
  {
    key: 'created_at',
    label: 'Created',
    type: 'date'
  }
]

// Methods
const handleEdit = (item) => {
  console.log('Edit clicked for:', item)
  alert(`Edit clicked for: ${item.name}`)
}

const handleDelete = (item) => {
  console.log('Delete clicked for:', item)
  if (confirm(`Are you sure you want to delete ${item.name}?`)) {
    alert(`Delete confirmed for: ${item.name}`)
  }
}

const handleSelectionChange = (selection) => {
  selectedItems.value = selection
  console.log('Selection changed:', selection)
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

// Lifecycle
onMounted(() => {
  console.log('TestDataTable mounted')
  console.log('Test data:', testData.value)
  console.log('Test columns:', testColumns.value)
})
</script>
