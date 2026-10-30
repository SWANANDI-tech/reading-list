@extends('layouts.app')

@section('title', 'My Books')

@section('content')

    {{-- Four pastel stat cards --}}
    <div class="stats">
        <div class="stat-card stat-total"><div class="label">Total books</div><div class="number">{{ $total }}</div></div>
        <div class="stat-card stat-to_read"><div class="label">To read</div><div class="number">{{ $toRead }}</div></div>
        <div class="stat-card stat-reading"><div class="label">Reading</div><div class="number">{{ $reading }}</div></div>
        <div class="stat-card stat-finished"><div class="label">Finished</div><div class="number">{{ $finished }}</div></div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>All books</h2>
            <a href="{{ route('books.create') }}" class="btn btn-primary">+ Add book</a>
        </div>

        <div class="toolbar">
            {{-- Filter pills (they keep your search text when you click them) --}}
            <div class="filters">
                <a href="{{ route('books.index', ['q' => $search]) }}" class="pill {{ $status === null ? 'active' : '' }}">All</a>
                <a href="{{ route('books.index', ['status' => 'to_read', 'q' => $search]) }}" class="pill {{ $status === 'to_read' ? 'active' : '' }}">To read</a>
                <a href="{{ route('books.index', ['status' => 'reading', 'q' => $search]) }}" class="pill {{ $status === 'reading' ? 'active' : '' }}">Reading</a>
                <a href="{{ route('books.index', ['status' => 'finished', 'q' => $search]) }}" class="pill {{ $status === 'finished' ? 'active' : '' }}">Finished</a>
            </div>

            {{-- Search box: searches title and author --}}
            <form method="GET" action="{{ route('books.index') }}" class="search">
                @if ($status)
                    <input type="hidden" name="status" value="{{ $status }}">
                @endif
                <input type="text" name="q" value="{{ $search }}" placeholder="Search title or author">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        @if ($books->isEmpty())
            <div class="empty">
                {{ ($status || $search !== '') ? 'No books match your search.' : 'No books yet.' }}
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Rating</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>
                                    <span class="badge badge-{{ $book->status }}">
                                        {{ $labels[$book->status] ?? $book->status }}
                                    </span>
                                </td>
                                <td>
                                    {{-- Filled stars for the rating, faded stars for the rest --}}
                                    @if ($book->rating)
                                        <span class="stars">
                                            {{ str_repeat('★', $book->rating) }}<span class="off">{{ str_repeat('★', 5 - $book->rating) }}</span>
                                        </span>
                                    @else
                                        <span style="color: var(--muted)">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('books.edit', $book) }}">Edit</a>

                                        <form method="POST" action="{{ route('books.destroy', $book) }}"
                                              onsubmit="return confirm('Delete this book?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection