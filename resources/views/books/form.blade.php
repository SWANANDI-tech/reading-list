<label for="title">Title</label>
<input type="text" id="title" name="title" value="{{ old('title', $book->title ?? '') }}">
@error('title') <div class="error">{{ $message }}</div> @enderror

<label for="author">Author</label>
<input type="text" id="author" name="author" value="{{ old('author', $book->author ?? '') }}">
@error('author') <div class="error">{{ $message }}</div> @enderror

<label for="status">Status</label>
<select id="status" name="status">
    @foreach (\App\Models\Book::STATUSES as $value => $label)
        <option value="{{ $value }}"
            {{ old('status', $book->status ?? 'to-read') === $value ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>
@error('status') <div class="error">{{ $message }}</div> @enderror

<p>
    <button type="submit" class="btn">Save</button>
    <a href="{{ route('books.index') }}">Cancel</a>
</p>