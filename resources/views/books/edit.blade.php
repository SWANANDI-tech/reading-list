@extends('layouts.app')

@section('title', 'Edit book')
@section('heading', 'Edit book')
@section('subheading', 'Change the details and save your updates')

@section('content')
    <div class="card" style="max-width: 560px; margin: 0 auto 24px;">
        <h2 style="margin-top: 0;">✏️ Book details</h2>

        <form method="POST" action="{{ route('books.update', $book) }}">
            @csrf
            @method('PUT')
            @include('books._form')
        </form>
    </div>
@endsection