<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enter Book</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 24px;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
        }

        .form-panel {
            border: 1px solid #eee;
            padding: 16px;
            border-radius: 6px;
            background: #fafafa;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: 600;
        }

        input[type=text],
        input[type=date],
        input[type=email],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .actions {
            margin-top: 12px;
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            color: #fff;
            background: #6c757d;
            border: none;
            cursor: pointer;
        }

        .btn-save {
            background: #198754;
        }

        .btn-cancel {
            background: #6c757d;
        }

        .errors {
            background: #f8d7da;
            color: #842029;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .hint {
            color: #666;
            font-size: 0.95rem;
            margin-top: 6px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="topbar">
            <h1>Enter New Book</h1>

            <div>
                <a href="{{ route('book-show') }}" class="btn btn-edit" style="margin-right:8px;">Book-Show</a>
                <a href="{{ route('book-enter') }}" class="btn btn-cancel">Book-Enter</a>
            </div>
        </div>

        <div class="form-panel">
            @if ($errors->any())
            <div class="errors">
                <strong>There were some problems with your input:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @php
            // Determine edit mode and compute safe input defaults without accessing properties on null.
            $isEdit = isset($book);
            // Use null-safe operator (PHP 8) to avoid reading properties on null.
            $titleVal = old('title', $book?->title ?? '');
            $authorVal = old('author', $book?->author ?? '');
            $publishedVal = old('published_date', $book?->published_date?->format('Y-m-d') ?? '');
            $genreVal = old('genre', $book?->genre ?? '');
            @endphp

            <form method="POST" action="{{ $isEdit ? route('books.update', $book->id) : route('books.store') }}">
                @csrf
                @if($isEdit)
                @method('PUT')
                @endif

                <label for="title">Title</label>
                <input id="title" name="title" type="text" value="{{ $titleVal }}" required>

                <label for="author">Author</label>
                <input id="author" name="author" type="text" value="{{ $authorVal }}" required>

                <label for="published_date">Published Date</label>
                <input id="published_date" name="published_date" type="date" value="{{ $publishedVal }}" required>

                <label for="genre">Genre</label>
                <input id="genre" name="genre" type="text" value="{{ $genreVal }}" required>

                <div class="actions">
                    <button type="submit" class="btn btn-save">{{ $isEdit ? 'Update Book' : 'Save Book' }}</button>
                    <a href="{{ route('books.index') }}" class="btn btn-cancel" role="button">Back to list</a>
                </div>

                <div class="hint">All fields are required when entering a new book.</div>
            </form>
        </div>
    </div>
</body>

</html>