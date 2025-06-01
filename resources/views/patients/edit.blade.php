<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Pasien: ') }} {{ $patient->name }}
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
                    <h3 class="text-2xl font-semibold text-emerald-700">Formulir Edit Data Pasien</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Ubah detail pasien di bawah ini.
                    </p>
                </div>

                <form method="POST" action="{{ route('patients.update', $patient->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="p-6 sm:p-8 space-y-6 text-gray-900">

                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-700" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $patient->name)" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="phone_number" :value="__('Nomor Telepon')" class="text-gray-700" />
                            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number', $patient->phone_number)" required />
                            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Alamat Email (Opsional)')" class="text-gray-700" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $patient->email)" autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="date_of_birth" :value="__('Tanggal Lahir (Opsional)')" class="text-gray-700" />
                            <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth', $patient->date_of_birth ? $patient->date_of_birth->format('Y-m-d') : '')" />
                            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="gender" :value="__('Jenis Kelamin (Opsional)')" class="text-gray-700" />
                            <select name="gender" id="gender" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki" {{ old('gender', $patient->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('gender', $patient->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                <option value="Lainnya" {{ old('gender', $patient->gender) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="patient_type" :value="__('Tipe Pasien (Opsional)')" class="text-gray-700" />
                            <select name="patient_type" id="patient_type" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Tipe Pasien --</option>
                                <option value="Umum" {{ old('patient_type', $patient->patient_type) == 'Umum' ? 'selected' : '' }}>Umum</option>
                                <option value="BPJS Kesehatan" {{ old('patient_type', $patient->patient_type) == 'BPJS Kesehatan' ? 'selected' : '' }}>BPJS Kesehatan</option>
                                <option value="Asuransi Swasta" {{ old('patient_type', $patient->patient_type) == 'Asuransi Swasta' ? 'selected' : '' }}>Asuransi Swasta</option>
                                <option value="Karyawan Rekanan" {{ old('patient_type', $patient->patient_type) == 'Karyawan Rekanan' ? 'selected' : '' }}>Karyawan Rekanan</option>
                                <option value="Lainnya" {{ old('patient_type', $patient->patient_type) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <x-input-error :messages="$errors->get('patient_type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Alamat Rumah (Opsional)')" class="text-gray-700" />
                            <textarea name="address" id="address" rows="3" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">{{ old('address', $patient->address) }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="registration_date" :value="__('Tanggal Registrasi')" class="text-gray-700" />
                            <x-text-input id="registration_date" class="block mt-1 w-full" type="date" name="registration_date" :value="old('registration_date', $patient->registration_date ? $patient->registration_date->format('Y-m-d') : '')" required />
                            <x-input-error :messages="$errors->get('registration_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="preferences_notes" :value="__('Catatan Preferensi (Opsional)')" class="text-gray-700" />
                            <textarea name="preferences_notes" id="preferences_notes" rows="3" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">{{ old('preferences_notes', $patient->preferences_notes) }}</textarea>
                            <x-input-error :messages="$errors->get('preferences_notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                            <a href="{{ route('patients.show', $patient->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 border border-gray-300 rounded-lg font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update Pasien') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>