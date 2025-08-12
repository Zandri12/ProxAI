<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\RoleManagementController;
use App\Http\Controllers\PermissionManagementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Get CSRF cookie for Sanctum
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Test route without authentication
Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'API is working!',
        'timestamp' => now()
    ]);
});

// Test route with authentication
Route::middleware('auth:sanctum')->get('/auth-test', function (Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'Authentication working!',
        'user' => $request->user(),
        'timestamp' => now()
    ]);
});

// User Management Routes with Sanctum (session-based auth)
Route::middleware('auth:sanctum')->group(function () {
    // Users
    Route::get('/users', [UserManagementController::class, 'index']);
    Route::post('/users', [UserManagementController::class, 'store']);
    Route::get('/users/{user}', [UserManagementController::class, 'show']);
    Route::put('/users/{user}', [UserManagementController::class, 'update']);
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy']);
    
    // Roles
    Route::get('/roles', [RoleManagementController::class, 'index']);
    Route::post('/roles', [RoleManagementController::class, 'store']);
    Route::get('/roles/{role}', [RoleManagementController::class, 'show']);
    Route::put('/roles/{role}', [RoleManagementController::class, 'update']);
    Route::delete('/roles/{role}', [RoleManagementController::class, 'destroy']);
    Route::get('/roles-permissions', [RoleManagementController::class, 'getPermissions']);
    
    // Permissions
    Route::get('/permissions', [PermissionManagementController::class, 'index']);
    Route::post('/permissions', [PermissionManagementController::class, 'store']);
    Route::get('/permissions/{permission}', [PermissionManagementController::class, 'show']);
    Route::put('/permissions/{permission}', [PermissionManagementController::class, 'update']);
    Route::delete('/permissions/{permission}', [PermissionManagementController::class, 'destroy']);
    Route::get('/permissions/module/{module}', [PermissionManagementController::class, 'getByModule']);
});
