<nav x-data="{ open: false }" class="bg-white border-b border-emerald-200"> {{-- Border sudah emerald --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <div class="flex items-center">
                            <svg class="h-8 w-auto text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                            </svg>
                            <span class="ms-2 font-semibold text-xl text-emerald-700">Klinik Sehat</span>
                        </div>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if (Auth::user() && Auth::user()->role !== 'patient')
                        <x-nav-link :href="route('patients.index')" :active="request()->routeIs('patients.*')">
                            {{ __('Pasien') }}
                        </x-nav-link>
                        <x-nav-link :href="route('appointments.index')" :active="request()->routeIs('appointments.*') && !request()->routeIs('patient.appointments.*')">
                            {{ __('Janji Temu (Staf)') }}
                        </x-nav-link>
                        <x-nav-link :href="route('feedbacks.index')" :active="request()->routeIs('feedbacks.*')">
                            {{ __('Umpan Balik') }}
                        </x-nav-link>
                        <x-nav-link :href="route('rewards.index')" :active="request()->routeIs('rewards.*') && !request()->routeIs('patient.rewards.*')">
                            {{ __('Rewards (Staf)') }}
                        </x-nav-link>
                        <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')">
                            {{ __('Laporan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.promotions.index')" :active="request()->routeIs('admin.promotions.*')">
                            {{ __('Program Promosi') }}
                        </x-nav-link>
                    @elseif (Auth::user() && Auth::user()->role === 'patient')
                        <x-nav-link :href="route('patient.appointments.index')" :active="request()->routeIs('patient.appointments.index')">
                            {{ __('Janji Temu Saya') }} 
                        </x-nav-link>
                        <x-nav-link :href="route('patient.appointments.create')" :active="request()->routeIs('patient.appointments.create')">
                            {{ __('Booking Baru') }}
                        </x-nav-link>
                        <x-nav-link :href="route('patient.loyalty.history')" :active="request()->routeIs('patient.loyalty.history')">
                            {{ __('Riwayat Poin Saya') }}
                        </x-nav-link>
                        <x-nav-link :href="route('patient.rewards.index')" :active="request()->routeIs('patient.rewards.index')">
                            {{ __('Katalog Reward') }}
                        </x-nav-link>
                        <x-nav-link :href="route('patient.doctors.index')" :active="request()->routeIs('patient.doctors.index')">
                            {{ __('Daftar Dokter') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        {{-- PERUBAHAN DI BUTTON INI --}}
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 bg-white hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        @auth 
        <div class="pt-2 pb-3 space-y-1">
            {{-- ... Link-link responsif yang sudah ada ... --}}
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if (Auth::user()->role !== 'patient')
                <x-responsive-nav-link :href="route('patients.index')" :active="request()->routeIs('patients.*')">
                    {{ __('Pasien') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('appointments.index')" :active="request()->routeIs('appointments.*') && !request()->routeIs('patient.appointments.*')">
                    {{ __('Janji Temu (Staf)') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('feedbacks.index')" :active="request()->routeIs('feedbacks.*')">
                    {{ __('Umpan Balik') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('rewards.index')" :active="request()->routeIs('rewards.*') && !request()->routeIs('patient.rewards.*')">
                    {{ __('Rewards (Staf)') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.index')">
                    {{ __('Laporan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.promotions.index')" :active="request()->routeIs('admin.promotions.*')">
                    {{ __('Program Promosi') }}
                </x-responsive-nav-link>
            @elseif (Auth::user()->role === 'patient')
                <x-responsive-nav-link :href="route('patient.appointments.index')" :active="request()->routeIs('patient.appointments.index')">
                    {{ __('Janji Temu Saya') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('patient.appointments.create')" :active="request()->routeIs('patient.appointments.create')">
                    {{ __('Booking Baru') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('patient.loyalty.history')" :active="request()->routeIs('patient.loyalty.history')">
                    {{ __('Riwayat Poin Saya') }}
                </x-responsive-nav-link>
                 <x-responsive-nav-link :href="route('patient.rewards.index')" :active="request()->routeIs('patient.rewards.index')">
                    {{ __('Katalog Reward') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('patient.doctors.index')" :active="request()->routeIs('patient.doctors.index')">
                    {{ __('Daftar Dokter') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>