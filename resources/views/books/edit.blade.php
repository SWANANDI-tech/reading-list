@extends('layouts.app')

@section('content')
    <div class="card">
        <h2>Edit book</h2>

        <form method="POST" action="{{ route('books.update', $book) }}">
            @csrf
            @method('PUT')
            @include('books._form')
        </form>
    </div>
@endsection