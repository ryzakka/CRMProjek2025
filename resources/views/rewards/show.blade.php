<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Reward: ') }} {{ $reward->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8"> {{-- max-w-3xl agar tidak terlalu lebar --}}
            
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-md" role="alert">
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start">
                        <h3 class="text-2xl font-semibold text-emerald-700 mb-2 sm:mb-0">{{ $reward->name }}</h3>
                        <div>
                            @if($reward->is_active)
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                            @endif
                        </div>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">{{ $reward->description ?? 'Tidak ada deskripsi tambahan.' }}</p>
                </div>

                <div class="p-6 sm:p-8 text-gray-900 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                        <div>
                            <strong class="block font-medium text-sm text-gray-500">{{ __('Poin Dibutuhkan:') }}</strong>
                            <p class="mt-1 text-gray-800 font-semibold text-emerald-600">{{ number_format($reward->points_required, 0, ',', '.') }} Poin</p>
                        </div>
                        <div>
                            <strong class="block font-medium text-sm text-gray-500">{{ __('Tipe Reward:') }}</strong>
                            <p class="mt-1 text-gray-800">{{ $reward->type }}</p>
                        </div>
                        @if(in_array($reward->type, ['DISCOUNT_PERCENTAGE', 'DISCOUNT_FIXED_AMOUNT']))
                        <div>
                            <strong class="block font-medium text-sm text-gray-500">{{ __('Nilai:') }}</strong>
                            <p class="mt-1 text-gray-800">
                                @if($reward->type == 'DISCOUNT_PERCENTAGE')
                                    Diskon {{ (float)$reward->value }}%
                                @elseif($reward->type == 'DISCOUNT_FIXED_AMOUNT')
                                    Diskon Rp {{ number_format($reward->value, 0, ',', '.') }}
                                @endif
                            </p>
                        </div>
                        @endif
                        <div>
                            <strong class="block font-medium text-sm text-gray-500">{{ __('Kuantitas Tersedia:') }}</strong>
                            <p class="mt-1 text-gray-800">{{ is_null($reward->quantity_available) ? 'Tidak Terbatas' : number_format($reward->quantity_available, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <strong class="block font-medium text-sm text-gray-500">{{ __('Berlaku Mulai:') }}</strong>
                            <p class="mt-1 text-gray-800">{{ $reward->start_date ? $reward->start_date->isoFormat('dddd, D MMMM YYYY') : '-' }}</p>
                        </div>
                        <div>
                            <strong class="block font-medium text-sm text-gray-500">{{ __('Berlaku Hingga:') }}</strong>
                            <p class="mt-1 text-gray-800">{{ $reward->valid_until ? $reward->valid_until->isoFormat('dddd, D MMMM YYYY') : 'Selamanya' }}</p>
                        </div>
                    </div>
                    
                    <hr class="my-4 border-gray-200">

                    <div class="text-xs text-gray-500 space-y-1">
                        {{-- Jika Anda menambahkan relasi createdByStaff di model Reward --}}
                        {{-- @if($reward->createdByStaff)
                        <p><strong>{{ __('Dibuat Oleh Staf:') }}</strong> {{ $reward->createdByStaff->name }}</p>
                        @endif --}}
                        <p><strong>{{ __('Dibuat pada:') }}</strong> {{ $reward->created_at ? $reward->created_at->isoFormat('D MMMM YYYY, HH:mm:ss') : '-' }}</p>
                        <p><strong>{{ __('Terakhir diperbarui pada:') }}</strong> {{ $reward->updated_at ? $reward->updated_at->isoFormat('D MMMM YYYY, HH:mm:ss') : '-' }}</p>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200 flex flex-wrap justify-start gap-3">
                        <a href="{{ route('rewards.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 border border-gray-300 rounded-lg font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150">
                            {{ __('Kembali ke Daftar Reward') }}
                        </a>
                        <x-primary-button-link href="{{ route('rewards.edit', $reward->id) }}">
                            {{ __('Edit Reward Ini') }}
                        </x-primary-button-link>
                         <form method="POST" action="{{ route('rewards.destroy', $reward->id) }}" class="inline-block" onsubmit="return confirm('Anda yakin ingin menghapus reward \'{{ $reward->name }}\'?');">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit">
                                {{ __('Hapus Reward Ini') }}
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>