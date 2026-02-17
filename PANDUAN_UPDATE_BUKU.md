# PANDUAN UPDATE DATABASE DAN FITUR BUKU

## 📋 PERUBAHAN YANG DILAKUKAN:

### 1. **Struktur Database Baru:**
- ❌ Dihapus: `authors`, `reading_levels`, `licenses`, `book_contributors`
- ✅ Ditambah: `book_types`, `book_book_type` (pivot)
- ✅ Update: `books` table dengan kolom `contributors` (text) dan `license` (enum)
- ✅ Update: `categories` dengan 9 kategori baru

### 2. **Fitur Form Buku:**
- **Kontributor**: Input manual (textarea)
- **Lisensi**: Radio button (single select)
  - Buku Edisi Terbatas
  - Buku Edisi Umum
- **Jenis Buku**: Checkbox (multi select)
  - Anak - Anak
  - Fiksi
  - Nonfiksi
  - Pendidikan
- **Kategori**: Checkbox (multi select)
  - Alam
  - Cerita Rakyat
  - Edisi Terbatas
  - Ekonomi Kreatif
  - Matematika
  - Pengembangan Diri
  - Sains
  - Seni Budaya
  - Tokoh

---

## 🚀 LANGKAH-LANGKAH INSTALASI:

### STEP 1: Update Database via phpMyAdmin

1. **Buka phpMyAdmin**
   ```
   http://localhost/phpmyadmin
   ```

2. **Pilih database** Anda (misalnya: `sembari_db`)

3. **Klik tab "SQL"**

4. **Copy paste semua isi file:**
   ```
   database/update_library_structure.sql
   ```

5. **Klik tombol "Go"** untuk execute

6. **Refresh** untuk melihat tabel baru

### STEP 2: Cek Perubahan

Pastikan di database Anda sekarang ada:
- ✅ Table `book_types` (4 data)
- ✅ Table `book_book_type` (pivot)
- ✅ Table `categories` (9 data baru)
- ✅ Table `books` dengan kolom `contributors` dan `license`

### STEP 3: Test di Aplikasi

1. **Login ke Admin**
   ```
   http://127.0.0.1:8000/admin/login
   ```

2. **Buka Menu Buku**
   - Klik "Buku" di sidebar
   - Klik "Tambah Buku"

3. **Test Form:**
   - Isi judul buku
   - Isi deskripsi
   - **Kontributor**: Ketik manual, misalnya:
     ```
     Penulis: John Doe
     Ilustrator: Jane Smith
     Penerjemah: Bob Wilson
     ```
   - **Lisensi**: Pilih salah satu (Edisi Terbatas / Edisi Umum)
   - **Jenis Buku**: Centang satu atau lebih (Anak-Anak, Fiksi, dll)
   - **Kategori**: Centang satu atau lebih (Alam, Sains, dll)
   - Upload cover
   - Klik "Simpan Buku"

4. **Cek Hasil:**
   - Buku muncul di daftar
   - Ada badge lisensi
   - Kontributor ditampilkan

---

## 📁 FILE YANG SUDAH DIBUAT/DIUPDATE:

### Database:
```
✅ database/update_library_structure.sql
```

### Controllers:
```
✅ app/Http/Controllers/Admin/BookController.php (updated)
```

### Views:
```
✅ resources/views/admin/books/index.blade.php (updated)
✅ resources/views/admin/books/create.blade.php (updated)
✅ resources/views/admin/books/edit.blade.php (new)
```

---

## 🎨 PREVIEW FORM:

### Form Tambah Buku:
```
┌─────────────────────────────────────────┐
│ [Judul Buku*]                           │
│ [Deskripsi (textarea)]                  │
│ [Kontributor (textarea manual)]         │
│                                         │
│ Lisensi Buku:                          │
│ ( ) Buku Edisi Terbatas                │
│ ( ) Buku Edisi Umum                    │
│                                         │
│ Jenis Buku:                            │
│ [x] Anak - Anak   [ ] Fiksi           │
│ [ ] Nonfiksi      [x] Pendidikan      │
│                                         │
│ Kategori:                              │
│ [ ] Alam          [x] Cerita Rakyat   │
│ [ ] Edisi Terbatas [ ] Ekonomi Kreatif│
│ [x] Matematika    [ ] Pengembangan Diri│
│ [ ] Sains         [ ] Seni Budaya     │
│ [ ] Tokoh                              │
│                                         │
│ [Upload Cover]                         │
│ [Preview Image]                        │
│                                         │
│ [Simpan Buku] [Batal]                 │
└─────────────────────────────────────────┘
```

---

## ⚠️ PENTING!

1. **Backup database** sebelum menjalankan SQL update
2. **Jangan lupa** jalankan di phpMyAdmin
3. **Clear cache** jika diperlukan:
   ```bash
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

4. **Untuk deploy ke cPanel:**
   - Upload semua file yang diupdate
   - Run SQL di phpMyAdmin cPanel
   - Clear cache via route `/clear-cache`

---

## 📞 BANTUAN:

Jika ada error:
1. Cek console browser (F12)
2. Cek Laravel log: `storage/logs/laravel.log`
3. Pastikan semua file terupload
4. Pastikan database sudah diupdate

---

**Selesai!** ✨
Database dan form sudah siap digunakan dengan struktur baru.
