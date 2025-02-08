<div class="columns-2 sm:columns-3 md:columns-4 lg:columns-5 xl:columns-6 gap-4 pt-4 *:rounded-xl">
    @foreach($photos as $photo)
    <div class="category-item break-inside-avoid mb-4">
        @if($photo->images->isNotEmpty())
        <img src="{{ asset('storage/' . $photo->images->first()->path) }}" class="w-full rounded-lg" alt="{{ $photo->title }}">
        @else
        <img src="{{ asset('storage/default-image.jpg') }}" class="w-full rounded-lg" alt="No image available">
        @endif
        <div class="text-container text-start">
            <h1 class="font-medium text-xl mt-2 text-neutralDark">{{$photo->group->title}}</h1>
            <p class="text-neutralGray">{{ $photo->group->deskripsi }}</p>
        </div>
    </div>
    @endforeach
</div>