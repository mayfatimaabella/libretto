@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>{{ $author->name }}</h5>
                </div>
                <div class="card-body">
                    @if($author->bio)
                        <p class="lead">{{ $author->bio }}</p>
                    @else
                        <p class="text-muted">No biography available.</p>
                    @endif
                    
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('authors.edit', $author) }}" class="btn bg-primary bg-opacity-25 text-dark">
                            <i class="fas fa-edit me-2"></i>Edit Author
                        </a>
                        <a href="{{ route('authors.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Authors
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-book me-2"></i>Books by {{ $author->name }}</h6>
                </div>
                <div class="card-body">
                    @if($author->books->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($author->books as $book)
                                <div class="list-group-item px-0">
                                    <h6 class="mb-1">{{ $book->title }}</h6>
                                    <small class="text-muted">Added {{ $book->created_at->diffForHumans() }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No books by this author yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
