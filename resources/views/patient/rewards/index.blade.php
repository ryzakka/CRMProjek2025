<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog Reward Loyalitas Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Kartu Info Poin Pasien (Ini sudah menggunakan gradient hijau dan seharusnya sudah terang) --}}
            <div class="mb-8 bg-gradient-to-r from-emerald-500 to-green-500 text-white p-6 sm:p-8 rounded-xl shadow-xl">
                <p class="text-xl font-medium">Halo, {{ Auth::user()->name }}!</p>
                <p class="text-4xl sm:text-5xl font-bold mt-2">
                    {{ number_format($patientPoints, 0, ',', '.') }}
                    <span class="text-2xl font-medium">Poin</span>
                </p>
                <p class="mt-1 text-emerald-100">Total poin loyalitas Anda saat ini.</p>
            </div>

            {{-- Kartu Utama untuk Daftar Reward --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg"> {{-- Hapus dark:bg-gray-800 --}}
                <div class="p-6 sm:p-8 text-gray-900"> {{-- Hapus dark:text-gray-100 --}}
                    <h3 class="text-2xl font-semibold text-emerald-700 mb-6">Reward yang Tersedia untuk Anda:</h3>

                    @if($rewards->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($rewards as $reward)
                                {{-- Kartu Individual Reward --}}
                                <div class="border border-gray-200 rounded-lg p-6 flex flex-col justify-between shadow-lg hover:shadow-2xl transition-shadow duration-300 
                                            {{ ($patientPoints >= $reward->points_required && (is_null($reward->quantity_available) || $reward->quantity_available > 0)) ? 'bg-emerald-50 border-emerald-300' : 'bg-gray-100 opacity-75' }}">
                                    {{-- Hapus dark:border-gray-700, dark:bg-emerald-900/50, dark:bg-gray-700/50 --}}
                                    <div>
                                        <div class="flex items-center mb-3">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-emerald-500 text-white flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1012 10.125A2.625 2.625 0 0012 4.875zM12 15v.008" />
                                                </svg>
                                            </div>
                                            <h4 class="ml-4 text-lg font-semibold text-gray-800">{{ $reward->name }}</h4> {{-- Hapus dark:text-white --}}
                                        </div>
                                        
                                        <p class="text-sm text-gray-600 mt-1 min-h-[40px]"> {{-- Hapus dark:text-gray-400 --}}
                                            {{ $reward->description ?? 'Tukarkan poin Anda dengan reward menarik ini.' }}
                                        </p>
                                        <p class="mt-3 text-sm text-gray-700"> {{-- Hapus dark:text-gray-300 --}}
                                            <strong>Tipe:</strong> {{ $reward->type }} <br>
                                            @if($reward->type == 'DISCOUNT_PERCENTAGE')
                                                <strong>Nilai:</strong> Diskon {{ (float)$reward->value }}%
                                            @elseif($reward->type == 'DISCOUNT_FIXED_AMOUNT')
                                                <strong>Nilai:</strong> Diskon Rp {{ number_format($reward->value, 0, ',', '.') }}
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-700"> {{-- Hapus dark:text-gray-300 --}}
                                            <strong>Stok:</strong> {{ is_null($reward->quantity_available) ? 'Tidak Terbatas' : $reward->quantity_available }}
                                        </p>
                                        <p class="text-sm text-gray-700"> {{-- Hapus dark:text-gray-300 --}}
                                            <strong>Berlaku hingga:</strong> {{ $reward->valid_until ? $reward->valid_until->isoFormat('D MMMM YYYY') : 'Selamanya' }}
                                        </p>
                                    </div>
                                    <div class="mt-5 pt-4 border-t border-gray-200"> {{-- Hapus dark:border-gray-600 --}}
                                        <p class="text-xl font-bold 
                                            {{ ($patientPoints >= $reward->points_required && (is_null($reward->quantity_available) || $reward->quantity_available > 0)) ? 'text-emerald-600' : 'text-red-500' }}">
                                            {{-- Hapus dark:text-emerald-400 dan dark:text-red-400 --}}
                                            {{ number_format($reward->points_required, 0, ',', '.') }} Poin
                                        </p>
                                        @if ($patientPoints >= $reward->points_required && (is_null($reward->quantity_available) || $reward->quantity_available > 0) )
                                            <p class="text-xs text-green-600 mt-1">Anda dapat menukarkan reward ini!</p> {{-- Hapus dark:text-green-400 --}}
                                            <p class="text-xs text-gray-500 mt-1">Hubungi staf klinik untuk proses penukaran.</p> {{-- Hapus dark:text-gray-400 --}}
                                        @elseif (!is_null($reward->quantity_available) && $reward->quantity_available <= 0)
                                             <p class="text-xs text-red-500 mt-1">Stok reward ini habis.</p> {{-- Hapus dark:text-red-400 --}}
                                        @else
                                            <p class="text-xs text-red-500 mt-1">Poin Anda belum cukup.</p> {{-- Hapus dark:text-red-400 --}}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{-- Jika menggunakan pagination di controller, $rewards->links() bisa ditambahkan di sini --}}
                        </div>
                    @else
                        <p class="text-center text-gray-600 py-8">Saat ini belum ada reward yang tersedia untuk dilihat.</p>
                    @endif
                    
                    <div class="mt-8 text-center">
                        <a href="{{ route('dashboard') }}" class="text-emerald-600 hover:text-emerald-800 underline font-medium">
                            &larr; {{ __('Kembali ke Dashboard Pasien') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>