<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    public function searchFriends(Request $request)
    {
        $user = auth()->guard('web')->user();
        $content = $request->get('content');
        $users = null;

        if($content && !is_array($content)){
            $users = User::where('email', 'like', sprintf('%%%s%%', $content))
                ->where('id', '!=', $user->id)->get();

        }


        return view('search-friends', compact('users'));
    }
}
