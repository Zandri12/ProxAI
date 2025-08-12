<script setup>
import { ref, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const page = usePage()

const stats = ref({
  totalUsers: 0,
  activeUsers: 0,
  totalRoles: 0
})

const recentActivities = ref([
  {
    id: 1,
    action: 'User John Doe logged in',
    timestamp: '2 minutes ago',
    type: 'success'
  },
  {
    id: 2,
    action: 'New user account created',
    timestamp: '5 minutes ago',
    type: 'success'
  },
  {
    id: 3,
    action: 'Role permissions updated',
    timestamp: '10 minutes ago',
    type: 'success'
  },
  {
    id: 4,
    action: 'System backup completed',
    timestamp: '1 hour ago',
    type: 'success'
  }
])

onMounted(async () => {
  // Load dashboard stats
  await loadDashboardStats()
})

const loadDashboardStats = async () => {
  try {
    // In a real app, you would fetch this from your API
    stats.value = {
      totalUsers: 156,
      activeUsers: 142,
      totalRoles: 8
    }
  } catch (error) {
    console.error('Error loading dashboard stats:', error)
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
          <div class="rounded-lg border bg-white shadow-sm p-6">
            <div class="flex flex-row items-center justify-between space-y-0 pb-2">
              <h3 class="text-sm font-medium">Total Users</h3>
              <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
              </svg>
            </div>
            <div class="text-2xl font-bold">{{ stats.totalUsers || 0 }}</div>
            <p class="text-xs text-gray-500">+20.1% from last month</p>
          </div>

          <div class="rounded-lg border bg-white shadow-sm p-6">
            <div class="flex flex-row items-center justify-between space-y-0 pb-2">
              <h3 class="text-sm font-medium">Active Users</h3>
              <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="text-2xl font-bold">{{ stats.activeUsers || 0 }}</div>
            <p class="text-xs text-gray-500">+180.1% from last month</p>
          </div>

          <div class="rounded-lg border bg-white shadow-sm p-6">
            <div class="flex flex-row items-center justify-between space-y-0 pb-2">
              <h3 class="text-sm font-medium">Total Roles</h3>
              <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
              </svg>
            </div>
            <div class="text-2xl font-bold">{{ stats.totalRoles || 0 }}</div>
            <p class="text-xs text-gray-500">+19% from last month</p>
          </div>

          <div class="rounded-lg border bg-white shadow-sm p-6">
            <div class="flex flex-row items-center justify-between space-y-0 pb-2">
              <h3 class="text-sm font-medium">System Status</h3>
              <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
            </div>
            <div class="text-2xl font-bold text-green-600">Online</div>
            <p class="text-xs text-gray-500">All systems operational</p>
          </div>
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
          <div class="space-y-4">
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
