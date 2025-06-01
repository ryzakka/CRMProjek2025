<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Umpan Balik/Survei ID: #') }}{{ $feedback->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
                    
                    <div>
                        <strong class="font-semibold">{{ __('ID Feedback:') }}</strong>
                        <p>{{ $feedback->id }}</p>
                    </div>

                    <div>
                        <strong class="font-semibold">{{ __('Tipe:') }}</strong>
                        <p>{{ $feedback->type }}</p>
                    </div>

                    <div>
                        <strong class="font-semibold">{{ __('Pasien:') }}</strong>
                        <p>
                            @if ($feedback->patient)
                                <a href="{{ route('patients.show', $feedback->patient_id) }}" class="text-indigo-600 hover:underline dark:text-indigo-400">
                                    {{ $feedback->patient->name }}
                                </a>
                            @else
                                Anonim/Sistem
                            @endif
                        </p>
                    </div>

                    @if ($feedback->appointment)
                    <div>
                        <strong class="font-semibold">{{ __('Terkait Janji Temu ID:') }}</strong>
                        <p>
                            <a href="{{ route('appointments.show', $feedback->appointment_id) }}" class="text-indigo-600 hover:underline dark:text-indigo-400">
                                #{{ $feedback->appointment_id }}
                            </a>
                             ({{ $feedback->appointment->appointment_date->isoFormat('D MMM YYYY') }} 
                             - {{ $feedback->appointment->service_description ?? 'Layanan Umum' }})
                        </p>
                    </div>
                    @endif

                    @if(!is_null($feedback->rating_overall_experience) || !is_null($feedback->rating_doctor_performance) || !is_null($feedback->rating_staff_friendliness) || !is_null($feedback->rating_facility_cleanliness))
                        <hr class="dark:border-gray-700">
                        <h3 class="text-lg font-medium">{{ __('Penilaian (Jika Survei):') }}</h3>
                        @if(!is_null($feedback->rating_overall_experience))
                        <div><strong class="font-semibold">{{ __('Pengalaman Keseluruhan:') }}</strong> {{ $feedback->rating_overall_experience }} / 5</div>
                        @endif
                        @if(!is_null($feedback->rating_doctor_performance))
                        <div><strong class="font-semibold">{{ __('Kinerja Dokter:') }}</strong> {{ $feedback->rating_doctor_performance }} / 5</div>
                        @endif
                        @if(!is_null($feedback->rating_staff_friendliness))
                        <div><strong class="font-semibold">{{ __('Keramahan Staf:') }}</strong> {{ $feedback->rating_staff_friendliness }} / 5</div>
                        @endif
                        @if(!is_null($feedback->rating_facility_cleanliness))
                        <div><strong class="font-semibold">{{ __('Kebersihan Fasilitas:') }}</strong> {{ $feedback->rating_facility_cleanliness }} / 5</div>
                        @endif
                    @endif
                    
                    <hr class="dark:border-gray-700">
                    <div>
                        <strong class="font-semibold">{{ __('Komentar/Isi Umpan Balik:') }}</strong>
                        <p class="whitespace-pre-wrap mt-1">{{ $feedback->comment ?? '-' }}</p>
                    </div>
                    
                    <hr class="dark:border-gray-700">
                    <div>
                        <strong class="font-semibold">{{ __('Status Penanganan:') }}</strong>
                        <p>{{ $feedback->status_penanganan ?? 'Baru' }}</p>
                    </div>

                    <div>
                        <strong class="font-semibold">{{ __('Catatan Tindak Lanjut:') }}</strong>
                        <p class="whitespace-pre-wrap mt-1">{{ $feedback->catatan_tindak_lanjut ?? '-' }}</p>
                    </div>

                    <div>
                        <strong class="font-semibold">{{ __('Ditangani Oleh Staf:') }}</strong>
                        <p>{{ $feedback->staffPenanggungJawab->name ?? '-' }}</p>
                    </div>
                    
                    <div>
                        <strong class="font-semibold">{{ __('Tanggal Masuk:') }}</strong>
                        <p>{{ $feedback->submitted_at ? $feedback->submitted_at->isoFormat('dddd, D MMMM YYYY, HH:mm') : '-' }}</p>
                    </div>
                    <div>
                        <strong class="font-semibold">{{ __('Terakhir Diperbarui:') }}</strong>
                        <p>{{ $feedback->updated_at ? $feedback->updated_at->isoFormat('dddd, D MMMM YYYY, HH:mm') : '-' }}</p>
                    </div>


                    <div class="mt-6 flex justify-start space-x-3">
                        <a href="{{ route('feedbacks.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Kembali ke Daftar') }}
                        </a>
                        <a href="{{ route('feedbacks.edit', $feedback->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Kelola Feedback Ini') }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>