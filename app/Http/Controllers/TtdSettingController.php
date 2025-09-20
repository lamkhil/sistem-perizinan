<?php

namespace App\Http\Controllers;

use App\Models\TtdSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TtdSettingController extends Controller
{
    public function index()
    {
        $ttdSettings = TtdSetting::getSettings();
        
        // Proses title menyetujui untuk mengganti placeholder tanggal
        $menyetujuiTitle = str_replace('{{ date("d F Y") }}', date('d F Y'), $ttdSettings->menyetujui_title);
        
        return view('ttd-settings.index', compact('ttdSettings', 'menyetujuiTitle'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'mengetahui_title' => 'required|string|max:255',
            'mengetahui_jabatan' => 'required|string|max:255',
            'mengetahui_unit' => 'required|string|max:255',
            'mengetahui_nama' => 'required|string|max:255',
            'mengetahui_pangkat' => 'required|string|max:255',
            'mengetahui_nip' => 'required|string|max:255',
            'mengetahui_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'menyetujui_title' => 'required|string|max:255',
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
            $file = $request->file('mengetahui_photo');
            $filename = 'mengetahui_ttd_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/ttd_photos', $filename);
            $data['mengetahui_photo'] = $filename;
        }
        
        // Handle upload foto menyetujui
        if ($request->hasFile('menyetujui_photo')) {
            $file = $request->file('menyetujui_photo');
            $filename = 'menyetujui_ttd_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/ttd_photos', $filename);
            $data['menyetujui_photo'] = $filename;
        }
        
        $ttdSettings->update($data);

        return redirect()->back()->with('success', 'Pengaturan TTD berhasil diperbarui.');
    }
}