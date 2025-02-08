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


    <section class="flex flex-wrap gap-4 px-10 items-center justify-center mb-4">
        <x-statistik-card
            title="Total Foto"
            count="2191"
            icon='<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#0672E8" viewBox="0 0 256 256">
                    <path
                        d="M208,34H80A14,14,0,0,0,66,48V66H48A14,14,0,0,0,34,80V208a14,14,0,0,0,14,14H176a14,14,0,0,0,14-14V190h18a14,14,0,0,0,14-14V48A14,14,0,0,0,208,34ZM78,48a2,2,0,0,1,2-2H208a2,2,0,0,1,2,2v74.2l-20.1-20.1a14,14,0,0,0-19.8,0L94.2,178H80a2,2,0,0,1-2-2ZM178,208a2,2,0,0,1-2,2H48a2,2,0,0,1-2-2V80a2,2,0,0,1,2-2H66v98a14,14,0,0,0,14,14h98Zm30-30H111.17l67.41-67.41a2,2,0,0,1,2.83,0L210,139.17V176A2,2,0,0,1,208,178Zm-88-68A22,22,0,1,0,98,88,22,22,0,0,0,120,110Zm0-32a10,10,0,1,1-10,10A10,10,0,0,1,120,78Z">
                    </path>
                </svg>'>
        </x-statistik-card>

        <x-statistik-card
            title="Total Kategori"
            count="2191"
            icon='<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#0672E8" viewBox="0 0 256 256">
                    <path
                        d="M208,34H80A14,14,0,0,0,66,48V66H48A14,14,0,0,0,34,80V208a14,14,0,0,0,14,14H176a14,14,0,0,0,14-14V190h18a14,14,0,0,0,14-14V48A14,14,0,0,0,208,34ZM78,48a2,2,0,0,1,2-2H208a2,2,0,0,1,2,2v74.2l-20.1-20.1a14,14,0,0,0-19.8,0L94.2,178H80a2,2,0,0,1-2-2ZM178,208a2,2,0,0,1-2,2H48a2,2,0,0,1-2-2V80a2,2,0,0,1,2-2H66v98a14,14,0,0,0,14,14h98Zm30-30H111.17l67.41-67.41a2,2,0,0,1,2.83,0L210,139.17V176A2,2,0,0,1,208,178Zm-88-68A22,22,0,1,0,98,88,22,22,0,0,0,120,110Zm0-32a10,10,0,1,1-10,10A10,10,0,0,1,120,78Z">
                    </path>
                </svg>'>
        </x-statistik-card>

        <x-statistik-card
            title="Total User"
            count="2191"
            icon='<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#0672E8" viewBox="0 0 256 256">
                    <path
                        d="M208,34H80A14,14,0,0,0,66,48V66H48A14,14,0,0,0,34,80V208a14,14,0,0,0,14,14H176a14,14,0,0,0,14-14V190h18a14,14,0,0,0,14-14V48A14,14,0,0,0,208,34ZM78,48a2,2,0,0,1,2-2H208a2,2,0,0,1,2,2v74.2l-20.1-20.1a14,14,0,0,0-19.8,0L94.2,178H80a2,2,0,0,1-2-2ZM178,208a2,2,0,0,1-2,2H48a2,2,0,0,1-2-2V80a2,2,0,0,1,2-2H66v98a14,14,0,0,0,14,14h98Zm30-30H111.17l67.41-67.41a2,2,0,0,1,2.83,0L210,139.17V176A2,2,0,0,1,208,178Zm-88-68A22,22,0,1,0,98,88,22,22,0,0,0,120,110Zm0-32a10,10,0,1,1-10,10A10,10,0,0,1,120,78Z">
                    </path>
                </svg>'>
        </x-statistik-card>
    </section>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>