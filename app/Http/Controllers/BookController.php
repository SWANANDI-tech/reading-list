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
            'rating' => 'nullable|integer|min:1|max:5',
            'genre'  => 'nullable|string|max:50',
            'notes'  => 'nullable|string|max:1000',
        ];
    }

    // Fills in the finished date automatically.
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

    // List page, with optional filter (status), search and sorting
    public function index(Request $request)
    {
        $status = $request->query('status');
        if (! array_key_exists((string) $status, $this->labels)) {
            $status = null;
        }

        $search = trim((string) $request->query('q', ''));

        $sortOptions = [
            'newest' => ['created_at', 'desc'],
            'title'  => ['title', 'asc'],
            'author' => ['author', 'asc'],
            'rating' => ['rating', 'desc'],
        ];
        [$sortColumn, $sortDirection] = $sortOptions[$request->query('sort', 'newest')] ?? $sortOptions['newest'];

                $books = Book::query()
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($request->query('bookmarked'), fn ($q) => $q->where('bookmarked', true))
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                          ->orWhere('author', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortColumn, $sortDirection)
            ->get();
           
            
        return view('books.index', [
            'books'    => $books,
            'status'   => $status,
            'search'   => $search,
            'labels'   => $this->labels,
            'total'    => Book::count(),
            'toRead'   => Book::where('status', 'to_read')->count(),
            'reading'  => Book::where('status', 'reading')->count(),
            'finished' => Book::where('status', 'finished')->count(),
        ]);
    }

    // History page: finished books grouped by month, with search and yearly goal
    public function history()
    {
        $search = trim((string) request('search', ''));

        $all = Book::where('status', 'finished')
            ->orderByDesc('finished_at')
            ->get();

        $shown = $search === ''
            ? $all
            : $all->filter(fn ($b) => str_contains(
                strtolower($b->title . ' ' . $b->author),
                strtolower($search)
            ));

        $grouped = $shown->groupBy(fn ($b) => $b->finished_at?->format('F Y') ?? 'Earlier');

        $thisYear = $all->filter(fn ($b) => $b->finished_at?->year === now()->year)->count();
        $goal = 12;

        return view('books.history', [
            'grouped'  => $grouped,
            'count'    => $all->count(),
            'thisYear' => $thisYear,
            'average'  => round($all->whereNotNull('rating')->avg('rating') ?? 0, 1),
            'goal'     => $goal,
            'percent'  => min(100, round($thisYear / $goal * 100)),
            'search'   => $search,
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

    // Moves a book forward: To read -> Reading -> Finished
    public function advance(Book $book)
    {
        if ($book->status === 'to_read') {
            $book->update(['status' => 'reading']);
            $message = 'Started reading "' . $book->title . '".';
        } elseif ($book->status === 'reading') {
            $book->update([
                'status'      => 'finished',
                'finished_at' => now()->toDateString(),
            ]);
            $message = 'Finished "' . $book->title . '". Nice!';
        } else {
            return redirect()->route('books.index');
        }

        return redirect()->back()->with('success', $message);
    }

    public function toggleBookmark(Book $book)
{
    $book->update(['bookmarked' => ! $book->bookmarked]);

    return redirect()->back();
}

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted.');
    }
}