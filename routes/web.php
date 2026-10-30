<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('books.index'));
Route::get('/history', [BookController::class, 'history'])->name('books.history');
Route::resource('books', BookController::class)->except(['show']);