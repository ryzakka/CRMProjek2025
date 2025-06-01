<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Janji Temu ID: #') }}{{ $appointment->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8"> {{-- max-w-3xl agar tidak terlalu lebar --}}

            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-md" role="alert">
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8 border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-semibold text-emerald-700">
                                Layanan: {{ $appointment->service_description ?? 'N/A' }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                untuk Pasien: 
                                <a href="{{ route('patients.show', $appointment->patient_id) }}" class="text-emerald-600 hover:underline font-medium">
                                    {{ $appointment->patient->name ?? 'N/A' }}
                                </a>
                            </p>
                        </div>
                        <div>
                            @if($appointment->status == 'Selesai')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $appointment->status }}
                                </span>
                            @elseif($appointment->status == 'Dijadwalkan' || $appointment->status == 'Dikonfirmasi')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $appointment->status }}
                                </span>
                            @elseif(Str::contains($appointment->status, 'Dibatalkan'))
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    {{ $appointment->status }}
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ $appointment->status }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8 text-gray-900 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                        <div>
                            <strong class="block font-medium text-sm text-gray-500">{{ __('Dokter:') }}</strong>
                            <p class="mt-1 text-gray-800">{{ $appointment->doctor->name ?? 'Belum ditentukan' }} 
                                @if($appointment->doctor) ({{ $appointment->doctor->specialization ?? 'Umum' }}) @endif
                            </p>
                        </div>
                        <div>
                            <strong class="block font-medium text-sm text-gray-500">{{ __('ID Janji Temu:') }}</strong>
                            <p class="mt-1 text-gray-800">#{{ $appointment->id }}</p>
                        </div>
                        <div>
                            <strong class="block font-medium text-sm text-gray-500">{{ __('Tanggal Janji Temu:') }}</strong>
                            <p class="mt-1 text-gray-800">{{ $appointment->appointment_date ? $appointment->appointment_date->isoFormat('dddd, D MMMM YYYY') : '-' }}</p>
                        </div>
                        <div>
                            <strong class="block font-medium text-sm text-gray-500">{{ __('Waktu:') }}</strong>
                            <p class="mt-1 text-gray-800">
                                {{ $appointment->start_time ? \Carbon\Carbon::parse($appointment->start_time)->format('H:i') : '' }}
                                {{ $appointment->end_time ? ' - ' . \Carbon\Carbon::parse($appointment->end_time)->format('H:i') : '' }}
                            </p>
                        </div>
                    </div>

                    @if($appointment->notes)
                    <div class="pt-5 border-t border-gray-200">
                        <strong class="block font-medium text-sm text-gray-500">{{ __('Catatan Tambahan:') }}</strong>
                        <p class="mt-1 text-gray-800 whitespace-pre-wrap">{{ $appointment->notes }}</p>
                    </div>
                    @endif

                    <hr class="my-4 border-gray-200">

                    <div class="text-xs text-gray-500 space-y-1">
                        <p><strong>{{ __('Dibuat pada:') }}</strong> {{ $appointment->created_at ? $appointment->created_at->isoFormat('D MMMM YYYY, HH:mm:ss') : '-' }}</p>
                        <p><strong>{{ __('Terakhir diperbarui pada:') }}</strong> {{ $appointment->updated_at ? $appointment->updated_at->isoFormat('D MMMM YYYY, HH:mm:ss') : '-' }}</p>
                        @if($appointment->survey_sent_at)
                        <p><strong>{{ __('Survei Dikirim pada:') }}</strong> {{ $appointment->survey_sent_at->isoFormat('D MMMM YYYY, HH:mm:ss') }}</p>
                        @endif
                    </div>

                    <div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-200">
                        <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 border border-gray-300 rounded-lg font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150 mr-4">
                            {{ __('Kembali ke Daftar') }}
                        </a>
                        <x-primary-button-link href="{{ route('appointments.edit', $appointment->id) }}">
                            {{ __('Edit Janji Temu Ini') }}
                        </x-primary-button-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>