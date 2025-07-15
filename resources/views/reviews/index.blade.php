@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Reviews</h2>
        <a href="{{ route('reviews.create') }}" class="btn bg-primary bg-opacity-25 text-dark">
            <i class="fas fa-plus me-2"></i>Add New Review
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
            Showing {{ $reviews->firstItem() ?? 0 }} to {{ $reviews->lastItem() ?? 0 }} 
            of {{ $reviews->total() }} results
        </p>
        <div class="text-muted">
            Page {{ $reviews->currentPage() }} of {{ $reviews->lastPage() }}
        </div>
    </div>

    @if($reviews->count())
    <div class="card bg-light border border-dark-subtle shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Book</th>
                            <th>Author</th>
                            <th>Rating</th>
                            <th>Content</th>
                            <th>Date</th>
                            <th class="text-end" style="width: 160px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $review)
                        <tr class="align-middle">
                            <td><strong>{{ $review->book->title }}</strong></td>
                            <td class="text-muted">{{ $review->book->author->name }}</td>
                            <td>
                                <div class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </td>
                            <td>{{ Str::limit($review->content ?? 'No content provided.', 60) }}</td>
                            <td>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>{{ $review->created_at->diffForHumans() }}
                                </small>
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('reviews.show', $review) }}" class="btn btn-sm btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('reviews.edit', $review) }}" class="btn btn-sm btn-outline-dark" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('reviews.destroy', $review) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this review?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination Links --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $reviews->links() }}
    </div>
    @else
    <div class="text-center py-5">
        <i class="fas fa-star fa-3x text-muted mb-3"></i>
        <h4 class="text-muted">No reviews found</h4>
        <p class="text-muted">Start by <a href="{{ route('reviews.create') }}">adding your first review</a></p>
    </div>
    @endif
</div>
@endsection
