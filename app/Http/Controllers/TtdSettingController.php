<?php

namespace App\Http\Controllers;

use App\Models\TtdSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TtdSettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Cek authorization - hanya admin dan penerbitan_berkas yang bisa akses
        if (!in_array($user->role, ['admin', 'penerbitan_berkas'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        
        $ttdSettings = TtdSetting::getSettings();
        
        return view('ttd-settings.index', compact('ttdSettings'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Cek authorization - hanya admin dan penerbitan_berkas yang bisa update
        if (!in_array($user->role, ['admin', 'penerbitan_berkas'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
        
        $request->validate([
            'mengetahui_title' => 'required|string|max:255',
            'mengetahui_jabatan' => 'required|string|max:255',
            'mengetahui_unit' => 'required|string|max:255',
            'mengetahui_nama' => 'required|string|max:255',
            'mengetahui_pangkat' => 'required|string|max:255',
            'mengetahui_nip' => 'required|string|max:255',
            'mengetahui_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'menyetujui_lokasi' => 'required|string|max:255',
            'menyetujui_tanggal' => 'required|date',
            'menyetujui_jabatan' => 'required|string|max:255',
            'menyetujui_nama' => 'required|string|max:255',
            'menyetujui_pangkat' => 'required|string|max:255',
            'menyetujui_nip' => 'required|string|max:255',
            'menyetujui_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $ttdSettings = TtdSetting::getSettings();
        
        $data = $request->except(['mengetahui_photo', 'menyetujui_photo']);
        
        // Handle upload foto mengetahui
        if ($request->hasFile('mengetahui_photo')) {
            // Hapus foto lama jika ada
            if ($ttdSettings->mengetahui_photo && Storage::disk('public')->exists('ttd_photos/' . $ttdSettings->mengetahui_photo)) {
                Storage::disk('public')->delete('ttd_photos/' . $ttdSettings->mengetahui_photo);
            }
            
            $file = $request->file('mengetahui_photo');
            $filename = 'mengetahui_ttd_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Debug: cek apakah file berhasil disimpan
            $path = $file->storeAs('public/ttd_photos', $filename);
            if ($path) {
                $data['mengetahui_photo'] = $filename;
                Log::info('TTD Mengetahui uploaded successfully: ' . $filename);
            } else {
                Log::error('TTD Mengetahui upload failed');
            }
        }
        
        // Handle upload foto menyetujui
        if ($request->hasFile('menyetujui_photo')) {
            // Hapus foto lama jika ada
            if ($ttdSettings->menyetujui_photo && Storage::disk('public')->exists('ttd_photos/' . $ttdSettings->menyetujui_photo)) {
                Storage::disk('public')->delete('ttd_photos/' . $ttdSettings->menyetujui_photo);
            }
            
            $file = $request->file('menyetujui_photo');
            $filename = 'menyetujui_ttd_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Debug: cek apakah file berhasil disimpan
            $path = $file->storeAs('public/ttd_photos', $filename);
            if ($path) {
                $data['menyetujui_photo'] = $filename;
                Log::info('TTD Menyetujui uploaded successfully: ' . $filename);
            } else {
                Log::error('TTD Menyetujui upload failed');
            }
        }
        
        // Handle hapus foto mengetahui
        if ($request->has('delete_mengetahui_photo') && $request->delete_mengetahui_photo == '1') {
            if ($ttdSettings->mengetahui_photo && Storage::disk('public')->exists('ttd_photos/' . $ttdSettings->mengetahui_photo)) {
                Storage::disk('public')->delete('ttd_photos/' . $ttdSettings->mengetahui_photo);
            }
            $data['mengetahui_photo'] = null;
        }
        
        // Handle hapus foto menyetujui
        if ($request->has('delete_menyetujui_photo') && $request->delete_menyetujui_photo == '1') {
            if ($ttdSettings->menyetujui_photo && Storage::disk('public')->exists('ttd_photos/' . $ttdSettings->menyetujui_photo)) {
                Storage::disk('public')->delete('ttd_photos/' . $ttdSettings->menyetujui_photo);
            }
            $data['menyetujui_photo'] = null;
        }
        
        $ttdSettings->update($data);

        return redirect()->back()->with('success', 'Pengaturan TTD berhasil diperbarui.');
    }
}