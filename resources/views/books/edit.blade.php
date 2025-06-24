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
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
