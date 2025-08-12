# User Management System

This document describes the User Management system built with Laravel Sanctum for authentication and Vue.js for the frontend.

## Features

- **Create Users**: Add new users with name, email, password, and role assignments
- **Read Users**: View all users with pagination and role information
- **Update Users**: Edit existing user information and roles
- **Delete Users**: Remove users (with protection against self-deletion)
- **Role Management**: Assign and manage user roles
- **Authentication**: Secure API endpoints using Laravel Sanctum

## Backend Components

### 1. UserManagementController (`app/Http/Controllers/UserManagementController.php`)

The main controller handling all CRUD operations:

- `index()` - List all users with pagination
- `store()` - Create new user
- `show()` - Display specific user
- `update()` - Update existing user
- `destroy()` - Delete user
- `getRoles()` - Get all available roles

### 2. API Routes (`routes/api.php`)

Protected API endpoints requiring Sanctum authentication:

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserManagementController::class, 'index']);
    Route::post('/users', [UserManagementController::class, 'store']);
    Route::get('/users/{user}', [UserManagementController::class, 'show']);
    Route::put('/users/{user}', [UserManagementController::class, 'update']);
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy']);
    Route::get('/roles', [UserManagementController::class, 'getRoles']);
});
```

### 3. Web Routes (`routes/web.php`)

Frontend route for the user management interface:

```php
Route::get('/user-management', function () {
    return Inertia::render('UserManagement/Index');
})->name('user-management.index');
```

## Frontend Components

### 1. UserManagement Index Page (`resources/js/Pages/UserManagement/Index.vue`)

Main page displaying:
- Users table with pagination
- Create user button
- Edit and delete actions for each user
- Role badges for each user

### 2. UserModal Component (`resources/js/Components/UserModal.vue`)

Reusable modal for creating and editing users:
- Form validation
- Password confirmation (optional for updates)
- Role selection via checkboxes
- Error handling and display

### 3. Authentication Service (`resources/js/lib/auth.js`)

Service for managing Sanctum tokens:
- Automatic token inclusion in API requests
- Token expiration handling
- Login/logout functionality

## Database Structure

### Users Table
- `id` - Primary key
- `name` - User's full name
- `email` - Unique email address
- `password` - Hashed password
- `email_verified_at` - Email verification timestamp
- `remember_token` - Remember me token
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

### Roles Table
- `id` - Primary key
- `name` - Role display name
- `slug` - Role identifier
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

### Role-User Pivot Table
- `role_id` - Foreign key to roles table
- `user_id` - Foreign key to users table

## Usage

### 1. Accessing User Management

Navigate to `/user-management` in your browser. You must be authenticated to access this page.

### 2. Creating a User

1. Click the "Add User" button
2. Fill in the required fields:
   - Name
   - Email (must be unique)
   - Password (minimum 8 characters)
   - Password confirmation
   - Select roles (optional)
3. Click "Create"

### 3. Editing a User

1. Click "Edit" on any user row
2. Modify the desired fields
3. Leave password blank to keep current password
4. Click "Update"

### 4. Deleting a User

1. Click "Delete" on any user row
2. Confirm the deletion
3. User will be permanently removed

### 5. Managing Roles

- Roles are displayed as badges on each user
- Multiple roles can be assigned to a user
- Roles can be modified when editing users

## Security Features

- **Authentication Required**: All API endpoints require valid Sanctum tokens
- **Self-Protection**: Users cannot delete their own accounts
- **Input Validation**: Server-side validation for all inputs
- **Password Hashing**: Passwords are automatically hashed using Laravel's Hash facade
- **CSRF Protection**: Built-in CSRF protection for web routes

## Testing

Run the test suite to verify functionality:

```bash
php artisan test --filter=UserManagementTest
```

Tests cover:
- User listing with pagination
- User creation with validation
- User updates
- User deletion
- Role management
- Security constraints
- Validation errors

## API Response Format

All API endpoints return JSON responses with consistent structure:

### Success Response
```json
{
    "success": true,
    "message": "Operation message",
    "data": { ... }
}
```

### Error Response
```json
{
    "success": false,
    "errors": {
        "field": ["Error message"]
    }
}
```

## Dependencies

- **Laravel 12.x** - Backend framework
- **Laravel Sanctum 4.x** - API authentication
- **Vue.js 3.x** - Frontend framework
- **Inertia.js** - SPA-like experience
- **Tailwind CSS** - Styling
- **Axios** - HTTP client

## Troubleshooting

### Common Issues

1. **401 Unauthorized**: Ensure you're authenticated and have a valid token
2. **Validation Errors**: Check that all required fields are filled correctly
3. **Role Assignment**: Verify that the selected roles exist in the database
4. **Password Confirmation**: Ensure password and confirmation match

### Debug Mode

Enable debug mode in `.env` to see detailed error messages:

```env
APP_DEBUG=true
```

## Future Enhancements

Potential improvements for the system:

- User search and filtering
- Bulk user operations
- User activity logging
- Advanced role permissions
- User import/export functionality
- Email notifications for user changes
