<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Routing\Route;

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);
