<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8"> {{-- Dibuat sedikit lebih lebar --}}

            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-md" role="alert">
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- Bagian Header Kartu Pasien --}}
                <div class="px-6 py-5 sm:px-8 sm:py-6 border-b border-gray-200 bg-gradient-to-r from-emerald-500 to-green-500 text-white rounded-t-lg">
                    <div class="flex flex-col sm:flex-row justify-between items-start">
                        <div>
                            <h3 class="text-3xl font-bold leading-tight">{{ $patient->name }}</h3>
                            <p class="mt-1 text-sm text-emerald-100">ID Pasien: #{{ $patient->id }} @if($patient->patient_type) <span class="font-semibold">({{ $patient->patient_type }})</span> @endif</p>
                        </div>
                        <div class="mt-3 sm:mt-0">
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $patient->user_id ? 'bg-sky-100 text-sky-800' : 'bg-gray-200 text-gray-700' }}">
                                {{ $patient->user_id ? 'Memiliki Akun Login' : 'Belum Ada Akun Login' }}
                            </span>
                        </div>
                    </div>
                    @if ($patient->user_id && $patient->user)
                    <p class="mt-2 text-sm text-emerald-50">Email Akun: {{ $patient->user->email }}</p>
                    @endif
                </div>

                {{-- Bagian Detail Informasi --}}
                <div class="p-6 sm:p-8 text-gray-900 space-y-8">

                    {{-- Informasi Kontak --}}
                    <section>
                        <h4 class="text-xl font-semibold text-emerald-700 mb-3 border-b pb-2 border-emerald-200">Informasi Kontak</h4>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">{{ __('Nomor Telepon') }}</dt>
                                <dd class="mt-1 text-base text-gray-800">{{ $patient->phone_number }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">{{ __('Alamat Email') }}</dt>
                                <dd class="mt-1 text-base text-gray-800">{{ $patient->email ?? '-' }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">{{ __('Alamat Rumah') }}</dt>
                                <dd class="mt-1 text-base text-gray-800 whitespace-pre-wrap">{{ $patient->address ?? '-' }}</dd>
                            </div>
                        </dl>
                    </section>

                    {{-- Informasi Pribadi --}}
                    <section>
                        <h4 class="text-xl font-semibold text-emerald-700 mb-3 border-b pb-2 border-emerald-200">Informasi Pribadi</h4>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">{{ __('Tanggal Lahir') }}</dt>
                                <dd class="mt-1 text-base text-gray-800">{{ $patient->date_of_birth ? $patient->date_of_birth->isoFormat('D MMMM YYYY') : '-' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">{{ __('Jenis Kelamin') }}</dt>
                                <dd class="mt-1 text-base text-gray-800">{{ $patient->gender ?? '-' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">{{ __('Tanggal Registrasi') }}</dt>
                                <dd class="mt-1 text-base text-gray-800">{{ $patient->registration_date ? $patient->registration_date->isoFormat('D MMMM YYYY') : '-' }}</dd>
                            </div>
                        </dl>
                    </section>

                    {{-- Informasi Loyalitas & Preferensi --}}
                    <section>
                         <h4 class="text-xl font-semibold text-emerald-700 mb-3 border-b pb-2 border-emerald-200">Loyalitas & Preferensi</h4>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">{{ __('Total Poin Loyalitas') }}</dt>
                                <dd class="mt-1 text-3xl font-bold text-emerald-600">{{ number_format($patient->total_loyalty_points, 0, ',', '.') }} <span class="text-xl">Poin</span></dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">{{ __('Catatan Preferensi') }}</dt>
                                <dd class="mt-1 text-base text-gray-800 whitespace-pre-wrap">{{ $patient->preferences_notes ?? '-' }}</dd>
                            </div>
                        </dl>
                    </section>

                    <div class="text-xs text-gray-500 pt-4 border-t border-gray-200">
                        <p><strong>{{ __('Data Pasien Dibuat pada:') }}</strong> {{ $patient->created_at ? $patient->created_at->isoFormat('D MMMM YYYY, HH:mm:ss') : '-' }}</p>
                        <p><strong>{{ __('Data Pasien Terakhir diperbarui pada:') }}</strong> {{ $patient->updated_at ? $patient->updated_at->isoFormat('D MMMM YYYY, HH:mm:ss') : '-' }}</p>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="mt-8 pt-6 border-t border-gray-200 flex flex-wrap justify-start gap-4">
                        <x-primary-button-link href="{{ route('patients.edit', $patient->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 me-2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            {{ __('Edit Pasien Ini') }}
                        </x-primary-button-link>
                        <a href="{{ route('points.redeem.create', $patient->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 me-2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-4.5A3.375 3.375 0 0012.75 9.75H11.25A3.375 3.375 0 007.5 13.125V18.75m3.75 0h1.5M12 12.75h.008v.008H12v-.008z" />
                            </svg>
                            {{ __('Tukarkan Poin') }}
                        </a>
                        <a href="{{ route('patients.loyalty_transactions', $patient->id) }}" class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-500 active:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 me-2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                            </svg>
                            {{ __('Riwayat Poin') }}
                        </a>
                        <a href="{{ route('admin.patients.award_promo.create', $patient->id) }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-500 active:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 me-2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('Berikan Poin Promosi') }}
                        </a>
                        <a href="{{ route('patients.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 border border-gray-300 rounded-lg font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150">
                            {{ __('Kembali ke Daftar Pasien') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>