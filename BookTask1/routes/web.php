<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::post('/books',[BookController::class,'store'])->name('books.store');
Route::get('/books/{book}/edit',[BookController::class,'edit'])->name('books.edit');
Route::put('/books/{book}',[BookController::class,'update'])->name('books.update');
Route::delete('/books/{book}',[BookController::class,'destroy'])->name('books.destroy');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {

    Route::resource('books', BookController::class);
    Route::resource('categories', CategoryController::class);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
Route::get('/', function () {
    return view('index');
})->name('home');
