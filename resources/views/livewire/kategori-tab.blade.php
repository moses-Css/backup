<div class="mx-auto">
    <div class="flex justify-center text-neutralDark items-center mb-4">
        <h2 class="text-lg font-medium">Kategori</h2>
    </div>
    
    <div class="flex space-x-2 overflow-x-auto whitespace-nowrap *:rounded-full *:px-4 *:py-3 text-xs sm:justify-center">
        @foreach($categories as $category)
            <button wire:click="filterCategory('{{ $category }}')"
                    class="tab-btn {{ $activeCategory === $category ? 'bg-primaryLight text-blue-600' : 'text-gray-600' }}">
                {{ ucfirst($category) }}
            </button>
        @endforeach
    </div>
</div>
