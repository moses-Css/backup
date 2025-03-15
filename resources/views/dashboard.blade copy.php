<x-app-layout>
    <section class="">
        <x-slot name="header">
            <h2 class="font-semibold leading-tight mb-2">
                <span class="font-light">Halo, </span>{{ auth()->user()->name}}
            </h2>

            <x-head-hero>
                {{__('Partner Dashboard')}}
            </x-head-hero>

            <x-text-hero class="mb-8">
                {{__('Platform resmi untuk mengelola, menyimpan, dan mengakses foto
                    dokumentasi BKKBN dengan mudah, aman, dan terstruktur.')}}
            </x-text-hero>

            <div class="mb-8">
                <p class="text-sm text-neutralGray ">Kemudahan Pencarian</p>
                <livewire:search-form />
            </div>

            <div class="flex justify-center w-full space-x-4">
                <x-secondary-button href="route('profile')">
                    {{__('Tabel')}}
                </x-secondary-button>

                <x-dropdown>
                    <x-slot name="trigger">
                        <x-primary-button>
                            {{__('Tambah')}}

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </x-primary-button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="#" @click.prevent="$dispatch('open-modal', 'kategori-modal')">
                            {{__('Kategori')}}
                        </x-dropdown-link>
                        <x-dropdown-link href="{{route('photos.create')}}">
                            {{__('Foto')}}
                        </x-dropdown-link>
                        <x-dropdown-link href="route('profile)">
                            {{__('User Role')}}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
                <x-kategori-modal />
            </div>
        </x-slot>
    </section>


    <section class="flex flex-wrap gap-4 px-5 items-center justify-center mb-24">
        <x-statistik-card
            title="Total Foto"
            count="{{$totalImages}}">
            <x-icon name="images-square" />
        </x-statistik-card>

        <x-statistik-card title="Total Kategori" count="{{$totalCategories}}">
            <x-icon name="list-dashes" />
        </x-statistik-card>

        <x-statistik-card
            title="Total User"
            count="{{$totalUsers}}">
            <x-icon name="users" />
        </x-statistik-card>
    </section>
    <!-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div> -->

    <section class="max-w-7xl relative mx-auto px-5 md:px-10 py-16 h-fit mb-24  rounded-4xl shadow-md outline-double">
        <div class="flex w-full">
            <div class="absolute size-4 bg-primary top-6 left-6 rounded-full"></div>
            <div class="absolute size-4 bg-primary top-6 left-[52px] rounded-full"></div>
            <div class="absolute size-4 bg-primary top-6 left-20 rounded-full"></div>
        </div>
        <h2 class="text-2xl md:text-3xl font-medium text-neutral-dark mb-4">Log</h2>

        <!-- Search & Date Filter -->
        <div class="grid grid-cols-2 items-center space-x-5 mb-4 *:border-neutralGray2 text-neutralGray">
            <div class="relative w-full ">
                <input type="text" placeholder="Cari"
                    class="w-full border border-neutralGray2 p-3 pr-16 pl-5 rounded-full bg-white focus:outline-none">

                <button class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-primary p-2 rounded-full text-white flex items-center justify-center">
                    <x-icon name="magnifying-glass" />
                </button>
            </div>

            <div class="border py-2 px-2 md:px-5 rounded-full items-center flex">
                <input type="text" id="dateRange" class=" text-primary bg-transparent outline-none cursor-pointer w-full border-none focus:ring-0 active:outline-none" readonly>
                <x-icon name="calendar" />
            </div>
        </div>

        <!-- Tab Filters -->
        <div class="flex space-x-4 mb-4">
            <button class="text-primary font-medium">Semua</button>
            <button class="text-neutral-gray font-medium">Foto</button>
            <button class="text-neutral-gray font-medium">Kategori</button>
            <button class="text-neutral-gray font-medium">Log Login</button>
        </div>

        <!-- Log Table -->
        <div class="overflow-x-auto rounded-lg border border-neutral-gray">
            <table class="min-w-full">
                <thead class="">
                    <tr class="*: boder border-b-neutralGray2 text-neutralDark dark:text-secondary ">
                        <th class="px-4 py-3 text-left text-sm font-semibold">User</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Activity</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y ">
                    @foreach ($logs as $log)
                    <tr class="border-b-neutralGray2 hover:bg-gray-50 transition-colors">
                        <!-- Kolom User -->
                        <td class="px-4 py-3 text-sm text-neutral-dark align-top min-w-[200px]">
                            <div class="flex items-center space-x-3">
                                <span class="font-medium truncate">{{ $log->user->name }}</span>
                            </div>
                        </td>

                        <!-- Kolom Activity -->
                        <td class="px-4 py-3 text-sm text-neutral-dark align-top max-w-[300px]">
                            <div class="truncate">{{ $log->activity }}</div>
                        </td>

                        <!-- Kolom Tanggal -->
                        <td class="px-4 py-3 text-sm text-neutral-dark align-top whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i') }} WIB
                        </td>

                        <!-- Kolom Aksi -->
                        <td class="px-4 py-3 text-sm text-neutral-dark align-top">
                            <form action="{{ route('logs.delete', $log->id) }}" method="POST" onsubmit="return confirm('Hapus log ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2  rounded-full transition-colors bg-primaryLight">
                                    <x-icon name="trash" class="" />
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <form action="{{ route('logs.clear') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua log?')" class="text-center mt-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-xl hover:bg-primary/80 transition-colors duration-300">Hapus Semua Log</button>
        </form>
        {{ $logs->links() }}
    </section>

    <section class="mb-24 px-5">
        @livewire('kategori-tab')
        @livewire('galeri-grid')
    </section>
</x-app-layout>