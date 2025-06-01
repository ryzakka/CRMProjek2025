<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Berikan Poin Promosi Manual') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8"> {{-- max-w-3xl agar form tidak terlalu lebar --}}

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8 border-b border-gray-200">
                    <h3 class="text-2xl font-semibold text-emerald-700">Formulir Pemberian Poin Promosi</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Pilih pasien dan promosi untuk memberikan poin loyalitas.
                    </p>
                </div>

                <div class="p-6 sm:p-8 text-gray-900">
                    {{-- Kartu Info Pasien dan Poin --}}
                    <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-md">
                        <p class="font-medium text-gray-700">Nama Pasien: <span class="font-semibold">{{ $patient->name }}</span></p>
                        <p class="font-medium text-gray-700">Total Poin Saat Ini: 
                            <span class="font-bold text-lg text-emerald-600">{{ number_format($patient->total_loyalty_points, 0, ',', '.') }}</span> Poin
                        </p>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-md" role="alert">
                            <p class="font-bold">Sukses!</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-md" role="alert">
                            <p class="font-bold">Gagal!</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-md" role="alert">
                            <strong class="font-bold">Oops! Ada beberapa hal yang perlu diperbaiki:</strong>
                            <ul class="mt-1 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.patients.award_promo.store', $patient->id) }}">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <x-input-label for="promotion_id" :value="__('Pilih Program Promosi Aktif')" class="text-gray-700" />
                                @if($promotions->count() > 0)
                                    <select name="promotion_id" id="promotion_id" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" required>
                                        <option value="">-- Pilih Promosi --</option>
                                        @foreach ($promotions as $promotion)
                                            <option value="{{ $promotion->id }}" {{ old('promotion_id') == $promotion->id ? 'selected' : '' }}>
                                                {{ $promotion->title }} (Memberikan: {{ number_format($promotion->points_awarded, 0, ',', '.') }} Poin)
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <p class="mt-1 text-sm text-gray-600">
                                        Tidak ada program promosi aktif yang tersedia untuk diberikan.
                                    </p>
                                @endif
                                <x-input-error :messages="$errors->get('promotion_id')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                                <a href="{{ route('patients.show', $patient->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 border border-gray-300 rounded-lg font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150 mr-4">
                                    {{ __('Batal') }}
                                </a>
                                @if($promotions->count() > 0)
                                <x-primary-button>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 me-2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ __('Berikan Poin Promosi') }}
                                </x-primary-button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>