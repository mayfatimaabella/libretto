@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-star me-2"></i>Review Details</h5>
                        <div class="text-warning">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                            <span class="ms-2 text-muted">({{ $review->rating }}/5)</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">                    <div class="row">
                        <div class="col-md-6">
                            <h6>Book</h6>
                            <p class="text-muted">{{ $review->book->title }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Author</h6>
                            <p class="text-muted">{{ $review->book->author->name }}</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Review Date</h6>
                            <p class="text-muted">{{ $review->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Rating</h6>
                            <p class="text-muted">{{ $review->rating }}/5 Stars</p>
                        </div>
                    </div>
                    
                    @if($review->content)
                        <h6>Review Content</h6>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0">{{ $review->content }}</p>
                        </div>
                    @endif
                    
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('reviews.edit', $review) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Review
                        </a>
                        <a href="{{ route('reviews.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Reviews
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
