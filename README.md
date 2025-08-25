# Manajemen App Pegawai Simple

Aplikasi manajemen pegawai sederhana yang dibuat menggunakan Laravel. Aplikasi ini memungkinkan pengguna untuk melakukan operasi CRUD (Create, Read, Update, Delete) pada data pegawai, jabatan, dan pengguna.

## Tentang Proyek

Proyek ini adalah aplikasi web sederhana untuk manajemen data pegawai. Dibuat sebagai portofolio dan untuk pembelajaran, proyek ini mencakup fungsionalitas dasar yang dibutuhkan dalam sebuah sistem manajemen kepegawaian.

### Dibangun Dengan

  * [Laravel](https://laravel.com/)
  * [PHP](https://www.php.net/)
  * [Tailwind CSS](https://tailwindcss.com/)
  * [Alpine.JS](https://alpinejs.dev/)
  * [MySQL](https://www.mysql.com/)

## Memulai

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut.

### Prasyarat

Pastikan Anda telah menginstal perangkat lunak berikut:

  * PHP \>= 8.2
  * Composer
  * Node.js
  * NPM
  * Database (misalnya MySQL, MariaDB, dll.)

### Instalasi

1.  **Clone repositori**
    ```sh
    git clone https://github.com/rangga11268/crud-manajemenapp-pegawai-simple.git
    ```
2.  **Buka direktori proyek**
    ```sh
    cd crud-manajemenapp-pegawai-simple
    ```
3.  **Install dependensi PHP**
    ```sh
    composer install
    ```
4.  **Install dependensi Node.js**
    ```sh
    npm install
    ```
5.  **Salin file `.env.example` menjadi `.env`**
    ```sh
    cp .env.example .env
    ```
6.  **Buat kunci aplikasi**
    ```sh
    php artisan key:generate
    ```
7.  **Konfigurasi database Anda di file `.env`**
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=user_database_anda
    DB_PASSWORD=password_database_anda
    ```
8.  **Jalankan migrasi database**
    ```sh
    php artisan migrate
    ```
9.  **Jalankan seeder database (opsional)**
    ```sh
    php artisan db:seed
    ```
10. **Jalankan server pengembangan**
    ```sh
    php artisan serve
    ```
11. **Kompilasi aset front-end**
    ```sh
    npm run dev
    ```

## Fitur

  * **Manajemen Pegawai:** Tambah, lihat, edit, dan hapus data pegawai.
  * **Manajemen Jabatan:** Tambah, lihat, edit, dan hapus data jabatan.
  * **Manajemen Pengguna:** Tambah, lihat, edit, dan hapus data pengguna dengan peran yang berbeda.
  * **Otentikasi:** Sistem login dan registrasi pengguna yang aman.
  * **Pencarian & Paginasi:** Fitur pencarian dan paginasi untuk memudahkan pengelolaan data dalam jumlah besar.

## Screenshots

### Landing Page
![Landing Page](public/Readme%20github/images/landingpage.png)

### Register
![Register](public/Readme%20github/images/register.png)

### Login
![Login](public/Readme%20github/images/login.png)

### Dashboard
![Dashboard](public/Readme%20github/images/dashboard.png)

### Pegawai
![Pegawai](public/Readme%20github/images/pegawai.png)

### Jabatan
![Jabatan](public/Readme%20github/images/jabatan.png)

### Users
![Users](public/Readme%20github/images/users.png)

## Berkontribusi

Kontribusi adalah hal yang membuat komunitas sumber terbuka menjadi tempat yang luar biasa untuk belajar, menginspirasi, dan berkreasi. Setiap kontribusi yang Anda berikan sangat **dihargai**.

Jika Anda memiliki saran untuk menjadikan proyek ini lebih baik, silakan *fork* repositori dan buat *pull request*. Anda juga bisa membuka *issue* dengan tag "enhancement". Jangan lupa untuk memberikan bintang pada proyek ini\! Terima kasih lagi\!

1.  Fork Proyek
2.  Buat Branch Fitur Anda (`git checkout -b feature/FiturLuarBiasa`)
3.  Commit Perubahan Anda (`git commit -m 'Menambahkan beberapa FiturLuarBiasa'`)
4.  Push ke Branch (`git push origin feature/FiturLuarBiasa`)
5.  Buka Pull Request

## Lisensi

Didistribusikan di bawah Lisensi MIT. Lihat `LICENSE` untuk informasi lebih lanjut.

## Kontak

Rangga - [darrelrangga8@gmail.com](mailto:darrelrangga@gmail.com)

Tautan Proyek: [https://github.com/rangga11268/crud-manajemenapp-pegawai-simple](https://github.com/rangga11268/crud-manajemenapp-pegawai-simple)
