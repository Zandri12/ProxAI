<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\RoleManagementController;
use App\Http\Controllers\PermissionManagementController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // User Management Routes
    Route::get('/user-management', function () {
        return Inertia::render('UserManagement/Index');
    })->name('user-management.index');
    
    // Role Management Routes
    Route::get('/role-management', function () {
        return Inertia::render('RoleManagement/Index');
    })->name('role-management.index');
    
    // Permission Management Routes
    Route::get('/permission-management', function () {
        return Inertia::render('PermissionManagement/Index');
    })->name('permission-management.index');
    
    // API Routes for User Management (session-based auth)
    Route::prefix('api')->group(function () {
        Route::get('/users', [UserManagementController::class, 'index']);
        Route::post('/users', [UserManagementController::class, 'store']);
        Route::get('/users/{user}', [UserManagementController::class, 'show']);
        Route::put('/users/{user}', [UserManagementController::class, 'update']);
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy']);
        
        // Role Management API Routes
        Route::get('/roles', [RoleManagementController::class, 'index']);
        Route::post('/roles', [RoleManagementController::class, 'store']);
        Route::get('/roles/{role}', [RoleManagementController::class, 'show']);
        Route::put('/roles/{role}', [RoleManagementController::class, 'update']);
        Route::delete('/roles/{role}', [RoleManagementController::class, 'destroy']);
        
        // Permission Management API Routes
        Route::get('/permissions', [PermissionManagementController::class, 'index']);
        Route::post('/permissions', [PermissionManagementController::class, 'store']);
        Route::get('/permissions/{permission}', [PermissionManagementController::class, 'show']);
        Route::put('/permissions/{permission}', [PermissionManagementController::class, 'update']);
        Route::delete('/permissions/{permission}', [PermissionManagementController::class, 'destroy']);
        
        // Test route
        Route::get('/auth-test', function (Request $request) {
            return response()->json([
                'success' => true,
                'message' => 'Session authentication working!',
                'user' => $request->user(),
                'authenticated' => auth()->check(),
                'timestamp' => now()
            ]);
        });
    });
});

require __DIR__.'/auth.php';
