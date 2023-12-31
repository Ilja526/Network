<?php

use App\Http\Controllers\FriendsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

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

Route::get('/', function () {
    return view('auth.login');
});


Route::group(['middleware'=>'auth'], static function (){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post/delete/{post}', [PostController::class, 'delete'])->name('post.delete');
    Route::get('/post/search', [HomeController::class, 'searchPost'])->name('post.search');
    Route::get('/friends/search', [FriendsController::class, 'searchFriends'])->name('friend.search');
    Route::post('/friends/request/{user}', [FriendsController::class, 'sendFriendRequest'])->name('friend.request');
    Route::post('/friends/invite/{invite}/accept', [FriendsController::class, 'acceptFriendship'])->name('friend.accept');
    Route::post('/friends/invite/{invite}/reject', [FriendsController::class, 'rejectFriendship'])->name('friend.reject');

});

Auth::routes();
