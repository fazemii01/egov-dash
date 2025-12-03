<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# WEBSITE-DINAS - Installation Guide

Ikuti langkah-langkah berikut untuk menginstall dan menjalankan project ini:

## 1. Install Yarn (Global)

```bash
npm install --global yarn
```

## 2. Install Composer (Global)

Composer adalah package manager untuk PHP.  
Download installer Composer di: https://getcomposer.org/download/

Setelah instalasi, cek versi Composer:
```bash
composer --version
```

## 3. Install Dependency Composer

```bash
composer install
```
Jika ada error terkait versi PHP atau plugin, gunakan:
```bash
composer install --ignore-platform-req=php --optimize-autoloader
```

## 4. Install Dependency NPM dengan Yarn

```bash
yarn
```

## 5. Compile Assets (SASS, JS, Media)

```bash
npm run dev
```
Perintah ini akan meng-compile layout demo1 secara default.

## 6. Copy File Environment

Untuk Linux/Mac:
```bash
cp .env.example .env
```
Untuk Windows:
```cmd
copy .env.example .env
```

## 7. Konfigurasi Database

- Buat database di MySQL.
- Edit file `.env` dan isi `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` sesuai database Anda.

## 8. Migrasi & Seeder Database

```bash
php artisan migrate:fresh --seed
```

## 9. Generate Application Key

```bash
php artisan key:generate
```

## 10. Jalankan Server Lokal

```bash
php artisan serve
```
Akses aplikasi di [http://localhost:8000/](http://localhost:8000/)

## 11. (Opsional) Storage Link

Untuk fitur upload gambar:
```bash
php artisan storage:link
```
Lihat dokumentasi: [Laravel Filesystem](https://laravel.com/docs/8.x/filesystem)

---

**Catatan:**  
Untuk build demo lain, silakan cek dokumentasi Multi-demo pada Metronic/Keenthemes.
