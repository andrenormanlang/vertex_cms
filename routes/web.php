<?php

use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController as ControllersPostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home Page Route
Route::get('/', [ControllersPostController::class, 'index'])->name('home');

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

// Admin Routes (Requires Authentication & Admin Middleware)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Home/Dashboard
    // Route::get('/', [AdminController::class, 'index'])->name('index');

    // Post Management
    Route::resource('posts', AdminPostController::class);

    Route::get('/tags/{name}', [TagController::class, 'show'])->name('tags.show');

    // Category Management
    Route::resource('categories', CategoryController::class);

    // Page Management
    Route::resource('pages', PageController::class);

    // Theme Management
    Route::get('themes', [ThemeController::class, 'index'])->name('themes.index');
    Route::post('themes/change', [ThemeController::class, 'changeTheme'])->name('themes.change');

    // Comment Management (Delete)
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Post Routes
Route::get('/posts/{slug}', [ControllersPostController::class, 'show'])->name('posts.show');

// Comment Routes
Route::post('/posts/{post:slug}/comments', [CommentController::class, 'store'])->name('comments.store');

// Custom Pages Routes
Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');
