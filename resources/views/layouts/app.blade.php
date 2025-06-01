<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Klinik Sehat Bersama - CRM') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-emerald-50">
        <div class="min-h-screen">
            @include('layouts.navigation')

            @if (isset($header))
                <header class="bg-white shadow"> {{-- Background putih dengan shadow standar sudah cukup baik --}}
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{-- $header biasanya berisi <h2 class="font-semibold text-xl text-gray-800 leading-tight"> --}}
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>
        {{-- Footer bisa ditambahkan di sini jika diinginkan untuk semua halaman terautentikasi --}}
        {{-- <footer class="py-4 text-center text-sm text-gray-500">
            Klinik Sehat Bersama &copy; {{ date('Y') }}
        </footer> --}}
    </body>
</html>