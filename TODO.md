# TODO

## Tahap 1 — Audit & perbaikan controller yang sudah terbaca (D.3)
- [ ] Buat perbaikan `per_page` (validasi + pagination) pada index(): Room/Pc/Payment/Membership/GamingSession
- [ ] Tambahkan eager loading pada `index()` dan `show()` untuk controller resource terkait
- [ ] Terapkan query scope di model untuk filter yang dipakai controller (mis. filter by type/status/room_id/method/level)
- [ ] Perbaiki validation `GamingSessionController@store()` dengan `exists:*` untuk FK
- [ ] Perbaiki validation `BookingSessionController@store()` dengan `exists:*` dan pertimbangkan invariant PC
- [ ] Audit dan perketat transaction logic untuk booking (dan gaming session) agar atomic dan aman race condition (lock/availability)

## Tahap 2 — Lanjut audit controller lain
- [ ] Baca `OperatorController`, `SessionGameController`, dan controller lain yang relevan
- [ ] Terapkan D.3 ke controller yang belum dievaluasi

## Tahap 3 — Verifikasi
- [ ] Jalankan `php artisan test` (jika ada test) dan/atau `php artisan route:list`
- [ ] Jalankan pemeriksaan quick: response index/show mengandung relasi yang diharapkan

