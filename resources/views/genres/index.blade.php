@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2></i>Genres</h2>
        <a href="{{ route('genres.create') }}" class="btn btn-info">
            <i class="fas fa-plus me-2"></i>Add New Genre
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($genres->count())
        <div class="card bg-light border border-dark-subtle shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Genre Name</th>
                                <th>Description</th>
                                <th>Books</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($genres as $index => $genre)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <i class="fas fa-tag text-info me-1"></i>
                                    {{ $genre->name }}
                                </td>
                                <td class="text-muted">
                                    {{ $genre->description ?? 'No description available.' }}
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $genre->books_count }} books</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('genres.show', $genre) }}" class="btn btn-sm btn-outline-info me-1" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('genres.edit', $genre) }}" class="btn btn-sm btn-outline-dark me-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('genres.destroy', $genre) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this genre?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">No genres found</h4>
            <p class="text-muted">Start by <a href="{{ route('genres.create') }}">adding your first genre</a></p>
        </div>
    @endif
</div>
@endsection
