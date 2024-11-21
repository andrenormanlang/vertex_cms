<?php

use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
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

// Public Tag Route (Move outside admin group)
Route::get('/tags/{name}', [TagController::class, 'show'])->name('tags.show');

// Public Post Routes
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

// Comment Routes
Route::post('/posts/{post:slug}/comments', [CommentController::class, 'store'])->name('comments.store');

// DashBoard Route (Requires Authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

// Admin Routes (Requires Authentication)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Post Management
    Route::resource('posts', AdminPostController::class);

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

// Custom Pages Routes (Move this to the end)
// Add a constraint to slug to avoid matching unintended routes
Route::get('/{slug}', [PageController::class, 'show'])->where('slug', '^[a-zA-Z0-9\-]+$')->name('pages.show');
