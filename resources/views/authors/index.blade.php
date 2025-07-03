@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2></i>Authors</h2>
        <a href="{{ route('authors.create') }}" class="btn bg-primary bg-opacity-25 text-dark ">
            <i class="fas fa-plus me-2"></i>Add New Author
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card bg-light border border-dark-subtle shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Books Count</th>
                            <th>Bio</th>
                            <th class="text-end" width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($authors as $author)
                        <tr>
                            <td><strong>{{ $author->name }}</strong></td>
                            <td>
                                <span class="badge bg-primary bg-opacity-25 text-dark">{{ $author->books_count }} books</span>
                            </td>
                            <td>
                                {{ Str::limit($author->bio ?? 'No bio available', 50) }}
                            </td>
                            <td class="text-end">
                                <a href="{{ route('authors.show', $author) }}" class="btn btn-sm btn-outline-info me-1" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('authors.edit', $author) }}" class="btn btn-sm btn-outline-dark me-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('authors.destroy', $author) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this author?')" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-users fa-3x mb-3 d-block text-info"></i>
                                No authors found. <a href="{{ route('authors.create') }}">Add the first author</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
