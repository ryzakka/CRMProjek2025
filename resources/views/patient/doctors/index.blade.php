<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Temukan Dokter Kami') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Menghapus dark:bg-gray-800 dan dark:text-gray-100 dari kartu filter --}}
            <div class="mb-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-emerald-700">Cari Dokter</h3>
                    <p class="mt-1 text-sm text-gray-600">Gunakan filter di bawah ini untuk menemukan dokter yang sesuai dengan kebutuhan Anda.</p>
                </div>
                <div class="p-6 sm:p-8 text-gray-900">
                    <form method="GET" action="{{ route('patient.doctors.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 items-end">
                            <div>
                                <x-input-label for="specialization" :value="__('Spesialisasi')" />
                                <select name="specialization" id="specialization" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">
                                    <option value="">Semua Spesialisasi</option>
                                    @foreach ($specializations as $spec)
                                        <option value="{{ $spec }}" {{ $request->specialization == $spec ? 'selected' : '' }}>{{ $spec }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                                <select name="gender" id="gender" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">
                                    <option value="">Semua Jenis Kelamin</option>
                                     @foreach ($genders as $genderOption)
                                        <option value="{{ $genderOption }}" {{ $request->gender == $genderOption ? 'selected' : '' }}>{{ $genderOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex space-x-3 md:col-span-1 lg:col-span-2 justify-start md:pt-6">
                                <x-primary-button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 me-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                    {{ __('Saring') }}
                                </x-primary-button>
                                <a href="{{ route('patient.doctors.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 border border-gray-300 rounded-lg font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150">
                                    Reset Filter
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if($doctors->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($doctors as $doctor)
                        {{-- Menghapus dark:bg-gray-800 dari kartu dokter --}}
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl flex flex-col hover:shadow-2xl transition-shadow duration-300">
                            <div class="p-6 text-gray-900 flex-grow">
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0 h-16 w-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl font-bold">
                                        {{ strtoupper(substr($doctor->name, 0, 1)) }}
                                    </div>
                                    <div class="ms-4">
                                        <h3 class="text-xl font-semibold text-emerald-700">{{ $doctor->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $doctor->specialization ?? 'Spesialisasi Umum' }}</p>
                                    </div>
                                </div>
                                
                                <div class="text-sm text-gray-700 space-y-2">
                                    <div class="mt-2">
                                        @if(!is_null($doctor->average_doctor_rating))
                                            <span class="text-sm font-semibold text-yellow-500">
                                                Rating: {{ number_format($doctor->average_doctor_rating, 1) }}/5.0
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                ({{ $doctor->doctor_rating_count }} ulasan)
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-500">Belum ada rating</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 me-2 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                        Jenis Kelamin: {{ $doctor->gender ?? 'N/A' }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 me-2 text-gray-400">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h6M9 12.75h6M9 18.75h6" />
                                        </svg>
                                        Ruang: {{ $doctor->room ?? 'Informasi tidak tersedia' }}
                                    </div>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Jadwal Umum:</h4>
                                    <p class="text-sm text-gray-600 whitespace-pre-line">{{ $doctor->availability_schedule ?? 'Hubungi klinik untuk informasi jadwal.' }}</p>
                                </div>
                            </div>
                            <div class="p-6 bg-gray-50 border-t border-gray-200">
                                <a href="{{ route('patient.appointments.create', ['doctor_id' => $doctor->id]) }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-500 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                                    Buat Janji Temu dengan Dokter Ini
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $doctors->appends(request()->query())->links() }}
                </div>
            @else
                {{-- Menghapus dark:bg-gray-800 dan dark:text-gray-100 dari kartu "tidak ada dokter" --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-10 text-center text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-400 mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <p class="text-xl font-medium">Tidak ada dokter yang ditemukan.</p>
                        <p class="text-gray-500 mt-1">Coba ubah kriteria filter Anda atau reset filter.</p>
                         <a href="{{ route('patient.doctors.index') }}" class="mt-6 inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-500 focus:outline-none">
                            Reset Filter
                        </a>
                    </div>
                </div>
            @endif
             <div class="mt-8 text-center">
                <a href="{{ route('dashboard') }}" class="text-emerald-600 hover:text-emerald-800 underline font-medium">
                    &larr; {{ __('Kembali ke Dashboard Pasien') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>