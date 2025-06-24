<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalBooks = Book::count();
        $totalAuthors = Author::count();
        $totalGenres = Genre::count();
        $totalReviews = Review::count();
        
        // Get recent books
        $recentBooks = Book::with('author')->latest()->take(5)->get();
        
        // Get top rated books (books with highest average review rating)
        $topRatedBooks = Book::with(['author', 'reviews'])
            ->whereHas('reviews')
            ->get()
            ->map(function ($book) {
                $book->average_rating = $book->reviews->avg('rating');
                return $book;
            })
            ->sortByDesc('average_rating')
            ->take(5);
            
        return view('dashboard', compact(
            'totalBooks', 
            'totalAuthors', 
            'totalGenres', 
            'totalReviews',
            'recentBooks',
            'topRatedBooks'
        ));
    }
}
