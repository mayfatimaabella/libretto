@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-book me-2"></i>Add New Book</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('books.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="author_id" class="form-label">Author <span class="text-danger">*</span></label>
                            <select name="author_id" id="author_id" class="form-control @error('author_id') is-invalid @enderror" required>
                                <option value="">-- Select Author --</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('author_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="genres" class="form-label">Genres</label>
                            <select name="genres[]" id="genres" class="form-control @error('genres') is-invalid @enderror" multiple>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}" {{ (collect(old('genres'))->contains($genre->id)) ? 'selected' : '' }}>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple genres</small>
                            @error('genres')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('books.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn bg-primary bg-opacity-25 text-dark">
                                <i class="fas fa-save me-2"></i>Save Book
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
