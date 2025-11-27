<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <x-sidebar>
        <x-slot name="header">{{ $header ?? 'Dashboard' }}</x-slot>
        {{ $slot }}
    </x-sidebar>

    {{-- Script untuk Notifikasi & Timeout --}}
    <x-notification-popup />
    <script>
        let inactivityTimer;
        let timeout = 300000;
        let debounceTimer;
        const DEBOUNCE_DELAY = 1000;

        function resetTimer() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                clearTimeout(inactivityTimer);
                inactivityTimer = setTimeout(logoutUser, timeout);
            }, DEBOUNCE_DELAY);
        }

        function logoutUser() {
            Swal.fire({
                title: 'Sesi Berakhir',
                text: 'Anda tidak aktif selama 5 menit dan akan dikeluarkan dari sistem demi keamanan.',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    const logoutForm = document.getElementById('logout-form');
                    if (logoutForm) {
                        logoutForm.submit();
                    }
                }
            });
        }

        function setupInactivityTimer() {
            resetTimer();
            
            const options = { passive: true, capture: false };
            
            let mousemoveThrottle;
            document.addEventListener('mousemove', () => {
                if (!mousemoveThrottle) {
                    mousemoveThrottle = setTimeout(() => {
                        resetTimer();
                        mousemoveThrottle = null;
                    }, 2000);
                }
            }, options);
            
            document.addEventListener('keypress', resetTimer, options);
            document.addEventListener('click', resetTimer, options);
            document.addEventListener('scroll', resetTimer, options);
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setupInactivityTimer);
        } else {
            setupInactivityTimer();
        }
    </script>
</body>
</html>
