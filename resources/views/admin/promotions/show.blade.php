<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Program Promosi') }}
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
                    <h3 class="text-2xl font-semibold text-emerald-700">{{ $promotion->title }}</h3>
                    @if($promotion->is_active)
                        <span class="mt-1 inline-block px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                    @else
                        <span class="mt-1 inline-block px-2 py-0.5 text-xs font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                    @endif
                </div>

                <div class="p-6 sm:p-8 text-gray-900 space-y-5">
                    <div>
                        <strong class="block font-medium text-sm text-gray-500">{{ __('Deskripsi:') }}</strong>
                        <p class="mt-1 text-gray-800 whitespace-pre-wrap">{{ $promotion->description ?? '-' }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                        <div>
                            <strong class="block font-medium text-sm text-gray-500">{{ __('Poin yang Diberikan:') }}</strong>
                            <p class="mt-1 text-gray-800 font-semibold text-emerald-600">{{ number_format($promotion->points_awarded, 0, ',', '.') }} Poin</p>
                        </div>
                        <div>
                            <strong class="block font-medium text-sm text-gray-500">{{ __('Kode Promo:') }}</strong>
                            <p class="mt-1 text-gray-800">{{ $promotion->promo_code ?? '-' }}</p>
                        </div>
                        <div>
                            <strong class="block font-medium text-sm text-gray-500">{{ __('Tanggal Mulai:') }}</strong>
                            <p class="mt-1 text-gray-800">{{ $promotion->start_date ? $promotion->start_date->isoFormat('dddd, D MMMM YYYY') : '-' }}</p>
                        </div>
                        <div>
                            <strong class="block font-medium text-sm text-gray-500">{{ __('Tanggal Selesai:') }}</strong>
                            <p class="mt-1 text-gray-800">{{ $promotion->end_date ? $promotion->end_date->isoFormat('dddd, D MMMM YYYY') : '-' }}</p>
                        </div>
                        <div>
                            <strong class="block font-medium text-sm text-gray-500">{{ __('Dibuat Oleh Staf:') }}</strong>
                            <p class="mt-1 text-gray-800">{{ $promotion->createdByStaff->name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <hr class="my-4 border-gray-200">

                    <div class="text-xs text-gray-500 space-y-1">
                        <p><strong>{{ __('Dibuat pada:') }}</strong> {{ $promotion->created_at ? $promotion->created_at->isoFormat('D MMMM YYYY, HH:mm:ss') : '-' }}</p>
                        <p><strong>{{ __('Terakhir diperbarui pada:') }}</strong> {{ $promotion->updated_at ? $promotion->updated_at->isoFormat('D MMMM YYYY, HH:mm:ss') : '-' }}</p>
                    </div>

                    <div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.promotions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 border border-gray-300 rounded-lg font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150 mr-4">
                            {{ __('Kembali ke Daftar') }}
                        </a>
                        <a href="{{ route('admin.promotions.edit', $promotion->id) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-500 active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
    {{ __('Edit Promosi Ini') }}
</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>