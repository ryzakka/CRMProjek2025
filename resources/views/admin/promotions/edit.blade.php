<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Program Promosi: ') }} {{ $promotion->title }}
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
                    <h3 class="text-2xl font-semibold text-emerald-700">Formulir Edit Program Promosi</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Ubah detail program promosi poin loyalitas di bawah ini.
                    </p>
                </div>

                <form method="POST" action="{{ route('admin.promotions.update', $promotion->id) }}">
                    @csrf
                    @method('PUT') {{-- Method spoofing untuk Update --}}
                    <div class="p-6 sm:p-8 space-y-6 text-gray-900">

                        <div>
                            <x-input-label for="title" :value="__('Judul Promosi')" class="text-gray-700" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $promotion->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Deskripsi (Opsional)')" class="text-gray-700" />
                            <textarea name="description" id="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">{{ old('description', $promotion->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="points_awarded" :value="__('Poin yang Diberikan')" class="text-gray-700" />
                            <x-text-input id="points_awarded" class="block mt-1 w-full" type="number" name="points_awarded" :value="old('points_awarded', $promotion->points_awarded)" required min="1" />
                            <x-input-error :messages="$errors->get('points_awarded')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="promo_code" :value="__('Kode Promo (Opsional, harus unik jika diisi)')" class="text-gray-700" />
                            <x-text-input id="promo_code" class="block mt-1 w-full" type="text" name="promo_code" :value="old('promo_code', $promotion->promo_code)" />
                            <x-input-error :messages="$errors->get('promo_code')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="start_date" :value="__('Tanggal Mulai (Opsional)')" class="text-gray-700" />
                                <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date', $promotion->start_date ? $promotion->start_date->format('Y-m-d') : '')" />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="end_date" :value="__('Tanggal Selesai (Opsional)')" class="text-gray-700" />
                                <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date', $promotion->end_date ? $promotion->end_date->format('Y-m-d') : '')" />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>
                        </div>

                        <div class="block">
                            <label for="is_active" class="inline-flex items-center">
                                <input id="is_active" type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="is_active" value="1" {{ old('is_active', $promotion->is_active) ? 'checked' : '' }}>
                                <span class="ms-2 text-sm text-gray-700">{{ __('Aktifkan Promosi Ini') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.promotions.show', $promotion->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 border border-gray-300 rounded-lg font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150 mr-4">
                                {{ __('Batal') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update Promosi') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>