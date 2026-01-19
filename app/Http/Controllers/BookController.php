<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class BookController extends Controller
{
    // Display dashboard with search and filter
    public function index(Request $request)
    {
        $query = Book::with('genre');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filter by genre
        if ($request->filled('genre_id')) {
            $query->where('genre_id', $request->genre_id);
        }
        
        $books = $query->get();
        $genres = Genre::all();
        $totalBooks = Book::count();
        $totalGenres = Genre::count();
        $topRated = Book::orderBy('rating', 'desc')->first();

        return view('dashboard', compact('books', 'genres', 'totalBooks', 'totalGenres', 'topRated'));
    }
    
    // Export to PDF
    public function exportPdf(Request $request)
    {
        $query = Book::with('genre');
        
        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('genre_id')) {
            $query->where('genre_id', $request->genre_id);
        }
        
        $books = $query->get();
        $filename = 'books_export_' . date('Y-m-d_H-i-s') . '.pdf';
        
        $pdf = Pdf::loadView('pdf.books', compact('books'));
        return $pdf->download($filename);
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
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB max
        ]);

        $rating = $request->input('rating');
        if ($rating && str_contains($rating, '/')) {
            [$num, $den] = explode('/', $rating);
            $rating = floatval($num) / floatval($den) * 10;
        }
        
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('books', 'public');
        }

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'published_year' => $request->published_year,
            'genre_id' => $request->genre_id,
            'rating' => $rating,
            'description' => $request->description,
            'photo' => $photoPath,
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
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $rating = $request->input('rating');
        if ($rating && str_contains($rating, '/')) {
            [$num, $den] = explode('/', $rating);
            $rating = floatval($num) / floatval($den) * 10;
        }
        
        $photoPath = $book->photo;
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($book->photo) {
                Storage::disk('public')->delete($book->photo);
            }
            $photoPath = $request->file('photo')->store('books', 'public');
        }

        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'published_year' => $request->published_year,
            'genre_id' => $request->genre_id,
            'rating' => $rating,
            'description' => $request->description,
            'photo' => $photoPath,
        ]);

        return redirect()->back()->with('success', 'Book updated successfully!');
    }

    // Soft delete a book
    public function destroy(Book $book)
    {
        $book->delete(); // Soft delete
        return redirect()->back()->with('success', 'Book moved to trash successfully!');
    }
}
