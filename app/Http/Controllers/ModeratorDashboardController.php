<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ModeratorDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(static function ($request, $next) {
            if (!auth()->check() || !auth()->user()->moderator) {
                abort(404);
            }

            return $next($request);
        });
    }

    public function users(){
        $users = User::all();
        return view('moderator-users', compact('users'));
    }

    public function posts(User $user){
        $posts = Post::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        return view('moderator-posts', compact('posts', 'user'));
    }

    public function deletePost(Post $post){
        $post->delete();
        return redirect()->back();
    }

    public function createModerator(User $user){
        if(!$user->moderator){
            $user->update(['moderator'=> true]);
        }
        return redirect()->back();
    }

    public function deleteModerator(User $user){
        if($user->moderator){
            $user->update(['moderator'=> false]);
        }
        return redirect()->back();
    }

    public function messages(User $user){
        $messages = Message::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        return view('moderator-messages', compact('messages', 'user'));
    }

    public function deleteMessage(Message $message){
        $message->delete();
        return redirect()->back();
    }
}
