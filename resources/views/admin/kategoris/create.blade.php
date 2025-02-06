@extends('layouts.main')

@section('title', 'Create Kategori')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold text-center mb-4">Create Kategori</h1>

    <form action="{{ route('kategoris.store') }}" method="POST">
        @csrf
        <div class="max-w-lg mx-auto bg-white p-6 rounded-md shadow-md">
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Kategori Name</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                @error('nama')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none">Create</button>
            </div>
        </div>
    </form>
</div>
@endsection