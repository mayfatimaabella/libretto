@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Books</h2>
        <a href="{{ route('books.create') }}" class="btn bg-primary bg-opacity-25 text-dark">
            <i class="fas fa-plus me-2"></i>Add New Book
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Results Info --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted mb-0">
            Showing {{ $books->firstItem() ?? 0 }} to {{ $books->lastItem() ?? 0 }} 
            of {{ $books->total() }} results
        </p>
        <div class="text-muted">
            Page {{ $books->currentPage() }} of {{ $books->lastPage() }}
        </div>
    </div>

    <div class="card bg-light border border-dark-subtle shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Genres</th>
                            <th class="text-end" width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                        <tr>
                            <td><strong>{{ $book->title }}</strong></td>
                            <td>{{ $book->author->name }}</td>
                            <td>
                                @if($book->genres->count())
                                    @foreach($book->genres as $genre)
                                        <span class="badge bg-primary bg-opacity-25 text-dark">{{ $genre->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No genres</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-outline-info me-1" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-outline-dark me-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this book?')" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-book-open fa-3x mb-3 d-block text-info"></i>
                                No books found. <a href="{{ route('books.create') }}">Add the first book</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination Links --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $books->links() }}
    </div>
</div>
@endsection
