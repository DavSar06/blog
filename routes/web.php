<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('dashboard');
Route::get('/post/{id}', [PostController::class, 'read'])->name('post.show');
Route::get('/search', [PostController::class, 'search'])->name('search');
Route::get('/mysearch', [UserController::class, 'search'])->name('mysearch');
// Need to be Authenticated and Verified
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage', [UserController::class, 'userPosts'])->name('userPosts');
    Route::get('/posts/create', [PostController::class, 'showCreatePage'])->name('post.create');
    Route::post('/publish', [PostController::class, 'create'])->name('post.store');
    Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/post/{id}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post/{id}', [PostController::class, 'delete'])->name('post.delete');

    // Auth Links
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
