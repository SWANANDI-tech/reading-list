@extends('layouts.app')

@section('title', 'My Books')

@section('content')

    {{-- Four stat cards. The numbers come from the controller. --}}
    <div class="stats">
        <div class="stat-card"><div class="label">Total books</div><div class="number">{{ $total }}</div></div>
        <div class="stat-card"><div class="label">To read</div><div class="number">{{ $toRead }}</div></div>
        <div class="stat-card"><div class="label">Reading</div><div class="number">{{ $reading }}</div></div>
        <div class="stat-card"><div class="label">Finished</div><div class="number">{{ $finished }}</div></div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>All books</h2>
            <a href="{{ route('books.create') }}" class="btn btn-primary">+ Add book</a>
        </div>

        {{-- Filter pills: the selected one gets the "active" class and turns blue --}}
        <div class="filters">
            <a href="{{ route('books.index') }}" class="pill {{ $status === null ? 'active' : '' }}">All</a>
            <a href="{{ route('books.index', ['status' => 'to_read']) }}" class="pill {{ $status === 'to_read' ? 'active' : '' }}">To read</a>
            <a href="{{ route('books.index', ['status' => 'reading']) }}" class="pill {{ $status === 'reading' ? 'active' : '' }}">Reading</a>
            <a href="{{ route('books.index', ['status' => 'finished']) }}" class="pill {{ $status === 'finished' ? 'active' : '' }}">Finished</a>
        </div>

        @if ($books->isEmpty())
            <div class="empty">No books yet.</div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>
                                    {{-- The badge color depends on the status --}}
                                    <span class="badge badge-{{ $book->status }}">
                                        {{ $labels[$book->status] ?? $book->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('books.edit', $book) }}">Edit</a>

                                        {{-- Delete asks "Are you sure?" before submitting --}}
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