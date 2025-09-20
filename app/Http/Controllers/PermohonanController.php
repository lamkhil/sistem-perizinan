<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\LogPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use App\Exports\PermohonanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Ambil parameter dari request
        $searchQuery = $request->query('search');
        $selectedSektor = $request->query('sektor');
        $selectedDateFilter = $request->query('date_filter');
        $customDate = $request->query('custom_date');

        // Query dasar
        $permohonans = Permohonan::query();

        // Filter berdasarkan peran
        if ($user->role === 'dpmptsp') {
            // DPMPTSP melihat semua permohonan
        } elseif ($user->role === 'pd_teknis') {
            // PD Teknis melihat semua permohonan (bisa diubah nanti jika perlu filter)
            // $permohonans->where('verifikator', $user->name); // Dikomentari sementara
        }
        // Admin melihat semua permohonan secara default

        // Terapkan filter sektor
        if ($selectedSektor) {
            $permohonans->where('sektor', $selectedSektor);
        }

        // Terapkan filter tanggal
        if ($selectedDateFilter) {
            $now = Carbon::now();
            
            switch ($selectedDateFilter) {
                case 'today':
                    $permohonans->whereDate('created_at', $now->toDateString());
                    break;
                case 'yesterday':
                    $permohonans->whereDate('created_at', $now->subDay()->toDateString());
                    break;
                case 'this_week':
                    $permohonans->whereBetween('created_at', [
                        $now->startOfWeek()->toDateTimeString(),
                        $now->endOfWeek()->toDateTimeString()
                    ]);
                    break;
                case 'last_week':
                    $permohonans->whereBetween('created_at', [
                        $now->subWeek()->startOfWeek()->toDateTimeString(),
                        $now->subWeek()->endOfWeek()->toDateTimeString()
                    ]);
                    break;
                case 'this_month':
                    $permohonans->whereMonth('created_at', $now->month)
                               ->whereYear('created_at', $now->year);
                    break;
                case 'last_month':
                    $lastMonth = $now->subMonth();
                    $permohonans->whereMonth('created_at', $lastMonth->month)
                               ->whereYear('created_at', $lastMonth->year);
                    break;
                case 'custom':
                    if ($customDate) {
                        $permohonans->whereDate('created_at', $customDate);
                    }
                    break;
            }
        }

        // Terapkan logika pencarian
        if ($searchQuery) {
            $permohonans->where(function ($query) use ($searchQuery) {
                $query->where('no_permohonan', 'like', '%' . $searchQuery . '%')
                      ->orWhere('nama_usaha', 'like', '%' . $searchQuery . '%');
            });
        }

        $permohonans = $permohonans->orderBy('created_at', 'desc')->paginate(10);
        
        // Ambil daftar sektor unik
        $sektors = Permohonan::select('sektor')->whereNotNull('sektor')->distinct()->pluck('sektor');

        return view('permohonan.index', compact('permohonans', 'sektors', 'selectedSektor', 'searchQuery', 'selectedDateFilter', 'customDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $verifikators = ['RAMLAN', 'SURYA', 'ALI', 'WILDAN A', 'TYO', 'WILDAN M', 'YOLA', 'NAURA'];
        $sektors = ['Perdagangan', 'Kesehatan', 'Perhubungan', 'Pertanian', 'Perindustrian', 'KKPR', 'Ketenagakerjaan'];
        $jenisPelakuUsahas = ['Orang Perseorangan', 'Badan Usaha'];
        $jenisUsahas = [
            'Perseroan Terbatas (PT)',
            'Perseroan Terbatas (PT) Perorangan',
            'Persekutuan Komanditer (CV/Commanditaire Vennootschap)',
            'Persekutuan Firma (FA / Venootschap Onder Firma)',
            'Persekutuan Perdata',
            'Perusahaan Umum (Perum)',
            'Perusahaan Umum Daerah (Perumda)',
            'Badan Hukum Lainnya',
            'Koperasi',
            'Persekutuan dan Perkumpulan',
            'Yayasan',
            'Badan Layanan Umum',
            'BUM Desa',
            'BUM Desa Bersama',
        ];
        $jenisProyeks = ['Utama', 'Pendukung', 'Pendukung UMKU', 'Kantor Cabang Administratif'];
        $verificationStatusOptions = ['Berkas Disetujui', 'Berkas Diperbaiki', 'Pemohon Dihubungi', 'Berkas Diunggah Ulang', 'Pemohon Belum Dihubungi'];

        return view('permohonan.create', compact('verifikators', 'sektors', 'jenisPelakuUsahas', 'jenisUsahas', 'jenisProyeks', 'verificationStatusOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $isDpmptsp = $user->role === 'dpmptsp';

        $rules = [
            'tanggal_permohonan' => 'nullable|date',
            'jenis_pelaku_usaha' => 'nullable|string|in:Orang Perseorangan,Badan Usaha',
            'nik' => 'nullable|string|max:16',
            'nama_usaha' => 'nullable|string', // Pastikan ini ada untuk input teks
            'jenis_badan_usaha' => 'nullable|string', // Tambahkan ini untuk dropdown Jenis Badan Usaha
            'nib' => 'nullable|string|max:20',
            'alamat_perusahaan' => 'nullable|string',
            'sektor' => 'nullable|string',
            'kbli' => 'nullable|string',
            'inputan_teks' => 'nullable|string',
            'modal_usaha' => 'nullable|numeric',
            'jenis_proyek' => 'nullable|string',
            'no_proyek' => 'nullable|string',
            'verifikator' => 'nullable|string',
            'status' => 'required|in:Dikembalikan,Diterima,Ditolak,Menunggu',
            'verifikasi_pd_teknis' => 'nullable|string',
            'verifikasi_dpmptsp' => 'nullable|string',
            'pengembalian' => 'nullable|date',
            'keterangan_pengembalian' => 'nullable|string',
            'menghubungi' => 'nullable|date',
            'keterangan_menghubungi' => 'nullable|string',
            'status_menghubungi' => 'nullable|string',
            'perbaikan' => 'nullable|date',
            'keterangan_perbaikan' => 'nullable|string',
            'terbit' => 'nullable|date',
            'keterangan_terbit' => 'nullable|string',
            'pemroses_dan_tgl_surat' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ];

        // Validasi kondisional berdasarkan role
        if ($user->role === 'pd_teknis') {
            // PD Teknis wajib isi: no_permohonan, tanggal_permohonan, jenis_pelaku_usaha, nib, verifikator, status
            $rules['no_permohonan'] = 'required|string|unique:permohonans,no_permohonan';
            $rules['tanggal_permohonan'] = 'required|date';
            $rules['jenis_pelaku_usaha'] = 'required|in:Orang Perseorangan,Badan Usaha';
            $rules['nib'] = 'required|string|max:20';
            $rules['verifikator'] = 'required|string';
            $rules['status'] = 'required|in:Dikembalikan,Diterima,Ditolak,Menunggu';
        } elseif ($user->role === 'dpmptsp') {
            // DPMPTSP wajib isi: nama_usaha, alamat_perusahaan, modal_usaha, jenis_proyek, verifikator, status
            $rules['nama_usaha'] = 'required|string';
            $rules['alamat_perusahaan'] = 'required|string';
            $rules['modal_usaha'] = 'required|numeric';
            $rules['jenis_proyek'] = 'required|string';
            $rules['verifikator'] = 'required|string';
            $rules['status'] = 'required|in:Dikembalikan,Diterima,Ditolak,Menunggu';
        } else {
            // Admin wajib isi semua field utama
            $rules['no_permohonan'] = 'required|string|unique:permohonans,no_permohonan';
            $rules['tanggal_permohonan'] = 'required|date';
            $rules['jenis_pelaku_usaha'] = 'required|in:Orang Perseorangan,Badan Usaha';
            $rules['verifikator'] = 'required|string';
            $rules['status'] = 'required|in:Dikembalikan,Diterima,Ditolak,Menunggu';
        }
        
        // Semua role wajib isi verifikator dan status
        $rules['verifikator'] = 'required|string';
        $rules['status'] = 'required|in:Dikembalikan,Diterima,Ditolak,Menunggu';

        $validated = $request->validate($rules);
        
        // Tambahkan user_id ke data yang akan disimpan
        $validated['user_id'] = $user->id;
        
        // PENTING: Jika jenis_pelaku_usaha adalah 'Orang Perseorangan', pastikan nama_usaha dan jenis_badan_usaha di-null-kan
        if (isset($validated['jenis_pelaku_usaha']) && $validated['jenis_pelaku_usaha'] === 'Orang Perseorangan') {
            $validated['nama_usaha'] = null;
            $validated['jenis_badan_usaha'] = null;
        }

        // PENTING: Jika jenis_pelaku_usaha adalah 'Badan Usaha', pastikan nik di-null-kan
        if (isset($validated['jenis_pelaku_usaha']) && $validated['jenis_pelaku_usaha'] === 'Badan Usaha') {
            $validated['nik'] = null;
        }
        
        // LOGIKA KHUSUS UNTUK DPMPTSP
        
        // Jika DPMPTSP dan no_permohonan kosong, buat nomor draft
        if ($isDpmptsp && empty($validated['no_permohonan'])) {
            $validated['no_permohonan'] = 'Draft-' . $user->name . '-' . Carbon::now()->format('YmdHis');
        }
        // Jika DPMPTSP dan jenis_pelaku_usaha kosong, set default ke 'Badan Usaha'
        if ($isDpmptsp && empty($validated['jenis_pelaku_usaha'])) {
            $validated['jenis_pelaku_usaha'] = 'Badan Usaha';
        }

        $permohonan = Permohonan::create($validated);

        // Buat log
        LogPermohonan::create([
            'permohonan_id' => $permohonan->id,
            'user_id' => Auth::id(),
            'status_sebelum' => 'Draft',
            'status_sesudah' => $permohonan->status,
            'keterangan' => 'Permohonan baru dibuat',
        ]);

        return redirect()->route('dashboard')->with('success', 'Permohonan berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Permohonan $permohonan)
    {
        $logs = LogPermohonan::where('permohonan_id', $permohonan->id)->orderBy('created_at', 'desc')->get();
        return view('permohonan.show', compact('permohonan', 'logs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permohonan $permohonan)
    {
        $verifikators = ['RAMLAN', 'SURYA', 'ALI', 'WILDAN A', 'TYO', 'WILDAN M', 'YOLA', 'NAURA'];
        $sektors = ['Perdagangan', 'Kesehatan', 'Perhubungan', 'Pertanian', 'Perindustrian', 'KKPR', 'Ketenagakerjaan'];
        $jenisPelakuUsahas = ['Orang Perseorangan', 'Badan Usaha'];
        $jenisUsahas = [
            'Perseroan Terbatas (PT)',
            'Perseroan Terbatas (PT) Perorangan',
            'Persekutuan Komanditer (CV/Commanditaire Vennootschap)',
            'Persekutuan Firma (FA / Venootschap Onder Firma)',
            'Persekutuan Perdata',
            'Perusahaan Umum (Perum)',
            'Perusahaan Umum Daerah (Perumda)',
            'Badan Hukum Lainnya',
            'Koperasi',
            'Persekutuan dan Perkumpulan',
            'Yayasan',
            'Badan Layanan Umum',
            'BUM Desa',
            'BUM Desa Bersama',
        ];
        $jenisProyeks = ['Utama', 'Pendukung', 'Pendukung UMKU', 'Kantor Cabang Administratif'];
        $verificationStatusOptions = ['Berkas Disetujui', 'Berkas Diperbaiki', 'Pemohon Dihubungi', 'Berkas Diunggah Ulang', 'Pemohon Belum Dihubungi'];

        return view('permohonan.edit', compact('permohonan', 'jenisPelakuUsahas', 'jenisUsahas', 'sektors', 'verifikators', 'jenisProyeks', 'verificationStatusOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permohonan $permohonan)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'tanggal_permohonan' => 'nullable|date',
            'jenis_pelaku_usaha' => 'nullable|string|in:Orang Perseorangan,Badan Usaha',
            'nik' => 'nullable|string|max:16',
            'nama_usaha' => 'nullable|string', // Pastikan ini ada untuk input teks
            'jenis_badan_usaha' => 'nullable|string', // Tambahkan ini untuk dropdown Jenis Badan Usaha
            'nib' => 'nullable|string|max:20',
            'alamat_perusahaan' => 'nullable|string',
            'sektor' => 'nullable|string',
            'kbli' => 'nullable|string',
            'inputan_teks' => 'nullable|string',
            'modal_usaha' => 'nullable|numeric',
            'jenis_proyek' => 'nullable|string',
            'no_proyek' => 'nullable|string',
            'verifikator' => 'nullable|string',
            'status' => 'required|in:Dikembalikan,Diterima,Ditolak,Menunggu',
            'verifikasi_pd_teknis' => 'nullable|string',
            'verifikasi_dpmptsp' => 'nullable|string',
            'pengembalian' => 'nullable|date',
            'keterangan_pengembalian' => 'nullable|string',
            'menghubungi' => 'nullable|date',
            'keterangan_menghubungi' => 'nullable|string',
            'status_menghubungi' => 'nullable|string',
            'perbaikan' => 'nullable|date',
            'keterangan_perbaikan' => 'nullable|string',
            'terbit' => 'nullable|date',
            'keterangan_terbit' => 'nullable|string',
            'pemroses_dan_tgl_surat' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);
        
        // PENTING: Jika jenis_pelaku_usaha adalah 'Orang Perseorangan', pastikan nama_usaha dan jenis_badan_usaha di-null-kan
        if ($request->input('jenis_pelaku_usaha') === 'Orang Perseorangan') {
            $validated['nama_usaha'] = null;
            $validated['jenis_badan_usaha'] = null;
        }

        // PENTING: Jika jenis_pelaku_usaha adalah 'Badan Usaha', pastikan nik di-null-kan
        if ($request->input('jenis_pelaku_usaha') === 'Badan Usaha') {
            $validated['nik'] = null;
        }

        $dataSebelum = $permohonan->getOriginal();
        
        $permohonan->update($validated);

        // Log perubahan
        $perubahan = $permohonan->getChanges();
        
        if (!empty(Arr::except($perubahan, ['updated_at']))) {
            $deskripsiLog = [];
            foreach ($perubahan as $field => $nilaiBaru) {
                if ($field === 'updated_at') continue;
                
                $nilaiLama = $dataSebelum[$field] ?? 'Kosong';
                if (in_array($field, ['tanggal_permohonan', 'pengembalian', 'menghubungi', 'perbaikan', 'terbit']) && $nilaiLama && $nilaiLama !== 'Kosong') {
                    try {
                        $nilaiLama = Carbon::parse($nilaiLama)->format('d-m-Y');
                    } catch (\Exception $e) {
                        // Keep original value if parsing fails
                    }
                }
                
                if (in_array($field, ['tanggal_permohonan', 'pengembalian', 'menghubungi', 'perbaikan', 'terbit']) && $nilaiBaru && $nilaiBaru !== 'Kosong') {
                    try {
                        $nilaiBaru = Carbon::parse($nilaiBaru)->format('d-m-Y');
                    } catch (\Exception $e) {
                        // Keep original value if parsing fails
                    }
                }
                
                $namaField = ucwords(str_replace('_', ' ', $field));
                
                if ($nilaiLama != $nilaiBaru) {
                   $deskripsiLog[] = "{$namaField} diubah dari '{$nilaiLama}' menjadi '{$nilaiBaru}'";
                }
            }

            if(!empty($deskripsiLog)) {
                LogPermohonan::create([
                    'permohonan_id' => $permohonan->id,
                    'user_id' => Auth::id(),
                    'status_sebelum' => $dataSebelum['status'],
                    'status_sesudah' => $permohonan->status,
                    'keterangan' => implode("\n• ", $deskripsiLog),
                ]);
            }
        }

        return redirect()->route('permohonan.show', $permohonan)
            ->with('success', 'Data permohonan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permohonan $permohonan)
    {
        // Simpan data sebelum dihapus
        $permohonanId = $permohonan->id;
        $statusSebelum = $permohonan->status;
        
        // Buat log sebelum menghapus
        LogPermohonan::create([
            'permohonan_id' => $permohonanId,
            'user_id' => Auth::id(),
            'status_sebelum' => $statusSebelum,
            'status_sesudah' => 'Dihapus',
            'keterangan' => 'Permohonan dihapus',
        ]);

        // Hapus permohonan setelah log dibuat
        $permohonan->delete();

        return redirect()->route('dashboard')->with('success', 'Permohonan berhasil dihapus!');
    }

    /**
     * Export data permohonan to Excel
     */
    public function exportExcel()
    {
        return Excel::download(new PermohonanExport, 'data_permohonan_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    /**
     * Export data permohonan to PDF
     */
    public function exportPdf()
    {
        $permohonans = Permohonan::with('user')->orderBy('created_at', 'desc')->get();
        
        $pdf = Pdf::loadView('permohonan.export-pdf', compact('permohonans'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('data_permohonan_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Export data permohonan to PDF (Compact version)
     */
    public function exportPdfCompact()
    {
        $permohonans = Permohonan::with('user')->orderBy('created_at', 'desc')->get();
        
        $pdf = Pdf::loadView('permohonan.export-pdf-compact', compact('permohonans'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('data_permohonan_ringkasan_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}