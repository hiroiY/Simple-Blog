<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();


Route::group(['middleware' => 'auth'], function() {
    // Routes within this group require authentication
    // ONLY user who can logged in are allowed to access this route

    Route::get('/', [PostController::class, 'index'])->name('index');

    Route::group(['prefix' => 'post' , 'as' => 'post.'], function() {
        Route::get('/create', [PostController::class, 'create'])->name('create');
        // 'prefix' => 'post' -> uri = /post/create
        // 'as' => 'post.' -> route name = post.create
        // post.create

        Route::post('/store', [PostController::class, 'store'])->name('store');
        // post.store

        Route::get('/{id}/show', [PostController::class, 'show'])->name('show');
        // post.show

        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        // post.edit

        Route::patch('/{id}/update', [PostController::class, 'update'])->name('update');
        // post.update

        Route::delete('{id}/destroy', [PostController::class, 'destroy'])->name('destroy');
        // post.destroy
    });

    Route::group(['prefix' => 'comment' , 'as' => 'comment.'], function() {
        Route::post('/{post_id}/store', [CommentController::class, 'store'])->name('store');
        // comment.store

        Route::delete('{id}/destroy', [CommentController::class, 'destroy'])->name('destroy');
        // comment.destroy
    });

    Route::group(['prefix' => 'profile' , 'as' => 'profile.'], function() {
        Route::get('/', [UserController::class, 'show'])->name('show');
        # profile.show

        Route::get('/edit', [UserController::class, 'edit'])->name('edit');
        # profile.edit

        Route::patch('/update', [UserController::class, 'update'])->name('update');
        # profile.update
    });

});
