@extends('layouts.app')

@section('title', 'Add book')
@section('heading', 'Add a new book')
@section('subheading', 'Fill in the details and save it to your shelf')

@section('content')
    {{-- A narrow white card in the middle of the page --}}
    <div class="card" style="max-width: 560px; margin: 0 auto 24px;">
        <h2 style="margin-top: 0;">📚 Book details</h2>

        <form method="POST" action="{{ route('books.store') }}">
            @csrf
            {{-- The input boxes live in _form.blade.php, shared with the Edit page --}}
            @include('books._form')
        </form>
    </div>
@endsection