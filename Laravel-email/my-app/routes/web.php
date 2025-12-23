<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdmitController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/profile/upload', [ProfileController::class, 'upload'])->name('profile.upload');
Route::get('/profile/upload', function () {
    return redirect()->route('profile.show');
})->name('profile.upload.redirect');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.perform');
Route::get('/students', [StudentController::class, 'index'])->name('students.index');

Route::get('/products', [ProductController::class, 'indexPage'])->name('products.index');

// Products Report Page
Route::get('/products-report', [ProductController::class, 'report'])->name('products.report');

// Excel Export Route
Route::get('/export-products-excel', [ProductController::class, 'exportExcel'])->name('export.products.excel');

// Admit Card Routes
Route::get('/generate-admit', [AdmitController::class, 'showForm'])->name('admit.form');
Route::post('/generate-admit', [AdmitController::class, 'generatePDF'])->name('admit.generate');
