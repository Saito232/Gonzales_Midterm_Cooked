<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\TrashController;

Route::get('/', [BookController::class,'index'])->name('dashboard');
Route::get('/books/export-pdf', [BookController::class, 'exportPdf'])->name('books.exportPdf');
Route::resource('books', BookController::class)->except(['show','create','edit']);
Route::resource('genres', GenreController::class)->except(['show','create','edit']);

// Trash routes
Route::get('/trash', [TrashController::class, 'index'])->name('trash.index');
Route::post('/trash/books/{id}/restore', [TrashController::class, 'restoreBook'])->name('trash.books.restore');
Route::delete('/trash/books/{id}/force-delete', [TrashController::class, 'forceDeleteBook'])->name('trash.books.forceDelete');
Route::post('/trash/genres/{id}/restore', [TrashController::class, 'restoreGenre'])->name('trash.genres.restore');
Route::delete('/trash/genres/{id}/force-delete', [TrashController::class, 'forceDeleteGenre'])->name('trash.genres.forceDelete');
