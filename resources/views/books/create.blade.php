@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Book</h2>
    <form action="{{ route('books.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Title:</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Author:</label>
            <select name="author_id" class="form-control" required>
                <option value="">-- Select Author --</option>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Genres:</label>
            <select name="genres[]" class="form-control" multiple>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple genres</small>
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
