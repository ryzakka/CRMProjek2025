<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8"> {{-- Tambahkan space-y-8 untuk jarak antar kartu --}}

            {{-- Kartu untuk Update Informasi Profil --}}
            <div class="p-4 sm:p-8 bg-white shadow-xl sm:rounded-xl"> {{-- Style kartu fantastis --}}
                <div class="max-w-xl"> {{-- Batasi lebar konten form --}}
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Kartu untuk Update Password --}}
            <div class="p-4 sm:p-8 bg-white shadow-xl sm:rounded-xl"> {{-- Style kartu fantastis --}}
                <div class="max-w-xl"> {{-- Batasi lebar konten form --}}
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Kartu untuk Hapus Akun --}}
            <div class="p-4 sm:p-8 bg-white shadow-xl sm:rounded-xl"> {{-- Style kartu fantastis --}}
                <div class="max-w-xl"> {{-- Batasi lebar konten form --}}
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>