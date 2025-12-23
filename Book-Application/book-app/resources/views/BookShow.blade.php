<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Books</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 24px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #f4f4f4;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
            color: #fff;
        }

        .btn-edit {
            background: #0d6efd;
        }

        .btn-delete {
            background: #dc3545;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .login-panel {
            border: 1px dashed #bbb;
            padding: 12px;
            border-radius: 6px;
            max-width: 360px;
        }

        .info {
            margin-top: 8px;
            color: #666;
            font-size: 0.95rem;
        }
        .buttons{
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
            color: red;
            background-color: #bbb;
        }
        .btn-show{
            color: red;
            background-color: blueviolet;
        }
        .btn-enter{
            color: red;
            background-color: blanchedalmond;
        }

        .topbar{
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            background-color: lightgreen;
            padding: 12px;
            border-radius: 16px;
        }

        .topbar h1{
            color: white;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="topbar">
            <h1>Books</h1>

            <div class="buttons">
                <a href="{{ route('book-show') }}" class="btn btn-show" style="margin-right:8px;">Book-Show</a>
                <a href="{{ route('book-enter') }}" class="btn btn-enter">Book-Enter</a>
            </div>
        </div>

        <div class="search-for-help">
            <input type="text" placeholder="Search for a book..." style="padding:8px; border:1px solid #ccc; border-radius:4px;">
            <button style="padding:8px 12px; border:none; border-radius:4px; background-color:#0d6efd; color:white;">Search</button>
            <p class="retrive-data">
                <strong>Search Results:</strong>
                <ul>
                    <li>No results found.</li>
                </ul>
            </p>
        </div>

        @if (session('status'))
            <div style="margin-top:12px; padding:10px; background:#e9f7ef; border:1px solid #c7eed6;">
                {{ session('status') }}
            </div>
        @endif

        <!-- Search form -->
        <form method="GET" action="{{ route('book-show') }}" class="search-for-help" style="margin-top:12px; display:flex; gap:8px; align-items:center;">
            <input type="text" name="q" placeholder="Search for a book..." value="{{ $q ?? '' }}" style="padding:8px; border:1px solid #ccc; border-radius:4px; width:320px;">
            <button type="submit" style="padding:8px 12px; border:none; border-radius:4px; background-color:#0d6efd; color:white;">Search</button>
        </form>

        @if(isset($q))
            <p class="retrive-data" style="margin-top:12px;">
                <strong>Search Results for "{{ $q }}":</strong>
                <ul>
                    @forelse($books as $b)
                        <li>{{ $b->title }} — {{ $b->author }} ({{ optional($b->published_date)->format('Y-m-d') ?? '-' }})</li>
                    @empty
                        <li>No results found.</li>
                    @endforelse
                </ul>
            </p>
        @endif

        @if (!isset($q) || $q === null || $q === '')
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Published</th>
                    <th>Genre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                <tr>
                    <td>{{ $book->id }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ optional($book->published_date)->format('Y-m-d') ?? '-' }}</td>
                    <td>{{ $book->genre ?? '-' }}</td>
                    <td>
                        <div class="actions">
                            <a class="btn btn-edit" href="{{ route('books.edit', $book->id) }}">Edit</a>

                            <form method="POST" action="{{ route('books.destroy', $book->id) }}" onsubmit="return confirm('Are you sure you want to delete this book?');" style="display:inline-block; margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
                <div style="margin-top:12px; padding:10px; background:red; border:1px solid #c7eed6; color:white">
                    No books found.
                </div>
        @endif
    </div>

</body>

</html>