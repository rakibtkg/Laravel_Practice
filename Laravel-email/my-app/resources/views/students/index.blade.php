<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
</head>
<body>
    <h1>Students</h1>

    <ul>
        @foreach($students as $student)
            <li>{{ $student->name }} — {{ $student->email }}</li>
        @endforeach
    </ul>

    <div style="margin-top:20px">
        @if($students->onFirstPage())
            <span>Previous</span>
        @else
            <a href="{{ $students->previousPageUrl() }}">Previous</a>
        @endif

        |

        @if($students->hasMorePages())
            <a href="{{ $students->nextPageUrl() }}">Next</a>
        @else
            <span>Next</span>
        @endif
    </div>

</body>
</html>
