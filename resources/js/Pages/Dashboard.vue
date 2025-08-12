<script setup>
import { ref, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import axios from '@/lib/axios'

const page = usePage()

const stats = ref({
  totalUsers: 0,
  activeUsers: 0,
  totalRoles: 0,
  totalPermissions: 0
})

const recentActivities = ref([])
const userGrowth = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
  // Load dashboard stats
  await loadDashboardStats()
})

const loadDashboardStats = async () => {
  try {
    loading.value = true
    error.value = null
    
    const response = await axios.get('/dashboard-data')
    
    if (response.data.success) {
      const data = response.data.data
      stats.value = data.stats
      recentActivities.value = data.recentActivities
      userGrowth.value = data.userGrowth
    }
  } catch (error) {
    console.error('Error loading dashboard stats:', error)
    error.value = 'Failed to load dashboard data'
    
    // Fallback to static data if API fails
    stats.value = {
      totalUsers: 0,
      activeUsers: 0,
      totalRoles: 0,
      totalPermissions: 0
    }
    recentActivities.value = []
  } finally {
    loading.value = false
  }
}

const navigateToUserManagement = () => {
  window.location.href = '/user-management'
}

const navigateToProfile = () => {
  window.location.href = '/profile'
}
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="mb-8">
          <h1 class="text-3xl font-bold tracking-tight">Welcome back, {{ page.props.auth.user?.name }}!</h1>
          <p class="text-gray-600">Here's what's happening with your account today.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 mb-8">
          <!-- Loading State -->
          <div v-if="loading" class="col-span-full text-center py-12">
            <div class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12H4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Loading dashboard data...
            </div>
          </div>

          <!-- Error State -->
          <div v-else-if="error" class="col-span-full text-center py-12">
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
              <div class="flex flex-col items-center">
                <svg class="h-12 w-12 text-red-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <h3 class="text-lg font-semibold text-red-800 mb-2">Error loading data</h3>
                <p class="text-red-700 mb-4">{{ error }}</p>
                <button @click="loadDashboardStats" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">Retry</button>
              </div>
            </div>
          </div>

          <!-- Stats Cards -->
          <template v-else>
            <div class="rounded-lg border bg-white shadow-sm p-6">
              <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="text-sm font-medium">Total Users</h3>
                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                </svg>
              </div>
              <div class="text-2xl font-bold">{{ stats.totalUsers || 0 }}</div>
              <p class="text-xs text-gray-500">Total registered users</p>
            </div>

            <div class="rounded-lg border bg-white shadow-sm p-6">
              <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="text-sm font-medium">Active Users</h3>
                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="text-2xl font-bold">{{ stats.activeUsers || 0 }}</div>
              <p class="text-xs text-gray-500">Currently active users</p>
            </div>

            <div class="rounded-lg border bg-white shadow-sm p-6">
              <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="text-sm font-medium">Total Roles</h3>
                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
              </div>
              <div class="text-2xl font-bold">{{ stats.totalRoles || 0 }}</div>
              <p class="text-xs text-gray-500">System roles defined</p>
            </div>

            <div class="rounded-lg border bg-white shadow-sm p-6">
              <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="text-sm font-medium">Total Permissions</h3>
                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
              </div>
              <div class="text-2xl font-bold">{{ stats.totalPermissions || 0 }}</div>
              <p class="text-xs text-gray-500">System permissions</p>
            </div>
          </template>
        </div>

        <!-- Quick Actions -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 mb-8">
          <div class="rounded-lg border bg-white shadow-sm p-6 hover:shadow-lg transition-shadow cursor-pointer" @click="navigateToUserManagement">
            <h3 class="flex items-center gap-2 font-semibold mb-2">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
              </svg>
              User Management
            </h3>
            <p class="text-sm text-gray-600 mb-2">Manage users, roles, and permissions</p>
            <p class="text-sm text-gray-500">Add, edit, or remove users and assign roles</p>
          </div>

          <div class="rounded-lg border bg-white shadow-sm p-6 hover:shadow-lg transition-shadow cursor-pointer" @click="navigateToProfile">
            <h3 class="flex items-center gap-2 font-semibold mb-2">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              Profile Settings
            </h3>
            <p class="text-sm text-gray-600 mb-2">Update your profile information</p>
            <p class="text-sm text-gray-500">Change your name, email, and password</p>
          </div>

          <div class="rounded-lg border bg-white shadow-sm p-6 hover:shadow-lg transition-shadow cursor-pointer">
            <h3 class="flex items-center gap-2 font-semibold mb-2">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
              System Logs
            </h3>
            <p class="text-sm text-gray-600 mb-2">View system activity and logs</p>
            <p class="text-sm text-gray-500">Monitor system performance and errors</p>
          </div>
        </div>

        <!-- Recent Activity -->
        <div class="rounded-lg border bg-white shadow-sm p-6">
          <h3 class="text-2xl font-semibold mb-2">Recent Activity</h3>
          <p class="text-sm text-gray-600 mb-4">Latest actions in your system</p>
          
          <!-- Loading State -->
          <div v-if="loading" class="text-center py-8">
            <div class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12H4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Loading activities...
            </div>
          </div>

          <!-- Empty State -->
          <div v-else-if="recentActivities.length === 0" class="text-center py-8">
            <div class="text-gray-500">
              <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              <h3 class="text-lg font-semibold mb-2">No recent activity</h3>
              <p class="text-sm">Activities will appear here as users interact with the system</p>
            </div>
          </div>

          <!-- Activities List -->
          <div v-else class="space-y-4">
            <div v-for="activity in recentActivities" :key="activity.id" class="flex items-center gap-4">
              <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
              <div class="flex-1">
                <p class="text-sm font-medium">{{ activity.action }}</p>
                <p class="text-xs text-gray-500">{{ activity.timestamp }}</p>
              </div>
              <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-blue-600 text-white">
                {{ activity.type }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
