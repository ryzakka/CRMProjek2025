<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Janji Temu Baru (oleh Staf)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8"> {{-- max-w-3xl agar form tidak terlalu lebar --}}

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
                    <h3 class="text-2xl font-semibold text-emerald-700">Formulir Penjadwalan Janji Temu</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Isi detail di bawah ini untuk menjadwalkan janji temu pasien.
                    </p>
                </div>

                <form method="POST" action="{{ route('appointments.store') }}">
                    @csrf
                    <div class="p-6 sm:p-8 space-y-6 text-gray-900">

                        <div>
                            <x-input-label for="patient_id" :value="__('Pilih Pasien')" class="text-gray-700" />
                            <select name="patient_id" id="patient_id" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Pasien --</option>
                                @foreach ($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
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
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }} (Spesialis: {{ $doctor->specialization }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('doctor_id')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="appointment_date" :value="__('Tanggal Janji Temu')" class="text-gray-700" />
                                <x-text-input id="appointment_date" class="block mt-1 w-full" type="date" name="appointment_date" :value="old('appointment_date', date('Y-m-d'))" required min="{{ date('Y-m-d') }}" />
                                <x-input-error :messages="$errors->get('appointment_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="start_time" :value="__('Waktu Mulai')" class="text-gray-700" />
                                <x-text-input id="start_time" class="block mt-1 w-full" type="time" name="start_time" :value="old('start_time')" required />
                                <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                            </div>
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
                            <x-input-label for="notes" :value="__('Catatan Tambahan (Opsional)')" class="text-gray-700" />
                            <textarea name="notes" id="notes" rows="3" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status Janji Temu Awal')" class="text-gray-700" />
                            <select name="status" id="status" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" required>
                                <option value="Dijadwalkan" {{ old('status', 'Dijadwalkan') == 'Dijadwalkan' ? 'selected' : '' }}>Dijadwalkan</option>
                                <option value="Dikonfirmasi" {{ old('status') == 'Dikonfirmasi' ? 'selected' : '' }}>Langsung Dikonfirmasi</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                            <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 border border-gray-300 rounded-lg font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Janji Temu') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
                <script>
                    const serviceSelect_staff = document.getElementById('service_description_select');
                    const serviceOtherTextarea_staff = document.getElementById('service_description_other');
                    const serviceFinalInput_staff = document.getElementById('service_description_final');

                    function updateServiceDescription_staff() {
                        if (serviceSelect_staff.value === 'Lainnya (jelaskan di catatan)') {
                            serviceOtherTextarea_staff.classList.remove('hidden');
                            serviceOtherTextarea_staff.setAttribute('required', 'required');
                            serviceFinalInput_staff.value = serviceOtherTextarea_staff.value; 
                        } else {
                            serviceOtherTextarea_staff.classList.add('hidden');
                            serviceOtherTextarea_staff.removeAttribute('required');
                            serviceFinalInput_staff.value = serviceSelect_staff.value;
                        }
                    }

                    serviceSelect_staff.addEventListener('change', updateServiceDescription_staff);
                    serviceOtherTextarea_staff.addEventListener('input', function() { 
                        if (serviceSelect_staff.value === 'Lainnya (jelaskan di catatan)') {
                            serviceFinalInput_staff.value = this.value;
                        }
                    });

                    // Initial call
                    updateServiceDescription_staff(); 
                    if(serviceSelect_staff.value === 'Lainnya (jelaskan di catatan)' && "{{ old('service_description_other') }}") {
                       serviceFinalInput_staff.value = "{{ old('service_description_other') }}";
                    } else if ("{{ old('service_description') }}") {
                       serviceFinalInput_staff.value = "{{ old('service_description') }}";
                    }
                </script>
            </div>
        </div>
    </div>
</x-app-layout>