<!-- resources/views/admin/kategoris/index.blade.php -->

@extends('layouts.main')

@section('content')
    <h1>Categories</h1>

    <a href="{{ route('kategoris.create') }}" class="btn btn-primary">Create New Category</a>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategoris as $kategori)
                <tr>
                    <td>{{ $kategori->id }}</td>
                    <td>{{ $kategori->nama }}</td>
                    <td>
                        <a href="{{ route('kategoris.edit', $kategori->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('kategoris.destroy', $kategori->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
