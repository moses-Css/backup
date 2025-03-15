@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    @if(isset($type))
        @if($type === 'category')
            <h1 class="text-2xl font-bold mb-6">Kategori: {{ $kategori->nama }}</h1>
            @forelse($groups as $group)
                <div class="mb-8 p-4 bg-white rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-4">{{ $group->title }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($group->photos as $photo)
                            @foreach($photo->images as $image)
                                <img src="{{ asset('storage/' . $image->path) }}" 
                                     alt="Image" 
                                     class="w-full h-48 object-cover rounded">
                            @endforeach
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-gray-600">Tidak ada grup ditemukan dalam kategori ini.</p>
            @endforelse

        @elseif($type === 'query')
            <h1 class="text-2xl font-bold mb-6">Hasil pencarian untuk "{{ $searchTerm }}"</h1>
            @if($images->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($images as $image)
                        <img src="{{ asset('storage/' . $image->path) }}" 
                             alt="Image" 
                             class="w-full h-48 object-cover rounded">
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">Tidak ada gambar ditemukan.</p>
            @endif
        @endif
    @else
        <p class="text-gray-600">Silakan lakukan pencarian menggunakan form di atas.</p>
    @endif
</div>
@endsection