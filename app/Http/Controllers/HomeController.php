<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = auth()->guard('web')->user()->posts;
        return view('home', compact('posts'));
    }

    public function searchPost(Request $request)
    {
        $value = $request->get('name');
        if(is_array($value)){
            $value = '';
        }
        $value = trim($value);

        $posts = null;
        if($value !== ''){
            $posts = Post::whereIn('user_id', static function ($query) use ($value) {
                $query->select('id')->from('users')->where('name', 'like', "%$value%")->orWhere('email', 'like', "%$value%");
            })->get();
        }


        return view('posts-search-result', compact('posts'));
    }
}
