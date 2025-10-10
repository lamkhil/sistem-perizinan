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
use Illuminate\Validation\Rule;

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
        $selectedStatus = $request->query('status');

        // Query dasar
        $permohonans = Permohonan::query();

        // Filter berdasarkan peran
        if ($user->role === 'dpmptsp') {
            // DPMPTSP melihat semua permohonan kecuali yang dibuat oleh penerbitan_berkas
            $permohonans->whereHas('user', function($query) {
                $query->where('role', '!=', 'penerbitan_berkas');
            });
        } elseif ($user->role === 'pd_teknis') {
            // PD Teknis melihat permohonan sesuai sektornya saja
            if ($user->sektor) {
                $permohonans->where('sektor', $user->sektor)
                    ->whereHas('user', function($query) {
                        $query->where('role', '!=', 'penerbitan_berkas');
                    });
            } else {
                // Jika PD Teknis belum ada sektor, tampilkan semua (fallback)
                $permohonans->whereHas('user', function($query) {
                    $query->where('role', '!=', 'penerbitan_berkas');
                });
            }
        } elseif ($user->role === 'penerbitan_berkas') {
            // Penerbitan Berkas hanya melihat data yang dibuat oleh role penerbitan_berkas
            $permohonans->whereHas('user', function($query) {
                $query->where('role', 'penerbitan_berkas');
            });
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

        // Terapkan filter status
        if ($selectedStatus) {
            if ($selectedStatus === 'Terlambat') {
                // Terlambat = semua status yang melewati deadline (bandingkan berdasarkan tanggal lokal)
                $today = now()->toDateString();
                $permohonans->whereNotNull('deadline')
                           ->whereDate('deadline', '<', $today);
            } else {
                $permohonans->where('status', $selectedStatus);
            }
        }

        // Terapkan logika pencarian
        if ($searchQuery) {
            $permohonans->where(function ($query) use ($searchQuery) {
                $query->where('no_permohonan', 'like', '%' . $searchQuery . '%')
                      ->orWhere('nama_usaha', 'like', '%' . $searchQuery . '%');
            });
        }

        $permohonans = $permohonans->orderBy('created_at', 'asc')->get();
        
        // Ambil daftar sektor unik dari database dan gabungkan dengan sektor yang tersedia
        $sektorsFromDb = Permohonan::select('sektor')->whereNotNull('sektor')->distinct()->pluck('sektor');
        $availableSektors = ['Dinkopdag', 'Disbudpar', 'Dinkes', 'Dishub', 'Dprkpp', 'Dkpp', 'Dlh', 'Disperinaker'];
        $sektors = $availableSektors;

        return view('permohonan.index', compact('permohonans', 'sektors', 'selectedSektor', 'searchQuery', 'selectedDateFilter', 'customDate', 'selectedStatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $verifikators = ['RAMLAN', 'SURYA', 'ALI', 'WILDAN A', 'TYO', 'WILDAN M', 'YOLA', 'NAURA'];
        $sektors = ['Dinkopdag', 'Disbudpar', 'Dinkes', 'Dishub', 'Dprkpp', 'Dkpp', 'Dlh', 'Disperinaker'];
        $jenisPelakuUsahas = ['Orang Perseorangan', 'Badan Usaha'];
        
        // CSS classes untuk hide field berdasarkan role
        $cssClasses = $this->getRoleBasedCssClasses($user);
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

        return view('permohonan.create', compact('verifikators', 'sektors', 'jenisPelakuUsahas', 'jenisUsahas', 'jenisProyeks', 'verificationStatusOptions', 'cssClasses'));
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
            'nama_perusahaan' => 'nullable|string',
            'jenis_badan_usaha' => 'nullable|string', // Tambahkan ini untuk dropdown Jenis Badan Usaha
            'nib' => 'nullable|string|max:20',
            'alamat_perusahaan' => 'nullable|string',
            'sektor' => 'nullable|string',
            'kbli' => 'nullable|string',
            'inputan_teks' => 'nullable|string',
            'modal_usaha' => 'nullable|numeric',
            'jenis_proyek' => 'nullable|string|in:Utama,Pendukung,Pendukung UMKU,Kantor Cabang',
            'no_proyek' => 'nullable|string',
            'pemilik' => 'nullable|string',
            'nama_perizinan' => 'nullable|string',
            'skala_usaha' => 'nullable|string',
            'risiko' => 'nullable|string',
            'jangka_waktu' => 'nullable|integer|min:1',
            'no_telephone' => 'nullable|string|max:100',
            'deadline' => 'nullable|date|after_or_equal:today', // CREATE: deadline harus >= hari ini
            'verifikator' => 'nullable|string',
            'status' => 'required|in:Menunggu,Dikembalikan,Diterima,Ditolak',
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
        ];

        // Validasi kondisional berdasarkan role
        if ($user->role === 'pd_teknis') {
            // PD Teknis wajib isi: no_permohonan, tanggal_permohonan, jenis_pelaku_usaha, nib, status
            $rules['no_permohonan'] = 'required|string|unique:permohonans,no_permohonan';
            $rules['tanggal_permohonan'] = 'required|date';
            $rules['jenis_pelaku_usaha'] = 'required|in:Orang Perseorangan,Badan Usaha';
            $rules['jenis_badan_usaha'] = 'nullable|string';
            $rules['nib'] = 'required|string|max:20';
            $rules['verifikator'] = 'nullable|string';
            $rules['status'] = 'required|in:Menunggu,Dikembalikan,Diterima,Ditolak,Terlambat';
        } elseif ($user->role === 'dpmptsp') {
            // DPMPTSP wajib isi: nama_usaha, alamat_perusahaan, modal_usaha, jenis_proyek, verifikator, status
            $rules['nama_usaha'] = 'required|string';
            $rules['alamat_perusahaan'] = 'required|string';
            $rules['modal_usaha'] = 'required|numeric';
            $rules['jenis_proyek'] = 'required|string';
            $rules['verifikator'] = 'required|string';
            $rules['status'] = 'required|in:Menunggu,Dikembalikan,Diterima,Ditolak,Terlambat';
        } else {
            // Admin wajib isi semua field utama
            $rules['no_permohonan'] = 'required|string|unique:permohonans,no_permohonan';
            $rules['tanggal_permohonan'] = 'required|date';
            $rules['jenis_pelaku_usaha'] = 'required|in:Orang Perseorangan,Badan Usaha';
            $rules['jenis_badan_usaha'] = 'nullable|string';
            $rules['verifikator'] = 'required|string';
            $rules['status'] = 'required|in:Menunggu,Dikembalikan,Diterima,Ditolak,Terlambat';
        }
        
        // Status perlu tetap tervalidasi; verifikator tidak wajib untuk PD Teknis
        $rules['status'] = 'required|in:Dikembalikan,Diterima,Ditolak,Terlambat';

        $validated = $request->validate(
            $rules,
            [
                'no_permohonan.required' => 'Nomor permohonan wajib diisi.',
                'no_permohonan.unique' => 'Nomor permohonan sudah digunakan. Silakan ganti dengan nomor lain.',
            ]
        );
        
        // Tambahkan user_id ke data yang akan disimpan
        $validated['user_id'] = $user->id;
        
        // Role-based field protection untuk CREATE
        if ($user->role === 'pd_teknis') {
            // PD Teknis tidak boleh mengisi nama_usaha
            $validated['nama_usaha'] = null;
            // PD Teknis tidak mengatur verifikator
            $validated['verifikator'] = null;
        } elseif ($user->role === 'dpmptsp') {
            // DPMPTSP tidak boleh mengisi nama_perusahaan
            $validated['nama_perusahaan'] = null;
        }
        
        // PENTING: Jika jenis_pelaku_usaha adalah 'Orang Perseorangan', pastikan jenis_badan_usaha di-null-kan
        if (isset($validated['jenis_pelaku_usaha']) && $validated['jenis_pelaku_usaha'] === 'Orang Perseorangan') {
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
        $tanggalBuat = now()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y');
        LogPermohonan::create([
            'permohonan_id' => $permohonan->id,
            'user_id' => Auth::id(),
            'status_sebelum' => 'Draft',
            'status_sesudah' => $permohonan->status,
            'keterangan' => 'Permohonan baru dibuat pada <strong>' . $tanggalBuat . '</strong>',
        ]);

        // Cek dan buat notifikasi deadline jika ada
        if ($permohonan->getAttribute('deadline')) {
            $permohonan->createDeadlineNotification();
        }

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
        $user = Auth::user();
        $verifikators = ['RAMLAN', 'SURYA', 'ALI', 'WILDAN A', 'TYO', 'WILDAN M', 'YOLA', 'NAURA'];
        $sektors = ['Dinkopdag', 'Disbudpar', 'Dinkes', 'Dishub', 'Dprkpp', 'Dkpp', 'Dlh', 'Disperinaker'];
        $jenisPelakuUsahas = ['Orang Perseorangan', 'Badan Usaha'];
        
        // CSS classes untuk hide field berdasarkan role
        $cssClasses = $this->getRoleBasedCssClasses($user);
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

        return view('permohonan.edit', compact('permohonan', 'jenisPelakuUsahas', 'jenisUsahas', 'sektors', 'verifikators', 'jenisProyeks', 'verificationStatusOptions', 'cssClasses'));
    }

    /**
     * Get role-based CSS class for body element
     */
    private function getRoleBasedCssClasses($user)
    {
        if ($user->role === 'pd_teknis') {
            return 'role-pd-teknis';
        } elseif ($user->role === 'dpmptsp') {
            return 'role-dpmptsp';
        } elseif ($user->role === 'admin') {
            return 'role-admin';
        } else {
            return 'role-non-admin';
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permohonan $permohonan)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'no_permohonan' => [
                'nullable',
                'string',
                Rule::unique('permohonans', 'no_permohonan')->ignore($permohonan->id),
            ],
            'tanggal_permohonan' => 'nullable|date',
            'jenis_pelaku_usaha' => 'nullable|string|in:Orang Perseorangan,Badan Usaha',
            'nik' => 'nullable|string|max:16',
            'nama_usaha' => 'nullable|string', // Pastikan ini ada untuk input teks
            'nama_perusahaan' => 'nullable|string',
            'jenis_badan_usaha' => 'nullable|string', // Tambahkan ini untuk dropdown Jenis Badan Usaha
            'nib' => 'nullable|string|max:20',
            'alamat_perusahaan' => 'nullable|string',
            'sektor' => 'nullable|string',
            'kbli' => 'nullable|string',
            'inputan_teks' => 'nullable|string',
            'modal_usaha' => 'nullable|numeric',
            'jenis_proyek' => 'nullable|string|in:Utama,Pendukung,Pendukung UMKU,Kantor Cabang',
            'no_proyek' => 'nullable|string',
            'pemilik' => 'nullable|string',
            'nama_perizinan' => 'nullable|string',
            'skala_usaha' => 'nullable|string',
            'risiko' => 'nullable|string',
            'jangka_waktu' => 'nullable|integer|min:1',
            'no_telephone' => 'nullable|string|max:100',
            'deadline' => 'nullable|date', // UPDATE: deadline boleh apa saja (termasuk yang sudah terlewat)
            // verifikator tidak wajib pada update (khususnya untuk PD Teknis)
            'verifikator' => 'sometimes|nullable|string',
            'status' => 'required|in:Diterima,Dikembalikan,Ditolak,Menunggu',
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
        ], [
            'no_permohonan.unique' => 'Nomor permohonan sudah digunakan. Silakan ganti dengan nomor lain.',
        ]);
        
        // Role-based validation untuk update
        $user = Auth::user();
        if ($user->role === 'pd_teknis') {
            // PD Teknis tidak boleh mengubah nama_usaha
            $validated['nama_usaha'] = $permohonan->nama_usaha; // Keep original value
        } elseif ($user->role === 'dpmptsp') {
            // DPMPTSP tidak boleh mengubah nama_perusahaan
            $validated['nama_perusahaan'] = $permohonan->nama_perusahaan; // Keep original value
        }
        
        // PENTING: Jika jenis_pelaku_usaha adalah 'Orang Perseorangan', pastikan jenis_badan_usaha di-null-kan
        if ($request->input('jenis_pelaku_usaha') === 'Orang Perseorangan') {
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
                        $nilaiLama = Carbon::parse($nilaiLama)->locale('id')->translatedFormat('d-m-Y');
                    } catch (\Exception $e) {
                        // Keep original value if parsing fails
                    }
                }
                
                if (in_array($field, ['tanggal_permohonan', 'pengembalian', 'menghubungi', 'perbaikan', 'terbit']) && $nilaiBaru && $nilaiBaru !== 'Kosong') {
                    try {
                        $nilaiBaru = Carbon::parse($nilaiBaru)->locale('id')->translatedFormat('d-m-Y');
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

        // Cek dan buat notifikasi deadline jika ada
        if ($permohonan->getAttribute('deadline')) {
            $permohonan->createDeadlineNotification();
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

    /**
     * Export data permohonan to PDF (Penerbitan Berkas version with TTD photos)
     */
    public function exportPdfPenerbitan()
    {
        $permohonans = Permohonan::with('user')->orderBy('created_at', 'desc')->get();
        $ttdSettings = \App\Models\TtdSetting::getSettings();
        
        $pdf = Pdf::loadView('pdf.penerbitan-berkas', compact('permohonans', 'ttdSettings'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('data_permohonan_penerbitan_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}