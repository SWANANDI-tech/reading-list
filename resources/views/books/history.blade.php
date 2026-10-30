@extends('layouts.app')

@section('title', 'Reading history')

@section('content')

    {{-- Three summary cards --}}
    <div class="stats" style="grid-template-columns: repeat(3, 1fr);">
        <div class="stat-card stat-finished"><div class="label">Books finished</div><div class="number">{{ $count }}</div></div>
        <div class="stat-card stat-reading"><div class="label">Finished this year</div><div class="number">{{ $thisYear }}</div></div>
        <div class="stat-card stat-to_read"><div class="label">Average rating</div><div class="number">{{ $average > 0 ? $average . ' ★' : '-' }}</div></div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Books you finished</h2>
        </div>

            <div class="card">
        <div class="card-header">
            <h2>Books you finished</h2>
        </div>

        <form method="GET" action="{{ route('history') }}" style="display:flex; gap:8px; margin:12px 0 18px; flex-wrap:wrap;">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search finished books"
                   style="flex:1; min-width:180px; padding:8px 14px; border:1px solid #e3d9f3; border-radius:999px;">
            <button type="submit" class="btn">Search</button>
            @if (!empty($search))
                <a href="{{ route('history') }}" style="align-self:center;">Clear</a>
            @endif
        </form>

        @if ($count === 0)

        @if ($count === 0)
            <div class="empty">Nothing finished yet. Mark a book as Finished and it will appear here.</div>
        @else
                @else
            @if ($grouped->isEmpty())
                <p class="hint">No finished books match your search.</p>
            @endif
            {{-- One block per month, newest first --}}
            @foreach ($grouped as $month => $books)
                <h3 class="month-title">{{ $month }}</h3>

                @foreach ($books as $book)
                    <div class="history-item">
                        <div>
                            <strong>{{ $book->title }}</strong>
                            <div class="meta">
                                by {{ $book->author }}
                                @if ($book->finished_at)
                                    · finished {{ $book->finished_at->format('j M Y') }}
                                @endif
                            </div>
                        </div>
                        <div class="stars">
                            @if ($book->rating)
                                {{ str_repeat('★', $book->rating) }}<span class="off">{{ str_repeat('★', 5 - $book->rating) }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endforeach
        @endif
    </div>

@endsection