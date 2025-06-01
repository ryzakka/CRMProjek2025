<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Statistik Klinik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Judul Utama Laman --}}
            <div class="mb-8">
                <h3 class="text-3xl font-semibold text-emerald-700">Ringkasan Aktivitas Klinik</h3>
                <p class="mt-1 text-gray-600">Pantau perkembangan dan metrik penting klinik Anda di sini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl hover:shadow-2xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-emerald-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-9-5.192A5.971 5.971 0 003 18.72M6.75 7.5A3.375 3.375 0 003 10.875c0 1.551.823 2.897 2.006 3.631a5.25 5.25 0 005.488 0c1.183-.734 2.006-2.08 2.006-3.631A3.375 3.375 0 009.375 7.5H12m0S12 7.5 12 7.5m0 0A3.375 3.375 0 0014.625 4.125c0-1.551-.823-2.897-2.006-3.631S9.375 0 9.375 0s-2.17.576-3.963 1.584A6.062 6.062 0 003 4.125v1.5C3 7.22 4.22 8.719 6 9.375m3.375-1.875A3.375 3.375 0 009.375 7.5m0-3.375S9.375 0 12 0s2.625 4.125 2.625 4.125m0 0A3.375 3.375 0 0012 7.5M12 0v4.125m0 0c0 .901.142 1.763.404 2.577M12 0c-.807.087-1.576.281-2.296.577m4.592 1.07A8.952 8.952 0 0112 4.875c0 .901-.142 1.763-.404 2.577M12 4.875c.807.087 1.576.281 2.296.577M9.704 1.577A8.952 8.952 0 0012 4.875c0 .901.142 1.763.404 2.577M12 4.875c-.807.087-1.576.281-2.296.577" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-700">Total Pasien Terdaftar</h3>
                                <p class="mt-1 text-3xl font-semibold text-emerald-600">{{ $totalPatients }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl hover:shadow-2xl transition-shadow duration-300">
                    <div class="p-6">
                         <div class="flex items-center">
                            <div class="flex-shrink-0 bg-emerald-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-700">Total Janji Temu</h3>
                                <p class="mt-1 text-3xl font-semibold text-emerald-600">{{ $totalAppointments }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl hover:shadow-2xl transition-shadow duration-300">
                    <div class="p-6">
                         <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3"> {{-- Warna hijau berbeda untuk variasi --}}
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-700">Janji Temu Selesai</h3>
                                <p class="mt-1 text-3xl font-semibold text-green-600">{{ $completedAppointments }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl hover:shadow-2xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3"> {{-- Warna biru untuk variasi --}}
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5A2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-700">Janji Temu Dijadwalkan</h3>
                                <p class="mt-1 text-3xl font-semibold text-blue-600">{{ $scheduledAppointments }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl hover:shadow-2xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3"> {{-- Warna kuning untuk variasi --}}
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-700">Total Poin Pasien</h3>
                                <p class="mt-1 text-3xl font-semibold text-yellow-600">{{ number_format($totalLoyaltyPointsInCirculation, 0, ',', '.') }} Poin</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KARTU BARU: TOP DOKTER --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl hover:shadow-2xl transition-shadow duration-300 md:col-span-1">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-emerald-700 mb-4">Top 5 Dokter Aktif</h3>
                        @if($topDoctors->count() > 0)
                            <ul class="space-y-3">
                                @foreach($topDoctors as $index => $doctor)
                                    <li class="flex items-center justify-between">
                                        <span class="text-gray-700">
                                            <span class="font-medium">{{ $index + 1 }}.</span> {{ $doctor->doctor_name }}
                                        </span>
                                        <span class="px-2 py-1 text-xs font-semibold text-emerald-700 bg-emerald-100 rounded-full">{{ $doctor->appointment_count }} janji temu</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500">Belum ada data janji temu dengan dokter.</p>
                        @endif
                    </div>
                </div>

                {{-- KARTU BARU: TOP LAYANAN --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl hover:shadow-2xl transition-shadow duration-300 md:col-span-1">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-emerald-700 mb-4">Top 5 Layanan Digunakan</h3>
                        @if($topServices->count() > 0)
                            <ul class="space-y-3">
                                @foreach($topServices as $index => $service)
                                    <li class="flex items-center justify-between">
                                        <span class="text-gray-700 truncate" title="{{ $service->service_description }}">
                                           <span class="font-medium">{{ $index + 1 }}.</span> {{ Str::limit($service->service_description, 30) }}
                                        </span>
                                        <span class="px-2 py-1 text-xs font-semibold text-emerald-700 bg-emerald-100 rounded-full">{{ $service->service_count }} kali</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500">Belum ada data layanan pada janji temu.</p>
                        @endif
                    </div>
                </div>

                {{-- KARTU BARU: DISTRIBUSI TIPE PASIEN --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl hover:shadow-2xl transition-shadow duration-300 md:col-span-1">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-emerald-700 mb-4">Distribusi Tipe Pasien</h3>
                        @if($patientTypeDistribution->count() > 0)
                            <ul class="space-y-3">
                                @foreach($patientTypeDistribution as $type)
                                    <li class="flex items-center justify-between">
                                        <span class="text-gray-700">{{ $type->patient_type ?: 'Tidak Diketahui' }}</span>
                                        <span class="px-2 py-1 text-xs font-semibold text-emerald-700 bg-emerald-100 rounded-full">{{ $type->patient_count }} pasien</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500">Belum ada data tipe pasien.</p>
                        @endif
                    </div>
                </div>
            </div>
            {{-- Anda bisa menambahkan filter periode tanggal di sini nanti --}}
        </div>
    </div>
</x-app-layout>