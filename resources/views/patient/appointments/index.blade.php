<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Janji Temu Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-md" role="alert">
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-2xl font-semibold text-gray-700">Riwayat dan Jadwal Anda</h3>
                <a href="{{ route('patient.appointments.create') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-emerald-500 active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 me-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Booking Janji Temu Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg"> {{-- Kartu utama: Hapus dark:bg-gray-800 --}}
                <div class="p-0 sm:p-2 text-gray-900"> {{-- Hapus dark:text-gray-100 --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-emerald-50"> {{-- Header tabel: Hapus dark:bg-gray-700/50 --}}
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-emerald-700 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-emerald-700 uppercase tracking-wider">
                                        Waktu
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-emerald-700 uppercase tracking-wider">
                                        Dokter
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-emerald-700 uppercase tracking-wider">
                                        Layanan/Keperluan
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-emerald-700 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200"> {{-- Body tabel: Hapus dark:bg-gray-800 dan dark:divide-gray-700 --}}
                                @forelse ($appointments as $appointment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $appointment->appointment_date ? $appointment->appointment_date->isoFormat('dddd, D MMMM YYYY') : '' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $appointment->start_time ? \Carbon\Carbon::parse($appointment->start_time)->format('H:i') : '' }}
                                            {{ $appointment->end_time ? ' - ' . \Carbon\Carbon::parse($appointment->end_time)->format('H:i') : '' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $appointment->doctor->name ?? 'Belum ditentukan' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-800 break-words">
                                            {{ $appointment->service_description ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($appointment->status == 'Selesai')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $appointment->status }}
                                                </span>
                                            @elseif($appointment->status == 'Dijadwalkan' || $appointment->status == 'Dikonfirmasi')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $appointment->status }}
                                                </span>
                                            @elseif(Str::contains($appointment->status, 'Dibatalkan'))
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    {{ $appointment->status }}
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    {{ $appointment->status }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                            Anda belum memiliki riwayat atau jadwal janji temu.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-6 border-t border-gray-200">
                        {{ $appointments->links() }}
                    </div>
                </div>
            </div>
             <div class="mt-8 text-center">
                <a href="{{ route('dashboard') }}" class="text-emerald-600 hover:text-emerald-800 underline font-medium">
                    &larr; {{ __('Kembali ke Dashboard') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>