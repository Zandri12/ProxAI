# Authentication Troubleshooting Guide

## Masalah: "Authentication failed" pada User Management

### Penyebab Masalah

1. **Session Expired**: Session user sudah expired
2. **CSRF Token Mismatch**: CSRF token tidak valid
3. **Middleware Conflict**: Konflik antara Sanctum dan web middleware
4. **Cookie Issues**: Browser tidak menyimpan session cookie

### Solusi yang Diterapkan

#### 1. Route Configuration
- **Sebelum**: API routes menggunakan `auth:sanctum` middleware
- **Sesudah**: API routes dipindah ke web routes dengan `auth` middleware
- **Lokasi**: `routes/web.php` dalam group `auth` middleware

#### 2. Session-based Authentication
- Menggunakan session authentication yang sama dengan web routes
- Tidak perlu CSRF cookie setup
- Lebih konsisten dengan aplikasi Laravel

#### 3. Route Structure
```
/api/users          → GET, POST
/api/users/{user}   → GET, PUT, DELETE  
/api/roles          → GET
/api/auth-test      → GET (test route)
```

### Cara Testing

#### 1. Test Authentication
```bash
# Pastikan sudah login dulu
curl -b cookies.txt http://localhost:8000/api/auth-test
```

#### 2. Test User Management
```bash
# Get users
curl -b cookies.txt http://localhost:8000/api/users

# Get roles  
curl -b cookies.txt http://localhost:8000/api/roles
```

#### 3. Test dari Browser
1. Login ke aplikasi
2. Buka halaman User Management
3. Buka Developer Tools > Console
4. Lihat debug information

### Debug Steps

#### 1. Check Session
```bash
# Cek session di database
php artisan tinker
>>> session()->getId()
>>> session()->all()
```

#### 2. Check Cookies
- Buka Developer Tools > Application > Cookies
- Pastikan session cookie ada dan valid

#### 3. Check Laravel Logs
```bash
tail -f storage/logs/laravel.log
```

#### 4. Check Route List
```bash
php artisan route:list --path=api
```

### Common Issues & Solutions

#### Issue 1: "Authentication required"
**Solution**: 
- Pastikan user sudah login
- Cek session tidak expired
- Refresh halaman

#### Issue 2: "CSRF token mismatch"
**Solution**:
- Route sudah dipindah ke web.php
- Tidak perlu CSRF setup manual
- Session authentication otomatis

#### Issue 3: "Route not found"
**Solution**:
- Clear route cache: `php artisan route:clear`
- Restart server
- Cek route list

### Testing Checklist

- [ ] User sudah login
- [ ] Session cookie ada di browser
- [ ] Route `/api/auth-test` berfungsi
- [ ] Route `/api/users` berfungsi
- [ ] Route `/api/roles` berfungsi
- [ ] Debug info muncul di console
- [ ] Tidak ada error di Network tab

### Next Steps

1. **Test Authentication**:
   ```bash
   curl -b cookies.txt http://localhost:8000/api/auth-test
   ```

2. **Test User Management**:
   - Buka halaman User Management
   - Lihat console untuk debug info
   - Cek Network tab untuk API calls

3. **Monitor Logs**:
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Check Database**:
   - Pastikan tabel `sessions` ada
   - Pastikan session data valid

### File Locations

- **Routes**: `routes/web.php` (baris 40-55)
- **Controller**: `app/Http/Controllers/UserManagementController.php`
- **Frontend**: `resources/js/Pages/UserManagement/Index.vue`
- **Axios Config**: `resources/js/lib/axios.js`
