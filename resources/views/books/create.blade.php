@extends('layouts.app')

@section('content')
    <h1>Add book</h1>

    <form method="POST" action="{{ route('books.store') }}">
        @csrf
        @include('books._form')
    </form>
@endsection
