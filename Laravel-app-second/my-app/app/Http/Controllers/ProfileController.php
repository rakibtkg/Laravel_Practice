<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MyUsers;

class ProfileController extends Controller
{

    public function profile()
    {
        // Prefer an authenticated user; if none, fall back to the first MyUsers record
    $user = Auth::user();
        if (!$user) {
            $user = MyUsers::first();
        }

        return view('profile', ['user' => $user]);
    }

    public function getUser(Request $request)
    {
        $email = $request->query('email');
        $user = MyUsers::where('email', $email)->first();
        return response()->json([
            'name' => $user->name,
            'email' => $user->email
        ]);
    }
}
