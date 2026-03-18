<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {

    Route::get('/books/export', [BookController::class, 'export'])->name('books.export');
    Route::resource('books', BookController::class);
    Route::resource('categories', CategoryController::class);

    Route::middleware('role:admin')->group(function () {

        // 1. Activity Logs
        Route::get('/activity-logs', function () {
            $logs = ActivityLog::with('user')->latest()->get();
            return view('logs', compact('logs'));
        })->name('logs.index');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
