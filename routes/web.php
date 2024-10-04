<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PostController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/allPost', [PostController::class,'allPost'])->name('allPost');
Route::get('/allPost/{post}', [PostController::class, 'show'])->name('allPost.detail');

Route::get('/myPost', [PostController::class,'myPost'])->name('myPost');
Route::get('/myPost/add', [PostController::class,'create'])->name('myPost.add');
Route::post('/myPost/', [PostController::class,'store'])->name('myPost.store');
Route::get('/myPost/edit/{post}', [PostController::class,'edit'])->name('myPost.edit');
Route::put('/myPost/{post}', [PostController::class,'update'])->name('myPost.update');
Route::delete('/myPost/{post}', [PostController::class,'destroy'])->name('myPost.destroy');


Route::post('/post/toggle-like', [LikeController::class, 'toggleLike'])->middleware('auth');

Route::resource('/comments', CommentController::class)->middleware('auth');
// Route::get('/landingPage', [PostController::class, 'landingPage'])->name('landingPage');
require __DIR__.'/auth.php';
