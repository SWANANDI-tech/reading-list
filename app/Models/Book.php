<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public const STATUSES = [
        'to-read'  => 'To read',
        'reading'  => 'Reading',
        'finished' => 'Finished',
    ];

    protected $fillable = ['title', 'author', 'status'];
}