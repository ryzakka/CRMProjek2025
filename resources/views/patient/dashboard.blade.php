<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8"> {{-- Tambahkan space-y-8 untuk jarak antar elemen --}}

            {{-- Pesan Sukses/Error --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-md" role="alert">
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-md" role="alert">
                    <p class="font-bold">Gagal!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            {{-- Kartu Selamat Datang dan Poin Loyalitas --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900">
                    <h3 class="text-2xl font-semibold text-emerald-700">Selamat datang kembali, {{ $user->name }}!</h3>
                    <p class="mt-1 text-gray-600">Kami senang melihat Anda lagi di Klinik Sehat Bersama.</p>
                    
                    @if ($user->patientProfile)
                        <div class="mt-6 p-6 bg-emerald-500 text-white rounded-lg shadow-lg text-center">
                            <p class="text-sm uppercase tracking-wider">Total Poin Loyalitas Anda</p>
                            <p class="text-5xl font-bold mt-2">
                                {{ number_format($user->patientProfile->total_loyalty_points, 0, ',', '.') }}
                            </p>
                            <p class="text-sm mt-1">Poin</p>
                        </div>
                    @else
                        <p class="mt-4 text-sm text-yellow-600 bg-yellow-50 p-3 rounded-md">Profil pasien Anda belum sepenuhnya terkonfigurasi untuk menampilkan poin.</p>
                    @endif
                </div>
            </div>

            {{-- Kartu Aksi Utama --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    <h4 class="text-xl font-semibold text-gray-800 mb-6">Apa yang ingin Anda lakukan hari ini?</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        
                        {{-- Kartu Booking Janji Temu Baru --}}
                        <a href="{{ route('patient.appointments.create') }}" class="block p-6 bg-emerald-50 hover:bg-emerald-100 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105">
                            <div class="flex items-center justify-center h-12 w-12 rounded-full bg-emerald-500 text-white mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5M12 15L12 18h.008v.008H12v-.008zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                </svg>
                            </div>
                            <h5 class="text-lg font-semibold text-emerald-700">Booking Janji Temu</h5>
                            <p class="mt-2 text-sm text-gray-600">Atur jadwal konsultasi atau pemeriksaan Anda.</p>
                        </a>

                        {{-- Kartu Lihat Janji Temu Saya --}}
                        <a href="{{ route('patient.appointments.index') }}" class="block p-6 bg-emerald-50 hover:bg-emerald-100 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105">
                            <div class="flex items-center justify-center h-12 w-12 rounded-full bg-emerald-500 text-white mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                                </svg>
                            </div>
                            <h5 class="text-lg font-semibold text-emerald-700">Janji Temu Saya</h5>
                            <p class="mt-2 text-sm text-gray-600">Lihat riwayat dan jadwal janji temu Anda.</p>
                        </a>

                        {{-- Kartu Riwayat Poin Saya --}}
                        <a href="{{ route('patient.loyalty.history') }}" class="block p-6 bg-emerald-50 hover:bg-emerald-100 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105">
                            <div class="flex items-center justify-center h-12 w-12 rounded-full bg-emerald-500 text-white mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /> {{-- Ikon jam bisa diganti ikon poin --}}
                                </svg>
                            </div>
                            <h5 class="text-lg font-semibold text-emerald-700">Riwayat Poin Saya</h5>
                            <p class="mt-2 text-sm text-gray-600">Lacak semua perolehan dan penggunaan poin loyalitas Anda.</p>
                        </a>

                        {{-- Kartu Katalog Reward --}}
                        <a href="{{ route('patient.rewards.index') }}" class="block p-6 bg-emerald-50 hover:bg-emerald-100 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105">
                            <div class="flex items-center justify-center h-12 w-12 rounded-full bg-emerald-500 text-white mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1012 10.125A2.625 2.625 0 0012 4.875zM12 15v.008" />
                                </svg>
                            </div>
                            <h5 class="text-lg font-semibold text-emerald-700">Katalog Reward</h5>
                            <p class="mt-2 text-sm text-gray-600">Lihat hadiah menarik yang bisa Anda tukarkan dengan poin.</p>
                        </a>

                        {{-- Kartu Daftar Dokter --}}
                        <a href="{{ route('patient.doctors.index') }}" class="block p-6 bg-emerald-50 hover:bg-emerald-100 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105">
                            <div class="flex items-center justify-center h-12 w-12 rounded-full bg-emerald-500 text-white mb-4">
                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </div>
                            <h5 class="text-lg font-semibold text-emerald-700">Daftar Dokter</h5>
                            <p class="mt-2 text-sm text-gray-600">Temukan dokter spesialis dan umum kami.</p>
                        </a>

                        {{-- Kartu Edit Profil --}}
                        <a href="{{ route('profile.edit') }}" class="block p-6 bg-emerald-50 hover:bg-emerald-100 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105">
                            <div class="flex items-center justify-center h-12 w-12 rounded-full bg-emerald-500 text-white mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /> {{-- Ikon profile bisa disesuaikan --}}
                                </svg>
                            </div>
                            <h5 class="text-lg font-semibold text-emerald-700">Edit Profil Saya</h5>
                            <p class="mt-2 text-sm text-gray-600">Perbarui informasi pribadi dan kontak Anda.</p>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>