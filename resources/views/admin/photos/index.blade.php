@extends('layouts.main')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Photos</h1>
    <a href="{{route ('photos.create')}}">Create</a>
    <!-- Button untuk memilih semua foto -->
    <div class="mb-4">
        <button id="select-all" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Select All</button>
        <form id="bulk-delete-form" action="{{ route('photos.bulkDelete') }}" method="POST" class="inline-block ml-4">
            @csrf
            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600" disabled id="bulk-delete-btn">Delete Selected</button>
        </form>
    </div>
    @livewire('kategori-tab')
    @livewire('galeri-grid')

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($photos as $photo)
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            @if($photo->images->isNotEmpty())
            <img src="{{ asset('storage/' . $photo->images->first()->path) }}" class="w-full h-64 object-cover" alt="{{ $photo->title }}">
            @else
            <img src="{{ asset('storage/default-image.jpg') }}" class="w-full h-64 object-cover" alt="No image available">
            @endif

            <div class="p-4">
                <h5 class="text-lg font-semibold">{{ $photo->title }}</h5>
                <p class="text-sm text-gray-500 mt-2">{{ $photo->deskripsi }}</p>
                <p class="text-sm text-gray-600 mt-2">
                <strong>Category:</strong> {{ $photo->group ? $photo->group->kategori->nama ?? 'Uncategorized' : 'Uncategorized' }}
                </p>
                <p class="text-xs text-gray-400 mt-1">{{ $photo->tanggal }}</p>

                <!-- Checkbox untuk memilih foto -->
                <div class="mt-4">
                    <input type="checkbox" class="photo-checkbox" name="photos[]" value="{{ $photo->id }}">
                </div>

                <div class="flex justify-between mt-4">
                    <!-- Edit Button -->
                    <a href="{{ route('photos.edit', $photo->id) }}" class="bg-yellow-500 text-white py-1 px-4 rounded-lg hover:bg-yellow-600">Edit</a>

                    <!-- Delete Button -->
                    <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this photo?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white py-1 px-4 rounded-lg hover:bg-red-600">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    document.getElementById('bulk-delete-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const selectedPhotos = Array.from(document.querySelectorAll('.photo-checkbox:checked'))
            .map(checkbox => checkbox.value);

        // Clear existing hidden inputs
        const existingInputs = this.querySelectorAll('input[name="photos[]"]');
        existingInputs.forEach(input => input.remove());

        // Add new hidden inputs
        selectedPhotos.forEach(photoId => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'photos[]';
            input.value = photoId;
            this.appendChild(input);
        });

        this.submit();
    });

    // Fungsi untuk memilih semua foto
    document.getElementById('select-all').addEventListener('click', function() {
        let checkboxes = document.querySelectorAll('.photo-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = !checkbox.checked);
        updateBulkDeleteButton();
    });

    // Update tombol bulk delete
    function updateBulkDeleteButton() {
        const checked = document.querySelectorAll('.photo-checkbox:checked').length > 0;
        document.getElementById('bulk-delete-btn').disabled = !checked;
    }

    document.querySelectorAll('.photo-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkDeleteButton);
    });
</script>
@endsection