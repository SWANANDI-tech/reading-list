@extends('layouts.app')

@section('content')
    <h1>My Reading List</h1>

    <a href="{{ route('books.create') }}" class="btn">Add book</a>

    @if ($books->isEmpty())
        <p>No books yet.</p>
    @else
        <table>
            <thead>
                <tr><th>Title</th><th>Author</th><th>Status</th><th></th></tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ \App\Models\Book::STATUSES[$book->status] ?? $book->status }}</td>
                        <td>
                            <a href="{{ route('books.edit', $book) }}">Edit</a>
                            <form method="POST" action="{{ route('books.destroy', $book) }}"
                                  style="display:inline"
                                  onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection