@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-tag me-2 text-info"></i>{{ $genre->name }}</h5>
                </div>
                <div class="card-body">
                    @if($genre->description)
                        <p class="lead">{{ $genre->description }}</p>
                    @else
                        <p class="text-muted">No description available for this genre.</p>
                    @endif
                    
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('genres.edit', $genre) }}" class="btn bg-primary bg-opacity-25 text-dark">
                            <i class="fas fa-edit me-2"></i>Edit Genre
                        </a>
                        <a href="{{ route('genres.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Genres
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-book me-2"></i>Books in {{ $genre->name }}</h6>
                </div>
                <div class="card-body">
                    @if($genre->books->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($genre->books as $book)
                                <div class="list-group-item px-0">
                                    <h6 class="mb-1">{{ $book->title }}</h6>
                                    <small class="text-muted">by {{ $book->author->name }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No books in this genre yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
