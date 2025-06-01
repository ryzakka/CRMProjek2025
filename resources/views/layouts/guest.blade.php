<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Klinik Sehat Bersama') }}</title> <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-emerald-50"> {{-- Background hijau sangat muda --}}
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="/">
                    {{-- GANTI DENGAN LOGO KLINIK ANDA JIKA ADA --}}
                    {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
                    <div class="flex flex-col items-center">
                        <svg class="h-16 w-16 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                        </svg>
                        <span class="mt-2 text-2xl font-semibold text-emerald-700">Klinik Sehat Bersama</span>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-xl"> 
                {{-- Shadow lebih tebal, rounded lebih besar --}}
                {{ $slot }}
            </div>

            <footer class="mt-8 mb-4 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Klinik Sehat Bersama. All rights reserved.
            </footer>
        </div>
    </body>
</html>