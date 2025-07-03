@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Edit Author</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('authors.update', $author) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $author->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="bio" class="form-label">Biography</label>
                            <textarea name="bio" id="bio" class="form-control @error('bio') is-invalid @enderror" 
                                      rows="4" placeholder="Enter author's biography...">{{ old('bio', $author->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('authors.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn bg-primary bg-opacity-25 text-dark">
                                <i class="fas fa-save me-2"></i>Update Author
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
