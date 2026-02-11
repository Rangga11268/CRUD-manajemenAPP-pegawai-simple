<p align="center">
  <img src="public/Readme%20github/images/landingPage.png" alt="HRIS Laravel Banner" width="100%">
</p>

<h1 align="center">HRIS Laravel</h1>
<p align="center">
  <strong>Sistem Informasi Manajemen Sumber Daya Manusia</strong><br>
  <em>Human Resource Information System</em>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Bootstrap-4.6-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
  <img src="https://img.shields.io/badge/CoreUI-3.x-321fdb?style=for-the-badge&logo=coreui&logoColor=white" alt="CoreUI">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Status-In%20Development-yellow?style=for-the-badge" alt="Status">
</p>

---

## 📖 Tentang Proyek

**HRIS Laravel** adalah aplikasi web berbasis Laravel untuk pengelolaan data Sumber Daya Manusia (SDM) secara terpusat. Aplikasi ini dirancang untuk membantu perusahaan dalam mengelola pegawai, absensi, cuti, penggajian, dan laporan — semuanya dalam satu platform.

> [!NOTE]
> Proyek ini masih dalam tahap **pengembangan aktif**. Beberapa fitur mungkin belum final dan dapat berubah sewaktu-waktu.

---

## ✨ Fitur Utama

| Modul                       | Deskripsi                                                              |
| --------------------------- | ---------------------------------------------------------------------- |
| 👤 **Manajemen Pegawai**    | CRUD lengkap, import data via Excel, foto profil, pencarian & paginasi |
| 💼 **Jabatan & Departemen** | Kelola struktur organisasi perusahaan                                  |
| ⏰ **Absensi (Attendance)** | Clock In/Out harian, validasi lokasi (Geofencing), laporan kehadiran   |
| 🏖️ **Cuti (Leave)**         | Pengajuan, persetujuan, riwayat cuti, sisa jatah cuti                  |
| 💰 **Penggajian (Salary)**  | CRUD slip gaji, generate gaji massal, export PDF/Excel                 |
| 📊 **Laporan & Statistik**  | Dashboard interaktif dengan grafik (ApexCharts)                        |
| 🔐 **Role & Akses (RBAC)**  | Manajemen peran & izin akses berbasis Spatie Laravel Permission        |
| 📅 **Kalender Perusahaan**  | Kelola hari libur & event perusahaan                                   |
| ⚙️ **Pengaturan Sistem**    | Konfigurasi nama, logo, jam kerja, toleransi keterlambatan, geofencing |
| 🌙 **Dark Mode**            | Toggle mode gelap dengan penyimpanan preferensi                        |
| 🔔 **Notifikasi**           | Sistem notifikasi real-time untuk approval & informasi                 |
| 🏠 **Landing Page**         | Halaman utama publik yang modern dan responsif                         |

---

## 📸 Screenshots

### Landing Page

![Landing Page](public/Readme%20github/images/landingPage.png)

### Dashboard

![Dashboard](public/Readme%20github/images/dashboard.png)

---

## 🛠️ Tech Stack

### Backend

| Teknologi                                                      | Fungsi                    |
| -------------------------------------------------------------- | ------------------------- |
| [Laravel 10](https://laravel.com/)                             | Framework utama           |
| [PHP 8.2+](https://www.php.net/)                               | Bahasa pemrograman        |
| [MySQL](https://www.mysql.com/)                                | Database                  |
| [Spatie Permission](https://spatie.be/docs/laravel-permission) | Role-Based Access Control |
| [Maatwebsite Excel](https://laravel-excel.com/)                | Import/Export data Excel  |

### Frontend

| Teknologi                                     | Fungsi                                       |
| --------------------------------------------- | -------------------------------------------- |
| [CoreUI 3](https://coreui.io/)                | Admin template & layout                      |
| [Bootstrap 4.6](https://getbootstrap.com/)    | CSS framework                                |
| [FontAwesome 5](https://fontawesome.com/)     | Icon library                                 |
| [SweetAlert2](https://sweetalert2.github.io/) | Alert & dialog interaktif                    |
| [ApexCharts](https://apexcharts.com/)         | Grafik & visualisasi data                    |
| [DataTables](https://datatables.net/)         | Tabel interaktif dengan pencarian & paginasi |

### Development Tools

| Teknologi                            | Fungsi                        |
| ------------------------------------ | ----------------------------- |
| [Vite](https://vitejs.dev/)          | Asset bundling                |
| [Laragon](https://laragon.org/)      | Local development environment |
| [Composer](https://getcomposer.org/) | PHP package manager           |
| [NPM](https://www.npmjs.com/)        | JavaScript package manager    |

---

## 🚀 Instalasi & Setup

### Prasyarat

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / MariaDB

### Langkah Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/Rangga11268/hris-laravel.git

# 2. Masuk ke direktori proyek
cd hris-laravel

# 3. Install dependensi PHP
composer install

# 4. Install dependensi Node.js
npm install

# 5. Salin file environment
cp .env.example .env

# 6. Generate application key
php artisan key:generate
```

### Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hris_laravel
DB_USERNAME=root
DB_PASSWORD=
```

### Menjalankan Aplikasi

```bash
# Jalankan migrasi & seeder
php artisan migrate --seed

# Buat symbolic link untuk storage
php artisan storage:link

# Jalankan server
php artisan serve

# (Terminal terpisah) Kompilasi aset
npm run dev
```

Buka `http://localhost:8000` di browser.

---

## 📁 Struktur Modul

```
app/
├── Http/Controllers/
│   ├── HomeController.php          # Dashboard
│   ├── PegawaiController.php       # Manajemen Pegawai
│   ├── JabatanController.php       # Manajemen Jabatan
│   ├── DepartmentController.php    # Manajemen Departemen
│   ├── AttendanceController.php    # Absensi
│   ├── LeaveController.php         # Cuti
│   ├── SalaryController.php        # Penggajian
│   ├── ReportController.php        # Laporan
│   ├── RoleController.php          # RBAC
│   ├── SettingController.php       # Pengaturan Sistem
│   ├── CalendarEventController.php # Kalender Perusahaan
│   └── NotificationController.php  # Notifikasi
├── Models/
│   ├── Pegawai.php
│   ├── Jabatan.php
│   ├── Department.php
│   ├── Attendance.php
│   ├── Leave.php
│   ├── Salary.php
│   ├── Setting.php
│   └── CalendarEvent.php
└── Imports/
    └── PegawaiImport.php           # Import Excel
```

---

## 🗺️ Roadmap

- [x] CRUD Pegawai, Jabatan, Departemen
- [x] Sistem Absensi (Clock In/Out)
- [x] Manajemen Cuti & Approval
- [x] Penggajian & Slip Gaji
- [x] Role-Based Access Control (RBAC)
- [x] Dashboard dengan Statistik
- [x] Dark Mode
- [x] Kalender Perusahaan
- [x] Import/Export Data
- [ ] Geofencing Absensi (Validasi GPS)
- [ ] Mobile-Responsive Optimization
- [ ] REST API untuk integrasi
- [ ] Audit Log & Activity History

---

## 🤝 Berkontribusi

Kontribusi sangat diterima! Jika Anda ingin berkontribusi:

1. Fork repositori ini
2. Buat branch fitur (`git checkout -b feature/FiturBaru`)
3. Commit perubahan (`git commit -m 'Menambahkan FiturBaru'`)
4. Push ke branch (`git push origin feature/FiturBaru`)
5. Buka Pull Request

---

## 📄 Lisensi

Didistribusikan di bawah Lisensi MIT. Lihat `LICENSE` untuk informasi lebih lanjut.

## 📬 Kontak

**Rangga** — [darrelrangga@gmail.com](mailto:darrelrangga@gmail.com)

---

<p align="center">
  <sub>⚠️ Proyek ini masih dalam pengembangan aktif. Fitur dan tampilan dapat berubah sewaktu-waktu.</sub>
</p>
