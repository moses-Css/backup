<div class="p-6">
    <!-- Breadcrumb -->
    <nav class="text-gray-400 text-2xl mb-6">
        @foreach ($breadcrumbs ?? [] as $index => $breadcrumb)
        @if ($index > 0)
        <span class="mx-2">›</span>
        @endif
        @if ($breadcrumb['type'] === 'kategori')
        <span class="text-black font-semibold">{{ $breadcrumb['name'] }}</span>
        @else
        <span class="text-blue-500 cursor-pointer" wire:click="{{ $breadcrumb['type'] === 'category' ? "selectCategory({$breadcrumb['id']})" : "selectGroup({$breadcrumb['id']})" }}">
            {{ $breadcrumb['name'] }}
        </span>
        @endif
        @endforeach
    </nav>

    <!-- Tampilkan Kategori atau Group atau Gambar -->
    @if (!$currentCategory)
    <div class="grid grid-cols-3 gap-4">
        @foreach ($kategories as $kategori)
        <div class="p-4 bg-gray-200 rounded-lg cursor-pointer" wire:click="selectCategory({{ $kategori->id }})">
            <img src="{{ optional($kategori->groups->first()->photos->first()->images->first())->path ?? 'https://source.unsplash.com/50x50/?abstract' }}" class="w-10 h-10 rounded-md object-cover">
            <span class="block mt-2 text-gray-800 font-medium">{{ $kategori->nama }}</span>
        </div>
        @endforeach
    </div>
    @elseif (!$currentGroup)
    <div class="grid grid-cols-3 gap-4">
        @foreach ($groups as $group)
        <div class="p-4 bg-gray-200 rounded-lg cursor-pointer" wire:click="selectGroup({{ $group->id }})">
            <img src="{{ optional($group->photos->first()->images->first())->path ?? 'https://source.unsplash.com/50x50/?nature' }}" class="w-10 h-10 rounded-md object-cover">
            <span class="block mt-2 text-gray-800 font-medium">{{ $group->title }}</span>
        </div>
        @endforeach
    </div>
    @else
    <div class="grid grid-cols-3 gap-4">
        @foreach ($images as $image)
        <img src="{{ asset('storage/' . $image->path) }}" class="w-full h-auto rounded-lg">
        @endforeach
    </div>
    @endif
</div>