============================================================
  JINEMO CRM - Aplikasi Customer Relationship Management
============================================================

LINK REPOSITORY GITHUB
-----------------------
https://github.com/fendyagung/Jinemo_crm

------------------------------------------------------------
TOOLS / TEKNOLOGI YANG DIGUNAKAN
------------------------------------------------------------
- PHP             >= 8.2
- Laravel         11
- MySQL           (via XAMPP)
- Composer
- XAMPP (Apache + MySQL)
- Bootstrap 5 (Frontend UI)

------------------------------------------------------------
CARA INSTALASI & MENJALANKAN DI LOCALHOST
------------------------------------------------------------

Langkah 1: Persiapan
  - Pastikan XAMPP sudah terinstall dan module Apache + MySQL dalam keadaan RUNNING.
  - Pastikan Composer sudah terinstall di komputer.

Langkah 2: Clone / Download Project
  - Clone via Git:
    git clone https://github.com/fendyagung/Jinemo_crm.git
  - Atau download ZIP dari GitHub lalu ekstrak ke folder lokal Anda.

Langkah 3: Install Dependensi
  - Buka terminal/command prompt, masuk ke folder project:
    cd Jinemo_crm
  - Jalankan perintah:
    composer install

Langkah 4: Konfigurasi File .env
  - Duplikat file ".env.example" dan ubah namanya menjadi ".env"
  - (Atau jalankan: cp .env.example .env)
  - Pastikan isi konfigurasi database pada file .env seperti berikut:
      DB_CONNECTION=mysql
      DB_HOST=127.0.0.1
      DB_PORT=3306
      DB_DATABASE=jinemo
      DB_USERNAME=root
      DB_PASSWORD=

Langkah 5: Generate App Key
  - Jalankan perintah berikut di terminal:
    php artisan key:generate

Langkah 6: Buat Database & Import Data
  - Buka browser, akses phpMyAdmin: http://localhost/phpmyadmin
  - Buat database baru dengan nama: jinemo
  - Pilih database "jinemo" yang baru dibuat, klik tab "Import"
  - Pilih file "jinemo.sql" yang ada di dalam folder project ini
  - Klik tombol "Import/Go" dan tunggu hingga selesai
  * CATATAN: File jinemo.sql sudah berisi semua tabel dan data lengkap.
             Tidak perlu menjalankan "php artisan migrate" lagi.

Langkah 7: Jalankan Server
  - Di terminal, jalankan:
    php artisan serve
  - Buka browser dan akses: http://127.0.0.1:8000

------------------------------------------------------------
USERNAME & PASSWORD DEMO
------------------------------------------------------------

  [ADMIN]
  Email    : admin@jinemo.com
  Password : password123
  Akses    : http://127.0.0.1:8000/login

  [CUSTOMER / USER]
  Email    : budi@example.com
  Password : password123
  Akses    : http://127.0.0.1:8000/login

------------------------------------------------------------
