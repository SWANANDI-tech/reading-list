@extends('layouts.app')

@section('content')
    <h1>My Reading List
        <a href="{{ route('books.create') }}" class="btn">Add book</a>
    </h1>

    @if ($books->isEmpty())
        <p>No books yet.</p>
    @else
        <table>
            <thead>
                <tr><th>Title</th><th>Author</th><th>Status</th></tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ \App\Models\Book::STATUSES[$book->status] ?? $book->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection