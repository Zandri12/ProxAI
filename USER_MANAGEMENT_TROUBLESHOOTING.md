# User Management Troubleshooting Guide

## Masalah yang Ditemukan

Halaman User Management mengalami beberapa masalah:

1. **Konflik Middleware**: API menggunakan `auth:sanctum` tapi frontend menggunakan session-based authentication
2. **Missing CSRF Token**: Tidak ada CSRF token di meta tag
3. **Session Configuration**: Konfigurasi session database tidak optimal
4. **CORS Issues**: Konfigurasi CORS tidak proper

## Solusi yang Diterapkan

### 1. Konfigurasi Axios
- Dibuat file `resources/js/lib/axios.js` dengan konfigurasi proper
- Menambahkan CSRF token handling
- Menggunakan `withCredentials: true` untuk session-based auth

### 2. CSRF Token
- Ditambahkan meta tag CSRF token di `resources/views/app.blade.php`
- Token akan otomatis disertakan di setiap request

### 3. Alternative API Routes
- Dibuat route alternatif dengan middleware `web` untuk session-based auth
- Route: `/api/web/users`, `/api/web/roles`, dll
- Menggunakan session authentication yang sama dengan web routes

### 4. Error Handling
- Improved error handling di frontend
- Better error messages untuk berbagai status code
- Debug information untuk troubleshooting

### 5. Configuration Files
- Dibuat `config/sanctum.php` untuk API authentication
- Dibuat `config/cors.php` untuk CORS handling
- Konfigurasi session database

## Cara Testing

### 1. Test Session Authentication
```bash
curl http://localhost:8000/api/session-test
```

### 2. Test User Management API
```bash
# Pastikan sudah login dulu
curl http://localhost:8000/api/web/users
```

### 3. Test dari Browser
- Buka halaman User Management
- Buka Developer Tools > Console
- Lihat debug information dan error messages

## Debug Information

Halaman User Management sekarang menampilkan:
- Current user information
- Authentication status
- API response details
- Error messages yang lebih jelas

## Troubleshooting Steps

1. **Check Authentication**
   - Pastikan user sudah login
   - Periksa session di browser

2. **Check Console Errors**
   - Buka Developer Tools > Console
   - Lihat error messages dan debug info

3. **Check Network Tab**
   - Buka Developer Tools > Network
   - Lihat request/response untuk API calls

4. **Check Laravel Logs**
   ```bash
   tail -f storage/logs/laravel.log
   ```

5. **Test API Endpoints**
   ```bash
   php artisan route:list --path=api
   ```

## Common Issues

### 1. "Authentication required"
- User belum login
- Session expired
- CSRF token invalid

### 2. "Access denied"
- User tidak punya permission
- Role/permission tidak ter-setup

### 3. "Server error"
- Database connection issue
- Migration belum dijalankan
- Model relationship error

## Next Steps

1. Jalankan migration jika belum:
   ```bash
   php artisan migrate
   ```

2. Seed data roles dan permissions:
   ```bash
   php artisan db:seed
   ```

3. Test dengan user yang punya permission admin

4. Monitor logs untuk error yang terjadi
