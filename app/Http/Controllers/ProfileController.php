<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Authorization check - user hanya bisa update profile sendiri
        $user = $request->user();
        if (!$user) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }

        // Sanitize input untuk mencegah XSS
        $validated = $request->validated();
        $validated['name'] = strip_tags($validated['name']);
        $validated['email'] = strtolower(trim($validated['email']));

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     * 
     * Data yang sudah di-entry oleh user akan tetap aman di database
     * Foreign key constraints menggunakan SET NULL, jadi user_id akan menjadi null
     * tapi data permohonan, log, dan penerbitan_berkas tetap ada
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Cek apakah user memiliki data terkait (opsional, untuk informasi)
        $hasPermohonan = $user->permohonans()->exists();
        $permohonanCount = $user->permohonans()->count();

        // Logout user terlebih dahulu
        Auth::logout();

        // Hapus user (dengan SET NULL, data terkait akan tetap aman)
        // user_id di tabel permohonans, log_permohonans, dan penerbitan_berkas akan menjadi NULL
        $user->delete();

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect dengan pesan informasi
        return Redirect::to('/')->with('status', 'Akun Anda telah dihapus. Data yang sudah di-entry tetap aman di database.');
    }
}
