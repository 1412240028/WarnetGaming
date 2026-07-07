# Dokumentasi API — Sistem WarnetGaming · v1.1 (Revisi)

Base URL: `/api` · Auth: Laravel Sanctum (Bearer Token) · Format: `application/json`

> **Riwayat revisi v1.0 → v1.1:**
> - ✅ Ditambahkan: `GET /rooms`, `GET /rooms/{room}` (sebelumnya route tidak terdaftar meski controller sudah siap)
> - ✅ Ditambahkan: `POST /pelanggans`, `DELETE /pelanggans/{pelanggan}` (memperbaiki gap: user baru daftar via `/register` tidak pernah punya record `pelanggans`, sehingga tidak bisa booking sesi sama sekali)
> - ❌ Dihapus: `POST /gaming-sessions` (digantikan sepenuhnya oleh `POST /booking-sessions`, yang sudah menangani validasi + auto `started_at`)
> - 📝 Diklarifikasi: `PCs` dan `Games` bersifat **read-only via API** (index/show saja) — data dikelola lewat database seeder (`PcSeeder`, `GameSeeder`), bukan lewat endpoint tulis, karena keduanya adalah data infrastruktur fisik warnet yang jarang berubah.

## Auth (4 endpoint)
| Method | Endpoint | Keterangan |
|---|---|---|
| POST | /register | Registrasi user & dapat token (publik) |
| POST | /login | Login & dapat token (publik) |
| POST | /logout | Logout, hapus token aktif |
| GET | /me | Profil user login |

> ⚠️ **Catatan penting:** `/register` hanya membuat record di tabel `users`. Untuk role pelanggan bisa booking sesi, admin/operator **wajib** membuat record pendamping lewat `POST /pelanggans` setelah user registrasi. Ini bukan otomatis.

## Health Check (1 endpoint)
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | /health | Cek status server (publik) → `{"status":"ok"}` |

## PCs (2 endpoint · read-only, semua role login)
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | /pcs | Daftar PC (filter: room_id, status) |
| GET | /pcs/{pc} | Detail PC |

*Penambahan/pengubahan PC dilakukan lewat `PcSeeder`, bukan API.*

## Games (2 endpoint · read-only, semua role login)
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | /games | Daftar game |
| GET | /games/{game} | Detail game |

*Penambahan/pengubahan game dilakukan lewat `GameSeeder`, bukan API.*

## Rooms (5 endpoint · admin) — ✅ diperbaiki di v1.1
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | /rooms | Daftar room (filter: type) |
| GET | /rooms/{room} | Detail room + relasi pcs, gamingSessions |
| POST | /rooms | Tambah room — `{ name, type }` |
| PUT | /rooms/{room} | Update room |
| DELETE | /rooms/{room} | Hapus room |

## Operators (5 endpoint · admin)
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | /operators | Daftar operator (filter: room_id, shift) |
| POST | /operators | Tambah — `{ user_id, shift, room_id }` |
| GET | /operators/{operator} | Detail operator |
| PUT | /operators/{operator} | Update operator |
| DELETE | /operators/{operator} | Hapus operator |

## Memberships (5 endpoint · admin)
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | /memberships | Daftar membership (filter: level) |
| POST | /memberships | Tambah — `{ level, discount_percent, tag }` |
| GET | /memberships/{membership} | Detail membership |
| PUT | /memberships/{membership} | Update membership |
| DELETE | /memberships/{membership} | Hapus membership |

## Payments (5 endpoint · admin, operator)
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | /payments | Daftar pembayaran (filter: method) |
| POST | /payments | Buat pembayaran — `{ gaming_session_id, nominal, method }` |
| GET | /payments/{payment} | Detail pembayaran |
| PUT | /payments/{payment} | Update pembayaran |
| DELETE | /payments/{payment} | Hapus pembayaran |

`method`: salah satu dari `cash`, `qris`, `transfer`, `member`.

## Pelanggan (5 endpoint · admin, operator) — ✅ diperbaiki di v1.1
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | /pelanggans | Daftar pelanggan + relasi user, membership |
| GET | /pelanggans/{pelanggan} | Detail pelanggan |
| POST | /pelanggans | Tambah pelanggan — `{ user_id, membership_id, status }` |
| PUT | /pelanggans/{pelanggan} | Update status/membership pelanggan |
| DELETE | /pelanggans/{pelanggan} | Hapus pelanggan |

## Gaming Sessions (3 endpoint) — ❌ POST lama dihapus di v1.1
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | /gaming-sessions | Daftar sesi (filter: status, only=active\|finished, room_id, per_page) — semua role login |
| GET | /gaming-sessions/{id} | Detail sesi + relasi pelanggan, pc, room, operator — semua role login |
| DELETE | /gaming-sessions/{id} | Hapus sesi — admin, operator |

> Untuk **membuat** sesi baru, gunakan `POST /booking-sessions` (lihat di bawah) — bukan endpoint terpisah.

## Booking Sessions (1 endpoint · semua role login)
**POST /booking-sessions** — Booking sesi gaming pelanggan

Request:
```json
{ "pelanggan_id": 3, "room_id": 1, "pc_id": 7, "operator_id": 2 }
```
Response · 201:
```json
{ "id": 88, "status": "active", "started_at": "2026-07-07T10:00:00Z" }
```
Otomatis membuat gaming session aktif dengan `started_at = now()`.

## Session Games (2 endpoint · semua role login)
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | /gaming-sessions/{id}/games | Daftar game dalam sesi (paginate) |
| POST | /gaming-sessions/{id}/games | Tambah game ke sesi — `{ game_id, played_at, notes }` |

Error 409: game sudah ditambahkan ke sesi yang sama (`DuplicateSessionGameException`).

## Food & Beverages (5 endpoint)
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | /food-beverages | Daftar item — semua role login |
| GET | /food-beverages/{id} | Detail item — semua role login |
| POST | /food-beverages | Tambah item — admin |
| PUT | /food-beverages/{id} | Update item — admin |
| DELETE | /food-beverages/{id} | Hapus item — admin |

`category`: salah satu dari `food`, `drink`, `snack`.

## Food Orders (4 endpoint)
| Method | Endpoint | Keterangan |
|---|---|---|
| GET | /food-orders | Daftar order + relasi items, session, pelanggan |
| GET | /food-orders/{id} | Detail order |
| POST | /food-orders | Buat order — pelanggan |
| PUT | /food-orders/{id}/status | Update status — admin, operator |

Alur `POST /food-orders`:
1. Cek gaming session berstatus active/started → 422 jika tidak
2. Lock stok tiap item (`lockForUpdate`) → `InsufficientStockException` jika stok kurang
3. Kurangi stok & hitung subtotal per item
4. Simpan order (status: `pending`) beserta item dalam 1 transaksi DB

## Kode Status HTTP
| Kode | Arti |
|---|---|
| 200 | OK |
| 201 | Created |
| 204 | No Content |
| 401 | Unauthorized — token tidak valid/belum login |
| 403 | Forbidden — role tidak diizinkan |
| 404 | Not Found |
| 422 | Unprocessable — validasi/kondisi bisnis gagal |

## Ringkasan Role & Keamanan
- **Bearer Token:** semua endpoint kecuali `/health`, `/register`, `/login` wajib header `Authorization: Bearer {token}`.
- **ADMIN:** full akses rooms, operators, memberships, food-beverages (write), pelanggans (full, sejak v1.1).
- **ADMIN + OPERATOR:** payments (full), pelanggans (full, sejak v1.1), food-orders status, delete gaming-sessions.
- **PELANGGAN (& semua role login):** booking-sessions, food-orders (store), session-games, index/show pcs, games, gaming-sessions, food-beverages, food-orders, rooms.