@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-star me-2"></i>Edit Review</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reviews.update', $review) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label for="book_id" class="form-label">Book <span class="text-danger">*</span></label>
                            <select name="book_id" id="book_id" class="form-select @error('book_id') is-invalid @enderror" required>
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}" {{ old('book_id', $review->book_id) == $book->id ? 'selected' : '' }}>
                                        {{ $book->title }} (by {{ $book->author->name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('book_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror                        </div>
                        
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                            <select name="rating" id="rating" class="form-select @error('rating') is-invalid @enderror" required>
                                <option value="1" {{ old('rating', $review->rating) == '1' ? 'selected' : '' }}>⭐ 1 Star</option>
                                <option value="2" {{ old('rating', $review->rating) == '2' ? 'selected' : '' }}>⭐⭐ 2 Stars</option>
                                <option value="3" {{ old('rating', $review->rating) == '3' ? 'selected' : '' }}>⭐⭐⭐ 3 Stars</option>
                                <option value="4" {{ old('rating', $review->rating) == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ 4 Stars</option>
                                <option value="5" {{ old('rating', $review->rating) == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 Stars</option>
                            </select>
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Review Content</label>
                            <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" 
                                      rows="4" placeholder="Write your review...">{{ old('content', $review->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('reviews.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-save me-2"></i>Update Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
