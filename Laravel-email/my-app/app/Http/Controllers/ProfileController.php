<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::check() ? User::find(Auth::id()) : null;
        return view('profilePicture', compact('user'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|max:100', // 100KB
        ]);

        // Allow uploads without authentication. If user is authenticated,
        // link the uploaded file to their profile; otherwise just store the file.
        $user = Auth::check() ? User::find(Auth::id()) : null;

        $file = $request->file('profile_picture');
        $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

        // Save to existing `public/upload` folder (project has `public/upload`)
        $uploadDir = public_path('upload');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $file->move($uploadDir, $filename);

        if ($user) {
            // store relative path used by asset() in views
            $user->update([
                'profile_picture' => 'upload/' . $filename,
            ]);
            return back()->with('status', 'Profile picture updated.');
        }

        // Uploaded successfully but not linked to any user account.
        return back()->with('status', 'File uploaded (not linked to an account).');
    }
}
