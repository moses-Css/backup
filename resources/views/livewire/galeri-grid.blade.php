<div class="columns-2 sm:columns-3 md:columns-4 lg:columns-5 xl:columns-6 gap-4 pt-4 *:rounded-xl">
    @foreach($filteredItems as $item)
        <div class="category-item break-inside-avoid mb-4">
            <img src="{{ $item['image'] }}" class="w-full rounded-lg">
            <div class="text-container text-start">
                <h1 class="font-medium text-xl mt-2">{{ $item['title'] }}</h1>
                <p class="text-gray-600">{{ $item['description'] }}</p>
            </div>
        </div>
    @endforeach
</div>