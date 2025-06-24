@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2></i>Reviews</h2>
        <a href="{{ route('reviews.create') }}" class="btn btn-danger">
            <i class="fas fa-plus me-2"></i>Add New Review
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @forelse($reviews as $review)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="card-title mb-0">{{ $review->book->title }}</h6>
                        <div class="text-warning">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                    <p class="text-muted small mb-2">by {{ $review->book->author->name }}</p>                    <p class="card-text">
                        {{ Str::limit($review->content ?? 'No content provided.', 100) }}
                    </p>
                    <div class="mt-auto">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>{{ $review->created_at->diffForHumans() }}
                        </small>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('reviews.show', $review) }}" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('reviews.edit', $review) }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this review?')">
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
                <i class="fas fa-star fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No reviews found</h4>
                <p class="text-muted">Start by <a href="{{ route('reviews.create') }}">adding your first review</a></p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
