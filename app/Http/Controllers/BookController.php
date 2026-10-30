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
            'rating' => 'nullable|integer|between:1,5',
        ];
    }

    // Fills in the finished date automatically.
    // Finished  -> keep the old date, or use today if it is new.
    // Otherwise -> clear the date and the rating.
    private function withFinishedDate(array $data, ?Book $book = null): array
    {
        if ($data['status'] === 'finished') {
            $data['finished_at'] = $book?->finished_at ?? now()->toDateString();
        } else {
            $data['finished_at'] = null;
            $data['rating'] = null;
        }
        return $data;
    }

    // List page, with optional filter ?status=reading and search ?q=dune
    public function index(Request $request)
    {
        $status = $request->query('status');
        if (! array_key_exists($status ?? '', $this->labels)) {
            $status = null;   // anything unknown means "All"
        }
        $search = trim((string) $request->query('q', ''));

        $books = Book::query()
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($search !== '', function ($q) use ($search) {
                // Match the search text in the title OR the author
                $q->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                          ->orWhere('author', 'like', "%{$search}%");
                });
            })
            ->orderBy('title')
            ->get();

        return view('books.index', [
            'books'    => $books,
            'status'   => $status,
            'search'   => $search,
            'labels'   => $this->labels,
            // Stat card numbers always count ALL books
            'total'    => Book::count(),
            'toRead'   => Book::where('status', 'to_read')->count(),
            'reading'  => Book::where('status', 'reading')->count(),
            'finished' => Book::where('status', 'finished')->count(),
        ]);
    }

    // History page: finished books grouped by month
    public function history()
    {
        $finished = Book::where('status', 'finished')
            ->orderByDesc('finished_at')
            ->get();

        // Books finished before the date column existed go under "Earlier"
        $grouped = $finished->groupBy(fn ($b) => $b->finished_at?->format('F Y') ?? 'Earlier');

        return view('books.history', [
            'grouped'  => $grouped,
            'count'    => $finished->count(),
            'thisYear' => $finished->filter(fn ($b) => $b->finished_at?->year === now()->year)->count(),
            'average'  => round($finished->whereNotNull('rating')->avg('rating') ?? 0, 1),
        ]);
    }

    public function create()
    {
        return view('books.create', ['labels' => $this->labels]);
    }

    public function store(Request $request)
    {
        $data = $this->withFinishedDate($request->validate($this->rules()));
        Book::create($data);
        return redirect()->route('books.index')->with('success', 'Book added.');
    }

    public function edit(Book $book)
    {
        return view('books.edit', ['book' => $book, 'labels' => $this->labels]);
    }

    public function update(Request $request, Book $book)
    {
        $data = $this->withFinishedDate($request->validate($this->rules()), $book);
        $book->update($data);
        return redirect()->route('books.index')->with('success', 'Book updated.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted.');
    }
}