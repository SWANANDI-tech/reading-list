<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/books');
Route::get('/history', [BookController::class, 'history'])->name('books.history');
Route::patch('/books/{book}/advance', [BookController::class, 'advance'])->name('books.advance');
Route::resource('books', BookController::class)->except(['show']);
Route::patch('/books/{book}/bookmark', [BookController::class, 'toggleBookmark'])->name('books.bookmark');