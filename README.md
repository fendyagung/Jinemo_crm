# Jinemo CRM - Tugas/Project
Aplikasi Jinemo CRM ini dibangun menggunakan framework **Laravel**. 

Berikut adalah panduan langkah demi langkah untuk menjalankan aplikasi ini di komputer lokal (misalnya untuk keperluan penilaian oleh dosen).

## Persyaratan Sistem
* PHP >= 8.2
* Composer
* XAMPP (atau server lokal sejenis yang memiliki MySQL)

## Panduan Instalasi dan Menjalankan Project

1. **Clone atau Download Project**
   Pastikan Anda sudah mengunduh / meng-clone seluruh isi folder project ini.
   ```bash
   git clone https://github.com/fendyagung/Jinemo_crm.git
   ```

2. **Buka Terminal di Folder Project**
   Masuk ke dalam folder project (contoh: `cd Jinemo_crm`).

3. **Install Dependensi Composer**
   Jalankan perintah berikut untuk mengunduh semua library PHP yang dibutuhkan oleh Laravel:
   ```bash
   composer install
   ```

4. **Siapkan File .env**
   - Copy file `.env.example` dan ubah namanya menjadi `.env`.
   - Atau bisa melalui terminal:
     ```bash
     cp .env.example .env
     ```
   - (Opsional) Jika Anda menggunakan Windows, cukup duplikat file `.env.example` lalu *rename* hasil duplikatnya menjadi `.env`.

5. **Generate App Key**
   Jalankan perintah berikut untuk menghasilkan kunci keamanan aplikasi:
   ```bash
   php artisan key:generate
   ```

6. **Konfigurasi Database**
   - Buka aplikasi **XAMPP** dan jalankan modul **Apache** dan **MySQL**.
   - Buka browser dan akses **phpMyAdmin** (biasanya di `http://localhost/phpmyadmin`).
   - Buat sebuah database baru dengan nama: `jinemo`
   - Pastikan konfigurasi di dalam file `.env` sudah sesuai (secara default sudah sesuai dengan XAMPP):
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=jinemo
     DB_USERNAME=root
     DB_PASSWORD=
     ```

7. **Import File Database (PENTING)**
   Di dalam folder root project ini, sudah disediakan file database bernama **`jinemo.sql`**.
   - Buka phpMyAdmin, pilih database `jinemo` yang baru saja Anda buat.
   - Klik tab **Import**.
   - Pilih file `jinemo.sql` dari folder project ini.
   - Klik **Go / Import** pada bagian bawah.
   
   *(Catatan: Anda tidak perlu menjalankan `php artisan migrate:fresh --seed` jika sudah meng-import file SQL ini, karena seluruh tabel dan data (termasuk akun admin) sudah ada di dalamnya).*

8. **Jalankan Server Lokal**
   Setelah semua langkah di atas selesai, jalankan server bawaan Laravel:
   ```bash
   php artisan serve
   ```

9. **Akses Aplikasi**
   Buka browser web Anda dan kunjungi URL berikut:
   [http://127.0.0.1:8000](http://127.0.0.1:8000) atau [http://localhost:8000](http://localhost:8000)

## Informasi Login (Akun Admin/User)
Jika database sudah berhasil di-import, Anda dapat login menggunakan kredensial yang ada di tabel `users`.
(Jika ada instruksi login khusus, misalnya email `admin@jinemo.com` dengan password `password`, silakan ditambahkan).

---
*Dibuat oleh Fendy Agung untuk keperluan evaluasi.*
