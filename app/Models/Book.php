<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // Columns that are allowed to be saved from a form
    protected $fillable = ['title', 'author', 'status', 'rating', 'finished_at', 'genre', 'notes'];

    // Makes finished_at behave like a real date (so we can format it)
    protected $casts = [
        'finished_at' => 'date',
        'bookmarked' => 'boolean',

    ];
}