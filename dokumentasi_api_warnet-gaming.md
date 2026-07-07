## **TUGAS**

## **BASIS DATA LANJUT**

_Sistem Manajemen Warnet Gaming (WarnetGaming)_

## **PERANCANGAN DAN IMPLEMENTASI**

_Skema Basis Data, Migrasi Laravel, Eloquent Model, RESTful API, Controller, dan Keamanan_

**Disusun Oleh :**

## PROGRAM STUDI TEKNIK INFORMATIKA FAKULTAS TEKNIK UNIVERSITAS PGRI RONGGOLAWE TUBAN

Dokumentasi Pengerjaan WarnetGaming – UNIROW Tuban

---

## **DAFTAR ISI**
BAB 1 – PENDAHULUAN
1.1 Latar Belakang
1.2 Tujuan Pengerjaan
1.3 Ruang Lingkup
1.4 Teknologi yang Digunakan
BAB 2 – PERANCANGAN BASIS DATA
2.1 Diagram Relasi Antar Tabel
2.2 Detail Tabel
2.3 Script DataBase
BAB 3 – IMPLEMENTASI MODEL ELOQUENT
3.1 Daftar Model
3.2 Urutan Migrasi
BAB 4 – IMPLEMENTASI API (RESTFUL)
4.1 Spesifikasi Umum API
4.2 Daftar Lengkap Endpoint API
4.3 Alur Validasi Pemesanan Makanan
BAB 5 – IMPLEMENTASI CONTROLLER
5.1 Struktur Controller
5.2 Fitur Khusus Controller
BAB 6 – ROUTING DAN STRUKTUR FILE
6.1 API Routes (routes/api.php)
BAB 7 – DATABASE SEEDER & PANDUAN INSTALASI
7.1 DatabaseSeeder
BAB 8 – KEAMANAN SISTEM
8.1 Strategi Keamanan
BAB 9 – PENUTUP
9.1 Rangkuman Hasil Pengerjaan

---

## **BAB 1 – PENDAHULUAN**

### **1.1 Latar Belakang**
Sistem manajemen warnet konvensional seringkali tidak terintegrasi dengan baik antara penyewaan PC, manajemen keanggotaan (membership), dan pemesanan makanan/minuman (F&B). Hal ini menyebabkan rekapan pendapatan sering tidak akurat dan rentan manipulasi. Oleh karena itu, diperlukan sistem *WarnetGaming* berbasis RESTful API yang melacak setiap sesi bermain, penggunaan PC, transaksi pembayaran, hingga inventaris makanan secara *real-time*.

### **1.2 Tujuan Pengerjaan**
1. Merancang skema basis data relasional untuk sistem manajemen warnet.
2. Membangun Migration Laravel dan Eloquent Model dengan relasi yang kompleks.
3. Mengembangkan API RESTful menggunakan otorisasi berbasis *Role* (Sanctum).
4. Menyediakan dokumentasi teknis yang terstruktur.

### **1.3 Ruang Lingkup**
Pengerjaan mencakup seluruh lapisan aplikasi back-end (Laravel), dari perancangan database, implementasi Controller, *Form Request Validation*, pengelolaan *concurrency* dengan transaksi database, hingga keamanan API.

### **1.4 Teknologi yang Digunakan**
| Komponen | Teknologi | Fungsi |
|---|---|---|
| Framework | Laravel 11 | Back-end & routing API |
| Bahasa | PHP 8.3+ | Server-side scripting |
| Database | MySQL 8.0+ | Penyimpanan data relasional |
| Auth API | Laravel Sanctum | Bearer Token authentication |
| ORM | Eloquent | Abstraksi database & SoftDeletes |

---

## **BAB 2 – PERANCANGAN BASIS DATA**

### **2.1 Diagram Relasi Antar Tabel**
Basis data *WarnetGaming* terdiri dari tabel-tabel utama yang saling terhubung:
- `users` (1:1) `pelanggans`
- `users` (1:1) `operators`
- `memberships` (1:N) `pelanggans`
- `rooms` (1:N) `pcs`
- `pcs` (M:N) `games` (melalui `pc_games`)
- `pelanggans`, `pcs`, `rooms`, `operators` (1:N) `gaming_sessions`
- `gaming_sessions` (1:N) `session_games`
- `gaming_sessions` (1:N) `food_orders`
- `food_orders` (1:N) `food_order_items`
- `food_beverages` (1:N) `food_order_items`
- `gaming_sessions` (1:N) `payments`

### **2.2 Detail Tabel**

**1. Tabel `users`**
Menyimpan akun login semua peran. Menggunakan *soft-delete*.
| Kolom | Tipe Data | Constraint | Keterangan |
|---|---|---|---|
| id | BIGINT | PK, AI | Primary key |
| name | VARCHAR | NOT NULL | Nama lengkap |
| email | VARCHAR | UNIQUE | Email login |
| password | VARCHAR | NOT NULL | Hash bcrypt |
| role | ENUM | admin,operator,pelanggan | Peran user |
| deleted_at | TIMESTAMP | NULLABLE | Soft delete |

**2. Tabel `pelanggans`**
| Kolom | Tipe Data | Constraint | Keterangan |
|---|---|---|---|
| id | BIGINT | PK, AI | Primary key |
| user_id | BIGINT | FK -> users.id | Referensi login |
| membership_id | BIGINT | FK -> memberships.id | Referensi level |
| status | VARCHAR | NOT NULL | Status pelanggan |
| deleted_at | TIMESTAMP| NULLABLE | Soft delete |

**3. Tabel `gaming_sessions`**
Menyimpan riwayat sesi sewa PC.
| Kolom | Tipe Data | Constraint | Keterangan |
|---|---|---|---|
| id | BIGINT | PK, AI | Primary key |
| pelanggan_id | BIGINT | FK -> pelanggans | Pelanggan penyewa |
| pc_id | BIGINT | FK -> pcs | Komputer yg dipakai |
| room_id | BIGINT | FK -> rooms | Ruangan |
| operator_id | BIGINT | FK -> operators | Operator shift |
| status | VARCHAR | Enum (active/finished) | Status sesi |
| started_at | DATETIME| NOT NULL | Waktu mulai |
| deleted_at | TIMESTAMP| NULLABLE | Soft delete |

**4. Tabel `food_orders` & `food_order_items`**
Mencatat pesanan makanan ke suatu sesi.
- `food_orders`: Menyimpan `gaming_session_id`, `total_amount`, `status` (pending/paid/delivered).
- `food_order_items`: Menyimpan detail `food_beverage_id`, `quantity`, `subtotal`.

---

## **BAB 3 – IMPLEMENTASI MODEL ELOQUENT**

### **3.1 Daftar Model**
Semua model menerapkan `SoftDeletes` untuk melindungi riwayat data.
| No | Model | Tabel | Fitur Khusus / Relasi |
|---|---|---|---|
| 1 | `User` | users | HasApiTokens, SoftDeletes |
| 2 | `Pelanggan` | pelanggans | belongsTo User, belongsTo Membership |
| 3 | `Operator` | operators | belongsTo User. Scopes: onShift(), inRoom() |
| 4 | `Membership` | memberships | hasMany Pelanggan |
| 5 | `Room` | rooms | hasMany Pc, hasMany GamingSession |
| 6 | `Pc` | pcs | belongsTo Room, belongsToMany Game |
| 7 | `Game` | games | belongsToMany Pc |
| 8 | `GamingSession`| gaming_sessions | belongsTo(Pelanggan, Pc, Room, Operator). Scopes: active(), finished() |
| 9 | `SessionGame` | session_games | belongsTo GamingSession, belongsTo Game |
| 10 | `FoodOrder` | food_orders | belongsTo GamingSession, hasMany FoodOrderItem |
| 11 | `FoodOrderItem`| food_order_items| belongsTo FoodOrder, belongsTo FoodBeverage |
| 12 | `FoodBeverage` | food_beverages | hasMany FoodOrderItem |
| 13 | `Payment` | payments | belongsTo GamingSession |

### **3.2 Urutan Migrasi**
Agar relasi *Foreign Key* tidak error, urutan migrasi adalah:
1. `users`, `memberships`, `rooms`, `games`, `food_beverages`
2. `pelanggans`, `operators`, `pcs` (butuh tabel master)
3. `pc_games`
4. `gaming_sessions` (butuh pelanggans, pcs, rooms, operators)
5. `session_games`, `payments`, `food_orders` (butuh gaming_sessions)
6. `food_order_items` (butuh food_orders dan food_beverages)

---

## **BAB 4 – IMPLEMENTASI API (RESTFUL)**

### **4.1 Spesifikasi Umum API**
- **Base URL:** `/api`
- **Auth:** Laravel Sanctum (Bearer Token) dengan Expiration 24 Jam.
- **Format:** `application/json` (Request & Response) menggunakan `JsonResource`.

### **4.2 Daftar Lengkap Endpoint API**

**Modul Auth & Utilitas**
- `GET /health` (Health check server)
- `POST /register` (Public, Rate limit: 6/1)
- `POST /login` (Public, Rate limit: 6/1)
- `POST /logout` (Logout & invalidate token)
- `GET /me` (Ambil data user yang sedang login)

**Modul Master (Read-Only via API)**
- `GET /rooms` & `GET /rooms/{id}`
- `GET /pcs` & `GET /pcs/{id}`
- `GET /games` & `GET /games/{id}`
- `GET /food-beverages` & `GET /food-beverages/{id}`

**Modul Admin & Operator**
- `GET, POST, PUT, DEL /operators`
- `GET, POST, PUT, DEL /memberships`
- `GET, POST, PUT, DEL /pelanggans`
- `GET, POST, PUT, DEL /payments`
- `POST, PUT, DEL /food-beverages` (Kelola stok makanan)

**Modul Transaksi (Sesi & Booking)**
- `POST /booking-sessions`: (Pelanggan) Membuka sesi main baru.
- `GET /gaming-sessions`: Menampilkan history sesi.
- `GET, POST /gaming-sessions/{id}/games`: Menambah game ke sesi.
- `POST /food-orders`: (Pelanggan) Memesan makanan.
- `PUT /food-orders/{id}/status`: (Operator) Update status makanan.

### **4.3 Alur Validasi Pesanan Makanan (POST /food-orders)**
Untuk mencegah *race condition* (pembelian melebihi stok):
1. **Validasi awal:** Pastikan `gaming_session_id` memiliki status `active`.
2. **Lock Database:** Lakukan `DB::transaction()` dan `lockForUpdate()` pada row menu makanan.
3. **Cek Stok:** Jika `stok < quantity`, lempar `InsufficientStockException` (HTTP 409).
4. **Eksekusi:** Kurangi stok makanan, buat data di `food_orders` dan `food_order_items`.

---

## **BAB 5 – IMPLEMENTASI CONTROLLER**

### **5.1 Struktur Controller**
Seluruh logika bisnis diletakkan pada `App\Http\Controllers\Api\*`. API menerapkan `Form Request Validation` di setiap request POST/PUT (contoh: `StorePelangganRequest`, `UpdateRoomRequest`).

### **5.2 Fitur Khusus Controller**
- **Database Transaction & Concurrency:** Di `GamingSessionService` dan `FoodOrderController`, digunakan `DB::transaction()` dengan `lockForUpdate()` untuk mencegah 2 pelanggan membooking 1 PC yang sama di detik yang sama, atau menghabiskan stok yang sama.
- **Custom Exceptions:** Penggunaan `PcNotAvailableException` dan `DuplicateSessionGameException` dengan method `render()` kustom agar selalu mengembalikan HTTP 409 Conflict secara rapi.
- **Eager Loading:** Digunakan secara konsisten (contoh: `Pelanggan::with(['user', 'membership'])`) untuk mencegah anomali *N+1 Query Problem*.
- **JsonResource:** Response tidak me-return model Eloquent secara mentah, melainkan dibungkus dengan class `JsonResource` untuk standarisasi output API.

---

## **BAB 6 – ROUTING DAN STRUKTUR FILE**

### **6.1 API Routes (`routes/api.php`)**
Routing menggunakan *middleware role* kustom:
- `middleware('auth:sanctum')`: Diterapkan ke semua route non-publik.
- `middleware('role:admin')`: Akses mutlak ke modul master.
- `middleware('role:admin,operator')`: Akses ke modul kasir (payments, pelanggans, food order status).

---

## **BAB 7 – DATABASE SEEDER & PANDUAN INSTALASI**

### **7.1 DatabaseSeeder**
Karena entitas infrastruktur fisik (seperti PC dan Ruangan) dan master data Game sangat jarang berubah, sistem dilengkapi dengan file Seeder (`RoomSeeder`, `PcSeeder`, `GameSeeder`) untuk menyuntikkan data *dummy* awal saat instalasi:
`php artisan migrate --seed`

---

## **BAB 8 – KEAMANAN SISTEM**

### **8.1 Strategi Keamanan**
1. **Validasi Input:** Seluruh data dijamin kebersihannya menggunakan validasi Laravel Form Request.
2. **Rate Limiting:** `/login` dan `/register` dibatasi maksimal 6 percobaan per menit (`throttle:6,1`) untuk menangkal brute-force attack.
3. **Sanctum Expiration:** Token Sanctum diatur kedaluwarsa dalam waktu 24 jam.
4. **SoftDeletes:** Mencegah hilangnya data riwayat (seperti riwayat booking) akibat proses *cascade delete* yang tidak disengaja.

---

## **BAB 9 – PENUTUP**

### **9.1 Rangkuman Hasil Pengerjaan**
Pengembangan sistem *WarnetGaming* berhasil mengimplementasikan seluruh kebutuhan manajemen operasional warnet modern dalam bentuk RESTful API. Struktur *database* telah dinormalisasi hingga tahap 3NF, sistem *routing* dilindungi oleh kontrol akses berbasis peran (RBAC), dan masalah keamanan kongkurensi transaksi (seperti perebutan PC atau stok) berhasil diselesaikan menggunakan kombinasi *database locks* dan mekanisme pengecualian (Exception) bawaan Laravel.
