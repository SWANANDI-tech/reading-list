<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $status = $request->query('status');

    $query = Book::latest();

    if ($status && isset(Book::STATUSES[$status])) {
        $query->where('status', $status);
    } else {
        $status = null;
    }

    $books = $query->get();

    return view('books.index', compact('books', 'status'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('books.create');
}

public function store(Request $request)
{
    $data = $request->validate([
        'title'  => ['required', 'max:255'],
        'author' => ['required', 'max:255'],
        'status' => ['required', Rule::in(array_keys(Book::STATUSES))],
    ]);

    Book::create($data);

    return redirect()->route('books.index')->with('success', 'Book added.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Book $book)
{
    return view('books.edit', compact('book'));
}

public function update(Request $request, Book $book)
{
    $data = $request->validate([
        'title'  => ['required', 'max:255'],
        'author' => ['required', 'max:255'],
        'status' => ['required', Rule::in(array_keys(Book::STATUSES))],
    ]);

    $book->update($data);

    return redirect()->route('books.index')->with('success', 'Book updated.');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
{
    $book->delete();

    return redirect()->route('books.index')->with('success', 'Book deleted.');
}
}