@extends('layouts.app')

@section('content')
    <h1>Edit book</h1>

    <form method="POST" action="{{ route('books.update', $book) }}">
        @csrf
        @method('PUT')
        @include('books._form')
    </form>
@endsection