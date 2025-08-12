# 🔐 Sistem Role dan Permission

Dokumentasi lengkap untuk sistem role dan permission yang telah diimplementasikan di project Laravel 12 dengan Breeze dan shadcn-vue.

## 📋 Overview

Sistem ini menggunakan pendekatan **Role-Based Access Control (RBAC)** yang memungkinkan:
- **Roles** - Peran yang dapat diassign ke user
- **Permissions** - Izin spesifik untuk setiap fitur
- **User-Role Assignment** - User dapat memiliki multiple roles
- **Role-Permission Assignment** - Role dapat memiliki multiple permissions

## 🏗️ Struktur Database

### Tabel yang Dibuat:

1. **`roles`** - Menyimpan data roles
2. **`permissions`** - Menyimpan data permissions
3. **`role_user`** - Pivot table untuk user-role relationship
4. **`permission_role`** - Pivot table untuk role-permission relationship

### Schema Tabel:

#### Tabel `roles`
```sql
- id (Primary Key)
- name (Nama role)
- slug (Slug unik untuk role)
- description (Deskripsi role)
- is_active (Status aktif role)
- created_at, updated_at (Timestamps)
```

#### Tabel `permissions`
```sql
- id (Primary Key)
- name (Nama permission)
- slug (Slug unik untuk permission)
- description (Deskripsi permission)
- module (Grup permission berdasarkan modul)
- is_active (Status aktif permission)
- created_at, updated_at (Timestamps)
```

## 👥 Roles yang Tersedia

### 1. Super Administrator
- **Slug:** `super-admin`
- **Deskripsi:** Full access to all features and settings
- **Permissions:** Semua permissions

### 2. Administrator
- **Slug:** `admin`
- **Deskripsi:** Administrative access to manage users, roles, and permissions
- **Permissions:** Semua permissions kecuali create/delete permissions

### 3. Developer
- **Slug:** `developer`
- **Deskripsi:** Developer access with technical permissions
- **Permissions:** View users, roles, permissions, dashboard access, profile edit

### 4. User
- **Slug:** `user`
- **Deskripsi:** Standard user with basic permissions
- **Permissions:** Dashboard access, profile edit

## 🔑 Permissions yang Tersedia

### User Management
- `users.view` - Melihat daftar users
- `users.create` - Membuat user baru
- `users.edit` - Mengedit user yang ada
- `users.delete` - Menghapus user

### Role Management
- `roles.view` - Melihat daftar roles
- `roles.create` - Membuat role baru
- `roles.edit` - Mengedit role yang ada
- `roles.delete` - Menghapus role

### Permission Management
- `permissions.view` - Melihat daftar permissions
- `permissions.create` - Membuat permission baru
- `permissions.edit` - Mengedit permission yang ada
- `permissions.delete` - Menghapus permission

### System Access
- `dashboard.access` - Akses ke dashboard
- `profile.edit` - Edit profile sendiri

## 🚀 Cara Menggunakan

### 1. Check User Roles
```php
// Di Controller atau View
if ($user->hasRole('admin')) {
    // User memiliki role admin
}

if ($user->hasAnyRole(['admin', 'developer'])) {
    // User memiliki salah satu dari role tersebut
}
```

### 2. Check User Permissions
```php
// Di Controller atau View
if ($user->hasPermission('users.create')) {
    // User memiliki permission untuk membuat user
}

if ($user->hasAnyPermission(['users.view', 'users.edit'])) {
    // User memiliki salah satu dari permission tersebut
}
```

### 3. Di Vue Component
```vue
<template>
    <div>
        <!-- Tampilkan menu berdasarkan permission -->
        <div v-if="$page.props.auth.user.hasPermission('users.view')">
            <Link :href="route('users.index')">Users</Link>
        </div>
        
        <!-- Tampilkan content berdasarkan role -->
        <div v-if="$page.props.auth.user.hasRole('admin')">
            Admin Panel
        </div>
    </div>
</template>
```

## 🎯 Menu Management Dropdown

Dashboard sekarang memiliki menu dropdown "Management" yang menampilkan:

### User Management
- **Users** - Daftar semua users
- **Add User** - Tambah user baru

### Role Management
- **Roles** - Daftar semua roles
- **Add Role** - Tambah role baru

### Permission Management
- **Permissions** - Daftar semua permissions
- **Add Permission** - Tambah permission baru

### System
- **Dashboard** - Kembali ke dashboard
- **Profile** - Edit profile

## 🔧 Menambah Role Baru

### 1. Edit RoleSeeder
```php
// database/seeders/RoleSeeder.php
[
    'name' => 'Manager',
    'slug' => 'manager',
    'description' => 'Manager access with limited permissions',
    'is_active' => true,
]
```

### 2. Jalankan Seeder
```bash
php artisan db:seed --class=RoleSeeder
```

## 🔧 Menambah Permission Baru

### 1. Edit PermissionSeeder
```php
// database/seeders/PermissionSeeder.php
[
    'name' => 'Export Data',
    'slug' => 'data.export',
    'description' => 'Can export data to various formats',
    'module' => 'data',
    'is_active' => true,
]
```

### 2. Jalankan Seeder
```bash
php artisan db:seed --class=PermissionSeeder
```

## 🔧 Assign Permission ke Role

### 1. Edit RolePermissionSeeder
```php
// database/seeders/RolePermissionSeeder.php
$manager = Role::where('slug', 'manager')->first();
if ($manager) {
    $manager->permissions()->attach([
        'dashboard.access',
        'profile.edit',
        'users.view',
        'data.export'
    ]);
}
```

### 2. Jalankan Seeder
```bash
php artisan db:seed --class=RolePermissionSeeder
```

## 🧪 Testing

### 1. Login dengan User Admin
```
Email: admin@proxa.com
Password: password123
```
- Dapat mengakses semua menu management
- Dapat melihat semua users, roles, dan permissions

### 2. Login dengan User Developer
```
Email: dev@proxa.com
Password: password123
```
- Dapat melihat users, roles, dan permissions
- Tidak dapat mengedit atau menghapus

### 3. Login dengan User Regular
```
Email: john@proxa.com
Password: password123
```
- Hanya dapat mengakses dashboard dan edit profile
- Tidak dapat melihat menu management

## 📁 File yang Telah Dibuat

### Models
- `app/Models/Role.php` - Model untuk Role
- `app/Models/Permission.php` - Model untuk Permission
- `app/Models/User.php` - Updated dengan role/permission methods

### Migrations
- `database/migrations/2025_08_11_202311_create_roles_table.php`
- `database/migrations/2025_08_11_202320_create_permissions_table.php`
- `database/migrations/2025_08_11_202327_create_role_user_table.php`
- `database/migrations/2025_08_11_202336_create_permission_role_table.php`

### Seeders
- `database/seeders/RoleSeeder.php` - Membuat roles default
- `database/seeders/PermissionSeeder.php` - Membuat permissions default
- `database/seeders/RolePermissionSeeder.php` - Assign permissions ke roles
- `database/seeders/UserSeeder.php` - Updated untuk assign roles ke users

### Components
- `resources/js/Components/ManagementDropdown.vue` - Dropdown menu management

### Pages
- `resources/js/Pages/Dashboard.vue` - Updated dengan management dropdown

## 🚀 Deployment

### 1. Jalankan Migrasi
```bash
php artisan migrate
```

### 2. Jalankan Seeder
```bash
php artisan db:seed
```

### 3. Build Assets
```bash
npm run build
```

## ⚠️ Catatan Penting

- **Jangan hapus role `super-admin`** - Ini adalah role tertinggi
- **Permission slug harus unik** - Gunakan format `module.action`
- **Role slug harus unik** - Gunakan format kebab-case
- **Test permissions** sebelum deploy ke production
- **Backup database** sebelum menjalankan seeder

## 🔮 Fitur Selanjutnya

Untuk pengembangan lebih lanjut, pertimbangkan:
- **Audit Log** - Mencatat semua perubahan
- **Permission Inheritance** - Role dapat inherit dari role lain
- **Dynamic Permissions** - Permissions yang dapat dikonfigurasi via UI
- **API Permissions** - Permissions untuk API endpoints
- **Permission Groups** - Grouping permissions yang lebih advanced

---

**Happy Role-Based Access Control! 🎉**
