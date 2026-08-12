<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<h1 align="center">🏨 Hotel Booking System API</h1>

<p align="center">
  RESTful API berbasis Laravel untuk mengelola kamar, reservasi, pelanggan, dan pembayaran hotel secara efisien dan aman.
</p>

<p align="center">
  <a href="#-tentang-proyek">Tentang</a> •
  <a href="#-fitur-utama">Fitur</a> •
  <a href="#-endpoint-api">API</a> •
  <a href="#️-instalasi">Instalasi</a> •
  <a href="#-pengujian-menggunakan-postman">Testing</a>
</p>

---

## 📑 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Model & Relasi Data](#-model--relasi-data)
- [Endpoint API](#-endpoint-api)
- [Instalasi](#️-instalasi)
- [Tangkapan Layar UI](#-tangkapan-layar-ui)
- [Pengujian Menggunakan Postman](#-pengujian-menggunakan-postman)
- [Unit Testing](#-unit-testing)
- [Lisensi](#-lisensi)

---

## 📖 Tentang Proyek

Sistem ini dibangun untuk membantu rantai hotel dalam menyederhanakan proses pemesanan kamar, mengelola interaksi pelanggan, dan menangani pembayaran secara aman. API ini menangani ketersediaan kamar, manajemen reservasi, data pelanggan, hingga pencatatan pembayaran — lengkap dengan autentikasi berbasis token dan sistem notifikasi otomatis untuk staf hotel.

## ✨ Fitur Utama

- **✅ Manajemen Kamar** — *retrieval*, pembuatan, dan detail kamar
- **✅ Manajemen Booking** — *retrieval* dan pembuatan reservasi
- **✅ Manajemen Pelanggan** — *retrieval* dan pendaftaran data pelanggan
- **✅ Pencatatan Pembayaran** terhadap *booking* tertentu
- **🔐 Token-based Authentication** — hanya *user* terautentikasi yang dapat menambah kamar, membuat *booking*, menambah pelanggan, dan mencatat pembayaran
- **🛡️ Validasi & Error Handling** menyeluruh untuk setiap *request*
- **📅 Room Availability Checker** — mencegah terjadinya *double booking*
- **🔔 Sistem Notifikasi Otomatis** ke staf hotel saat *booking* dibuat/dibatalkan, menggunakan Laravel Events, Listeners, dan Queues
- **🧪 Unit Test** lengkap untuk memastikan seluruh fungsi API berjalan sesuai ekspektasi

## 🛠 Tech Stack

| Kategori | Teknologi |
| :--- | :--- |
| **Framework** | Laravel |
| **Database** | MySQL |
| **Autentikasi** | Laravel Sanctum / Passport (token-based) |
| **Background Jobs** | Laravel Queues |
| **Testing** | PHPUnit |
| **API Testing Tool** | Postman |

## 🗂 Model & Relasi Data

| Model | Atribut |
| :--- | :--- |
| **Room** | `number`, `type`, `price_per_night`, `status` |
| **Booking** | `room_id`, `customer_id`, `check_in_date`, `check_out_date`, `total_price` |
| **Customer** | `name`, `email`, `phone_number` |
| **Payment** | `booking_id`, `amount`, `payment_date`, `status` |

**Relasi:**

```
Room       1 ──── * Booking
Customer   1 ──── * Booking
Booking    1 ──── * Payment
```

*Satu `Room` dapat memiliki banyak `Booking`. Satu `Booking` dimiliki oleh satu `Room` dan satu `Customer`. Satu `Customer` dapat memiliki banyak `Booking`. Satu `Booking` dapat memiliki banyak `Payment`.*

## 🔌 Endpoint API

*(Endpoint yang ditandai 🔐 membutuhkan autentikasi Bearer Token)*

| Method | Endpoint | Deskripsi | Auth |
| :--- | :--- | :--- | :---: |
| **GET** | `/api/rooms` | Menampilkan daftar semua kamar | - |
| **GET** | `/api/rooms/{id}` | Menampilkan detail satu kamar | - |
| **POST** | `/api/rooms` | Menambahkan kamar baru | 🔐 |
| **GET** | `/api/bookings` | Menampilkan daftar semua booking | - |
| **POST** | `/api/bookings` | Membuat booking baru (dengan cek ketersediaan) | 🔐 |
| **GET** | `/api/customers` | Menampilkan daftar semua pelanggan | - |
| **POST** | `/api/customers` | Mendaftarkan pelanggan baru | 🔐 |
| **POST** | `/api/payments` | Mencatat pembayaran untuk booking | 🔐 |

---

## ⚙️ Instalasi

**1. Clone repository**

```bash
git clone https://github.com/sandymubarak2-sudo/reservasi-hotel-berbasis-web.git
cd reservasi-hotel-berbasis-web
```

**2. Install dependencies**

```bash
composer install
```

**3. Salin file environment & generate application key**

```bash
cp .env.example .env
php artisan key:generate
```

**4. Konfigurasi koneksi database**

Sesuaikan kredensial database utama pada file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_booking
DB_USERNAME=root
DB_PASSWORD=
```

**5. Jalankan migrasi database**

```bash
php artisan migrate
```

**6. Jalankan server lokal**

```bash
php artisan serve
```

**7. Jalankan queue worker** (untuk sistem notifikasi booking)

```bash
php artisan queue:work
```

---

## 🖼 Tangkapan Layar UI

> Tambahkan screenshot tampilan aplikasi di sini agar pengunjung repo bisa langsung melihat hasil akhirnya tanpa perlu clone dulu.

| Halaman | Preview |
| :--- | :--- |
| Dashboard Admin | `![Dashboard](docs/screenshots/dashboard.png)` |
| Daftar Kamar | `![Rooms](docs/screenshots/rooms.png)` |
| Form Booking | `![Booking](docs/screenshots/booking.png)` |
| Riwayat Pembayaran | `![Payment](docs/screenshots/payment.png)` |

*Simpan file gambar di folder `docs/screenshots/`, lalu ganti kode di atas dengan sintaks gambar Markdown asli (hapus tanda kutip kode `` ` ``).*

## 🧪 Pengujian Menggunakan Postman

> Tambahkan link koleksi Postman kamu di sini agar tim/reviewer bisa langsung mencoba API tanpa setup manual.

1. Import file koleksi Postman: [`postman/Hotel-Booking-API.postman_collection.json`](postman/Hotel-Booking-API.postman_collection.json)
2. Import environment: [`postman/Hotel-Booking-API.postman_environment.json`](postman/Hotel-Booking-API.postman_environment.json)
3. Atur variable `base_url` sesuai alamat server lokal kamu (contoh: `http://127.0.0.1:8000`)
4. Login terlebih dahulu melalui endpoint autentikasi untuk mendapatkan token, lalu set token tersebut pada variable `auth_token`
5. Jalankan koleksi request satu per satu, atau gunakan fitur **Runner** untuk menjalankan seluruh test sekaligus

## ✅ Unit Testing

Buat database terpisah khusus untuk keperluan testing, lalu tambahkan kredensialnya ke file `.env`:

```env
DB_TEST_DATABASE=test_db
DB_TEST_USERNAME=test_db_username
DB_TEST_PASSWORD=test_db_password
```

Jalankan seluruh test suite dengan:

```bash
php artisan test
```

## 📄 Lisensi

Proyek ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).