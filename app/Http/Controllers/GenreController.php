<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    // Display all genres with movies count
    public function index()
    {
        $genres = Genre::withCount('books')->get();
        return view('genres', compact('genres'));
    }

    // Store a new genre
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name',
            'description' => 'nullable|string|max:1000',
        ]);

        Genre::create($request->only(['name', 'description']));

        return redirect()->back()->with('success', 'Genre created successfully!');
    }

    // Update an existing genre
    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $genre->update($request->only(['name', 'description']));

        return redirect()->back()->with('success', 'Genre updated successfully!');
    }

    // Delete a genre and detach it from movies
    public function destroy(Genre $genre)
    {
        // Set genre_id of associated books to null before deleting
        $genre->books()->update(['genre_id' => null]);

        $genre->delete();

        return redirect()->back()->with('success', 'Genre deleted successfully!');
    }
}
