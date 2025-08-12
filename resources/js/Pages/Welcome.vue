<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />
    
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
        <div class="container mx-auto px-4 py-16">
            <!-- Header -->
            <div class="text-center mb-16">
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                </div>
                
                <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    Selamat Datang di Laravel 12
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">
                    Framework PHP modern dengan Breeze authentication dan shadcn-vue components
                </p>
                
                <!-- Navigation Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <template v-if="$page.props.auth.user">
                        <Link :href="route('dashboard')">
                            <button class="px-8 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold">
                                Dashboard
                            </button>
                        </Link>
                    </template>
                    <template v-else>
                        <Link :href="route('login')" v-if="canLogin">
                            <button class="px-8 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold">
                                Login
                            </button>
                        </Link>
                        <Link :href="route('register')" v-if="canRegister">
                            <button class="px-8 py-3 border border-gray-300 bg-white text-gray-700 rounded-md hover:bg-gray-50 font-semibold">
                                Register
                            </button>
                        </Link>
                    </template>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                <div class="rounded-lg border bg-white shadow-sm p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold leading-none tracking-tight mb-2">Laravel 12</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Framework PHP terbaru dengan performa optimal dan fitur modern
                    </p>
                    <div class="p-6 pt-0">
                        <p class="text-gray-600 dark:text-gray-400">
                            Laravel 12 menghadirkan peningkatan performa yang signifikan, 
                            sintaks yang lebih bersih, dan dukungan untuk PHP 8.2+.
                        </p>
                    </div>
                </div>

                <div class="rounded-lg border bg-white shadow-sm p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold leading-none tracking-tight mb-2">Laravel Breeze</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Authentication starter kit yang ringan dan fleksibel
                    </p>
                    <div class="p-6 pt-0">
                        <p class="text-gray-600 dark:text-gray-400">
                            Breeze menyediakan implementasi authentication yang bersih 
                            dengan Vue.js, Inertia.js, dan Tailwind CSS.
                        </p>
                    </div>
                </div>

                <div class="rounded-lg border bg-white shadow-sm p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold leading-none tracking-tight mb-2">shadcn-vue</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Komponen UI yang reusable dan customizable
                    </p>
                    <div class="p-6 pt-0">
                        <p class="text-gray-600 dark:text-gray-400">
                            shadcn-vue menyediakan komponen Vue.js yang modern 
                            dengan design system yang konsisten dan accessible.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tech Stack -->
            <div class="rounded-lg border bg-white shadow-sm p-6 max-w-2xl mx-auto">
                <h3 class="text-2xl font-semibold leading-none tracking-tight text-center mb-2">Tech Stack</h3>
                <p class="text-sm text-gray-600 text-center mb-4">
                    Teknologi yang digunakan dalam project ini
                </p>
                <div class="p-6 pt-0">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">{{ laravelVersion }}</div>
                            <div class="text-sm text-gray-600">Laravel</div>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">{{ phpVersion }}</div>
                            <div class="text-sm text-gray-600">PHP</div>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600">3.x</div>
                            <div class="text-sm text-gray-600">Vue.js</div>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-cyan-600">1.x</div>
                            <div class="text-sm text-gray-600">Inertia</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
