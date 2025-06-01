<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Data Pasien') }}
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
            @if (session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-md" role="alert">
                    <p class="font-bold">Gagal!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            {{-- Mengganti dark:bg-gray-800 menjadi bg-white dan dark:text-gray-100 menjadi text-gray-900 --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900">
                    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <h3 class="text-2xl font-semibold text-emerald-700 mb-4 sm:mb-0">Daftar Semua Pasien</h3>
                        <a href="{{ route('patients.create') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-emerald-500 active:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 me-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            {{ __('Tambah Pasien Baru') }}
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-emerald-50"> {{-- Menghapus dark:bg-gray-700/50 --}}
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-emerald-700 uppercase tracking-wider"> {{-- Menghapus dark:text-emerald-300 --}}
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-emerald-700 uppercase tracking-wider">
                                        No. Telepon
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-emerald-700 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-emerald-700 uppercase tracking-wider">
                                        Tipe Pasien
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-emerald-700 uppercase tracking-wider">
                                        Tgl Registrasi
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-emerald-700 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200"> {{-- Menghapus dark:bg-gray-800 dan dark:divide-gray-700 --}}
                                @forelse ($patients as $patient)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"> {{-- Menghapus dark:text-white --}}
                                            <a href="{{ route('patients.show', $patient->id) }}" class="text-emerald-600 hover:text-emerald-800 hover:underline">
                                                {{ $patient->name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"> {{-- Menghapus dark:text-gray-300 --}}
                                            {{ $patient->phone_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $patient->email ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $patient->patient_type ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $patient->registration_date ? \Carbon\Carbon::parse($patient->registration_date)->isoFormat('D MMM YY') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            <a href="{{ route('patients.edit', $patient->id) }}" class="text-emerald-600 hover:text-emerald-800 hover:underline">Edit</a>
                                            <form method="POST" action="{{ route('patients.destroy', $patient->id) }}" class="inline-block" onsubmit="return confirm('Anda yakin ingin menghapus data pasien \'{{ $patient->name }}\'? Tindakan ini tidak bisa dibatalkan.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 hover:underline">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500"> {{-- Menghapus dark:text-gray-300 --}}
                                            Belum ada data pasien.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-6 border-t border-gray-200"> {{-- Menghapus dark:border-gray-700 --}}
                        {{ $patients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>