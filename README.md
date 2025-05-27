<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Absensi Satpam - Laravel

Aplikasi ini adalah sistem manajemen dan absensi untuk Satpam berbasis Laravel.

## Fitur Utama

- Manajemen data Satpam (CRUD)
- Manajemen lokasi kerja, UPT, ULTG
- Upload foto Satpam
- Validasi data lengkap
- Sistem absensi

---

## Tahapan Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/Absensi---Laravel.git
cd Absensi---Laravel
```

### 2. Install Dependency

```bash
composer install
```

### 3. Copy & Konfigurasi File Environment

```bash
cp .env.example .env
```
Edit file `.env` dan sesuaikan konfigurasi database Anda:
```
DB_DATABASE=nama_database
DB_USERNAME=username_db
DB_PASSWORD=password_db
```

### 4. Generate Key Aplikasi

```bash
php artisan key:generate
```

### 5. Migrasi & Import Database

- **Jika sudah ada file SQL (misal: `absensi.sql`):**
    - Import melalui phpMyAdmin atau command line:
        ```bash
        mysql -u username_db -p nama_database < absensi.sql
        ```

### 6. Storage Link (untuk upload foto)

```bash
php artisan storage:link
```

### 7. Jalankan Server

```bash
php artisan serve
```
Akses aplikasi di [http://localhost:8000](http://localhost:8000)

---

## Catatan

- Pastikan sudah menginstall PHP, Composer, dan MySQL/MariaDB.
- Untuk upload foto, pastikan folder `storage` dan `public` dapat ditulis oleh web server.
- Jika ada error, cek konfigurasi `.env` dan permission folder.

---

## Kontribusi

Pull request dan issue sangat terbuka untuk pengembangan aplikasi ini.

---

## Lisensi

Aplikasi ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).
