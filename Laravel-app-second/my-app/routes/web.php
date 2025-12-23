<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
// Route::get('/', function () {
//     return view('welcome');
// });
//
// Route::get('/hello', function () {
//     $controller = app()->make(App\Http\Controllers\Controller::class);
//     return $controller->hello();
// });
Route::get('/', [HomeController::class, 'home']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('user.login');
Route::post('/login', [LoginController::class, 'login'])->name('user.login.submit');
Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('user.register');
Route::post('/register', [LoginController::class, 'register'])->name('user.register.submit');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
Route::post('/profile', [ProfileController::class, 'getUser'])->name('profile.user.info');