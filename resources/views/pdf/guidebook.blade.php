<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Sistem Perizinan</title>
    <style>
        @page {
            margin: 2cm;
        }
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 20pt;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 10px;
        }
        .header p {
            font-size: 12pt;
            color: #666;
        }
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 14pt;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 10px;
            border-left: 4px solid #2563eb;
            padding-left: 10px;
        }
        .subsection-title {
            font-size: 12pt;
            font-weight: bold;
            color: #334155;
            margin-top: 15px;
            margin-bottom: 8px;
        }
        .content {
            text-align: justify;
            margin-bottom: 15px;
        }
        .list {
            margin-left: 20px;
            margin-bottom: 10px;
        }
        .list li {
            margin-bottom: 8px;
        }
        .highlight-box {
            background-color: #eff6ff;
            border-left: 4px solid #2563eb;
            padding: 15px;
            margin: 15px 0;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9pt;
            color: #666;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        table th, table td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SISTEM ANALISA DAN TRACKING PERIZINAN</h1>
        <p>Panduan Penggunaan Sistem</p>
        <p style="font-size: 10pt; margin-top: 5px;">Versi 1.0 | 2025</p>
    </div>

    <div class="section">
        <div class="section-title">1. PENDAHULUAN</div>
        <div class="content">
            <p>
                Sistem Analisa dan Tracking Perizinan adalah aplikasi web berbasis Laravel yang dirancang untuk 
                mengoptimalkan proses pengurusan perizinan usaha. Sistem ini menyediakan platform terintegrasi bagi 
                berbagai pemangku kepentingan dalam proses perizinan, mulai dari pengajuan hingga penerbitan dokumen resmi.
            </p>
            <p>
                Sistem ini dikembangkan oleh <strong>Muhammad Ulil Amri</strong> (NIM: 23091397091) dan 
                <strong>Nesyari Az-Zahra</strong> (NIM: 23091397104), mahasiswa Program Studi Manajemen Informatika, 
                Universitas Negeri Surabaya.
            </p>
        </div>
    </div>

    <div class="section page-break">
        <div class="section-title">2. FITUR UTAMA SISTEM</div>
        
        <div class="subsection-title">2.1 Manajemen Permohonan</div>
        <div class="content">
            <ul class="list">
                <li>Pengajuan permohonan perizinan secara digital</li>
                <li>Tracking status permohonan secara real-time</li>
                <li>Filter multi-kriteria: status, sektor, tanggal, jenis usaha</li>
                <li>Deteksi otomatis permohonan yang melewati deadline</li>
                <li>Log aktivitas untuk audit trail</li>
            </ul>
        </div>

        <div class="subsection-title">2.2 Dashboard & Analitik</div>
        <div class="content">
            <ul class="list">
                <li>Dashboard khusus untuk setiap role pengguna</li>
                <li>Statistik real-time dengan visualisasi grafik</li>
                <li>Chart distribusi status permohonan</li>
                <li>Filter statistik berdasarkan periode waktu</li>
                <li>Monitoring kinerja dan metrik operasional</li>
            </ul>
        </div>

        <div class="subsection-title">2.3 Dokumen Digital</div>
        <div class="content">
            <ul class="list">
                <li>Generate BAP (Berita Acara Pemeriksaan) dalam format PDF</li>
                <li>Digital signature pad untuk tanda tangan elektronik</li>
                <li>Ekspor data ke format Excel dengan formatting lengkap</li>
                <li>Ekspor data ke PDF landscape dengan layout tabel optimal</li>
                <li>Template PDF yang dapat dikustomisasi</li>
            </ul>
        </div>

        <div class="subsection-title">2.4 Notifikasi Real-time</div>
        <div class="content">
            <ul class="list">
                <li>Notifikasi real-time untuk berkas yang dikembalikan</li>
                <li>Badge counter untuk jumlah notifikasi</li>
                <li>Modal notifikasi dengan detail lengkap</li>
                <li>Update status notifikasi: Dikembalikan, Dihubungi, Selesai</li>
                <li>Tracking informasi menghubungi pemohon</li>
            </ul>
        </div>
    </div>

    <div class="section page-break">
        <div class="section-title">3. ROLE PENGGUNA</div>
        
        <div class="subsection-title">3.1 Administrator</div>
        <div class="content">
            <p>Memiliki akses penuh untuk:</p>
            <ul class="list">
                <li>Manajemen user (create, edit, delete)</li>
                <li>Konfigurasi sistem</li>
                <li>Monitoring semua permohonan</li>
                <li>Pengaturan TTD (Tanda Tangan Digital)</li>
                <li>Manajemen master data jenis usaha</li>
            </ul>
        </div>

        <div class="subsection-title">3.2 DPMPTSP</div>
        <div class="content">
            <p>Bertanggung jawab untuk:</p>
            <ul class="list">
                <li>Koordinasi dan monitoring permohonan</li>
                <li>Update status permohonan (Menunggu, Diterima, Ditolak, Dikembalikan)</li>
                <li>Menerima dan mengelola notifikasi berkas dikembalikan</li>
                <li>Tracking menghubungi pemohon</li>
                <li>Review dan generate BAP</li>
            </ul>
        </div>

        <div class="subsection-title">3.3 PD Teknis</div>
        <div class="content">
            <p>Melakukan:</p>
            <ul class="list">
                <li>Verifikasi teknis sesuai sektor yang ditangani</li>
                <li>Pemeriksaan lapangan</li>
                <li>Generate BAP dengan input persyaratan lengkap</li>
                <li>Digital signature untuk pemeriksa</li>
                <li>Statistik per sektor</li>
            </ul>
        </div>

        <div class="subsection-title">3.4 Penerbitan Berkas</div>
        <div class="content">
            <p>Menginput dan mengelola:</p>
            <ul class="list">
                <li>Data penerbitan (nama usaha, alamat, kegiatan)</li>
                <li>Generate dokumen resmi dengan signature digital</li>
                <li>Ekspor laporan ke Excel dan PDF Landscape</li>
            </ul>
        </div>
    </div>

    <div class="section page-break">
        <div class="section-title">4. ALUR KERJA SISTEM</div>
        
        <div class="subsection-title">4.1 Alur Umum Permohonan</div>
        <div class="content">
            <ol class="list">
                <li><strong>Pengajuan:</strong> Permohonan dibuat dengan status "Menunggu"</li>
                <li><strong>Verifikasi:</strong> DPMPTSP melakukan verifikasi awal</li>
                <li><strong>Pemeriksaan:</strong> PD Teknis melakukan verifikasi teknis dan pemeriksaan lapangan</li>
                <li><strong>BAP:</strong> Generate Berita Acara Pemeriksaan dengan digital signature</li>
                <li><strong>Keputusan:</strong> Status diubah menjadi Diterima, Ditolak, atau Dikembalikan</li>
                <li><strong>Penerbitan:</strong> Jika diterima, dokumen resmi diterbitkan</li>
            </ol>
        </div>

        <div class="subsection-title">4.2 Status Permohonan</div>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Menunggu</td>
                    <td>Permohonan baru diajukan, menunggu proses verifikasi</td>
                </tr>
                <tr>
                    <td>Diterima</td>
                    <td>Permohonan telah disetujui dan dapat dilanjutkan ke tahap berikutnya</td>
                </tr>
                <tr>
                    <td>Ditolak</td>
                    <td>Permohonan ditolak karena tidak memenuhi persyaratan</td>
                </tr>
                <tr>
                    <td>Dikembalikan</td>
                    <td>Permohonan dikembalikan untuk perbaikan atau kelengkapan dokumen</td>
                </tr>
                <tr>
                    <td>Terlambat</td>
                    <td>Permohonan melewati deadline yang ditentukan (otomatis)</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section page-break">
        <div class="section-title">5. CARA MENGGUNAKAN SISTEM</div>
        
        <div class="subsection-title">5.1 Login ke Sistem</div>
        <div class="content">
            <ol class="list">
                <li>Buka aplikasi melalui browser</li>
                <li>Masukkan email dan password yang telah diberikan</li>
                <li>Isi CAPTCHA untuk keamanan</li>
                <li>Klik tombol "Login"</li>
            </ol>
        </div>

        <div class="subsection-title">5.2 Membuat Permohonan Baru</div>
        <div class="content">
            <ol class="list">
                <li>Klik menu "Permohonan" di sidebar</li>
                <li>Klik tombol "Tambah Permohonan"</li>
                <li>Isi semua field yang wajib diisi</li>
                <li>Pilih sektor, jenis usaha, dan informasi lainnya</li>
                <li>Klik "Simpan" untuk menyimpan permohonan</li>
            </ol>
        </div>

        <div class="subsection-title">5.3 Generate BAP (Berita Acara Pemeriksaan)</div>
        <div class="content">
            <ol class="list">
                <li>Pilih permohonan yang akan dibuat BAP</li>
                <li>Klik tombol "BAP" pada permohonan tersebut</li>
                <li>Isi form BAP dengan lengkap:
                    <ul>
                        <li>Nomor BAP dan tanggal pemeriksaan</li>
                        <li>Hasil peninjauan lapangan</li>
                        <li>Daftar persyaratan dengan status (Sesuai/Tidak Sesuai/Belum Ada)</li>
                        <li>Keputusan dan catatan</li>
                    </ul>
                </li>
                <li>Lakukan digital signature untuk pemeriksa dan koordinator</li>
                <li>Klik "Generate PDF" untuk menghasilkan dokumen BAP</li>
            </ol>
        </div>

        <div class="subsection-title">5.4 Melihat Statistik</div>
        <div class="content">
            <ol class="list">
                <li>Klik menu "Statistik" di sidebar</li>
                <li>Pilih periode waktu yang ingin dilihat</li>
                <li>Sistem akan menampilkan:
                    <ul>
                        <li>Total permohonan</li>
                        <li>Distribusi status permohonan</li>
                        <li>Grafik trend permohonan</li>
                        <li>Statistik per sektor</li>
                    </ul>
                </li>
            </ol>
        </div>
    </div>

    <div class="section page-break">
        <div class="section-title">6. EKSPOR DATA</div>
        
        <div class="subsection-title">6.1 Ekspor ke Excel</div>
        <div class="content">
            <ol class="list">
                <li>Pada halaman Permohonan, gunakan filter untuk memilih data yang ingin diekspor</li>
                <li>Klik tombol "Export Excel"</li>
                <li>File Excel akan terdownload dengan format yang sudah disesuaikan</li>
            </ol>
        </div>

        <div class="subsection-title">6.2 Ekspor ke PDF</div>
        <div class="content">
            <ol class="list">
                <li>Pilih data yang ingin diekspor menggunakan filter</li>
                <li>Klik tombol "Export PDF Landscape"</li>
                <li>File PDF akan terdownload dalam format landscape dengan layout tabel optimal</li>
            </ol>
        </div>
    </div>

    <div class="section page-break">
        <div class="section-title">7. KEAMANAN SISTEM</div>
        
        <div class="highlight-box">
            <p><strong>Sistem ini dilengkapi dengan berbagai fitur keamanan:</strong></p>
            <ul class="list">
                <li>Authentication & Authorization dengan role-based access control</li>
                <li>CSRF Protection untuk semua POST requests</li>
                <li>Input Validation dengan Laravel Form Request</li>
                <li>SQL Injection Protection menggunakan Eloquent ORM</li>
                <li>XSS Protection dengan Blade auto-escape dan input sanitization</li>
                <li>Password Hashing menggunakan bcrypt algorithm</li>
                <li>CAPTCHA untuk form login</li>
                <li>Rate Limiting (5 attempts pada login)</li>
                <li>Data Protection dengan foreign key constraints (SET NULL untuk data safety)</li>
            </ul>
        </div>
    </div>

    <div class="section page-break">
        <div class="section-title">8. TEKNOLOGI YANG DIGUNAKAN</div>
        
        <div class="subsection-title">Backend</div>
        <ul class="list">
            <li>Laravel 11.x</li>
            <li>PHP 8.2+</li>
            <li>MySQL Database</li>
            <li>Eloquent ORM</li>
        </ul>

        <div class="subsection-title">Frontend</div>
        <ul class="list">
            <li>Tailwind CSS</li>
            <li>Alpine.js</li>
            <li>Chart.js</li>
            <li>Blade Templating</li>
        </ul>

        <div class="subsection-title">Tools & Libraries</div>
        <ul class="list">
            <li>SignaturePad.js (Digital Signature)</li>
            <li>SweetAlert2 (Alert & Notification)</li>
            <li>DomPDF (PDF Generation)</li>
            <li>Maatwebsite Excel (Excel Export)</li>
        </ul>
    </div>

    <div class="section">
        <div class="section-title">9. KONTAK & DUKUNGAN</div>
        <div class="content">
            <p>
                Untuk pertanyaan, saran, atau bantuan teknis terkait penggunaan sistem, 
                silakan hubungi administrator sistem atau tim pengembang.
            </p>
            <div class="highlight-box">
                <p><strong>Tim Pengembang:</strong></p>
                <p>Muhammad Ulil Amri (NIM: 23091397091)</p>
                <p>Nesyari Az-Zahra (NIM: 23091397104)</p>
                <p>Program Studi Manajemen Informatika</p>
                <p>Universitas Negeri Surabaya</p>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Dikembangkan menggunakan Laravel Framework | © 2025</p>
    </div>
</body>
</html>

