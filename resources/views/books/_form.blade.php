<div class="form-group">
    <label for="title">Title</label>
    <input type="text" id="title" name="title" value="{{ old('title', $book->title ?? '') }}">
    @error('title') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="author">Author</label>
    <input type="text" id="author" name="author" value="{{ old('author', $book->author ?? '') }}">
    @error('author') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="status">Status</label>
    <select id="status" name="status">
        @foreach ($labels as $value => $label)
            <option value="{{ $value }}" {{ old('status', $book->status ?? 'to_read') === $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('status') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="rating">Rating</label>
    <select id="rating" name="rating">
        <option value="">No rating</option>
        @for ($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}" {{ (string) old('rating', $book->rating ?? '') === (string) $i ? 'selected' : '' }}>
                {{ str_repeat('★', $i) }} ({{ $i }})
            </option>
        @endfor
    </select>
    <div class="hint">Only saved when the status is Finished.</div>
    @error('rating') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-actions">
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('books.index') }}">Cancel</a>
</div>