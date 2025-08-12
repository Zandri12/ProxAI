<template>
  <div class="p-8">
    <h1 class="text-2xl font-bold mb-4">Simple DataTable Test</h1>
    
    <div class="mb-4">
      <p>Data count: {{ data.length }}</p>
      <p>Columns count: {{ columns.length }}</p>
    </div>
    
    <DataTable
      :data="data"
      :columns="columns"
      @edit="handleEdit"
      @delete="handleDelete"
      @selection-change="handleSelectionChange"
    />
    
    <div class="mt-4">
      <p>Selected: {{ selectedItems.length }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import DataTable from '@/Components/DataTable.vue'

const data = ref([
  { id: 1, name: 'John', email: 'john@test.com', status: 'Active' },
  { id: 2, name: 'Jane', email: 'jane@test.com', status: 'Inactive' },
  { id: 3, name: 'Bob', email: 'bob@test.com', status: 'Active' }
])

const columns = ref([
  { key: 'id', label: 'ID', type: 'text' },
  { key: 'name', label: 'Name', type: 'text' },
  { key: 'email', label: 'Email', type: 'text' },
  { key: 'status', label: 'Status', type: 'status' }
])

const selectedItems = ref([])

const handleEdit = (item) => {
  console.log('Edit:', item)
}

const handleDelete = (item) => {
  console.log('Delete:', item)
}

const handleSelectionChange = (selection) => {
  selectedItems.value = selection
  console.log('Selection:', selection)
}
</script>
