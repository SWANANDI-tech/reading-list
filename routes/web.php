<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('books.index'));
Route::resource('books', BookController::class)->except(['show']);