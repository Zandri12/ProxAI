# 🔧 Troubleshooting Guide

Dokumentasi untuk mengatasi masalah umum yang mungkin terjadi di project Laravel 12 dengan Breeze dan shadcn-vue.

## 🚨 Dashboard Blank/Error

### Gejala:
- Halaman dashboard kosong/blank setelah login
- Tidak ada error yang terlihat
- Console browser kosong

### Penyebab Umum:

#### 1. Data Auth Tidak Ter-load
**Gejala:** Dashboard kosong, tidak ada data user
**Solusi:**
```bash
# Pastikan seeder sudah dijalankan
php artisan migrate:fresh --seed

# Atau jalankan seeder saja
php artisan db:seed
```

#### 2. Relationship Data Tidak Ter-load
**Gejala:** User ada tapi roles kosong
**Solusi:**
```php
// Di DashboardController, pastikan eager loading
$user = $request->user();
$user->load(['roles.permissions']);
```

#### 3. JavaScript Error
**Gejala:** Console browser ada error
**Solusi:**
```bash
# Build ulang assets
npm run build

# Atau development mode
npm run dev
```

### Langkah Debug:

#### 1. Check Database
```bash
# Jalankan script debug
php debug_user.php
```

#### 2. Check Laravel Logs
```bash
# Lihat log Laravel
tail -f storage/logs/laravel.log
```

#### 3. Check Browser Console
- Buka Developer Tools (F12)
- Lihat tab Console untuk error JavaScript
- Lihat tab Network untuk request yang gagal

#### 4. Check Laravel Response
```bash
# Test endpoint dashboard
curl -H "Accept: application/json" http://localhost:8000/dashboard
```

## 🔐 Authentication Issues

### Gejala:
- Tidak bisa login
- Session expired
- Redirect loop

### Solusi:

#### 1. Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

#### 2. Check Session Config
```bash
# Pastikan session driver sesuai
# File: config/session.php
'driver' => env('SESSION_DRIVER', 'file'),
```

#### 3. Check Database Connection
```bash
# Test koneksi database
php artisan tinker
DB::connection()->getPdo();
```

## 🎨 Frontend Issues

### Gejala:
- CSS tidak ter-load
- JavaScript error
- Layout rusak

### Solusi:

#### 1. Build Assets
```bash
npm run build
```

#### 2. Clear Browser Cache
- Hard refresh (Ctrl+F5)
- Clear browser cache
- Disable browser extensions

#### 3. Check Vite Config
```javascript
// File: vite.config.js
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
```

## 🗄️ Database Issues

### Gejala:
- Migration error
- Seeder error
- Data tidak tersimpan

### Solusi:

#### 1. Reset Database
```bash
php artisan migrate:fresh --seed
```

#### 2. Check Database Schema
```bash
# Lihat struktur tabel
php artisan migrate:status

# Rollback migration tertentu
php artisan migrate:rollback --step=1
```

#### 3. Check Database Connection
```bash
# Test koneksi
php artisan db:show
```

## 🚀 Server Issues

### Gejala:
- Server tidak bisa diakses
- Port sudah digunakan
- Permission denied

### Solusi:

#### 1. Check Port Availability
```bash
# Windows
netstat -ano | findstr :8000

# Linux/Mac
lsof -i :8000
```

#### 2. Kill Process
```bash
# Windows
taskkill /PID <PID> /F

# Linux/Mac
kill -9 <PID>
```

#### 3. Use Different Port
```bash
php artisan serve --port=8001
```

## 🔍 Debug Commands

### 1. Check Laravel Status
```bash
php artisan about
```

### 2. Check Routes
```bash
php artisan route:list
```

### 3. Check Config
```bash
php artisan config:show
```

### 4. Check Environment
```bash
php artisan env
```

### 5. Clear All Caches
```bash
php artisan optimize:clear
```

## 📱 Browser Compatibility

### Supported Browsers:
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

### Check Browser Console:
```javascript
// Test basic functionality
console.log('Dashboard loaded');
console.log('User data:', window.userData);
```

## 🧪 Testing Checklist

### Before Testing:
- [ ] Database migrated and seeded
- [ ] Assets built (`npm run build`)
- [ ] Server running (`php artisan serve`)
- [ ] Browser cache cleared

### Test Scenarios:
- [ ] Login with admin user
- [ ] Login with regular user
- [ ] Check dashboard loads
- [ ] Check user data displays
- [ ] Check roles display correctly

## 📞 Getting Help

### 1. Check Logs
```bash
tail -f storage/logs/laravel.log
```

### 2. Enable Debug Mode
```env
# File: .env
APP_DEBUG=true
APP_ENV=local
```

### 3. Check Laravel Version
```bash
php artisan --version
```

### 4. Check PHP Version
```bash
php --version
```

## 🚨 Emergency Fixes

### If Nothing Works:

#### 1. Complete Reset
```bash
# Reset everything
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

#### 2. Check File Permissions
```bash
# Linux/Mac
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### 3. Reinstall Dependencies
```bash
composer install --no-dev
npm install
```

---

**Remember:** Most issues can be solved by clearing cache and rebuilding assets! 🔧
