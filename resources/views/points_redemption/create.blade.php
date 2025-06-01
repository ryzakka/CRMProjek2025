<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proses Penukaran Poin Loyalitas Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8"> {{-- max-w-3xl agar form tidak terlalu lebar --}}

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8 border-b border-gray-200">
                    <h3 class="text-2xl font-semibold text-emerald-700">Penukaran Poin untuk: {{ $patient->name }}</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Pilih reward yang akan ditukarkan oleh pasien.
                    </p>
                </div>

                <div class="p-6 sm:p-8 text-gray-900">
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

                    <form method="POST" action="{{ route('points.redeem.store', $patient->id) }}">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <x-input-label for="reward_id" :value="__('Pilih Reward untuk Ditukarkan')" class="text-gray-700" />
                                @if($rewards->count() > 0)
                                    <select name="reward_id" id="reward_id" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" required>
                                        <option value="">-- Pilih Reward --</option>
                                        @foreach ($rewards as $reward)
                                            <option value="{{ $reward->id }}" {{ old('reward_id') == $reward->id ? 'selected' : '' }}>
                                                {{ $reward->name }} (Butuh: {{ number_format($reward->points_required, 0, ',', '.') }} Poin)
                                                @if($reward->type == 'DISCOUNT_PERCENTAGE')
                                                    - Diskon {{ (float)$reward->value }}%
                                                @elseif($reward->type == 'DISCOUNT_FIXED_AMOUNT')
                                                    - Diskon Rp {{ number_format($reward->value, 0, ',', '.') }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <p class="mt-1 text-sm text-gray-600">
                                        Pasien ini belum memiliki poin yang cukup untuk menukarkan reward yang tersedia, atau tidak ada reward aktif yang poinnya mencukupi.
                                    </p>
                                @endif
                                <x-input-error :messages="$errors->get('reward_id')" class="mt-2" />
                            </div>

                            {{-- Anda bisa menambahkan field catatan untuk staf di sini jika perlu --}}

                            <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                                <a href="{{ route('patients.show', $patient->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 border border-gray-300 rounded-lg font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150 mr-4">
                                    {{ __('Batal') }}
                                </a>
                                @if($rewards->count() > 0)
                                <x-primary-button>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 me-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-4.5A3.375 3.375 0 0012.75 9.75H11.25A3.375 3.375 0 007.5 13.125V18.75m3.75 0h1.5M12 12.75h.008v.008H12v-.008z" />
                                    </svg>
                                    {{ __('Proses Penukaran') }}
                                </x-primary-button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
             <div class="mt-8 text-center">
                <a href="{{ route('admin.promotions.index') }}" class="text-emerald-600 hover:text-emerald-800 underline font-medium">
                    Lihat Program Promosi (untuk poin tambahan)
                </a>
            </div>
        </div>
    </div>
</x-app-layout>