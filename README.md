🌱 TanamCare API (Backend)

TanamCare adalah layanan Backend API untuk aplikasi monitoring tanaman berbasis mobile. Aplikasi ini dirancang untuk membantu petani maupun penghobi tanaman dalam memantau pertumbuhan, mendapatkan rekomendasi perawatan, serta menemukan solusi atas hama atau penyakit tanaman.

Dibangun menggunakan teknologi web modern yang cepat, aman, dan scalable.

🛠️ Spesifikasi Teknologi (Tech Stack)

Project ini dibangun dengan spesifikasi minimum berikut:

Bahasa Pemrograman: PHP (Versi 8.2 atau lebih baru)

Framework: Laravel (Versi 12.x)

Database: PostgreSQL

API Authentication: Laravel Sanctum

Web Server: Apache/Nginx (via Laragon/XAMPP atau Docker)

✨ Fitur Utama

1. 🌿 Manajemen & Monitoring Tanaman

Log Harian: Pengguna dapat mencatat tinggi tanaman, jumlah daun, kondisi fisik, dan mengunggah foto perkembangan harian.

My Garden: Pengguna dapat mengelola daftar tanaman yang sedang mereka tanam.

History: Melacak riwayat pertumbuhan dari hari pertama tanam hingga panen.

2. 📚 Knowledge Base (Data Master)

Katalog Spesies: Database lengkap mengenai jenis tanaman (nama ilmiah, suhu optimal, kebutuhan cahaya, frekuensi penyiraman).

Plant Issues: Database penyakit, hama, dan solusi penanganannya.

3. 🛡️ Keamanan & Audit Data

Autentikasi: Register & Login menggunakan Token (Bearer Token).

Data Audit:

Soft Deletes: Data tanaman yang dihapus tidak hilang permanen (deleted_at).

User Tracking: Mengetahui siapa admin yang mengubah data master (created_by, updated_by).

🚀 Panduan Instalasi (Localhost)

Ikuti langkah berikut untuk menjalankan aplikasi di komputer lokal Anda.

Prasyarat

Pastikan Anda sudah menginstall:

PHP >= 8.2

Composer

PostgreSQL Database

Langkah-langkah

Clone Repository

git clone [https://github.com/MuhRidwaan/tanam-care-backend.git](https://github.com/MuhRidwaan/tanam-care-backend.git)
cd tanam-care-backend

Install Dependencies

composer install

Konfigurasi Environment
Duplikat file .env.example menjadi .env:

cp .env.example .env

Setup Database (PostgreSQL)
Buka file .env dan sesuaikan konfigurasi database Anda. Pastikan DB_CONNECTION diubah ke pgsql.

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=tanamcare_db
DB_USERNAME=postgres
DB_PASSWORD=password_anda

Generate Key & Migrasi Database

php artisan key:generate
php artisan migrate

Jalankan Server

php artisan serve

Aplikasi akan berjalan di http://127.0.0.1:8000.

🔌 Dokumentasi API (Endpoints)

Gunakan Postman atau Insomnia untuk mengakses endpoint berikut.
Header Wajib: Accept: application/json

Auth

Method

Endpoint

Deskripsi

POST

/api/register

Mendaftar akun baru

POST

/api/login

Masuk dan mendapatkan Token

POST

/api/logout

Keluar (Hapus Token)

Tanaman Saya (Butuh Token)

Method

Endpoint

Deskripsi

GET

/api/my-plants

List semua tanaman user

POST

/api/my-plants

Tambah tanaman baru

GET

/api/my-plants/{id}

Detail tanaman & history log

Monitoring & Logs (Butuh Token)

Method

Endpoint

Deskripsi

POST

/api/logs

Input data monitoring harian (Support Upload Foto)

Master Data (Public/Auth)

Method

Endpoint

Deskripsi

GET

/api/species

Lihat katalog tanaman

GET

/api/issues

Lihat daftar penyakit & solusi

POST

/api/species

Tambah spesies baru (Admin)

📂 Struktur Database

Aplikasi menggunakan skema relasional dengan tabel utama:

users: Data pengguna (Role: User/Admin).

plant_species: Katalog referensi tanaman.

user_plants: Instance tanaman milik user.

monitoring_logs: Catatan transaksional harian.

plant_issues: Referensi hama dan solusi.

📝 Lisensi

Project ini bersifat Open Source di bawah lisensi MIT.
