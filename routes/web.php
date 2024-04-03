<?php

use App\Http\Controllers\FriendsController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ModeratorDashboardController;
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
    Route::get('/messages/show/{friendship}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/create/{friendship}', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages/delete/{message}', [MessageController::class, 'delete'])->name('messages.delete');
    Route::get('/moderator/users', [ModeratorDashboardController::class, 'users'])->name('moderator.users');
    Route::get('/moderator/{user}/posts', [ModeratorDashboardController::class, 'posts'])->name('moderator.posts');
    Route::post('/moderator/{post}/delete-post', [ModeratorDashboardController::class, 'deletePost'])->name('moderator.delete-post');
    Route::post('/moderator/{user}/create-moderator', [ModeratorDashboardController::class, 'createModerator'])->name('moderator.create-moderator');
    Route::post('/moderator/{user}/delete-moderator', [ModeratorDashboardController::class, 'deleteModerator'])->name('moderator.delete-moderator');
    Route::get('/moderator/{user}/messages', [ModeratorDashboardController::class, 'messages'])->name('moderator.messages');
    Route::post('/moderator/{message}/delete-messages', [ModeratorDashboardController::class, 'deleteMessage'])->name('moderator.delete-message');
    Route::post('/comment/create/{post}', [PostController::class, 'createComment'])->name('comment.create');
    Route::post('/comment/delete/{comment}', [PostController::class, 'deleteComment'])->name('comment.delete');
    Route::get('/groups', [GroupController::class, 'index'])->name('group.index');
    Route::get('/group/create/', [GroupController::class, 'create'])->name('group.create');
    Route::post('/group/store/', [GroupController::class, 'store'])->name('group.store');
    Route::post('/group/{group}/update/', [GroupController::class, 'update'])->name('group.update');
    Route::get('/group/{group}/edit/', [GroupController::class, 'edit'])->name('group.edit');
    Route::post('/group/{group}/delete/', [GroupController::class, 'delete'])->name('group.delete');
    Route::post('/group/{group}/{user}/invite/', [GroupController::class, 'invite'])->name('group.invite');
    Route::post('/group/{group_invite}/accept/', [GroupController::class, 'acceptInvite'])->name('group.accept-invite');
    Route::post('/group/{group_invite}/reject/', [GroupController::class, 'rejectInvite'])->name('group.reject-invite');
});

Auth::routes();
