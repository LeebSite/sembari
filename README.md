
<div align="center">

  <img src="public/favicon.ico" alt="Logo Sembari" width="100" />

  # 📚 Sembari (Sistem Membaca & Belajar Mandiri)
  
  **Platform Perpustakaan Digital & Flipbook Interaktif**
  
  [![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
  [![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php)](https://php.net)
  [![TailwindCSS](https://img.shields.io/badge/Tailwind-CSS-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
  [![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap)](https://getbootstrap.com)

  <p align="center">
    Platform literasi digital modern dengan fitur baca buku interaktif (flipbook), manajemen koleksi buku, dan panel admin yang komprehensif. Didesain untuk kemudahan akses dan pengalaman membaca yang menyenangkan.
  </p>

</div>

---

## ✨ Fitur Utama

### 📖 Untuk Pengunjung (Public)
- **Flipbook Reader Interactive**: Membaca buku digital layaknya buku asli dengan animasi *page-flip* (berbasis Turn.js).
- **Katalog Buku**: Pencarian dan filter buku berdasarkan kategori, jenis, dan tingkat baca.
- **Responsive Design**: Tampilan yang optimal di Desktop, Tablet, dan Mobile.
- **Tanpa Login**: Akses mudah untuk masyarakat umum tanpa perlu registrasi rumit.

### 🛡️ Panel Admin
- **Dashboard Analitik**: Statistik pengunjung, total buku, dan aktivitas terbaru.
- **Manajemen Buku**: Upload PDF, Cover, Metadata, serta pengaturan lisensi (Umum/Terbatas).
- **Manajemen Pengguna Admin**: Kelola akun admin dan role (Super Admin/Staff).
- **Maintenance Tools**: Fitur bawaan untuk clear cache dan perbaikan storage link di hosting.

---

## 🛠️ Teknologi

- **Framework**: Laravel 11
- **Database**: MySQL
- **Frontend Public**: Blade + Tailwind CSS (Vite) + Turn.js
- **Frontend Admin**: Blade + Bootstrap 5 (CDN) + Custom CSS
- **Icons**: Bootstrap Icons (Admin) & Heroicons/Lucide (Public)

---

## 🚀 Instalasi Lokal (Localhost)

Ikuti langkah ini untuk menjalankan proyek di komputer Anda (Windows/Linux/Mac).

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL Database

### Langkah-langkah

1. **Clone Repositori**
   ```bash
   git clone https://github.com/username/sembari.git
   cd sembari
   ```

2. **Install Dependensi PHP**
   ```bash
   composer install
   ```

3. **Install Dependensi Frontend**
   ```bash
   npm install
   npm run build
   ```
   > ⚠️ **Penting**: Jalankan `npm run build` agar file CSS/JS terbentuk di folder `public/build`.

4. **Konfigurasi Environment**
   - Copy file `.env.example` menjadi `.env`:
     ```bash
     cp .env.example .env
     ```
   - Edit `.env` dan sesuaikan database:
     ```env
     DB_DATABASE=sembari
     DB_USERNAME=root
     DB_PASSWORD=
     ```

5. **Generate Key & Migrasi Database**
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   ```
   > Command `--seed` akan membuat akun admin default.

6. **Link Storage**
   ```bash
   php artisan storage:link
   ```

7. **Jalankan Server**
   ```bash
   php artisan serve
   ```
   Buka browser di: [http://127.0.0.1:8000](http://127.0.0.1:8000)

   - **Login Admin**: [http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)
   - **User Default**: `superadmin` / `password123` (Cek seeder jika berbeda)

---

## 🌐 Deploy ke cPanel / Shared Hosting

Panduan khusus untuk hosting cPanel dimana Anda tidak memilki akses terminal SSH penuh.

1. **Persiapan File**
   - Di komputer lokal, jalankan `npm run build` terlebih dahulu.
   - Compress/Zip seluruh folder project **KECUALI** folder `node_modules` dan `.git`.

2. **Upload & Ekstrak**
   - Upload ZIP ke File Manager cPanel (misal di folder `public_html/` atau `sembari/`).
   - Ekstrak file.

3. **Database**
   - Buat Database & User MySQL baru di cPanel.
   - Import file SQL database lokal Anda via phpMyAdmin, ATAU sesuaikan `.env` dan jalankan migrasi via SSH jika ada.

4. **Konfigurasi .env**
   - Sesuaikan `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` dengan yang dibuat di cPanel.
   - Ubah `APP_URL` ke domain Anda, misal: `https://domainanda.com`.
   - Set `APP_ENV=production` dan `APP_DEBUG=false`.

5. **Storage Link (PENTING ⚠️)**
   Karena keterbatasan akses terminal di shared hosting, seringkali gambar tidak muncul.
   
   Aplikasi ini dilengkapi **Tools Otomatis**. Setelah upload:
   
   👉 Buka: `https://domainanda.com/maintenance`
   
   Halaman tersebut akan otomatis:
   - Membersihkan cache aplikasi.
   - Mendeteksi path hosting.
   - **Membuat Symlink Storage** agar gambar cover & PDF bisa diakses publik.

---

## 📂 Struktur Folder Penting

```
sembari/
├── app/
│   ├── Http/Controllers/Admin/  # Logika Backend Admin
│   └── Models/                  # Model Database (Book, Category, dll)
├── public/
│   ├── build/                   # Hasil compile CSS/JS Public (Tailwind)
│   ├── css/                     # CSS Manual untuk Admin Panel
│   └── storage/                 # Shortcut ke file upload (harus di-link)
├── resources/
│   └── views/
│       ├── admin/               # View Blade khusus Admin
│       └── ...                  # View Public
└── routes/
    └── web.php                  # Definisi Route Web
```

---

## 🤝 Kontribusi

Tertarik mengembangkan Sembari? Silakan fork repositori ini dan buat Pull Request!

---

<div align="center">
  <small>Dikembangkan dengan ❤️ untuk Literasi Indonesia</small>
</div>
