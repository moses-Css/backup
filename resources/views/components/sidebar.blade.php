<aside id="sidebar" class="h-screen w-64 p-6 fixed flex flex-col transition-transform -translate-x-full sm:translate-x-0 border-r z-40 bg-secondary">
    <!-- <div id="profile" class="flex items-center gap-3 transition-opacity duration-300 mb-4">
        <img class="max-w-44 items-center mx-auto flex justify-center" src="{{ asset('build/assets/logo/logoapp.png') }}" alt="Logo">
    </div> -->

    <x-dropdown>
        <x-slot name="trigger">
            <button class="relative px-6 py-3 min-w-[100px] border-2 border-primary/50 outline-none bg-primary rounded-full
    shadow-[inset_-3px_-15px_20px_#005ED1,inset_-3px_-10px_10px_#005ED1,inset_-10px_0px_15px_#005ED1] 
    transition-all duration-300 ease-in-out will-change-transform transform-gpu 
    hover:scale-[1.05] hover:shadow-[inset_-3px_-15px_20px_#005ED1,inset_-3px_-10px_10px_#005ED1,inset_-10px_0px_15px_#005ED1,5px_15px_15px_#005ED1] 
    active:scale-[0.98] active:shadow-none flex items-center justify-center gap-2 ">
                <span class="text-secondary font-semibold">Tambah</span>
                <svg class="w-5 h-5 fill-secondary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>


        </x-slot>

        <x-slot name="content">
            <x-dropdown-link href="#" @click.prevent="$dispatch('open-modal', 'kategori-modal')">
                {{__('Kategori')}}
            </x-dropdown-link>
            <x-dropdown-link href="foto" @click.prevent="$dispatch('open-modal', 'foto-modal')">
                {{__('Foto')}}
            </x-dropdown-link>
            <x-dropdown-link href="route('profile)">
                {{__('User Role')}}
            </x-dropdown-link>
        </x-slot>
    </x-dropdown>
    <!-- Menu -->
    <nav class="space-y-1 flex-1">
        <h3 class="text-xs tracking-wide font-medium text-neutralGray mt-5">Menu</h3>
        <div class="border-l pr-2">
            <x-sidebar-link icon="home" route="home" :href="route('welcome')" wire:navigate> {{ __('Beranda') }} </x-sidebar-link>
            <x-sidebar-link :href="route('dashboard')" wire:navigate icon="dashboard" route="dashboard"> {{ __('Dashboard') }} </x-sidebar-link>
            <x-sidebar-link icon="log" route="log"> Log </x-sidebar-link>
            <x-sidebar-link icon="wrench" route="manage-user"> Manage User </x-sidebar-link>
        </div>

        <!-- <h3 class="text-xs tracking-wide font-medium text-neutralGray pt-6">Tambah</h3>
        <div class="border-l pr-2">
            <x-sidebar-link icon="images-square" route="photo"> Foto </x-sidebar-link>
            <x-sidebar-link
                icon="stack"
                route="kategori"
                iconClass="fill-neutralDark"
                @click.prevent="window.dispatchEvent(new CustomEvent('open-modal'))">
                Kategori
            </x-sidebar-link>

            <x-sidebar-link icon="users" route="user-role"> User Role </x-sidebar-link>
        </div> -->
    </nav>

    <!-- Bottom Section -->
    <div class="mt-auto flex-row items-center my-auto space-y-4  ">

        <div class="flex md:hidden items-center justify-between w-full rounded-md p-2 border hover:bg-gray-100 transition cursor-pointer">
            <!-- Avatar -->
            <div class="flex space-x-4 items-center">
                <div class="size-10 bg-gradient-to-r from-primary to-sky-400 rounded-full"></div>
                <div class="flex flex-col">
                    <h1 class="font-semibold">{{ Auth()->user()->name }}</h1>
                    <p class="text-xs text-neutralGray">ASD</p>
                </div>
            </div>

            <!-- Caret Icon (Selalu di pojok kanan) -->
            <x-icon name="caret-right" class="text-neutralGray group-hover:text-neutralDark transition" />
        </div>

    </div>
</aside>