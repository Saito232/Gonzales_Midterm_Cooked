<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Display dashboard
    public function index()
    {
        $books = Book::with('genre')->get();
        $genres = Genre::all();
        $totalBooks = Book::count();
        $totalGenres = Genre::count();
        $topRated = Book::orderBy('rating', 'desc')->first();

        return view('dashboard', compact('books', 'genres', 'totalBooks', 'totalGenres', 'topRated'));
    }

    // Store a new book
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:books,title',
            'author' => 'required|string|max:255',
            'published_year' => 'required|digits:4|integer',
            'rating' => 'nullable|string',
            'genre_id' => 'nullable|exists:genres,id',
            'description' => 'nullable|string',
        ]);

        $rating = $request->input('rating');
        if ($rating && str_contains($rating, '/')) {
            [$num, $den] = explode('/', $rating);
            $rating = floatval($num) / floatval($den) * 10;
        }

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'published_year' => $request->published_year,
            'genre_id' => $request->genre_id,
            'rating' => $rating,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Book created successfully!');
    }

    // Update an existing book
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|unique:books,title,' . $book->id,
            'author' => 'required|string|max:255',
            'published_year' => 'required|digits:4|integer',
            'rating' => 'nullable|string',
            'genre_id' => 'nullable|exists:genres,id',
            'description' => 'nullable|string',
        ]);

        $rating = $request->input('rating');
        if ($rating && str_contains($rating, '/')) {
            [$num, $den] = explode('/', $rating);
            $rating = floatval($num) / floatval($den) * 10;
        }

        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'published_year' => $request->published_year,
            'genre_id' => $request->genre_id,
            'rating' => $rating,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Book updated successfully!');
    }

    // Delete a book
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->back()->with('success', 'Book deleted successfully!');
    }
}
