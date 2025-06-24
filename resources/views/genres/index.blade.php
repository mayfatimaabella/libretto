@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2></i>Genres</h2>
        <a href="{{ route('genres.create') }}" class="btn btn-warning">
            <i class="fas fa-plus me-2"></i>Add New Genre
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @forelse($genres as $genre)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-tag me-2 text-warning"></i>{{ $genre->name }}
                    </h5>
                    <p class="card-text text-muted">
                        {{ $genre->description ?? 'No description available.' }}
                    </p>
                    <div class="mb-3">
                        <span class="badge bg-warning text-dark">{{ $genre->books_count }} books</span>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('genres.show', $genre) }}" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('genres.edit', $genre) }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('genres.destroy', $genre) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this genre?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No genres found</h4>
                <p class="text-muted">Start by <a href="{{ route('genres.create') }}">adding your first genre</a></p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
