<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // The three allowed statuses and the text shown for each
    private array $labels = [
        'to_read'  => 'To read',
        'reading'  => 'Reading',
        'finished' => 'Finished',
    ];

    // Rules used when adding and editing
    private function rules(): array
    {
        return [
            'title'  => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'status' => 'required|in:to_read,reading,finished',
        ];
    }

    // List page, with optional filter ?status=reading
    public function index(Request $request)
    {
        $status = $request->query('status');
        if (! array_key_exists($status ?? '', $this->labels)) {
            $status = null;   // anything unknown means "All"
        }

        $books = Book::when($status, fn ($q) => $q->where('status', $status))
                     ->orderBy('title')
                     ->get();

        return view('books.index', [
            'books'    => $books,
            'status'   => $status,
            'labels'   => $this->labels,
            // Stat card numbers always count ALL books, not just the filtered ones
            'total'    => Book::count(),
            'toRead'   => Book::where('status', 'to_read')->count(),
            'reading'  => Book::where('status', 'reading')->count(),
            'finished' => Book::where('status', 'finished')->count(),
        ]);
    }

    public function create()
    {
        return view('books.create', ['labels' => $this->labels]);
    }

    public function store(Request $request)
    {
        Book::create($request->validate($this->rules()));
        return redirect()->route('books.index')->with('success', 'Book added.');
    }

    public function edit(Book $book)
    {
        return view('books.edit', ['book' => $book, 'labels' => $this->labels]);
    }

    public function update(Request $request, Book $book)
    {
        $book->update($request->validate($this->rules()));
        return redirect()->route('books.index')->with('success', 'Book updated.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted.');
    }
}