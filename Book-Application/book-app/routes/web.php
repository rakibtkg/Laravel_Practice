<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;

Route::get('/book-show', [BooksController::class, 'index'])->name('book-show');
Route::get('/', [BooksController::class, 'create'])->name('book-enter');

Route::resource('books', BooksController::class);


