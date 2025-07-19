
---

## ✅ **README.md (Frontend Repository)**

# Attendance Management - Frontend (jQuery + Bootstrap)

Tugas frontend untuk menampilkan sistem absensi dari backend Laravel.

## 📌 Spesifikasi

- Teknologi: HTML, jQuery, Bootstrap, DataTables
- Ajax untuk komunikasi API
- Single layout Blade + Bootstrap navbar
- Berpindah halaman antar menu (bukan SPA)

## 📄 Fitur Halaman

### 1. Departemen
- Tabel DataTables
- Tambah/Edit via modal form
- Hapus menggunakan konfirmasi

### 2. Karyawan
- Tabel DataTables
- Tambah/Edit via modal form
- Pilih Departemen dari API

### 3. Absensi (Log)
- Hanya menampilkan data
- Tampilkan status `Late`, `Early Leave`, atau kosong
- Support filter tanggal & departemen

### 4. Check-In
- Pilih karyawan, tombol clock-in
- Jika telat harus isi deskripsi

### 5. Check-Out
- Pilih karyawan, tombol clock-out
- Jika pulang cepat wajib deskripsi (kecuali sudah telat)

## 📦 Instalasi

- git clone [https://github.com/username/frontend-attendance.git](https://github.com/dnshaniff/attendances_frontend.git)
- cd attendances_frontend
- php artisan serve
