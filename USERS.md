# 📋 Daftar User Default

Berikut adalah daftar user yang telah dibuat oleh UserSeeder untuk testing dan development:

## 🔐 Informasi Login

**Password untuk semua user: `password123`**

## 👥 Daftar User

### 1. Administrator
- **Email:** `admin@proxa.com`
- **Nama:** Administrator
- **Role:** Admin
- **Status:** Email Verified

### 2. John Doe
- **Email:** `john@proxa.com`
- **Nama:** John Doe
- **Role:** User
- **Status:** Email Verified

### 3. Jane Smith
- **Email:** `jane@proxa.com`
- **Nama:** Jane Smith
- **Role:** User
- **Status:** Email Verified

### 4. Developer
- **Email:** `dev@proxa.com`
- **Nama:** Developer
- **Role:** Developer
- **Status:** Email Verified

### 5. Test User
- **Email:** `test@proxa.com`
- **Nama:** Test User
- **Role:** User
- **Status:** Email Verified

## 🚀 Cara Menggunakan

### Login dengan User Default
1. Buka halaman login: `/login`
2. Gunakan salah satu email di atas
3. Password: `password123`
4. Klik "Log in"

### Contoh Login
```
Email: admin@proxa.com
Password: password123
```

## 🔄 Menjalankan Seeder Ulang

Jika Anda ingin menjalankan seeder ulang (akan menghapus data lama):

```bash
# Reset database dan jalankan seeder
php artisan migrate:fresh --seed

# Atau jalankan seeder saja (jika tabel sudah ada)
php artisan db:seed
```

## 📝 Menambah User Baru

Untuk menambah user baru, edit file `database/seeders/UserSeeder.php`:

```php
User::create([
    'name' => 'Nama User Baru',
    'email' => 'userbaru@proxa.com',
    'email_verified_at' => now(),
    'password' => Hash::make('password123'),
]);
```

## ⚠️ Catatan Penting

- **Jangan gunakan password ini di production!**
- **Ganti password setelah login pertama kali**
- **User ini hanya untuk development dan testing**
- **Semua user sudah terverifikasi email**

## 🎯 Penggunaan untuk Testing

User default ini sangat berguna untuk:
- Testing fitur authentication
- Testing protected routes
- Development fitur baru
- Demo aplikasi
- Testing role-based access

---

**Happy Testing! 🎉**
