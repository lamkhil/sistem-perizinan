<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:dpmptsp,pd_teknis,penerbitan_berkas'],
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

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ];

        // Tambahkan sektor jika role adalah pd_teknis
        if ($request->role === 'pd_teknis' && $request->sektor) {
            $userData['sektor'] = $request->sektor;
        }

        $user = User::create($userData);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
