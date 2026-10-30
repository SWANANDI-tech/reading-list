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

        @if ($count === 0)
            <div class="empty">Nothing finished yet. Mark a book as Finished and it will appear here.</div>
        @else
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