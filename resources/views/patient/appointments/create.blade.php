<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Janji Temu Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Pesan Flash dan Error sudah menggunakan styling yang baik --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-md" role="alert">
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-md" role="alert">
                    <p class="font-bold">Gagal!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-md" role="alert">
                    <p class="font-bold">Oops! Ada beberapa hal yang perlu diperbaiki:</p>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg"> {{-- Hapus dark:bg-gray-800 --}}
                <div class="p-6 sm:p-8 border-b border-gray-200"> {{-- Hapus dark:border-gray-700 --}}
                    <h3 class="text-2xl font-semibold text-emerald-700">Formulir Booking Janji Temu</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Silakan isi detail di bawah ini untuk menjadwalkan janji temu Anda.
                    </p>
                </div>

                <form method="POST" action="{{ route('patient.appointments.store') }}">
                    @csrf
                    <div class="p-6 sm:p-8 space-y-6 text-gray-900"> {{-- Hapus dark:text-gray-100 --}}

                        <div>
                            <x-input-label for="doctor_id" :value="__('Pilih Dokter (Opsional)')" class="text-gray-700"/>
                            <select name="doctor_id" id="doctor_id" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">
                                <option value="">-- Dokter Umum / Pilihan Klinik --</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }} (Spesialis: {{ $doctor->specialization }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('doctor_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="appointment_date" :value="__('Pilih Tanggal Janji Temu')" class="text-gray-700"/>
                            <x-text-input id="appointment_date" class="block mt-1 w-full" type="date" name="appointment_date" :value="old('appointment_date', date('Y-m-d'))" required 
                                          min="{{ date('Y-m-d') }}" />
                            <x-input-error :messages="$errors->get('appointment_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="start_time" :value="__('Pilih Waktu Mulai')" class="text-gray-700"/>
                            <x-text-input id="start_time" class="block mt-1 w-full" type="time" name="start_time" :value="old('start_time')" required />
                            <p class="mt-1 text-xs text-gray-500">
                                Contoh: 09:00, 14:30. Klinik akan mengkonfirmasi ketersediaan jam. Jam operasional klinik: 08:00 - 20:00.
                            </p>
                            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="service_description_select" :value="__('Layanan atau Keperluan')" class="text-gray-700"/>
                            <select id="service_description_select" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Layanan --</option>
                                @foreach ($availableServices as $service)
                                    <option value="{{ $service }}" {{ old('service_description_select', old('service_description')) == $service ? 'selected' : '' }}>{{ $service }}</option>
                                @endforeach
                            </select>
                            <textarea name="service_description_other" id="service_description_other" rows="2" class="{{ old('service_description_select', old('service_description')) == 'Lainnya (jelaskan di catatan)' ? '' : 'hidden' }} mt-2 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" placeholder="Jelaskan layanan atau keperluan lainnya">{{ old('service_description_other') }}</textarea>
                            {{-- Hidden input to carry the final service_description value --}}
                            <input type="hidden" name="service_description" id="service_description_final" value="{{ old('service_description', $availableServices[0] ?? '') }}">
                            <x-input-error :messages="$errors->get('service_description')" class="mt-2" />
                            <x-input-error :messages="$errors->get('service_description_other')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="notes" :value="__('Catatan Tambahan untuk Klinik (Opsional)')" class="text-gray-700"/>
                            <textarea id="notes" name="notes" rows="3" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 border border-gray-300 rounded-lg font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Ajukan Janji Temu') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
                <script>
                    const serviceSelect = document.getElementById('service_description_select');
                    const serviceOtherTextarea = document.getElementById('service_description_other');
                    const serviceFinalInput = document.getElementById('service_description_final');

                    function updateServiceDescription() {
                        if (serviceSelect.value === 'Lainnya (jelaskan di catatan)') {
                            serviceOtherTextarea.classList.remove('hidden');
                            serviceOtherTextarea.setAttribute('required', 'required'); // Make it required if "Lainnya" is chosen
                            serviceFinalInput.value = serviceOtherTextarea.value; // Update final value from textarea
                        } else {
                            serviceOtherTextarea.classList.add('hidden');
                            serviceOtherTextarea.removeAttribute('required');
                            serviceFinalInput.value = serviceSelect.value; // Update final value from select
                        }
                    }

                    serviceSelect.addEventListener('change', updateServiceDescription);
                    serviceOtherTextarea.addEventListener('input', function() { // Update final value when textarea changes
                        if (serviceSelect.value === 'Lainnya (jelaskan di catatan)') {
                            serviceFinalInput.value = this.value;
                        }
                    });

                    // Initial call to set state based on old input
                    updateServiceDescription(); 
                    // If there was old input for textarea, make sure final input reflects it
                    if(serviceSelect.value === 'Lainnya (jelaskan di catatan)' && "{{ old('service_description_other') }}") {
                       serviceFinalInput.value = "{{ old('service_description_other') }}";
                    } else if ("{{ old('service_description') }}") {
                       serviceFinalInput.value = "{{ old('service_description') }}";
                    }

                </script>
            </div>
             <div class="mt-8 text-center">
                <a href="{{ route('patient.appointments.index') }}" class="text-emerald-600 hover:text-emerald-800 underline font-medium">
                    &larr; {{ __('Lihat Riwayat Janji Temu Saya') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>