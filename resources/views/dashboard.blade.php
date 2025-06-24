@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Simple Header -->
    <div class="row">
        <div class="col-12">
            <div class="jumbotron bg-light p-4 rounded mb-4">
                <h1 class="display-4 text-center">Libretto Library System</h1>
                <hr class="my-4">
            </div>
        </div>
    </div>

    <!-- Simple Stats Row -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-header bg-primary text-white">
                    <h5>📝 Authors</h5>
                </div>
                <div class="card-body">
                    <h2 class="text-primary">{{ $totalAuthors }}</h2>
                    <p>Total Authors</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-header bg-success text-white">
                    <h5>📚 Books</h5>
                </div>
                <div class="card-body">
                    <h2 class="text-success">{{ $totalBooks }}</h2>
                    <p>Total Books</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-header bg-warning text-white">
                    <h5>🏷️ Genres</h5>
                </div>
                <div class="card-body">
                    <h2 class="text-warning">{{ $totalGenres }}</h2>
                    <p>Total Genres</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-header bg-danger text-white">
                    <h5>⭐ Reviews</h5>
                </div>
                <div class="card-body">
                    <h2 class="text-danger">{{ $totalReviews }}</h2>
                    <p>Total Reviews</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Sections -->
    <div class="row">
        <div class="col-12">
            <h3 class="mb-3">📋 Management Sections</h3>
        </div>
    </div>

    <div class="row">
        <!-- Authors Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">👨‍💼 Authors Management</h5>
                </div>
                <div class="card-body">

                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('authors.index') }}" class="btn btn-primary">View Authors</a>
                        <a href="{{ route('authors.create') }}" class="btn btn-outline-primary">Add Author</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Books Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">📖 Books Management</h5>
                </div>
                <div class="card-body">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('books.index') }}" class="btn btn-success">View Books</a>
                        <a href="{{ route('books.create') }}" class="btn btn-outline-success">Add Book</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Genres Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">🏷️ Genres Management</h5>
                </div>
                <div class="card-body">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('genres.index') }}" class="btn btn-warning">View Genres</a>
                        <a href="{{ route('genres.create') }}" class="btn btn-outline-warning">Add Genre</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">⭐ Reviews Management</h5>
                </div>
                <div class="card-body">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('reviews.index') }}" class="btn btn-danger">View Reviews</a>
                        <a href="{{ route('reviews.create') }}" class="btn btn-outline-danger">Add Review</a>
                    </div>
                </div>
            </div>
        </div>

@endsection
