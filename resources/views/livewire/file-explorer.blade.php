<div>

    <div>
        Current Type: {{ $currentType }} <br>
        Count Items: {{ $items->count() }}
    </div>

    <!-- Breadcrumb -->
    <nav class="text-gray-400 text-4xl mb-12 flex items-center">
        @foreach($breadcrumbs as $index => $crumb)
        <span
            wire:click="goToBreadcrumb({{ $index }})"
            class="cursor-pointer {{ $index === count($breadcrumbs)-1 ? 'text-black font-semibold' : 'hover:text-gray-600' }} capitalize">
            {{ $crumb['name'] }}
        </span>
        @if(!$loop->last)
        <span class="mx-4">›</span>
        @endif
        @endforeach
    </nav>

    <!-- Selection-container -->
    @if(count($selectedItems) > 0)
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t p-4 shadow-lg z-50">
        <div class="flex items-center justify-between max-w-6xl mx-auto">
            <div class="flex items-center space-x-4">
                <span class="font-medium">
                    {{ count($selectedItems) }} Selected
                </span>
                <button
                    wire:click="unselectAll"
                    class="p-2 hover:bg-gray-100 rounded-full">
                    ✕ Clear
                </button>
                <button
                    wire:click="deleteSelectedItems"
                    class="flex items-center space-x-2 text-red-600 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Delete</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Content -->
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 w-full">
        @if($currentType === 'kategori')
        @foreach($items as $kategori)
        <div
            wire:click.debounce.100ms="selectItem({{ $kategori->id }})"
            wire:dblclick.debounce.100ms="navigateTo('kategori', {{ $kategori->id }})"
            class="group flex p-4 border rounded-lg hover:border-blue-200 cursor-pointer transition-colors select-none
            {{ in_array($kategori->id, $selectedItems) ? 'bg-blue-50 border-blue-300 select-none' : 'bg-white' }}">

            <div class="flex items-center space-x-3 overflow-hidden w-full">
                <div class="text-xl rounded-lg flex items-center justify-center">
                    📁
                </div>


                <!-- Tambahkan max-w-full dan flex-1 agar tidak mendorong tombol -->
                <span class="text-neutralDark font-medium truncate flex-1 max-w-[80%]">{{ $kategori->nama }}</span>
            </div>

            <!-- Pastikan tombol tidak terdorong -->
            <x-dropdown>
                <x-slot name="trigger">
                    <button class=" hover:text-gray-700 flex-shrink-0 hover:bg-neutralGray2 py-1 px-3 rounded-full duration-200">
                        <span class="text-neutralGray font-semibold">&#8942;</span>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <button
                        type="button"
                        wire:click.prevent="$dispatch('confirm-delete', { id: {{ $kategori->id }} })"
                        @click.stop
                        class="flex items-center space-x-2 text-red-600 hover:text-red-700 p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Delete</span>
                    </button>
                </x-slot>
            </x-dropdown>
        </div>

        @endforeach

        @elseif($currentType === 'group')
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 w-full">
            @foreach($items as $group)
            @php
            // Hitung total images dalam grup
            $totalImages = $group->photos->sum(fn($photo) => $photo->images->count());
            $firstImage = $group->photos->first()?->images->first();
            @endphp

            @if($totalImages === 1 && $firstImage)
            {{-- Tampilkan sebagai image langsung --}}
            <div class="relative aspect-square cursor-pointer"
                x-data
                @click.prevent="if ($event.detail === 1) { 
                $wire.selectItem({{ $group->id }}, $event.shiftKey) 
            }"
                @dblclick.prevent="$wire.previewImage({{ $firstImage->id }})">

                <img src="{{ Storage::url($firstImage->path) }}"
                    class="w-full h-full object-cover rounded-lg border shadow-sm 
                        {{ in_array($group->id, $selectedItems) ? 'ring-2 ring-blue-500' : '' }}">
            </div>
            @else
            {{-- Tampilkan sebagai card grup --}}
            <div
                class="flex flex-col border rounded-lg hover:border-blue-200 cursor-pointer 
                   {{ in_array($group->id, $selectedItems) ? 'bg-blue-50 border-blue-300' : 'bg-white' }}"
                x-data
                @click.prevent="if ($event.detail === 1) { 
                $wire.selectItem({{ $group->id }}, $event.shiftKey) 
            }"
                @dblclick.prevent="$wire.navigateTo('group', {{ $group->id }})">

                <div class="aspect-square overflow-hidden">
                    <img src="{{ $firstImage ? Storage::url($firstImage->path) : 'https://source.unsplash.com/400x400/?abstract' }}"
                        class="w-full h-full object-cover">
                </div>

                <div class="p-2 border-t">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium truncate">{{ $group->title }}</span>
                        <span class="text-xs text-gray-500">
                            {{ $totalImages }} {{ str('image')->plural($totalImages) }}
                        </span>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>


        @elseif($currentType === 'image')
        <div class="grid grid-cols-3 gap-4">
            @foreach($items as $image)
            <div
                wire:key="image-{{ $image->id }}"
                x-data
                @click.prevent="if ($event.detail === 1) { 
            $wire.selectItem({{ $image->id }}, $event.shiftKey) 
        }"
                class="relative aspect-square cursor-pointer {{ in_array($image->id, $selectedItems) ? 'ring-2 ring-blue-500' : '' }}">
                <img
                    loading="lazy"
                    src="{{ Storage::url($image->path) }}"
                    class="w-full h-full object-cover rounded-lg shadow-sm border bg-gray-100"
                    @if($loop->first) wire:init.preload @endif>
            </div>
            @endforeach
        </div>
        @endif


        <script>
            document.addEventListener('alpine:init', () => {
                // Tangkap event keyboard global
                const handleKeyEvent = (e) => {
                    if (e.key === 'Shift' || e.key === 'Control' || e.key === 'Meta') {
                        Livewire.dispatch('key' + e.type, {
                            key: e.key
                        })
                    }
                }

                window.addEventListener('keydown', handleKeyEvent)
                window.addEventListener('keyup', handleKeyEvent)
            })
        </script>
    </div>