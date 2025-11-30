<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Security Headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Content Security Policy (menggantikan X-Frame-Options)
        $isDevelopment = config('app.env') === 'local' || config('app.debug');
        
        // Di development, nonaktifkan CSP karena Vite menggunakan IPv6 [::1] yang tidak didukung CSP
        // CSP hanya aktif di production untuk keamanan
        if (!$isDevelopment) {
            // CSP untuk production - lebih ketat
            $csp = "default-src 'self'; " .
                   "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://fonts.bunny.net; " .
                   "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net; " .
                   "font-src 'self' https://fonts.gstatic.com https://fonts.bunny.net data:; " .
                   "img-src 'self' data: https:; " .
                   "frame-ancestors 'self';";
            $response->headers->set('Content-Security-Policy', $csp);
        }
        // Di development, CSP dinonaktifkan untuk memungkinkan Vite dev server bekerja dengan IPv6

        // Cache-Control headers untuk static assets
        if ($request->is('*.css') || $request->is('*.js') || $request->is('*.jpg') || 
            $request->is('*.png') || $request->is('*.gif') || $request->is('*.svg') ||
            $request->is('*.woff') || $request->is('*.woff2') || $request->is('*.ttf')) {
            $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
        } else {
            // Cache-Control untuk HTML pages
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, private');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
        }

        return $response;
    }
}

