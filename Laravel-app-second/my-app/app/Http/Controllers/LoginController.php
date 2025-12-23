<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyUsers;

class LoginController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('login');
    }


    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // 1️⃣ Validate inputs
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:my_users,email',
            'password' => 'required|string|min:3',
        ]);

        // 2️⃣ Save to database (without hashing)
        MyUsers::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'], // ❗ stored as plain text
        ]);
        //send response message
        session()->flash('message', 'Registration successful! Please log in.');

        // 3️⃣ Return response or redirect
        return redirect()->route('user.login')
            ->with('message', 'Registration successful! Please log in.');
    }

    public function login(Request $request)
    {
        // Validate and authenticate the user
        $email = $request->input('email');
        $password = $request->input('password');
        return response()->json([
            'status' => 'error',
            'message' => 'All fields are required'
        ], 422); // 422 = validation error

        $user = MyUsers::where('email', $email)->where('password', $password)->first();
        if (!$user) {
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials'
                ], 401); // 401 = unauthorized
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful!',
            'user_id' => $user->user_id
        ]);


        // You can add more validation and save the user to the database here
    }
}
