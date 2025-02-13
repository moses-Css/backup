<div class="mx-auto">
    <div class="flex justify-center text-neutralDark items-center mb-4">
        <h2 class="text-lg md:text-3xl font-medium">Kategori</h2>
    </div>

    <div class="flex space-x-2 overflow-x-auto whitespace-nowrap *:rounded-full *:px-4 *:py-3 text-xs md:text-sm sm:justify-center">
        <button
            wire:click="filterCategory('all')"
            class="{{ $activeCategory === 'all' ? 'bg-primaryLight text-primary' : 'text-neutralGray' }}">
            All
        </button>
        @foreach($categories as $category)
        <button wire:click="filterCategory('{{ $category->id }}')"
            class="tab-btn {{ $activeCategory == $category->id ? 'bg-primaryLight text-primary' : 'text-neutralGray' }}">
            {{ ucfirst($category->nama) }}
        </button>
        @endforeach
    </div>
</div>