<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrashController extends Controller
{
    // Display trash page
    public function index()
    {
        $books = Book::onlyTrashed()->with('genre')->get();
        $genres = Genre::onlyTrashed()->get();
        
        return view('trash', compact('books', 'genres'));
    }
    
    // Restore a book
    public function restoreBook($id)
    {
        $book = Book::onlyTrashed()->findOrFail($id);
        $book->restore();
        
        return redirect()->back()->with('success', 'Book restored successfully!');
    }
    
    // Permanently delete a book
    public function forceDeleteBook($id)
    {
        $book = Book::onlyTrashed()->findOrFail($id);
        
        // Delete photo if exists
        if ($book->photo) {
            Storage::disk('public')->delete($book->photo);
        }
        
        $book->forceDelete();
        
        return redirect()->back()->with('success', 'Book permanently deleted!');
    }
    
    // Restore a genre
    public function restoreGenre($id)
    {
        $genre = Genre::onlyTrashed()->findOrFail($id);
        $genre->restore();
        
        return redirect()->back()->with('success', 'Genre restored successfully!');
    }
    
    // Permanently delete a genre
    public function forceDeleteGenre($id)
    {
        $genre = Genre::onlyTrashed()->findOrFail($id);
        $genre->forceDelete();
        
        return redirect()->back()->with('success', 'Genre permanently deleted!');
    }
}
