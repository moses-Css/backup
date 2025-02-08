@extends('layouts.main')

@section('title', 'Tambah Foto Baru')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold mb-6">Tambah Foto Baru</h1>

    <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid gap-6 mb-6">
            <!-- Kategori -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                <select name="kategori_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
                @error('kategori_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title (Nama Grup) -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Judul Grup</label>
                <input type="text" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required maxlength="255">
                @error('title')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                <textarea name="deskripsi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                @error('deskripsi')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                <input type="date" name="tanggal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                @error('tanggal')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lokasi -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Lokasi</label>
                <input type="text" name="lokasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                @error('lokasi')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Gambar -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Upload Gambar</label>
                <input
                    type="file"
                    name="images[]"
                    multiple
                    class="block w-full text-sm text-gray-900 border 
               {{ $errors->has('images.*') ? 'border-red-500' : 'border-gray-300' }} 
               rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                @error('images')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
                @error('images.*')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
            Simpan
        </button>
    </form>
</div>

@endsection