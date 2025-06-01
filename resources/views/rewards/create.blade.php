<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Reward Baru untuk Program Loyalitas') }}
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
                    <h3 class="text-2xl font-semibold text-emerald-700">Formulir Penambahan Reward</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Isi detail reward baru di bawah ini.
                    </p>
                </div>

                <form method="POST" action="{{ route('rewards.store') }}">
                    @csrf
                    <div class="p-6 sm:p-8 space-y-6 text-gray-900">

                        <div>
                            <x-input-label for="name" :value="__('Nama Reward')" class="text-gray-700" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Deskripsi (Opsional)')" class="text-gray-700" />
                            <textarea name="description" id="description" rows="3" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="points_required" :value="__('Poin yang Dibutuhkan')" class="text-gray-700" />
                            <x-text-input id="points_required" class="block mt-1 w-full" type="number" name="points_required" :value="old('points_required')" required min="1" />
                            <x-input-error :messages="$errors->get('points_required')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="type" :value="__('Tipe Reward')" class="text-gray-700" />
                            <select name="type" id="type" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Tipe --</option>
                                @foreach ($rewardTypes as $key => $value)
                                    <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div id="value_field_container" class="hidden"> {{-- Disembunyikan/ditampilkan oleh JS --}}
                            <x-input-label for="value" :value="__('Nilai Reward (misal: 10 untuk 10%, atau 50000 untuk Rp)')" class="text-gray-700" />
                            <x-text-input id="value" class="block mt-1 w-full" type="number" name="value" :value="old('value')" step="any" />
                            <x-input-error :messages="$errors->get('value')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="quantity_available" :value="__('Kuantitas Tersedia (Kosongkan jika tidak terbatas)')" class="text-gray-700" />
                            <x-text-input id="quantity_available" class="block mt-1 w-full" type="number" name="quantity_available" :value="old('quantity_available')" min="0" />
                            <x-input-error :messages="$errors->get('quantity_available')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="start_date" :value="__('Tanggal Mulai Berlaku (Opsional)')" class="text-gray-700" />
                                <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date')" />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="end_date" :value="__('Tanggal Selesai Berlaku (Opsional)')" class="text-gray-700" />
                                <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date')" />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>
                        </div>

                        <div class="block">
                            <label for="is_active" class="inline-flex items-center">
                                <input id="is_active" type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="ms-2 text-sm text-gray-700">{{ __('Aktifkan Reward Ini Saat Disimpan') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                            <a href="{{ route('rewards.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 border border-gray-300 rounded-lg font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Reward Baru') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
                <script>
                    const rewardTypeSelect = document.getElementById('type');
                    const valueFieldContainer = document.getElementById('value_field_container');
                    const valueInput = document.getElementById('value');

                    function toggleValueField() {
                        const selectedType = rewardTypeSelect.value;
                        if (selectedType === 'DISCOUNT_PERCENTAGE' || selectedType === 'DISCOUNT_FIXED_AMOUNT') {
                            valueFieldContainer.classList.remove('hidden');
                            valueInput.setAttribute('required', 'required');
                        } else {
                            valueFieldContainer.classList.add('hidden');
                            valueInput.removeAttribute('required');
                            valueInput.value = ''; // Kosongkan nilainya jika tidak relevan
                        }
                    }
                    rewardTypeSelect.addEventListener('change', toggleValueField);
                    // Panggil saat load untuk menangani old input
                    toggleValueField();
                </script>
            </div>
        </div>
    </div>
</x-app-layout>