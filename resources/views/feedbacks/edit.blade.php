<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Umpan Balik/Survei ID: #') }}{{ $feedback->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Informasi Feedback (Read-only) --}}
                    <div class="mb-6 space-y-3">
                        <div>
                            <strong class="font-semibold">{{ __('Tipe:') }}</strong> {{ $feedback->type }}
                        </div>
                        <div>
                            <strong class="font-semibold">{{ __('Pasien:') }}</strong> 
                            {{ $feedback->patient->name ?? 'Anonim/Sistem' }}
                            @if($feedback->patient) ({{ $feedback->patient->phone_number }}) @endif
                        </div>
                        @if($feedback->appointment)
                        <div>
                            <strong class="font-semibold">{{ __('Terkait Janji Temu:') }}</strong> 
                            <a href="{{ route('appointments.show', $feedback->appointment_id) }}" class="text-indigo-600 hover:underline dark:text-indigo-400">
                                #{{ $feedback->appointment_id }}
                            </a> 
                            ({{ $feedback->appointment->appointment_date->isoFormat('D MMM YY') }} - {{ $feedback->appointment->service_description ?? 'Layanan Umum' }})
                        </div>
                        @endif
                        @if(!is_null($feedback->rating_overall_experience) || !is_null($feedback->rating_doctor_performance) || !is_null($feedback->rating_staff_friendliness) || !is_null($feedback->rating_facility_cleanliness))
                            <div class="border-t dark:border-gray-700 pt-3 mt-3">
                                <h3 class="text-md font-medium">{{ __('Penilaian Diberikan:') }}</h3>
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
                            </div>
                        @endif
                        <div class="border-t dark:border-gray-700 pt-3 mt-3">
                            <strong class="font-semibold">{{ __('Isi Komentar/Feedback:') }}</strong>
                            <p class="mt-1 whitespace-pre-wrap bg-gray-100 dark:bg-gray-900 p-3 rounded-md">{{ $feedback->comment ?? '-' }}</p>
                        </div>
                        <div>
                            <strong class="font-semibold">{{ __('Tanggal Masuk:') }}</strong> {{ $feedback->submitted_at ? $feedback->submitted_at->isoFormat('dddd, D MMMM YY, HH:mm') : '-' }}
                        </div>
                    </div>

                    <hr class="my-6 dark:border-gray-700">

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Oops! Ada kesalahan:</strong>
                            <ul class="mt-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('feedbacks.update', $feedback->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mt-4">
                            <x-input-label for="status_penanganan" :value="__('Status Penanganan')" />
                            <select name="status_penanganan" id="status_penanganan" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                @php
                                    $statuses = ['Baru', 'Diproses', 'Selesai', 'Tidak Perlu Tindakan'];
                                @endphp
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" {{ old('status_penanganan', $feedback->status_penanganan ?? 'Baru') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('status_penanganan')" class="mt-2" />
                        </div>
                        
                        <div class="mt-4">
                            <x-input-label for="catatan_tindak_lanjut" :value="__('Catatan Tindak Lanjut Staf (Opsional)')" />
                            <textarea name="catatan_tindak_lanjut" id="catatan_tindak_lanjut" rows="5" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('catatan_tindak_lanjut', $feedback->catatan_tindak_lanjut) }}</textarea>
                            <x-input-error :messages="$errors->get('catatan_tindak_lanjut')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('feedbacks.show', $feedback->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update Status Feedback') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>