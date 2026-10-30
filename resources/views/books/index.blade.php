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
           <form method="GET" action="{{ route('books.index') }}" style="display:inline-block; margin-top:10px;">
    @if (request('status'))
        <input type="hidden" name="status" value="{{ request('status') }}">
    @endif
    @if (request('search'))
        <input type="hidden" name="search" value="{{ request('search') }}">
    @endif
    <select name="sort" onchange="this.form.submit()">
        <option value="newest" @selected(request('sort', 'newest') === 'newest')>Newest first</option>
        <option value="title"  @selected(request('sort') === 'title')>Title (A to Z)</option>
        <option value="author" @selected(request('sort') === 'author')>Author (A to Z)</option>
        <option value="rating" @selected(request('sort') === 'rating')>Highest rated</option>
    </select>
</form>
        </div>

        {{-- Search box --}}
<form method="GET" action="{{ route('books.index') }}" style="display:flex; gap:8px; margin:12px 0 18px; flex-wrap:wrap;">
    @if (!empty($status))
        <input type="hidden" name="status" value="{{ $status }}">
    @endif
    @if (request('sort'))
        <input type="hidden" name="sort" value="{{ request('sort') }}">
    @endif

    <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Search by title or author"
           style="flex:1; min-width:180px; padding:8px 14px; border:1px solid #e3d9f3; border-radius:999px;">
    <button type="submit" class="btn">Search</button>

    @if (!empty($search))
        <a href="{{ route('books.index', array_filter(['status' => $status, 'sort' => request('sort')])) }}" style="align-self:center;">Clear</a>
    @endif
</form>
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
                                <td>
    <form method="POST" action="{{ route('books.bookmark', $book) }}" style="display:inline;">
        @csrf
        @method('PATCH')
        <button type="submit" title="Bookmark"
                style="background:none; border:none; cursor:pointer; font-size:1.1rem; color: {{ $book->bookmarked ? '#e0a82e' : '#cfc6e0' }};">
            {{ $book->bookmarked ? '★' : '☆' }}
        </button>
    </form>
    {{ $book->title }}
</td>
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