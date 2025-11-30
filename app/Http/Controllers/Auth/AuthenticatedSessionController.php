<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // Ensure session is started and CSRF token is generated
        request()->session()->regenerateToken();
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect berdasarkan role
        $user = Auth::user();
        switch ($user->role) {
            case 'penerbitan_berkas':
                return redirect()->intended(route('penerbitan-berkas', absolute: false));
            default:
                return redirect()->intended(route('dashboard', absolute: false));
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            // Logout user
        Auth::guard('web')->logout();

            // Invalidate session
        $request->session()->invalidate();

            // Regenerate CSRF token
        $request->session()->regenerateToken();

            // Redirect to login page with success message
            return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
            
        } catch (\Exception $e) {
            // Log error if needed
            \Log::error('Logout error: ' . $e->getMessage());
            
            // Force logout and redirect even if there's an error
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat logout, silakan login kembali.');
        }
    }
}
