@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-book me-2"></i>{{ $book->title }}</h5>
                </div>
                <div class="card-body">
                    <p class="lead">
                        <strong>Author:</strong> {{ $book->author->name }}
                    </p>
                    
                    @if($book->genres->count() > 0)
                        <div class="mb-3">
                            <strong>Genres:</strong>
                            @foreach($book->genres as $genre)
                                <span class="badge bg-secondary me-1">{{ $genre->name }}</span>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Book
                        </a>
                        <a href="{{ route('books.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Books
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-star me-2"></i>Reviews</h6>
                    <span class="badge bg-primary">{{ $book->reviews->count() }}</span>
                </div>
                <div class="card-body">
                    @if($book->reviews->count() > 0)
                        <div class="mb-3">
                            <strong>Average Rating:</strong>
                            <div class="text-warning">
                                @php $avgRating = $book->reviews->avg('rating') @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($avgRating))
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <span class="text-muted">({{ number_format($avgRating, 1) }}/5)</span>
                            </div>
                        </div>
                        
                        <div class="reviews-list" style="max-height: 400px; overflow-y: auto;">
                            @foreach($book->reviews as $review)
                                <div class="border-bottom pb-2 mb-2">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                    @if($review->content)
                                        <p class="mt-1 mb-0 small">{{ Str::limit($review->content, 100) }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No reviews yet for this book.</p>
                        <a href="{{ route('reviews.create') }}" class="btn btn-sm btn-outline-danger mt-2">
                            <i class="fas fa-plus me-1"></i>Add First Review
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
