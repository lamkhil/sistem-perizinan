<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permohonan; // ✅ Tambahkan ini
use App\Models\JenisUsaha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Admin bisa melihat semua user, role lain hanya melihat user non-admin
        if ($user->role === 'admin') {
            $users = User::latest()->get();
        } else {
            $users = User::where('role', '!=', 'admin')->latest()->get();
        }
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:pd_teknis,dpmptsp,penerbitan_berkas'],
        ];

        // Jika role adalah pd_teknis, sektor wajib diisi
        if ($request->role === 'pd_teknis') {
            $rules['sektor'] = ['required', 'in:Dinkopdag,Disbudpar,Dinkes,Dishub,Dprkpp,Dkpp,Dlh,Disperinaker'];
        }

        $request->validate($rules);

        // Cek apakah sudah ada admin
        $adminExists = User::where('role', 'admin')->exists();
        
        // Jika role yang dipilih adalah admin dan sudah ada admin, tolak
        if ($request->role === 'admin' && $adminExists) {
            return back()->withErrors(['role' => 'Role admin sudah ada dan tidak dapat dibuat lagi.']);
        }

        // Sanitize input untuk mencegah XSS
        $userData = [
            'name' => strip_tags($request->name),
            'email' => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ];

        // Tambahkan sektor jika role adalah pd_teknis
        if ($request->role === 'pd_teknis' && $request->sektor) {
            $userData['sektor'] = $request->sektor;
        }

        User::create($userData);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        // Authorization check - hanya admin yang bisa edit user
        $currentUser = Auth::user();
        if (!$currentUser || $currentUser->role !== 'admin') {
            abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Authorization check - hanya admin yang bisa update user
        $currentUser = Auth::user();
        if (!$currentUser || $currentUser->role !== 'admin') {
            abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:admin,pd_teknis,dpmptsp,penerbitan_berkas'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ];

        // Jika role adalah pd_teknis, sektor wajib diisi
        if ($request->role === 'pd_teknis') {
            $rules['sektor'] = ['required', 'in:Dinkopdag,Disbudpar,Dinkes,Dishub,Dprkpp,Dkpp,Dlh,Disperinaker'];
        }

        $request->validate($rules);

        // Cek apakah sudah ada admin dan user yang diupdate bukan admin yang sudah ada
        $adminExists = User::where('role', 'admin')->where('id', '!=', $user->id)->exists();
        
        // Jika role yang dipilih adalah admin dan sudah ada admin lain, tolak
        if ($request->role === 'admin' && $adminExists) {
            return back()->withErrors(['role' => 'Role admin sudah ada dan tidak dapat dibuat lagi.']);
        }

        // Sanitize input untuk mencegah XSS
        $user->name = strip_tags($request->name);
        $user->email = strtolower(trim($request->email));
        $user->role = $request->role;
        
        // Update sektor jika role adalah pd_teknis
        if ($request->role === 'pd_teknis' && $request->sektor) {
            $user->sektor = $request->sektor;
        } elseif ($request->role !== 'pd_teknis') {
            // Hapus sektor jika role bukan pd_teknis
            $user->sektor = null;
        }
        
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    /**
     * ✅ Menampilkan halaman yang berisi semua tabel permohonan
     */
    public function semuaTabel()
    {
        $permohonans = Permohonan::latest()->get();
        return view('users.semua-tabel', compact('permohonans'));
    }
}
