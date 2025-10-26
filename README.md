# Doorprize System

Aplikasi sederhana untuk mengelola peserta dan melakukan pengundian doorprize secara acak. Project ini memudahkan pendaftaran peserta, pengundian, dan pencatatan pemenang.

## Fitur
- Registrasi peserta (nama, nomor kontak, kode unik)
- Pengelolaan daftar peserta (tambah / edit / hapus)
- Pengundian acak dan pencatatan pemenang
- Ekspor daftar pemenang (CSV/JSON)
- Panel admin untuk mengelola sesi doorprize

## Persyaratan
- PHP >= 8.0
- Composer
- Database (MySQL, PostgreSQL, SQLite)
- Node.js & npm (jika ada asset frontend)

## Instalasi
1. Clone repo:
    git clone <repo-url> doorprize-system
2. Masuk folder proyek:
    cd doorprize-system
3. Install dependensi PHP:
    composer install
4. Salin file environment:
    cp .env.example .env
    lalu sesuaikan konfigurasi database di `.env`
5. Generate app key:
    php artisan key:generate
6. Jalankan migrasi (dan seeding jika tersedia):
    php artisan migrate
    php artisan db:seed --class=SampleParticipantsSeeder (opsional)
7. Jika proyek menggunakan asset frontend:
    npm install
    npm run dev

## Menjalankan
Jalankan server lokal:
php artisan serve

Buka browser ke http://127.0.0.1:8000 dan masuk ke panel admin untuk menambahkan peserta serta menjalankan pengundian.

## Penggunaan singkat
- Tambah peserta melalui form "Peserta".
- Buat sesi doorprize baru (opsional) untuk memisahkan pengundian.
- Jalankan fungsi "Undi" atau tombol "Draw" untuk mengambil pemenang secara acak.
- Ekspor hasil jika ingin menyimpan atau mengumumkan pemenang.

## Kontribusi
Kontribusi diterima! Silakan:
1. Fork repository
2. Buat branch fitur/bugfix
3. Push perubahan dan buat pull request dengan deskripsi jelas

## Keamanan
Laporkan masalah keamanan melalui issue atau kontak maintainer di repo. Jangan mengunggah kredensial ke repository publik.

## Lisensi
Project ini dilisensikan di bawah MIT License. Lihat file LICENSE untuk detail.
