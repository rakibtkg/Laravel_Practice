<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Picture</title>
</head>
<body>
    @if(session('status'))
        <p style="color:green">{{ session('status') }}</p>
    @endif

    <h2>{{ $user ? ($user->name . "'s Profile") : 'Profile' }}</h2>

    <div>
        @if(isset($user) && $user && $user->profile_picture)
            <img src="{{ asset($user->profile_picture) }}" alt="Profile" style="max-width:200px">
        @else
            <p>No profile picture uploaded.</p>
        @endif
    </div>

    <form action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="profile_picture">Choose image (max 2MB):</label>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*" required>
            @error('profile_picture')<div style="color:red">{{ $message }}</div>@enderror
        </div>
        <button type="submit">Upload</button>
    </form>
</body>
</html>