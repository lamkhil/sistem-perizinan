# Sistem Perizinan

Web application berbasis Laravel untuk pengelolaan proses perizinan usaha secara digital. Sistem ini menyediakan platform terintegrasi bagi berbagai pemangku kepentingan dalam proses perizinan, mulai dari pengajuan hingga penerbitan dokumen resmi.

## Deskripsi Sistem

Sistem Perizinan adalah aplikasi web yang dirancang untuk mengoptimalkan proses pengurusan perizinan usaha. Sistem ini mendukung workflow multi-level dengan kontrol akses berdasarkan peran pengguna, memungkinkan pengelolaan yang efisien dari tahap pengajuan hingga persetujuan dan penerbitan dokumen.

## Fitur Utama

### Autentikasi dan Keamanan
- Sistem login dengan validasi CAPTCHA untuk meningkatkan keamanan
- Role-based access control dengan 4 level akses berbeda
- Session management dan monitoring aktivitas pengguna
- Validasi data pada level model dan controller
- Email verification untuk semua user
- Password hashing dengan bcrypt

### Manajemen Pengguna
- 4 role dengan permission berbeda: Administrator, DPMPTSP, PD Teknis, Penerbitan Berkas
- User management dengan kontrol penuh untuk administrator
- Validasi kredensial pada level database dan aplikasi
- Pengaturan profil pengguna dengan update keamanan
- Manajemen sektor untuk user PD Teknis (8 sektor: Dinkopdag, Disbudpar, Dinkes, Dishub, Dprkpp, Dkpp, Dlh, Disperinaker)

### Pengelolaan Permohonan
- Full CRUD untuk data permohonan
- Tracking status: Menunggu, Diterima, Ditolak, Dikembalikan, Terlambat
- Filter multi-kriteria: status, sektor, tanggal, jenis usaha
- Deteksi otomatis permohonan yang melewati deadline
- Log aktivitas untuk audit trail
- Form-only layout untuk create/edit (tanpa header/sidebar)
- Detail permohonan dengan action buttons terintegrasi
- Tracking workflow: Pengembalian, Menghubungi, Perbaikan, Terbit

### Penerbitan Berkas
- Full CRUD untuk data penerbitan berkas
- Relasi dengan permohonan (1:1)
- Tracking status: Menunggu, Diterima, Ditolak, Dikembalikan
- Manajemen nomor BAP dan tanggal BAP
- Filter dan pencarian data penerbitan berkas
- Ekspor data ke Excel dan PDF

### Dashboard dan Analitik
- Dashboard khusus untuk setiap role pengguna
- Statistik real-time dengan visualisasi grafik
- Chart distribusi status permohonan
- Filter statistik berdasarkan periode waktu
- Monitoring kinerja dan metrik operasional
- Dashboard PD Teknis dengan filter per sektor
- Tracking permohonan terlambat dan deadline

### Ekspor Data dan Laporan
- Ekspor data ke format Excel dengan formatting lengkap
- Ekspor data ke PDF landscape dengan layout tabel optimal
- Filter custom berdasarkan rentang tanggal
- Generate dokumen penerbitan berkas dengan signature digital
- Template PDF yang dapat dikustomisasi
- Generate Berita Acara Pemeriksaan (BAP) dalam format PDF
- Form BAP dengan validasi client-side dan server-side
- Tabel persyaratan dinamis dengan checkbox interaktif

### Konfigurasi Sistem
- Pengaturan tanda tangan digital untuk dokumen resmi
- Manajemen master data jenis usaha
- Konfigurasi parameter sistem
- Pengaturan role dan permission
- Pengaturan koordinator untuk dokumen BAP (nama dan NIP)
- Edit koordinator khusus untuk administrator
- Pengaturan lokasi dan tanggal untuk tanda tangan

### User Interface
- Desain modern menggunakan Tailwind CSS framework
- Responsive layout untuk berbagai ukuran layar
- Interaktif dengan Alpine.js untuk interaksi real-time
- Grafik visualisasi dengan Chart.js
- Konsistensi warna dan tipografi
- Digital signature pad untuk tanda tangan elektronik
- Notifikasi real-time untuk berkas dikembalikan
- Modal notifikasi dengan expand/collapse untuk detail
- Form validation dengan feedback visual menggunakan SweetAlert2
- Form-only layout untuk pengalaman input yang fokus
- Status badge dengan warna dan animasi

### Berita Acara Pemeriksaan (BAP)
- Form BAP dengan validasi lengkap (client-side dan server-side)
- Tabel persyaratan dinamis yang dapat ditambah/dikurangi
- Status persyaratan: Sesuai, Tidak Sesuai, Belum Ada
- Sub-item persyaratan untuk detail lebih lanjut
- Digital signature pad untuk tanda tangan pemeriksa dan koordinator
- Generate PDF BAP dengan format profesional
- Edit nama dan NIP koordinator (khusus admin)
- Format PDF dengan tabel hitam-putih dan checkmark icon yang kompatibel
- Layout "Mengetahui" dengan format 3 baris yang rapi

### Notifikasi Sistem
- Notifikasi real-time untuk berkas yang dikembalikan
- Badge counter untuk jumlah notifikasi
- Modal notifikasi dengan detail lengkap
- Update status notifikasi: Dikembalikan, Dihubungi, Selesai
- Tracking informasi menghubungi pemohon
- Keterangan menghubungi dengan template cepat
- API endpoint untuk fetch dan update notifikasi
- Filter notifikasi berdasarkan role pengguna

## Stack Teknologi

### Backend
- Laravel 11.x
- PHP 8.2+
- MySQL Database
- Eloquent ORM untuk database abstraction
- Form Request Validation untuk input validation

### Frontend
- Tailwind CSS untuk styling
- Alpine.js untuk interaktivitas
- Chart.js untuk visualisasi data
- Blade templating engine
- SignaturePad.js untuk digital signature
- SweetAlert2 untuk alert dan konfirmasi
- AJAX untuk interaksi tanpa reload halaman

### Dependencies
- mews/captcha: Implementasi CAPTCHA security
- maatwebsite/excel: Ekspor ke format Excel
- barryvdh/laravel-dompdf: Generasi dokumen PDF
- doctrine/dbal: Database abstraction layer untuk migration dengan modifikasi kolom
- signature_pad: Digital signature pad untuk tanda tangan elektronik
- sweetalert2: Alert dan notification yang user-friendly

## Instalasi

### Prasyarat
- PHP versi 8.2 atau lebih tinggi
- Composer untuk dependency management
- Node.js dan NPM untuk asset compilation
- MySQL versi 5.7 atau lebih tinggi
- Web server (Apache/Nginx)

## Database Seeding

### User Seeder
Seeder default akan membuat 11 user dengan role berbeda:

**Admin:**
- Email: `admin@dpmptsp.surabaya.go.id`
- Password: `Admin@2025`

**DPMPTSP:**
- Email: `dpmptsp@dpmptsp.surabaya.go.id`
- Password: `Dpmptsp@2025`

**PD Teknis (8 user):**
- Email: `[sektor]@dpmptsp.surabaya.go.id` (contoh: `dinkopdag@dpmptsp.surabaya.go.id`)
- Password: `PdTeknis@2025`
- Sektor: Dinkopdag, Disbudpar, Dinkes, Dishub, Dprkpp, Dkpp, Dlh, Disperinaker

**Penerbitan Berkas:**
- Email: `penerbitan@dpmptsp.surabaya.go.id`
- Password: `Penerbitan@2025`

### Data Seeder
Untuk membuat data dummy permohonan dan penerbitan berkas:
```bash
php artisan db:seed --class=ComprehensiveDataSeeder
```

## Struktur Database

Sistem menggunakan 7 tabel utama:

1. **users** - Data pengguna dengan role dan sektor
2. **permohonans** - Data permohonan perizinan
3. **penerbitan_berkas** - Data penerbitan berkas
4. **log_permohonans** - Log aktivitas permohonan
5. **jenis_usahas** - Master data jenis usaha
6. **ttd_settings** - Pengaturan tanda tangan digital
7. **app_settings** - Pengaturan aplikasi

ERD lengkap dapat dilihat di file `database/dbml_schema.dbml`. File ini dapat digunakan di [dbdiagram.io](https://dbdiagram.io/) untuk melihat visualisasi ERD secara interaktif.

## Keamanan

### Implementasi Keamanan
- Authentication & Authorization dengan role-based access control
- CSRF Protection untuk semua POST requests (33+ form terlindungi)
- Input Validation dengan Laravel Form Request
- SQL Injection Protection menggunakan Eloquent ORM (prepared statements)
- XSS Protection dengan Blade auto-escape dan input sanitization
- Session Security dengan regeneration, http_only, dan same_site cookies
- CAPTCHA untuk form login
- Rate Limiting pada login (5 attempts)
- Password Hashing menggunakan bcrypt
- File Upload Security dengan validasi extension dan MIME type
- Error Handling yang aman (tidak expose informasi sistem)
- Data Protection dengan foreign key constraints (SET NULL untuk data safety)
- Email verification untuk mencegah akun tidak terverifikasi

## Role dan Permission

### Administrator
- Akses penuh ke semua fitur
- Manajemen user
- Manajemen jenis usaha
- Pengaturan sistem
- Edit koordinator BAP

### DPMPTSP
- Melihat semua permohonan
- Membuat dan mengelola permohonan
- Verifikasi permohonan
- Melihat notifikasi berkas dikembalikan
- Ekspor data

### PD Teknis
- Melihat permohonan sesuai sektor
- Verifikasi permohonan sesuai sektor
- Membuat BAP
- Dashboard dengan filter sektor

### Penerbitan Berkas
- Melihat dan mengelola penerbitan berkas
- Membuat penerbitan berkas
- Pengaturan tanda tangan digital
- Ekspor data penerbitan berkas

## API Endpoints

### Notifikasi API
- `GET /api/notifications` - Mendapatkan daftar notifikasi
- `POST /api/notifications/{id}/update` - Update status notifikasi

### Export API
- `GET /permohonan/export/excel` - Ekspor permohonan ke Excel
- `GET /permohonan/export/pdf-landscape` - Ekspor permohonan ke PDF
- `GET /penerbitan-berkas/export/excel` - Ekspor penerbitan berkas ke Excel
- `GET /penerbitan-berkas/export/pdf/landscape` - Ekspor penerbitan berkas ke PDF

## Lisensi

Dikembangkan menggunakan Laravel Framework

---

**Catatan:** Pastikan untuk mengubah password default setelah instalasi pertama untuk keamanan sistem.
