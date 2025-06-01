<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Transaksi Poin Loyalitas Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Kartu Info Pasien dan Poin (sudah bagus dengan gradient hijau) --}}
            <div class="mb-8 bg-gradient-to-r from-emerald-500 to-green-500 text-white p-6 sm:p-8 rounded-xl shadow-xl">
                <h3 class="text-xl font-medium">Pasien: {{ $patientProfile->name }}</h3>
                <p class="text-4xl sm:text-5xl font-bold mt-2">
                    {{ number_format($patientProfile->total_loyalty_points, 0, ',', '.') }}
                    <span class="text-2xl font-medium">Poin</span>
                </p>
                <p class="mt-1 text-emerald-100">Total poin loyalitas Anda saat ini.</p>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg"> {{-- Hapus dark:bg-gray-800 --}}
                <div class="p-6 sm:p-8 text-gray-900"> {{-- Hapus dark:text-gray-100 --}}
                    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <h3 class="text-2xl font-semibold text-emerald-700 mb-4 sm:mb-0">Detail Semua Transaksi Poin Anda</h3>
                         <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 border border-transparent rounded-lg font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition ease-in-out duration-150">
                            &larr; {{ __('Kembali ke Dashboard') }}
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-emerald-50"> {{-- Header tabel: Hapus dark:bg-gray-700/50 --}}
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-emerald-700 uppercase tracking-wider">
                                        Tanggal & Waktu
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-emerald-700 uppercase tracking-wider">
                                        Deskripsi Transaksi
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-emerald-700 uppercase tracking-wider">
                                        Jumlah Poin
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-emerald-700 uppercase tracking-wider">
                                        Ref. Janji Temu
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-emerald-700 uppercase tracking-wider">
                                        Ref. Promosi
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-emerald-700 uppercase tracking-wider">
                                        Diproses Oleh (Staf)
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200"> {{-- Hapus dark:bg-gray-800 dan dark:divide-gray-700 --}}
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $transaction->transaction_date ? $transaction->transaction_date->isoFormat('D MMM YY, HH:mm') : ($transaction->created_at ? $transaction->created_at->isoFormat('D MMM YY, HH:mm') : '-') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-800 break-words">
                                            {{ $transaction->description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold 
                                            @if($transaction->points > 0) text-green-600 
                                            @elseif($transaction->points < 0) text-red-600
                                            @else text-gray-500 @endif">
                                            {{ $transaction->points >= 0 ? '+' : '' }}{{ number_format($transaction->points, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            @if($transaction->appointment_id && $transaction->appointment)
                                                <a href="{{ route('patient.appointments.index') }}#appointment-{{ $transaction->appointment_id }}"
                                                   class="text-emerald-600 hover:underline"
                                                   title="{{ $transaction->appointment->service_description ?? 'Janji Temu' }} pada {{ $transaction->appointment->appointment_date->isoFormat('D MMM YY') }}">
                                                    #{{ $transaction->appointment_id }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            @if($transaction->promotion_id && $transaction->promotion)
                                                 <span title="{{ $transaction->promotion->description ?? $transaction->promotion->title }}">
                                                    {{ $transaction->promotion->title }}
                                                 </span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $transaction->staff->name ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                            Anda belum memiliki riwayat transaksi poin.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-6 border-t border-gray-200">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>