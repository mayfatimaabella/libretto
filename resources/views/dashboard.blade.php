@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="jumbotron bg-light p-4 rounded mb-4">
                <h1 class="display-4 text-center">Libretto</h1>
                <hr class="my-4">
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center bg-info bg-opacity-10 border border-info-subtle">
                <div class="card-header bg-info bg-opacity-25 text-dark">
                    <h5>Authors</h5>
                </div>
                <div class="card-body">
                    <h2 class="text-info">{{ $totalAuthors }}</h2>
                    <p class="text-muted">Authors</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-info bg-opacity-10 border border-info-subtle">
                <div class="card-header bg-info bg-opacity-25 text-dark">
                    <h5>Books</h5>
                </div>
                <div class="card-body">
                    <h2 class="text-info">{{ $totalBooks }}</h2>
                    <p class="text-muted">Books</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-info bg-opacity-10 border border-info-subtle">
                <div class="card-header bg-info bg-opacity-25 text-dark">
                    <h5>Genres</h5>
                </div>
                <div class="card-body">
                    <h2 class="text-info">{{ $totalGenres }}</h2>
                    <p class="text-muted">Genres</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-info bg-opacity-10 border border-info-subtle">
                <div class="card-header bg-info bg-opacity-25 text-dark">
                    <h5>Reviews</h5>
                </div>
                <div class="card-body">
                    <h2 class="text-info">{{ $totalReviews }}</h2>
                    <p class="text-muted">Reviews</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Section Header -->
    <div class="row">
        <div class="col-12">
            <h3 class="mb-3">Management Section</h3>
        </div>
    </div>

    <!-- Management Cards -->
    <div class="row">
        <!-- Authors -->
        <div class="col-md-6 mb-4">
            <div class="card bg-light border border-dark-subtle">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Authors Management</h5>
                </div>
                <div class="card-body">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('authors.index') }}" class="btn btn-dark">View Authors</a>
                        <a href="{{ route('authors.create') }}" class="btn btn-outline-dark">Add Author</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Books -->
        <div class="col-md-6 mb-4">
            <div class="card bg-light border border-dark-subtle">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Books Management</h5>
                </div>
                <div class="card-body">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('books.index') }}" class="btn btn-dark">View Books</a>
                        <a href="{{ route('books.create') }}" class="btn btn-outline-dark">Add Book</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Genres -->
        <div class="col-md-6 mb-4">
            <div class="card bg-light border border-dark-subtle">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Genres Management</h5>
                </div>
                <div class="card-body">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('genres.index') }}" class="btn btn-dark">View Genres</a>
                        <a href="{{ route('genres.create') }}" class="btn btn-outline-dark">Add Genre</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews -->
        <div class="col-md-6 mb-4">
            <div class="card bg-light border border-dark-subtle">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Reviews Management</h5>
                </div>
                <div class="card-body">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('reviews.index') }}" class="btn btn-dark">View Reviews</a>
                        <a href="{{ route('reviews.create') }}" class="btn btn-outline-dark">Add Review</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
