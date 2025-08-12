<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="ProxAI - Sign In" />
    
    <div class="min-h-screen flex">
        <!-- Left Side - Video Background with Branding -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
            <!-- Video Background -->
            <video 
                class="absolute inset-0 w-full h-full object-cover"
                autoplay 
                muted 
                loop 
                playsinline
            >
                <source src="/video/Abstract White Background 4K - Motion Graphics Background Loop - White Video Loop - Free Stock Footage 4K (1080p, h264).mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            
            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900/70 to-blue-900/70"></div>
            
            <!-- ProxAI Logo - Top Left -->
            <div class="relative z-10 absolute top-8 left-8">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30 transition-all duration-300 hover:bg-white/30 hover:scale-110 hover:shadow-lg group cursor-pointer">
                        <svg class="w-7 h-7 text-white transition-all duration-300 group-hover:scale-110 group-hover:rotate-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">ProxAI</h1>
                    </div>
                </div>
            </div>
            
            <!-- Main Icon - Independent Position -->
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
                <div class="text-center">
                    <div class="flex justify-center mb-6">
                        <div class="transition-all duration-500 hover:scale-110 hover:rotate-6 cursor-pointer group">
                            <svg class="w-16 h-16 text-white transition-all duration-500 group-hover:text-blue-200 group-hover:drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Main Content Box -->
                    <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-6 border border-white/20 relative transition-all duration-300 hover:bg-white/20 hover:scale-105 hover:shadow-xl cursor-pointer">
                        <!-- Decorative Lines -->
                        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-12 h-0.5 bg-gradient-to-r from-transparent via-blue-400 to-transparent transition-all duration-300 group-hover:w-16"></div>
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-12 h-0.5 bg-gradient-to-r from-transparent via-emerald-400 to-transparent transition-all duration-300 group-hover:w-16"></div>
                        
                        <!-- Content -->
                        <div class="text-center">
                            <h3 class="text-lg font-light text-white mb-2 transition-all duration-300 group-hover:text-blue-100">Welcome to the Future</h3>
                            <p class="text-blue-100 text-sm leading-relaxed transition-all duration-300 group-hover:text-blue-50">
                                Experience the power of AI-driven financial intelligence
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Floating Elements - Independent Positions -->
            <div class="absolute top-1/3 left-1/4 z-10">
                <div class="w-3 h-3 bg-blue-400/30 rounded-full animate-pulse transition-all duration-500 hover:scale-150 hover:bg-blue-400/70 hover:animate-bounce cursor-pointer group">
                    <div class="w-full h-full rounded-full bg-blue-400/20 animate-ping"></div>
                </div>
            </div>
            <div class="absolute top-1/3 left-1/3 z-10">
                <div class="w-2 h-2 bg-blue-300/40 rounded-full animate-pulse delay-1000 transition-all duration-500 hover:scale-150 hover:bg-blue-300/80 hover:animate-bounce cursor-pointer group">
                    <div class="w-full h-full rounded-full bg-blue-300/30 animate-ping delay-500"></div>
                </div>
            </div>
            <div class="absolute bottom-1/3 right-1/4 z-10">
                <div class="w-3 h-3 bg-emerald-400/30 rounded-full animate-pulse delay-500 transition-all duration-500 hover:scale-150 hover:bg-emerald-400/70 hover:animate-bounce cursor-pointer group">
                    <div class="w-full h-full rounded-full bg-emerald-400/20 animate-ping delay-1000"></div>
                </div>
            </div>
            <div class="absolute bottom-1/3 right-1/3 z-10">
                <div class="w-2 h-2 bg-emerald-300/40 rounded-full animate-pulse delay-1500 transition-all duration-500 hover:scale-150 hover:bg-emerald-300/80 hover:animate-bounce cursor-pointer group">
                    <div class="w-full h-full rounded-full bg-emerald-300/30 animate-ping delay-1500"></div>
                </div>
            </div>
            
            <!-- Proxsis Biztech Global - Independent Bottom Left -->
            <div class="absolute bottom-8 left-8 text-white z-20">
                <p class="text-lg font-semibold transition-all duration-300 hover:scale-105 hover:text-blue-200 cursor-pointer">Proxsis Biztech Global</p>
            </div>
            
            <!-- Proxsis Biztech Global - Independent Bottom Left -->
            <div class="absolute bottom-8 left-8 text-white z-20">
                <p class="text-lg font-semibold">Proxsis Biztech Global</p>
            </div>
            
            <!-- Proxsis Biztech Global - Independent Bottom Left -->
            <div class="absolute bottom-8 left-8 text-white z-20">
                <p class="text-lg font-semibold">Proxsis Biztech Global</p>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="flex-1 flex items-center justify-center bg-gray-50 p-8">
            <div class="w-full max-w-sm">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-3 transition-all duration-300 hover:bg-blue-200 hover:scale-110 hover:shadow-lg group cursor-pointer">
                        <svg class="w-6 h-6 text-blue-600 transition-all duration-300 group-hover:scale-110 group-hover:rotate-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h1 class="text-xl font-semibold text-gray-900 transition-all duration-300 hover:text-blue-600 cursor-pointer">ProxAI</h1>
                </div>

                <!-- Login Form Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <!-- Form Header -->
                    <div class="text-center mb-8">
                        <div class="flex justify-center mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center transition-all duration-300 hover:bg-blue-200 hover:scale-110 hover:shadow-lg group cursor-pointer">
                                <svg class="w-6 h-6 text-blue-600 transition-all duration-300 group-hover:scale-110 group-hover:rotate-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-900 mb-2 transition-all duration-300 hover:text-blue-600 cursor-pointer">Welcome Back</h2>
                        <p class="text-gray-500 text-sm transition-all duration-300 hover:text-gray-700 cursor-pointer">Sign in to your account</p>
                    </div>

                    <!-- Status Message -->
                    <div v-if="status" class="mb-8 bg-emerald-50/80 backdrop-blur-sm border border-emerald-200/50 rounded-2xl p-4">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-emerald-500 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm font-medium text-emerald-800">{{ status }}</p>
                        </div>
                    </div>

                    <!-- Login Form -->
                    <form @submit.prevent="submit" class="space-y-5">
                        <div>
                            <InputLabel for="email" value="Email" class="text-sm font-medium text-gray-700 mb-2 block transition-all duration-200 hover:text-blue-600" />
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-all duration-200 group-focus-within:text-blue-500">
                                    <svg class="w-4 h-4 text-gray-400 transition-all duration-200 group-focus-within:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 hover:border-gray-300 hover:shadow-sm focus:shadow-md"
                                    v-model="form.email"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="Enter your email"
                                />
                            </div>
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div>
                            <InputLabel for="password" value="Password" class="text-sm font-medium text-gray-700 mb-2 block transition-all duration-200 hover:text-blue-600" />
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none transition-all duration-200 group-focus-within:text-blue-500">
                                    <svg class="w-4 h-4 text-gray-400 transition-all duration-200 group-focus-within:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 hover:border-gray-300 hover:shadow-sm focus:shadow-md"
                                    v-model="form.password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Enter your password"
                                />
                            </div>
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer group">
                                <Checkbox name="remember" v-model:checked="form.remember" />
                                <span class="ml-2 text-sm text-gray-600 transition-all duration-200 group-hover:text-blue-600">Remember me</span>
                            </label>

                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-all duration-200 hover:scale-105"
                            >
                                Forgot password?
                            </Link>
                        </div>

                        <PrimaryButton
                            class="w-full flex justify-center items-center py-3 px-6 border border-transparent rounded-xl text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 hover:scale-105 hover:shadow-lg active:scale-95"
                            :class="{ 'opacity-75 cursor-not-allowed': form.processing }"
                            :disabled="form.processing"
                        >
                            <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span v-else>Sign In</span>
                        </PrimaryButton>
                    </form>

                    <!-- Form Footer -->
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-500">
                            Don't have an account? 
                            <Link :href="route('register')" class="font-medium text-blue-600 hover:text-blue-700 transition-all duration-200 hover:scale-105 inline-block">
                                Get started
                            </Link>
                        </p>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="mt-4 text-center">
                    <p class="text-xs text-gray-400 transition-all duration-200 hover:text-gray-600 cursor-pointer">© 2024 ProxAI</p>
                </div>
            </div>
        </div>
    </div>
</template>
