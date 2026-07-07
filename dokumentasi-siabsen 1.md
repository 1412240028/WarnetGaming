## **TUGAS** 

## **BASIS DATA LANJUT** 

_Sistem Informasi Absensi Online Mahasiswa (SIABSEN)_ 

## **PERANCANGAN DAN IMPLEMENTASI** 

_Skema Basis Data, Migrasi Laravel, Eloquent Model, RESTful API (52 Endpoint), Controller, dan View Blade_ 

**Disusun Oleh :** 

## PROGRAM STUDI TEKNIK INFORMATIKA FAKULTAS TEKNIK UNIVERSITAS PGRI RONGGOLAWE TUBAN 

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

## **DAFTAR ISI** 

DAFTAR ISI ......................................................................................................................... 1 BAB 1 – PENDAHULUAN ................................................................................................... 2 1.1  Latar Belakang .......................................................................................................... 2 1.2  Tujuan Pengerjaan .................................................................................................... 2 1.3  Ruang Lingkup .......................................................................................................... 2 1.4  Teknologi yang Digunakan ....................................................................................... 2 BAB 2 – PERANCANGAN BASIS DATA ............................................................................ 3 2.1  Diagram Relasi Antar Tabel ...................................................................................... 4 2.2  Detail Tabel ............................................................................................................... 4 2.2.1  Tabel users ......................................................................................................... 4 2.2.2  Tabel mahasiswa ............................................................................................... 5 2.2.3  Tabel dosen ........................................................................................................ 5 2.2.4  Tabel mata_kuliah .............................................................................................. 5 2.2.5  Tabel jadwal_kuliah ............................................................................................ 6 2.2.6  Tabel krs_mahasiswa......................................................................................... 6 2.2.7  Tabel sesi_absensi ............................................................................................. 6 2.2.8  Tabel absensi ..................................................................................................... 7 2.2.9  Tabel notifikasi.................................................................................................... 8 2.3  Script DataBase ........................................................................................................ 8 BAB 3 – IMPLEMENTASI MODEL ELOQUENT................................................................. 8 3.1  Daftar Model .............................................................................................................. 9 3.2  Script ......................................................................................................................... 9 3.2.1 User ..................................................................................................................... 9 3.2.2 Mahasiswa ......................................................................................................... 11 3.2.3 Dosen ................................................................................................................ 12 3.2.4 Mata Kuliah ........................................................................................................ 12 3.2.5 Jadwal Kuliah .................................................................................................... 13 3.2.6 KRS Mahasiswa ................................................................................................ 14 3.3  Urutan Migrasi ......................................................................................................... 15 BAB 4 – IMPLEMENTASI API (RESTFUL) ....................................................................... 15 4.1  Spesifikasi Umum API ............................................................................................ 16 4.2  Daftar Lengkap Endpoint API ................................................................................. 16 4.2.1  Modul Auth ....................................................................................................... 16 4.2.2  Modul Mahasiswa ............................................................................................. 16 4.2.3  Modul Dosen .................................................................................................... 17 4.2.4  Modul Mata Kuliah & Jadwal ............................................................................ 17 4.2.5  Modul KRS ....................................................................................................... 17 4.2.6  Modul Sesi Absensi (termasuk QR) ................................................................. 17 

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

4.2.7  Modul Absensi & Laporan ................................................................................ 18 4.2.8  Modul Notifikasi ................................................................................................ 18 4.3  Alur Validasi Absensi QR (POST /api/absensi) ...................................................... 18 4.4  Mekanisme QR Token (Rotasi 30 Detik) ................................................................ 19 BAB 5 – IMPLEMENTASI CONTROLLER ........................................................................ 19 5.1  Struktur Controller ................................................................................................... 19 5.2  Fitur Khusus Controller ........................................................................................... 20 5.2.1  Kalkulasi Jarak GPS – Formula Haversine...................................................... 21 5.2.2  Database Transaction ...................................................................................... 21 5.2.3  Eager Loading .................................................................................................. 21 BAB 6 – IMPLEMENTASI VIEWS BLADE ........................................................................ 21 6.1  Struktur Direktori Views .......................................................................................... 22 6.2  Fitur Khusus View ................................................................................................... 22 6.2.1  Panel QR Real-Time (sesi-absensi/show.blade.php) ...................................... 23 6.2.2  Tombol Ambil Lokasi GPS ............................................................................... 23 6.2.3  Layout Sidebar Responsive ............................................................................. 23 6.2.4  Progress Bar Kehadiran ................................................................................... 23 BAB 7 – ROUTING DAN STRUKTUR FILE ...................................................................... 23 7.1  Web Routes (routes/web.php) ................................................................................ 24 7.2  API Routes (routes/api.php) ................................................................................... 24 7.3  Struktur Direktori File Lengkap ............................................................................... 25 BAB 8 – DATABASE SEEDER & PANDUAN INSTALASI ............................................... 25 8.1  DatabaseSeeder ..................................................................................................... 26 8.2  Panduan Instalasi Step-by-Step ............................................................................. 26 8.3  Akun Default untuk Pengujian ................................................................................ 26 BAB 9 – KEAMANAN SISTEM .......................................................................................... 27 9.1  Strategi Keamanan ................................................................................................. 28 9.2  Catatan Keamanan Tambahan ............................................................................... 28 BAB 10 – PENUTUP.......................................................................................................... 28 10.1  Rangkuman Hasil Pengerjaan .............................................................................. 29 10.2  Fitur Unggulan ....................................................................................................... 29 10.3  Rekomendasi Pengembangan Lanjutan .............................................................. 29 

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

## **BAB 1 – PENDAHULUAN** 

## **1.1  Latar Belakang** 

Sistem absensi konvensional berbasis tanda tangan kertas masih banyak digunakan di perguruan tinggi dan memiliki berbagai kelemahan: rentan manipulasi, tidak efisien dalam rekap data, serta tidak mendukung transparansi real-time. Universitas PGRI Ronggolawe Tuban (UNIROW) memerlukan solusi digital yang mampu mengintegrasikan validasi kehadiran mahasiswa secara otomatis. 

SIABSEN (Sistem Informasi Absensi Online Mahasiswa) dirancang sebagai jawaban atas kebutuhan tersebut, menggunakan teknologi QR Code dengan rotasi token dinamis, validasi GPS berbasis geofencing, serta arsitektur RESTful API yang dapat dikonsumsi oleh aplikasi mobile maupun web. 

## **1.2  Tujuan Pengerjaan** 

1. Merancang dan mengimplementasikan skema basis data relasional untuk sistem absensi online. 

2. Membangun Migration Laravel beserta Eloquent Model untuk seluruh entitas sistem. 

3. Mengembangkan API RESTful dengan menggunakan Laravel Sanctum. 

4. Membuat antarmuka web (Blade) lengkap dengan panel admin, dosen, dan mahasiswa. 

5. Menyediakan dokumentasi teknis yang komprehensif untuk keperluan pengembangan lebih lanjut. 

## **1.3  Ruang Lingkup** 

Pengerjaan mencakup seluruh lapisan aplikasi back-end dan front-end Laravel, mulai dari perancangan database hingga implementasi view Blade. Tidak termasuk dalam ruang lingkup: konfigurasi server produksi, integrasi Firebase Cloud Messaging (FCM), dan pengembangan aplikasi mobile. 

## **1.4  Teknologi yang Digunakan** 

||||
|---|---|---|
|**Komponen**|**Teknologi / Versi**|**Fungsi**|
|Framework<br>Bahasa<br>Database<br>Cache/Token<br>Auth API<br>ORM<br>Front-end<br>Penyimpanan<br>Node.js|Laravel 11.x<br>PHP 8.2+<br>MySQL 8.0+<br>Redis 7.x<br>Laravel Sanctum<br>Eloquent<br>Blade + Bootstrap 5.3<br>AWS S3 (opsional)<br>18+|Back-end & routing<br>Server-side scripting<br>Penyimpanan data utama<br>QR token TTL 30 detik<br>Bearer Token authentication<br>Abstraksi database<br>Tampilan web panel<br>Foto selfie & wajah<br>Build tools|



Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

## **BAB 2 – PERANCANGAN BASIS DATA** 

## **2.1  Diagram Relasi Antar Tabel** 

Basis data SIABSEN terdiri dari 9 (sembilan) tabel yang saling berelasi. Berikut adalah gambaran relasi antar entitas: 

|||||
|---|---|---|---|
|**Tabel Asal**|**Kardinalitas**|**Tabel Tujuan**|**Keterangan**|
|users<br>users<br>mahasiswa<br>dosen<br>mata_kuliah<br>jadwal_kuliah<br>jadwal_kuliah<br>sesi_absensi<br>mahasiswa<br>users|1 : 0..1<br>1 : 0..1<br>1 : N<br>1 : N<br>1 : N<br>1 : N<br>1 : N<br>1 : N<br>1 : N<br>1 : N|mahasiswa<br>dosen<br>krs_mahasiswa<br>jadwal_kuliah<br>jadwal_kuliah<br>krs_mahasiswa<br>sesi_absensi<br>absensi<br>absensi<br>notifikasi|Satu user bisa punya satu profil<br>mahasiswa<br>Satu user bisa punya satu profil<br>dosen<br>Satu mahasiswa bisa memiliki<br>banyak KRS<br>Satu dosen bisa mengampu<br>banyak jadwal<br>Satu MK bisa memiliki banyak<br>jadwal<br>Satu jadwal diikuti banyak<br>mahasiswa (KRS)<br>Satu jadwal memiliki banyak sesi<br>pertemuan<br>Satu sesi berisi banyak record<br>absensi<br>Satu mahasiswa bisa absen di<br>banyak sesi<br>Satu user bisa menerima banyak<br>notifikasi|



## **2.2  Detail Tabel** 

## **2.2.1  Tabel users** 

Tabel pusat yang menyimpan akun login untuk semua peran (mahasiswa, dosen, admin). Menggunakan soft-delete agar data historis tetap terjaga. 

|||||
|---|---|---|---|
|**Kolom**|**Tipe Data**|**Constraint**|**Keterangan**|
|id|BIGINT<br>UNSIGNED|PK, AI|Primary key auto-increment|
|nama|VARCHAR(100)|NOT NULL|Nama lengkap user|
|email|VARCHAR(150)|UNIQUE, NOT<br>NULL|Email login|
|password|VARCHAR(255)|NOT NULL|Hash bcrypt|
|role|ENUM|mahasiswa/dosen/<br>admin|Peran user|



Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

|||||
|---|---|---|---|
|**Kolom**|**Tipe Data**|**Constraint**|**Keterangan**|
|foto_profil|VARCHAR(500)|NULLABLE|Path foto profil|
|fcm_token|VARCHAR(255)|NULLABLE|Token Firebase Push|
|is_active|TINYINT(1)|DEFAULT 1|Status aktif akun|
|deleted_at|TIMESTAMP|NULLABLE|Soft delete|
|created_at/update<br>d_at|TIMESTAMP|AUTO|Timestamp sistem|



## **2.2.2  Tabel mahasiswa** 

|||||
|---|---|---|---|
|**Kolom**|**Tipe Data**|**Constraint**|**Keterangan**|
|id|BIGINT<br>UNSIGNED|PK, AI|Primary key|
|user_id|BIGINT<br>UNSIGNED|FK → users.id|Referensi akun login|
|nim|VARCHAR(20)|UNIQUE, NOT NULL|Nomor Induk Mahasiswa|
|jurusan|VARCHAR(100)|NOT NULL|Nama jurusan|
|program_studi|VARCHAR(100)|NOT NULL|Program studi|
|angkatan|YEAR|NOT NULL|Tahun angkatan|
|foto_wajah_ref|VARCHAR(500)|NULLABLE|Path foto referensi wajah<br>(S3)|



## **2.2.3  Tabel dosen** 

|**2.2.3  Tabel dosen**||||
|---|---|---|---|
|||||
|**Kolom**|**Tipe Data**|**Constraint**|**Keterangan**|
|id|BIGINT<br>UNSIGNED|PK, AI|Primary key|
|user_id|BIGINT<br>UNSIGNED|FK → users.id|Referensi akun login|
|nidn|VARCHAR(20)|UNIQUE|Nomor Induk Dosen Nasional|
|jabatan|VARCHAR(100)|NULLABLE|Jabatan fungsional|
|bidang_ilmu|VARCHAR(100)|NULLABLE|Bidang keahlian|



## **2.2.4  Tabel mata_kuliah** 

|||||
|---|---|---|---|
|**Kolom**|**Tipe Data**|**Constraint**|**Keterangan**|
|id|BIGINT<br>UNSIGNED|PK, AI|Primary key|
|kode_mk|VARCHAR(15)|UNIQUE|Kode mata kuliah (mis. SI-301)|
|nama_mk|VARCHAR(150)|NOT NULL|Nama lengkap mata kuliah|



Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

|||||
|---|---|---|---|
|**Kolom**|**Tipe Data**|**Constraint**|**Keterangan**|
|sks|TINYINT<br>UNSIGNED|NOT NULL|Jumlah SKS (1–6)|
|semester|TINYINT<br>UNSIGNED|NOT NULL|Semester penyelenggaraan (1–<br>8)|
|program_studi|VARCHAR(100)|NOT NULL|Program studi penyelenggara|



## **2.2.5  Tabel jadwal_kuliah** 

|||||
|---|---|---|---|
|**Kolom**|**Tipe Data**|**Constraint**|**Keterangan**|
|id|BIGINT<br>UNSIGNED|PK, AI|Primary key|
|mata_kuliah_id|BIGINT<br>UNSIGNED|FK → mata_kuliah|Referensi mata kuliah|
|dosen_id|BIGINT<br>UNSIGNED|FK → dosen|Referensi dosen pengampu|
|hari|ENUM|Senin–Sabtu|Hari penyelenggaraan|
|jam_mulai|TIME|NOT NULL|Jam mulai perkuliahan|
|jam_selesai|TIME|NOT NULL|Jam selesai perkuliahan|
|ruangan|VARCHAR(50)|NOT NULL|Kode ruangan|
|lat_pusat|DECIMAL(10,7)|NOT NULL|Latitude titik pusat geofence|
|lng_pusat|DECIMAL(10,7)|NOT NULL|Longitude titik pusat geofence|
|radius_meter|SMALLINT|DEFAULT 100|Radius validasi GPS (meter)|
|tahun_ajaran|VARCHAR(15)|NOT NULL|Mis: 2024/2025 Genap|



## **2.2.6  Tabel krs_mahasiswa** 

|||||
|---|---|---|---|
|**Kolom**|**Tipe Data**|**Constraint**|**Keterangan**|
|id|BIGINT<br>UNSIGNED|PK, AI|Primary key|
|mahasiswa_id|BIGINT<br>UNSIGNED|FK → mahasiswa|Referensi mahasiswa|
|jadwal_id|BIGINT<br>UNSIGNED|FK → jadwal_kuliah|Referensi jadwal kuliah|
|semester|TINYINT|NOT NULL|Semester aktif (1–8)|
|tahun_ajaran|VARCHAR(15)|NOT NULL|Tahun ajaran aktif|
|status|ENUM|aktif/tidak_aktif|Status pendaftaran KRS|



_Constraint unik: (mahasiswa_id, jadwal_id, tahun_ajaran) mencegah pendaftaran ganda._ 

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

## **2.2.7  Tabel sesi_absensi** 

|||||
|---|---|---|---|
|**Kolom**|**Tipe Data**|**Constraint**|**Keterangan**|
|id|BIGINT<br>UNSIGNED|PK, AI|Primary key|
|jadwal_id|BIGINT<br>UNSIGNED|FK → jadwal|Referensi jadwal|
|tanggal|DATE|NOT NULL|Tanggal pertemuan|
|jam_buka|DATETIME|NULLABLE|Waktu sesi dibuka|
|jam_tutup||||
||DATETIME|NULLABLE|Waktu sesi ditutup|
|qr_token|VARCHAR(100)|NULLABLE,<br>INDEX|UUID token QR aktif|
|qr_expired_at|DATETIME|NULLABLE|Waktu kadaluarsa QR (TTL 30<br>dtk)|
|status|ENUM|aktif/tutup|Status sesi|
|pertemuan_ke|TINYINT|NOT NULL|Urutan pertemuan (1–16)|
|dibuka_oleh|BIGINT<br>UNSIGNED|FK → users|Dosen/admin yang membuka<br>sesi|



## **2.2.8  Tabel absensi** 

|||||
|---|---|---|---|
|**Kolom**|**Tipe Data**|**Constraint**|**Keterangan**|
|id|BIGINT<br>UNSIGNED|PK, AI|Primary key|
|sesi_id|BIGINT<br>UNSIGNED|FK → sesi|Referensi sesi absensi|
|mahasiswa_id|BIGINT<br>UNSIGNED|FK → mahasiswa|Referensi mahasiswa|
|jam_absen|DATETIME|NULLABLE|Waktu mahasiswa melakukan<br>absen|
|status|ENUM|Hadir/Telat/…|Status kehadiran|
|lat_absen|DECIMAL(10,7)|NULLABLE|Latitude lokasi absensi|
|lng_absen|DECIMAL(10,7)|NULLABLE|Longitude lokasi absensi|
|jarak_meter|DECIMAL(8,2)|NULLABLE|Jarak ke titik pusat ruangan|
|is_gps_valid|BOOLEAN|DEFAULT false|Validasi GPS dalam radius|
|foto_selfie|VARCHAR(500)|NULLABLE|Path foto selfie (S3)|
|face_score|DECIMAL(5,4)|NULLABLE|Skor kemiripan wajah (0–1)|
|is_face_valid|BOOLEAN|DEFAULT false|Validasi wajah lolos threshold|
|catatan|VARCHAR(255)|NULLABLE|Catatan override dosen/admin|
|is_valid|BOOLEAN|DEFAULT true|Status keabsahan record|



Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

_Constraint unik: (sesi_id, mahasiswa_id) memastikan satu mahasiswa hanya absen sekali per sesi._ 

## **2.2.9  Tabel notifikasi** 

|||||
|---|---|---|---|
|**Kolom**|**Tipe Data**|**Constraint**|**Keterangan**|
|id|BIGINT<br>UNSIGNED|PK, AI|Primary key|
|user_id|BIGINT<br>UNSIGNED|FK → users|Penerima notifikasi|
|judul|VARCHAR(100)|NOT NULL|Judul notifikasi|
|pesan|TEXT|NOT NULL|Isi pesan|
|tipe|ENUM|absensi/pengumuman/sis<br>tem|Kategori notif|
|is_read|BOOLEAN|DEFAULT false|Status sudah dibaca|
|fcm_message_id|VARCHAR(100)|NULLABLE|ID pesan dari Firebase|
|data_payload|VARCHAR(500)|NULLABLE|Data tambahan (JSON<br>string)|



## **2.3  Script DataBase** 

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

## **BAB 3 – IMPLEMENTASI MODEL ELOQUENT** 

## **3.1  Daftar Model** 

Seluruh model Eloquent diimplementasikan di direktori app/Models/ dengan fitur: relationships, fillable, casts, dan query scopes. 

||||||
|---|---|---|---|---|
|**No**|**Model**|**Tabel**|**Relasi Utama**|**Fitur Khusus**|
|1|User|users|hasOne(Mahasiswa),<br>hasOne(Dosen),<br>hasMany(Notifikasi)|SoftDeletes,<br>HasApiTokens,<br>Sanctum|
|2|Mahasisw<br>a|mahasiswa|belongsTo(User),<br>hasMany(KrsMahasiswa),<br>hasMany(Absensi)|Scopes: byProdi,<br>byAngkatan|
|3|Dosen|dosen|belongsTo(User),<br>hasMany(JadwalKuliah)|—|
|4|MataKulia<br>h|mata_kuliah|hasMany(JadwalKuliah)|Scopes: byProdi,<br>bySemester|
|5|JadwalKul<br>iah|jadwal_kuliah|belongsTo(MataKuliah),<br>belongsTo(Dosen),<br>hasMany(SesiAbsensi),<br>hasMany(KrsMahasiswa)|Scopes: byHari,<br>byTahunAjaran|
|6|KrsMahasi<br>swa|krs_mahasisw<br>a|belongsTo(Mahasiswa),<br>belongsTo(JadwalKuliah)|Scope: aktif|
|7|SesiAbse<br>nsi|sesi_absensi|belongsTo(JadwalKuliah),<br>belongsTo(User dibuka_oleh),<br>hasMany(Absensi)|Cast datetime, helper<br>isQrValid()|
|8|Absensi|absensi|belongsTo(SesiAbsensi),<br>belongsTo(Mahasiswa)|Scopes: hadir, alfa,<br>valid|
|9|Notifikasi|notifikasi|belongsTo(User)|Scopes: unread, byTipe|



## **3.2  Script** 

## **3.2.1 User** 

```
<?php
namespace App\Models;
```

```
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
```

```
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
```

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

```
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'foto_profil',
        'fcm_token',
        'is_active',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];
    // ─── Relationships
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }
    public function dosen()
    {
        return $this->hasOne(Dosen::class);
    }
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }
    public function sesiDibuka()
    {
        return $this->hasMany(SesiAbsensi::class,
'dibuka_oleh');
    }
    // ─── Helpers
    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }
    public function isDosen(): bool
    {
        return $this->role === 'dosen';
    }
```

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

```
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
```

## **3.2.2 Mahasiswa** 

```
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa';
    protected $fillable = [
        'user_id',
        'nim',
        'jurusan',
        'program_studi',
        'angkatan',
        'foto_wajah_ref',
    ];
    // ─── Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function krsMahasiswa()
    {
        return $this->hasMany(KrsMahasiswa::class);
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
    //Scopes
    public function scopeByProdi($query, string $prodi)
    {
        return $query->where('program_studi', $prodi);
    }
    public function scopeByAngkatan($query, int $tahun)
{
```

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

```
        return $query->where('angkatan', $tahun);
    }
}
```

## **3.2.3 Dosen** 

```
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Dosen extends Model
{
    use HasFactory;
    protected $table = 'dosen';
    protected $fillable = [
        'user_id',
        'nidn',
        'jabatan',
        'bidang_ilmu',
    ];
    // ─── Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function jadwalKuliah()
    {
        return $this->hasMany(JadwalKuliah::class);
    }
}
```

## **3.2.4 Mata Kuliah** 

```
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class MataKuliah extends Model
{
    use HasFactory;
    protected $table = 'mata_kuliah';
    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'sks',
```

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

```
        'semester',
        'program_studi',
    ];
    // Relationships
    public function jadwalKuliah()
    {
        return $this->hasMany(JadwalKuliah::class);
    }
    // ─── Scopes
    public function scopeByProdi($query, string $prodi)
    {
        return $query->where('program_studi', $prodi);
    }
    public function scopeBySemester($query, int $semester)
    {
        return $query->where('semester', $semester);
    }
}
```

## **3.2.5 Jadwal Kuliah** 

```
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class JadwalKuliah extends Model
{
    use HasFactory;
    protected $table = 'jadwal_kuliah';
    protected $fillable = [
        'mata_kuliah_id',
        'dosen_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'lat_pusat',
        'lng_pusat',
        'radius_meter',
        'tahun_ajaran',
    ];
    // ─── Relationships
────────────────────────────────────────────────────────
    public function mataKuliah()
{
```

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

```
        return $this->belongsTo(MataKuliah::class);
    }
    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
    public function krsMahasiswa()
    {
        return $this->hasMany(KrsMahasiswa::class,
'jadwal_id');
    }
    public function sesiAbsensi()
    {
        return $this->hasMany(SesiAbsensi::class, 'jadwal_id');
    }
    // Scopes
    public function scopeByHari($query, string $hari)
    {
        return $query->where('hari', $hari);
    }
    public function scopeByTahunAjaran($query, string
$tahunAjaran)
    {
        return $query->where('tahun_ajaran', $tahunAjaran);
    }
}
```

## **3.2.6 KRS Mahasiswa** 

```
<?php
```

```
namespace App\Models;
```

```
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
```

```
class KrsMahasiswa extends Model
{
    use HasFactory;
    protected $table = 'krs_mahasiswa';
    protected $fillable = [
        'mahasiswa_id',
        'jadwal_id',
        'semester',
        'tahun_ajaran',
        'status',
    ];
// Relationships
```

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

```
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
    public function jadwalKuliah()
    {
        return $this->belongsTo(JadwalKuliah::class,
'jadwal_id');
    }
    // ─── Scopes
───────────────────────────────────────────────────────────────
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
```

## **3.3  Urutan Migrasi** 

Urutan migrasi sangat penting untuk menjaga integritas foreign key. Tabel yang direferensikan harus dibuat terlebih dahulu: 

|||||
|---|---|---|---|
|**Urut**<br>**an**|**File Migrasi**|**Tabel Dibuat**|**Dependensi FK**|
|||||
|1|000001_create_users_table|users|—  (tabel dasar)|
|||||
|2|000002_create_mahasiswa_t<br>able|mahasiswa|users.id|
|||||
|3|000003_create_dosen_table|dosen|users.id|
|||||
|4|000004_create_mata_kuliah_t<br>able|mata_kuliah|—|
|||||
|||||
|5|000005_create_jadwal_kuliah<br>_table|jadwal_kuliah|mata_kuliah.id, dosen.id|
|||||
|6|000006_create_krs_mahasisw<br>a_table|krs_mahasiswa|mahasiswa.id, jadwal_kuliah.id|
|||||
|7|000007_create_sesi_absensi_<br>table|sesi_absensi|jadwal_kuliah.id, users.id|
|||||
|8|000008_create_absensi_table|absensi|sesi_absensi.id, mahasiswa.id|
|||||
|9|000009_create_notifikasi_tabl<br>e|notifikasi|users.id|
|||||



Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

## **BAB 4 – IMPLEMENTASI API (RESTFUL)** 

## **4.1  Spesifikasi Umum API** 

|**Atribut**|**Nilai**|
|---|---|
|||
|Base URL|https://api.absensi.unirow.ac.id/api|
|||
|Autentikasi|Laravel Sanctum – Bearer Token|
|||
|Format Request|application/json|
|||
|||
|Format Response|application/json|
|||
|Total Endpoint|52 endpoint|
|||
|Versi|v1.0|
|||



## **4.2  Daftar Lengkap Endpoint API** 

Seluruh endpoint (kecuali POST /auth/login dan POST /auth/register) memerlukan header Authorization: Bearer {token}. 

## **4.2.1  Modul Auth** 

|||||
|---|---|---|---|
|**Metho**<br>**d**|**Endpoint**|**Akses**|**Keterangan**|
|||||
|POST|/auth/login|Public|Login, mendapatkan Bearer token|
|||||
|POST|/auth/register|Public|Registrasi user baru (admin only flow)|
|||||
|||||
|POST|/auth/logout|Auth|Logout, hapus token aktif|
|||||
|GET|/auth/me|Auth|Data profil user yang sedang login|
|||||
|PUT|/auth/update-profile|Auth|Update nama, foto, FCM token|
|||||
|PUT|/auth/change-password|Auth|Ganti password dengan verifikasi lama|
|||||



## **4.2.2  Modul Mahasiswa** 

|**Metho**<br>**d**|**Endpoint**|**Akses**|**Keterangan**|
|---|---|---|---|
|||||
|GET|/mahasiswa|Auth|Daftar mahasiswa (filter: prodi, angkatan, nim,<br>search)|
|||||
|POST|/mahasiswa|Auth|Tambah mahasiswa baru beserta akun login<br>(transaction)|
|||||
|GET|/mahasiswa/{id}|Auth|Detail mahasiswa + daftar KRS aktif|
|||||
|PUT|/mahasiswa/{id}|Auth|Update data mahasiswa & user dalam satu<br>transaction|
|||||
|DELE<br>TE|/mahasiswa/{id}|Auth|Soft-delete user (otomatis cascade ke mahasiswa)|
|||||



Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

## **4.2.3  Modul Dosen** 

|||||
|---|---|---|---|
|**Metho**<br>**d**|**Endpoint**|**Akses**|**Keterangan**|
|||||
|GET|/dosen|Auth|Daftar dosen (filter: search, nidn)|
|||||
|POST|/dosen|Auth|Tambah dosen baru beserta akun login|
|||||
|GET|/dosen/{id}|Auth|Detail dosen + jadwal mengajar|
|||||
|PUT|/dosen/{id}|Auth|Update data dosen|
|||||
|||||
|DELE<br>TE|/dosen/{id}|Auth|Hapus dosen (soft-delete user)|
|||||



## **4.2.4  Modul Mata Kuliah & Jadwal** 

||||
|---|---|---|
|**Method**|**Endpoint**|**Keterangan**|
||||
|GET/POST|/mata-kuliah|List & tambah mata kuliah (filter: prodi,<br>semester)|
||||
|GET/PUT/DEL<br>ETE|/mata-kuliah/{id}|Detail, update, hapus mata kuliah|
||||
|GET/POST|/jadwal-kuliah|List & tambah jadwal (filter: hari, tahun_ajaran,<br>dosen_id)|
||||
|GET/PUT/DEL<br>ETE|/jadwal-kuliah/{id}|Detail, update, hapus jadwal kuliah|
||||



## **4.2.5  Modul KRS** 

||||
|---|---|---|
|**Metho**<br>**d**|**Endpoint**|**Keterangan**|
||||
|GET|/krs|Daftar KRS (filter: mahasiswa_id, jadwal_id, tahun_ajaran, status)|
||||
|POST|/krs|Daftarkan KRS baru (cek duplikasi unik<br>mahasiswa+jadwal+tahun)|
||||
|GET|/krs/{id}|Detail KRS|
||||
|PUT|/krs/{id}|Update status KRS (aktif/tidak_aktif)|
||||
|DELE<br>TE|/krs/{id}|Hapus KRS|
||||



## **4.2.6  Modul Sesi Absensi (termasuk QR)** 

||||
|---|---|---|
|**Metho**<br>**d**|**Endpoint**|**Keterangan**|
||||
|GET|/sesi-absensi|Daftar sesi (filter: jadwal_id, status, tanggal)|
||||
||||
|POST|/sesi-absensi|Buat sesi baru (cek duplikasi jadwal+tanggal)|
||||
|GET|/sesi-absensi/{id}|Detail sesi + daftar absensi real-time|
||||



Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

|**Metho**<br>**d**|**Endpoint**|**Keterangan**|
|---|---|---|
||||
|PUT|/sesi-absensi/{id}|Update pertemuan_ke atau tanggal|
||||
|DEL|/sesi-absensi/{id}|Hapus sesi|
||||
|POST|/sesi-absensi/{id}/buka|Buka sesi: set status aktif + generate UUID QR token<br>(TTL 30 dtk)|
||||
|POST|/sesi-absensi/{id}/tutup|Tutup sesi: set status tutup + hapus QR token|
||||
|GET|/sesi-absensi/{id}/qr-refresh|Rotasi QR token: generate UUID baru TTL 30 detik|



## **4.2.7  Modul Absensi & Laporan** 

||||
|---|---|---|
|**Metho**<br>**d**|**Endpoint**|**Keterangan**|
||||
|GET|/absensi|Daftar absensi (filter: sesi_id, mahasiswa_id, status)|
||||
|POST|/absensi|Submit absensi: validasi QR + GPS + KRS + duplikasi|
||||
|GET|/absensi/{id}|Detail satu record absensi|
||||
|PUT|/absensi/{id}|Override status absensi oleh dosen/admin + catatan|
||||
|DELE<br>TE|/absensi/{id}|Hapus record absensi|
||||
|GET|/absensi/rekap/mahasiswa/{id}|Rekap kehadiran per MK untuk satu mahasiswa|
||||
|GET|/absensi/rekap/sesi/{id}|Seluruh absensi dalam satu sesi|
||||
|GET|/absensi/rekap/bawah-75|Mahasiswa kehadiran < 75% (filter tahun_ajaran)|
||||



## **4.2.8  Modul Notifikasi** 

||||
|---|---|---|
|**Metho**<br>**d**|**Endpoint**|**Keterangan**|
||||
|GET|/notifikasi|Daftar notifikasi user login (filter: is_read, tipe)|
||||
|POST|/notifikasi|Kirim notifikasi manual (admin)|
||||
|GET|/notifikasi/{id}|Detail notifikasi|
||||
|PUT|/notifikasi/{id}/baca|Tandai satu notifikasi sudah dibaca|
||||
|PUT|/notifikasi/baca-semua|Tandai semua notifikasi user sebagai sudah dibaca|
||||
|DELE<br>TE|/notifikasi/{id}|Hapus notifikasi|
||||



## **4.3  Alur Validasi Absensi QR (POST /api/absensi)** 

Ketika mahasiswa melakukan scan QR dan submit absensi, sistem melakukan validasi berlapis: 

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

|**Lan**<br>**gka**<br>**h**|**Validasi**|**Respons Jika Gagal**|
|---|---|---|
||||
|1|Cek qr_token valid di Redis (TTL 30 dtk) dan<br>status sesi = aktif|422 – QR tidak valid / kadaluarsa|
||||
|2|Cek KRS mahasiswa aktif untuk jadwal terkait<br>sesi|403 – Mahasiswa tidak terdaftar|
||||
|3|Cek duplikasi: mahasiswa belum absen di<br>sesi ini|409 – Sudah absen sebelumnya|
||||
|4|Hitung jarak GPS Haversine antara lokasi<br>mahasiswa dan titik pusat|Record disimpan dengan is_gps_valid =<br>false|
||||
|5|Tentukan status: Hadir jika ≤ 15 mnt dari jam<br>mulai, Telat jika > 15 mnt|Status otomatis diset|
||||
|6|Simpan record absensi ke tabel absensi|201 Created – sukses|
||||



## **4.4  Mekanisme QR Token (Rotasi 30 Detik)** 

Sistem menggunakan UUID v4 yang disimpan di Redis dengan TTL 30 detik untuk mencegah penyebaran token via foto/screenshot: 

||||
|---|---|---|
|**Lan**<br>**gka**<br>**h**|**Aksi**|**Detail**|
||||
|1|Dosen buka sesi|POST /sesi-absensi/{id}/buka → generate UUID, simpan di DB dan<br>Redis (TTL 30 dtk)|
||||
|2|Tampil QR di layar|Front-end render QR dari qr_token, countdown timer 30 detik<br>dimulai|
||||
|3|Rotasi otomatis|Setiap 30 detik: GET /qr-refresh → UUID baru, Redis diperbarui,<br>QR diperbarui|
||||
|4|Mahasiswa scan|Kirim POST /absensi dengan qr_token yang sedang aktif|
||||
|5|Validasi token|Sistem cek token di Redis (bukan DB) → pastikan masih dalam TTL|
||||
||||
|6|Sesi ditutup|POST /tutup → qr_token di DB dan Redis dihapus, status = tutup|
||||



## **BAB 5 – IMPLEMENTASI CONTROLLER** 

## **5.1  Struktur Controller** 

Controller dibagi menjadi dua namespace: Api\ (untuk endpoint JSON) dan Web\ (untuk Blade/HTML). Masing-masing memiliki tanggung jawab berbeda namun berbagi Model yang sama. 

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

|**Name**<br>**space**|**Controller**|**Metode**|**Keterangan**|
|---|---|---|---|
|||||
|Api\|AuthController|login, logout, me,<br>updateProfile,<br>changePassword, register|Auth Sanctum token|
|||||
|Api\|MahasiswaController|index, store, show, update,<br>destroy|CRUD + DB transaction|
|||||
|Api\|DosenController|index, store, show, update,<br>destroy|CRUD + DB transaction|
|||||
|Api\|MataKuliahController|index, store, show, update,<br>destroy|CRUD standard|
|||||
|Api\|JadwalKuliahController|index, store, show, update,<br>destroy|CRUD + eager load|
|||||
|Api\|KrsMahasiswaControlle<br>r|index, store, show, update,<br>destroy|CRUD + cek duplikasi|
|||||
|Api\|SesiAbsensiController|CRUD + buka, tutup,<br>qrRefresh|QR UUID generator|
|||||
|||||
|Api\|AbsensiController|CRUD + rekapMahasiswa,<br>rekapSesi,<br>mahasiswaBawahPersen|Haversine GPS, laporan|
|||||
|Api\|NotifikasiController|CRUD + markRead,<br>markAllRead|Manajemen notifikasi|
|||||
|Web\|AuthWebController|showLogin, login, logout,<br>profile, updateProfile,<br>changePassword|Session auth Blade|
|||||
|Web\|DashboardController|index|Stat cards + sesi aktif|
|||||
|||||
|Web\|MahasiswaWebControll<br>er|index, create, store, show,<br>edit, update, destroy|CRUD + rekap absensi|
|||||
|Web\|DosenWebController|index, create, store, show,<br>edit, update, destroy|CRUD Blade|
|||||
|Web\|MataKuliahWebControll<br>er|index, create, store, edit,<br>update, destroy|CRUD Blade|
|||||
|Web\|JadwalKuliahWebContr<br>oller|index, create, store, show,<br>edit, update, destroy|CRUD + GPS picker|
|||||
|Web\|KrsWebController|index, create, store, update,<br>destroy|CRUD + toggle status|
|||||
|Web\|SesiAbsensiWebContro<br>ller|index, create, store, show,<br>edit, update, destroy, buka,<br>tutup|QR panel real-time|
|||||
|Web\|AbsensiWebController|index, show, edit, update,<br>destroy, bawah75|Laporan + override|
|||||
|Web\|NotifikasiWebController|index, show, destroy,<br>markRead, markAllRead|Inbox notifikasi|



Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

## **5.2  Fitur Khusus Controller** 

## **5.2.1  Kalkulasi Jarak GPS – Formula Haversine** 

AbsensiController mengimplementasikan formula Haversine untuk menghitung jarak antara koordinat GPS mahasiswa dan titik pusat ruangan kuliah: 

_R = 6.371.000 meter (radius bumi)_ 

_a = sin²(Δlat/2) + cos(lat1) × cos(lat2) × sin²(Δlng/2) jarak = R × 2 × atan2(√a, √(1−a))  [dalam meter]_ 

Jika jarak ≤ radius_meter yang dikonfigurasi pada jadwal, maka is_gps_valid = true. 

## **5.2.2  Database Transaction** 

Pembuatan user baru (mahasiswa/dosen) menggunakan DB::transaction() untuk memastikan atomicity – jika pembuatan profil gagal, akun user juga otomatis di-rollback: 

## **5.2.3  Eager Loading** 

Seluruh endpoint yang mengembalikan data berelasi menggunakan with() untuk mencegah masalah N+1 query, contoh: Absensi::with(['mahasiswa.user', 'sesi.jadwalKuliah.mataKuliah']). 

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

## **BAB 6 – IMPLEMENTASI VIEWS BLADE** 

## **6.1  Struktur Direktori Views** 

|||
|---|---|
|**Direktori / File**|**Keterangan**|
|||
|layouts/app.blade.php|Layout utama: sidebar navigasi + topbar + flash<br>messages|
|||
|auth/login.blade.php|Halaman login dengan toggle password visibility|
|||
|auth/profile.blade.php|Halaman profil: edit nama/foto + ganti password|
|||
|||
|dashboard.blade.php|Dashboard: 4 stat card + sesi aktif + peringatan<br>kehadiran|
|||
|mahasiswa/index.blade.php|Tabel daftar mahasiswa dengan filter multi-parameter|
|||
|mahasiswa/form.blade.php|Form create/edit mahasiswa (digunakan bersama)|
|||
|mahasiswa/show.blade.php|Detail mahasiswa: profil + KRS + rekap kehadiran<br>progress bar|
|||
|dosen/index.blade.php|Tabel daftar dosen dengan pencarian|
|||
|dosen/form.blade.php|Form create/edit dosen|
|||
|dosen/show.blade.php|Detail dosen + jadwal mengajar + jumlah sesi|
|||
|mata-kuliah/index.blade.php|Katalog MK dengan filter prodi & semester|
|||
|mata-kuliah/form.blade.php|Form create/edit MK|
|||
|jadwal-kuliah/index.blade.php|Tabel jadwal dengan filter hari & tahun ajaran|
|||
|jadwal-kuliah/form.blade.php|Form jadwal + tombol ambil lokasi GPS otomatis|
|||
|jadwal-kuliah/show.blade.php|Detail jadwal: peserta KRS + riwayat sesi|
|||
|krs/index.blade.php|Daftar KRS mahasiswa + toggle status aktif/nonaktif|
|||
|krs/form.blade.php|Form pendaftaran KRS|
|||
|sesi-absensi/index.blade.php|Daftar sesi + tombol buka/tutup inline|
|||
|sesi-absensi/form.blade.php|Form create/edit sesi|
|||
|sesi-absensi/show.blade.php|Panel monitor: QR live-refresh 30 dtk + tabel absensi<br>auto-refresh 5 dtk|
|||
|absensi/index.blade.php|Tabel absensi + badge status + ikon GPS/wajah|
|||
|absensi/edit.blade.php|Form override status absensi oleh dosen/admin|
|||
|absensi/bawah75.blade.php|Laporan mahasiswa kehadiran < 75% + progress bar|
|||
|notifikasi/index.blade.php|Inbox notifikasi: filter baca/belum + tandai semua<br>dibaca|



Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

## **6.2  Fitur Khusus View** 

## **6.2.1  Panel QR Real-Time (sesi-absensi/show.blade.php)** 

View ini merupakan halaman paling kompleks dalam sistem. Terdapat dua proses JavaScript yang berjalan bersamaan: 

|**Proses**|**Interval**|**Aksi**|**API Endpoint**|
|---|---|---|---|
|||||
|Rotasi QR Token|30 detik|Fetch token baru → render<br>QR baru via qrserver.com API|GET /api/sesi-<br>absensi/{id}/qr-refresh|
|||||
|Refresh Tabel|5 detik|Fetch data absensi terbaru →<br>update DOM tabel|GET<br>/api/absensi/rekap/sesi/{id<br>}|
|||||



## **6.2.2  Tombol Ambil Lokasi GPS** 

Form jadwal kuliah memiliki tombol 'Ambil Lokasi Saat Ini' yang menggunakan browser Geolocation API (navigator.geolocation.getCurrentPosition) untuk mengisi otomatis field latitude dan longitude pusat geofence. 

## **6.2.3  Layout Sidebar Responsive** 

Layout utama menggunakan sidebar fixed dengan gradient biru tua (linear-gradient dari #1A237E ke #283593). Menu sidebar menampilkan item berbeda berdasarkan role user: admin melihat semua menu master data, dosen hanya melihat menu absensi dan jadwal. 

## **6.2.4  Progress Bar Kehadiran** 

Halaman detail mahasiswa dan laporan bawah 75% menampilkan progress bar berwarna: hijau (≥75%), kuning (50–74%), merah (<50%), sehingga memudahkan identifikasi visual status kehadiran. 

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

## **BAB 7 – ROUTING DAN STRUKTUR FILE** 

## **7.1  Web Routes (routes/web.php)** 

Seluruh route web menggunakan middleware auth (Session Laravel) dan dikelompokkan per modul dengan Resource Controller: 

||||
|---|---|---|
|**Route Group**|**Resource Route**|**Tambahan**|
||||
|Auth|login, logout, profile|showLogin, changePassword|
||||
||||
|Mahasiswa|index, create, store, show, edit, update,<br>destroy|—|
||||
|Dosen|index, create, store, show, edit, update,<br>destroy|—|
||||
|Mata Kuliah|index, create, store, edit, update, destroy|—|
||||
|Jadwal Kuliah|index, create, store, show, edit, update,<br>destroy|—|
||||
|KRS|index, create, store, update, destroy|toggle status|
||||
|Sesi Absensi|index, create, store, show, edit, update,<br>destroy|POST /{id}/buka, POST<br>/{id}/tutup|
||||
|Absensi|index, show, edit, update, destroy|GET /absensi-bawah-75|
||||
|Notifikasi|index, show, destroy|PUT /{id}/baca, PUT /baca-<br>semua|
||||



## **7.2  API Routes (routes/api.php)** 

Seluruh route API menggunakan middleware auth:sanctum dan menghasilkan 52 endpoint total: 

|**Modul**|**Jumlah**<br>**Endpoint**|**Metode HTTP**|
|---|---|---|
||||
|Auth|6|POST (3), GET (1), PUT (2)|
||||
|Mahasiswa|5|GET (2), POST (1), PUT (1), DELETE (1)|
||||
|Dosen|5|GET (2), POST (1), PUT (1), DELETE (1)|
||||
|Mata Kuliah|5|GET (2), POST (1), PUT (1), DELETE (1)|
||||
|Jadwal Kuliah|5|GET (2), POST (1), PUT (1), DELETE (1)|
||||
|KRS|5|GET (2), POST (1), PUT (1), DELETE (1)|
||||
|Sesi Absensi|8|GET (3), POST (3), PUT (1), DELETE (1)|
||||
|Absensi|8|GET (4), POST (1), PUT (1), DELETE (1), GET<br>laporan (3)|
||||
|Notifikasi|6|GET (2), POST (1), PUT (2), DELETE (1)|
||||
|TOTAL|52|GET (22), POST (13), PUT (11), DELETE (9)|
||||



Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

## **7.3  Struktur Direktori File Lengkap** 

Berikut pemetaan file ke direktori Laravel yang sesungguhnya setelah instalasi: 

|**File yang Dihasilkan**|**Direktori Tujuan di Laravel**|**Jumlah File**|
|---|---|---|
||||
|Migration *.php|database/migrations/|9 file|
||||
|DatabaseSeeder.php|database/seeders/|1 file|
||||
|Model *.php|app/Models/|9 file|
||||
|Api Controller *.php|app/Http/Controllers/Api/|9 file|
||||
|Web Controller *.php|app/Http/Controllers/Web/|10 file|
||||
|routes/api.php|routes/api.php|1 file|
||||
|routes/web.php|routes/web.php|1 file|
||||
|View Blade (layouts, auth)|resources/views/|2 file|
||||
|View Blade (dashboard)|resources/views/|1 file|
||||
|View Blade (mahasiswa)|resources/views/mahasiswa/|3 file|
||||
|View Blade (dosen)|resources/views/dosen/|3 file|
||||
||||
|View Blade (mata-kuliah)|resources/views/mata-kuliah/|2 file|
||||
|View Blade (jadwal-kuliah)|resources/views/jadwal-kuliah/|3 file|
||||
|View Blade (krs)|resources/views/krs/|2 file|
||||
|View Blade (sesi-absensi)|resources/views/sesi-absensi/|3 file|
||||
||||
|View Blade (absensi)|resources/views/absensi/|3 file|
||||
|View Blade (notifikasi)|resources/views/notifikasi/|1 file|
||||
|API Documentation (.md)|—  (referensi)|1 file|
||||
|README.md|—  (root project)|1 file|
||||
|TOTAL||65 file|
||||



Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

## **BAB 8 – DATABASE SEEDER & PANDUAN INSTALASI** 

## **8.1  DatabaseSeeder** 

Seeder menyediakan data awal untuk keperluan pengujian dan demonstrasi sistem: 

||||
|---|---|---|
|**Entitas**|**Jumlah**|**Detail**|
||||
|Admin|1|admin@unirow.ac.id / admin123|
||||
|Dosen|3|Dr. Budi Santoso, Siti Rahayu, Andi Wijaya|
||||
||||
|Mahasiswa|5|NIM 210411001–005, Program Studi Sistem Informasi|
||||
|Mata Kuliah|3|Basis Data Lanjut, Pemrograman Web Lanjut, Kecerdasan<br>Buatan|
||||
|Jadwal|3|Senin–Rabu, Gedung B-201 / Lab Komputer / Gedung C-<br>301|
||||
||||
|KRS|15|5 mahasiswa × 3 jadwal|
||||
|Sesi Absensi|1|Pertemuan 1 (hari ini, status tutup)|
||||
|Absensi|3|3 dari 5 mahasiswa (Hadir, Hadir, Telat)|



## **8.2  Panduan Instalasi Step-by-Step** 

## **1. Buat project Laravel baru:** 

composer create-project laravel/laravel siabsen && cd siabsen 

2. **Install Laravel Sanctum:** 

   - composer require laravel/sanctum 

3. **Salin seluruh file ke direktori sesuai tabel 7.3 di atas.** 

4. **Konfigurasi file .env:** DB_DATABASE=siabsen_db REDIS_HOST=127.0.0.1  (untuk QR token) 

5. **Jalankan migrasi dan seeder:** 

   - php artisan migrate:fresh --seed 

6. **Jalankan development server:** 

php artisan serve  →  buka http://localhost:8000 

## **8.3  Akun Default untuk Pengujian** 

|||||
|---|---|---|---|
|**Role**|**Email Login**|**Password**|**Akses**|
|||||
|Admin|admin@unirow.ac.id|admin123|Semua fitur + master data|
|||||
|Dosen|budi@unirow.ac.id|dosen123|Jadwal, sesi absensi,<br>laporan|
|||||
|Mahasiswa|ahmad@student.unirow.ac.id|mahasiswa123|API absensi (mobile)|
|||||



Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

## **BAB 9 – KEAMANAN SISTEM** 

## **9.1  Strategi Keamanan** 

||||
|---|---|---|
|**Aspek**|**Implementasi**|**Keterangan**|
||||
|Autentikasi API|Laravel Sanctum Bearer Token|Token disimpan di tabel<br>personal_access_tokens|
||||
|Autentikasi Web|Laravel Session (cookie)|Guard 'web' dengan middleware auth|
||||
|Password|Hash bcrypt (cost factor default)|Hash::make() – tidak pernah disimpan<br>plain text|
||||
|QR Token|UUID v4 + Redis TTL 30 detik|Token dirotasi setiap 30 detik untuk<br>mencegah reuse|
||||
|Validasi GPS|Haversine + radius per ruangan|Radius dikonfigurasi per jadwal (default<br>100 m)|
||||
|Foto Selfie|AWS S3 private ACL + Signed<br>URL|URL akses hanya valid 15 menit|
||||
|Soft Delete|deleted_at pada tabel users|Data tidak dihapus permanen, histori<br>terjaga|
||||
|Input Validation|Laravel Validator di setiap<br>store/update|Mencegah SQL injection dan data kotor|
||||
|CSRF Protection|@csrf pada setiap form Blade|Token CSRF Laravel bawaan|
||||
|Database SSL|Konfigurasi mysql.options<br>di .env|Enkripsi koneksi ke database|



## **9.2  Catatan Keamanan Tambahan** 

- QR token TIDAK disimpan di cookie browser – hanya ditampilkan di layar dosen dan dikonsumsi sekali pakai oleh API. 

- Validasi is_gps_valid bersifat informatif, bukan blokir keras – keputusan override tetap ada pada dosen/admin. 

- Endpoint rekap laporan hanya bisa diakses oleh user yang sudah terautentikasi (tidak ada laporan publik). 

- Rekomendasi produksi: tambahkan middleware role-check (Spatie Permission atau gate custom) agar mahasiswa tidak bisa mengakses endpoint admin. 

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

## **BAB 10 – PENUTUP** 

## **10.1  Rangkuman Hasil Pengerjaan** 

Keseluruhan pengerjaan sistem SIABSEN telah menghasilkan implementasi lengkap dari basis data hingga antarmuka pengguna dengan rincian sebagai berikut: 

||||
|---|---|---|
|**Komponen**|**Jumlah**|**Status**|
||||
|Migration Database|9 file|✓Selesai|
||||
||||
|Eloquent Model|9 file|✓Selesai|
||||
|API Controller|9 file|✓Selesai|
||||
|Web Controller (Blade)|10 file|✓Selesai|
||||
|API Endpoint|52 endpoint|✓Selesai|
||||
||||
|View Blade|24 file|✓Selesai|
||||
|Route (Web + API)|2 file|✓Selesai|
||||
|Database Seeder|1 file|✓Selesai|
||||
|Dokumentasi API (.md)|1 file|✓Selesai|
||||
||||
|README & Panduan Instalasi|1 file|✓Selesai|
||||
|TOTAL FILE DIHASILKAN|65 file|✓Selesai|
||||



## **10.2  Fitur Unggulan** 

- QR Code dengan rotasi token UUID setiap 30 detik – mencegah manipulasi via screenshot/foto. 

- Validasi GPS real-time menggunakan formula Haversine – memastikan mahasiswa berada dalam radius ruangan. 

- Panel monitor sesi real-time – QR diperbarui otomatis setiap 30 detik, tabel absensi diperbarui setiap 5 detik tanpa refresh halaman. 

- Laporan kehadiran di bawah 75% – memudahkan identifikasi mahasiswa yang berisiko tidak memenuhi syarat ujian. 

- Arsitektur dual-layer (API + Web) – satu back-end melayani aplikasi mobile (API) dan panel admin web (Blade) sekaligus. 

## **10.3  Rekomendasi Pengembangan Lanjutan** 

1. Implementasi middleware role-based access control (RBAC) menggunakan Spatie Laravel Permission. 

2. Integrasi Firebase Cloud Messaging (FCM) untuk push notification ke aplikasi mobile mahasiswa. 

3. Pengembangan modul verifikasi wajah (face recognition) menggunakan layanan AWS Rekognition atau model ML lokal. 

Dokumentasi Pengerjaan SIABSEN – UNIROW Tuban 

4. Penambahan ekspor laporan ke format Excel/PDF menggunakan Laravel Excel dan DomPDF. 

5. Integrasi dengan SIAKAD UNIROW untuk sinkronisasi data mahasiswa, dosen, dan jadwal secara otomatis. 

6. Penambahan fitur izin digital dengan upload surat keterangan dokter/orang tua untuk status Izin/Sakit. 

