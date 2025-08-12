# Proxa - Laravel 12 + Breeze + shadcn-vue

Project Laravel 12 yang terintegrasi dengan Laravel Breeze untuk authentication dan shadcn-vue untuk komponen UI yang indah.

## 🚀 Fitur

- **Laravel 12** - Framework PHP terbaru dengan performa optimal
- **Laravel Breeze** - Starter kit authentication dengan Vue.js dan Inertia.js
- **shadcn-vue** - Komponen UI yang indah dan dapat dikustomisasi
- **Tailwind CSS** - Framework CSS utility-first
- **Vue 3** - Framework JavaScript modern dengan Composition API
- **Inertia.js** - SPA-like experience tanpa kompleksitas SPA

## 📋 Prasyarat

Sebelum menjalankan project ini, pastikan sistem Anda memiliki:

- PHP 8.2 atau lebih tinggi
- Composer
- Node.js 18+ dan npm
- Database (MySQL, PostgreSQL, atau SQLite)

## 🛠️ Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd Proxa
```

### 2. Install Dependencies PHP
```bash
composer install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=proxa_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan Migration
```bash
php artisan migrate
```

### 6. Install Dependencies Node.js
```bash
npm install
```

### 7. Build Assets
```bash
npm run build
```

## 🚀 Menjalankan Project

### Development Mode
```bash
# Terminal 1 - Laravel Server
php artisan serve

# Terminal 2 - Vite Dev Server
npm run dev
```

### Production Mode
```bash
npm run build
php artisan serve
```

## 🎨 Komponen shadcn-vue yang Tersedia

Project ini sudah terinstall dengan komponen shadcn-vue berikut:

- **Button** - Tombol dengan berbagai variant dan ukuran
- **Card** - Container untuk konten dengan header, content, dan footer
- **Input** - Input field dengan styling yang konsisten
- **Label** - Label untuk form elements

### Cara Menambahkan Komponen Baru

```bash
npx shadcn-vue@latest add [component-name]
```

Contoh:
```bash
npx shadcn-vue@latest add dialog
npx shadcn-vue@latest add dropdown-menu
npx shadcn-vue@latest add table
```

## 📁 Struktur Project

```
Proxa/
├── app/                    # Logic aplikasi Laravel
├── resources/
│   ├── js/
│   │   ├── Components/    # Komponen Vue
│   │   │   ├── ui/        # Komponen shadcn-vue
│   │   │   └── ...        # Komponen kustom
│   │   ├── Pages/         # Halaman Vue
│   │   ├── Layouts/       # Layout Vue
│   │   └── app.js         # Entry point Vue
│   └── css/
│       └── app.css        # Styles Tailwind CSS
├── routes/                 # Route Laravel
├── database/               # Migration dan seeder
└── public/                 # Assets yang di-build
```

## 🔐 Authentication

Project menggunakan Laravel Breeze yang menyediakan:

- Login/Register
- Email verification
- Password reset
- Profile management
- Protected routes

### Routes yang Tersedia

- `/` - Welcome page
- `/login` - Login page
- `/register` - Register page
- `/dashboard` - Dashboard (protected)
- `/profile` - Profile management (protected)

## 🎯 Contoh Penggunaan Komponen

### Button
```vue
<template>
  <Button variant="default">Primary Button</Button>
  <Button variant="secondary">Secondary Button</Button>
  <Button variant="outline">Outline Button</Button>
  <Button variant="destructive">Delete Button</Button>
</template>

<script setup>
import { Button } from '@/Components/ui/button';
</script>
```

### Card
```vue
<template>
  <Card>
    <CardHeader>
      <CardTitle>Judul Card</CardTitle>
      <CardDescription>Deskripsi card</CardDescription>
    </CardHeader>
    <CardContent>
      <p>Konten card</p>
    </CardContent>
  </Card>
</template>

<script setup>
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/Components/ui/card';
</script>
```

### Form dengan Input dan Label
```vue
<template>
  <div class="space-y-4">
    <div class="space-y-2">
      <Label for="name">Nama</Label>
      <Input id="name" type="text" placeholder="Masukkan nama" />
    </div>
    <div class="space-y-2">
      <Label for="email">Email</Label>
      <Input id="email" type="email" placeholder="Masukkan email" />
    </div>
    <Button type="submit">Kirim</Button>
  </div>
</template>

<script setup>
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
</script>
```

## 🎨 Kustomisasi

### Mengubah Tema Warna

Edit file `tailwind.config.js` untuk mengubah skema warna:

```javascript
module.exports = {
  theme: {
    extend: {
      colors: {
        // Kustomisasi warna di sini
        primary: {
          50: '#eff6ff',
          500: '#3b82f6',
          900: '#1e3a8a',
        },
      },
    },
  },
}
```

### Menambahkan Komponen Kustom

Buat komponen baru di `resources/js/Components/`:

```vue
<!-- resources/js/Components/CustomComponent.vue -->
<template>
  <div class="custom-component">
    <!-- Konten komponen -->
  </div>
</template>

<script setup>
// Logic komponen
</script>

<style scoped>
/* Styles komponen */
</style>
```

## 🧪 Testing

```bash
# Unit tests
php artisan test

# Browser tests (jika menggunakan Laravel Dusk)
php artisan dusk
```

## 📦 Deployment

### 1. Build Production Assets
```bash
npm run build
```

### 2. Optimize Laravel
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Set Environment Variables
```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

## 🤝 Kontribusi

1. Fork project
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 License

Project ini menggunakan MIT License. Lihat file `LICENSE` untuk detail lebih lanjut.

## 🆘 Support

Jika Anda mengalami masalah atau memiliki pertanyaan:

1. Periksa dokumentasi Laravel: https://laravel.com/docs
2. Periksa dokumentasi shadcn-vue: https://www.shadcn-vue.com
3. Buat issue di repository ini

## 🙏 Credits

- [Laravel](https://laravel.com) - Framework PHP
- [Laravel Breeze](https://laravel.com/docs/breeze) - Authentication starter kit
- [shadcn-vue](https://www.shadcn-vue.com) - UI components
- [Tailwind CSS](https://tailwindcss.com) - CSS framework
- [Vue.js](https://vuejs.org) - JavaScript framework
- [Inertia.js](https://inertiajs.com) - SPA-like experience

---

**Happy Coding! 🎉**
