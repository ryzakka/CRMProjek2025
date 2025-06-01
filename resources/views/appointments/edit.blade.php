<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Janji Temu ID: #') }}{{ $appointment->id }}
            @if($appointment->patient)
                - {{ $appointment->patient->name }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

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

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8 border-b border-gray-200">
                    <h3 class="text-2xl font-semibold text-emerald-700">Formulir Edit Janji Temu</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Ubah detail janji temu pasien di bawah ini.
                    </p>
                </div>

                <form method="POST" action="{{ route('appointments.update', $appointment->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="p-6 sm:p-8 space-y-6 text-gray-900">

                        <div>
                            <x-input-label for="patient_id" :value="__('Pilih Pasien')" class="text-gray-700" />
                            <select name="patient_id" id="patient_id" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Pasien --</option>
                                @foreach ($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->name }} ({{ $patient->phone_number }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('patient_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="doctor_id" :value="__('Pilih Dokter')" class="text-gray-700" />
                            <select name="doctor_id" id="doctor_id" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Dokter --</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }} (Spesialis: {{ $doctor->specialization }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('doctor_id')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="appointment_date" :value="__('Tanggal Janji Temu')" class="text-gray-700" />
                                <x-text-input id="appointment_date" class="block mt-1 w-full" type="date" name="appointment_date" :value="old('appointment_date', $appointment->appointment_date->format('Y-m-d'))" required min="{{ date('Y-m-d') }}" />
                                <x-input-error :messages="$errors->get('appointment_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="start_time" :value="__('Waktu Mulai')" class="text-gray-700" />
                                <x-text-input id="start_time" class="block mt-1 w-full" type="time" name="start_time" :value="old('start_time', \Carbon\Carbon::parse($appointment->start_time)->format('H:i'))" required />
                                <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-4"> {{-- Beri jarak jika tidak masuk grid --}}
                            <x-input-label for="end_time" :value="__('Waktu Selesai (Opsional)')" class="text-gray-700"/>
                            <x-text-input id="end_time" class="block mt-1 w-full" type="time" name="end_time" :value="old('end_time', $appointment->end_time ? \Carbon\Carbon::parse($appointment->end_time)->format('H:i') : '')" />
                            <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="service_description_select" :value="__('Layanan atau Keperluan')" class="text-gray-700"/>
                            @php
                                // Cek apakah old('service_description') ada di $availableServices atau merupakan custom value
                                $currentService = old('service_description', $appointment->service_description);
                                $isCustomService = !in_array($currentService, $availableServices) && $currentService !== 'Lainnya (jelaskan di catatan)';
                            @endphp
                            <select id="service_description_select_staff" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Layanan --</option>
                                @foreach ($availableServices as $service)
                                    <option value="{{ $service }}" {{ $currentService == $service ? 'selected' : '' }}>{{ $service }}</option>
                                @endforeach
                                @if($isCustomService && $currentService) {{-- Jika ada custom value lama, tampilkan sbg opsi terpilih --}}
                                    <option value="{{ $currentService }}" selected>{{ $currentService }} (Custom)</option>
                                @endif
                            </select>
                            <textarea name="service_description_other" id="service_description_other_staff" rows="2" class="{{ ($currentService == 'Lainnya (jelaskan di catatan)' || $isCustomService) ? '' : 'hidden' }} mt-2 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" placeholder="Jelaskan layanan atau keperluan lainnya">{{ $isCustomService ? $currentService : old('service_description_other') }}</textarea>
                            <input type="hidden" name="service_description" id="service_description_final_staff" value="{{ $currentService }}">
                            <x-input-error :messages="$errors->get('service_description')" class="mt-2" />
                            <x-input-error :messages="$errors->get('service_description_other')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status Janji Temu')" class="text-gray-700" />
                            <select name="status" id="status" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" required>
                                @php
                                    $statuses = ['Dijadwalkan', 'Dikonfirmasi', 'Selesai', 'Dibatalkan Pasien', 'Dibatalkan Klinik', 'Tidak Hadir'];
                                @endphp
                                @foreach ($statuses as $statusOption)
                                    <option value="{{ $statusOption }}" {{ old('status', $appointment->status) == $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="notes" :value="__('Catatan Tambahan (Opsional)')" class="text-gray-700" />
                            <textarea name="notes" id="notes" rows="3" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">{{ old('notes', $appointment->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                            <a href="{{ route('appointments.show', $appointment->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 border border-gray-300 rounded-lg font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update Janji Temu') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
                <script>
                    // Gunakan ID unik untuk elemen dan event listener jika script ini ada di layout yg sama dgn form create pasien
                    const serviceSelectStaff = document.getElementById('service_description_select_staff');
                    const serviceOtherTextareaStaff = document.getElementById('service_description_other_staff');
                    const serviceFinalInputStaff = document.getElementById('service_description_final_staff');

                    function updateServiceDescriptionStaff() {
                        if (serviceSelectStaff.value === 'Lainnya (jelaskan di catatan)') {
                            serviceOtherTextareaStaff.classList.remove('hidden');
                            serviceOtherTextareaStaff.setAttribute('required', 'required');
                            serviceFinalInputStaff.value = serviceOtherTextareaStaff.value; 
                        } else {
                            serviceOtherTextareaStaff.classList.add('hidden');
                            serviceOtherTextareaStaff.removeAttribute('required');
                            serviceFinalInputStaff.value = serviceSelectStaff.value;
                        }
                    }

                    serviceSelectStaff.addEventListener('change', updateServiceDescriptionStaff);
                    serviceOtherTextareaStaff.addEventListener('input', function() { 
                        if (serviceSelectStaff.value === 'Lainnya (jelaskan di catatan)') {
                            serviceFinalInputStaff.value = this.value;
                        }
                    });

                    // Panggil saat load untuk menangani old input atau data dari database
                    updateServiceDescriptionStaff(); 
                    // Jika nilai awal adalah custom (tidak ada di dropdown & bukan 'Lainnya'), set textarea
                    if (serviceSelectStaff.value === "{{ old('service_description', $appointment->service_description) }}" && !Array.from(serviceSelectStaff.options).some(opt => opt.value === serviceSelectStaff.value) && serviceSelectStaff.value !== 'Lainnya (jelaskan di catatan)') {
                        if(serviceSelectStaff.value) { // Pastikan ada nilainya
                            serviceOtherTextareaStaff.value = serviceSelectStaff.value;
                            serviceOtherTextareaStaff.classList.remove('hidden');
                            serviceFinalInputStaff.value = serviceSelectStaff.value;
                            // Set dropdown ke "Lainnya" jika nilai custom ada, agar textarea tampil
                            Array.from(serviceSelectStaff.options).forEach(opt => {
                                if (opt.value === 'Lainnya (jelaskan di catatan)') opt.selected = true;
                            });
                            serviceOtherTextareaStaff.setAttribute('required', 'required');
                        }
                    } else if ("{{ old('service_description') }}" && serviceSelectStaff.value !== 'Lainnya (jelaskan di catatan)') {
                       serviceFinalInputStaff.value = "{{ old('service_description') }}";
                    } else if (serviceSelectStaff.value !== 'Lainnya (jelaskan di catatan)') {
                        serviceFinalInputStaff.value = "{{ $appointment->service_description }}";
                    }

                </script>
            </div>
        </div>
    </div>
</x-app-layout>