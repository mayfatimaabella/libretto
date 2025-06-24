@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Book</h2>
    <form action="{{ route('books.update', $book) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Title:</label>
            <input type="text" name="title" class="form-control" value="{{ $book->title }}" required>
        </div>
        <div class="mb-3">
            <label>Author:</label>
            <select name="author_id" class="form-control" required>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>
                        {{ $author->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Genres:</label>
            <select name="genres[]" class="form-control" multiple>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ $book->genres->contains($genre->id) ? 'selected' : '' }}>
                        {{ $genre->name }}
                    </option>
                @endforeach
            </select>
            <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple genres</small>
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
