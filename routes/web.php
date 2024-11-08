<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home Page Route
Route::get('/', [PostController::class, 'index'])->name('home');

// Authentication Routes
require __DIR__ . '/auth.php';

// Dashboard Route (Requires Authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

// Admin Routes (Requires Authentication)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Home/Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Post Management
    Route::resource('posts', PostController::class);

    // Category Management
    Route::resource('categories', CategoryController::class);

    // Comment Management (Delete)
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Post Routes
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

// Comment Routes
Route::post('/posts/{post:slug}/comments', [CommentController::class, 'store'])->name('comments.store');

