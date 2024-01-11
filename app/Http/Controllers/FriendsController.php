<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\Invite;
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
            $users = User::where('email', 'like', sprintf('%%%s%%', $content))->whereNotIn('id', function($query) use($user) {
                $query->select('user_first')->from('friendships')->where('user_first', $user->id)->orWhere('user_second', $user->id);
            })->whereNotIn('id', function($query) use($user) {
                $query->select('user_second')->from('friendships')->where('user_first', $user->id)->orWhere('user_second', $user->id);
            })
                ->where('id', '!=', $user->id)->get();

        }
        $invites = Invite::where('user_to', $user->id)->get();
        $friendships = Friendship::where('user_first', $user->id)->orWhere('user_second', $user->id)->get();
        return view('search-friends', compact('users', 'invites', 'friendships'));
    }

    public function sendFriendRequest(User $user)
    {
        $currentUser = auth()->guard('web')->user();
        $friendAllowed = User::where('id', '!=', $currentUser->id)->where('id', $user->id)->count()>0;
        if(!$friendAllowed){
            return redirect()->back()->with('error', 'Wrong friend has been provided');
        }

        $alreadyExists = Invite::where(['user_from'=> $currentUser->id, 'user_to'=> $user->id])->count()>0;
        if($alreadyExists){
            return redirect()->back()->with('error', 'Wrong friend has been provided');
        }
        $invite = new Invite();
        $invite->user_from = $currentUser->id;
        $invite->user_to = $user->id;
        $invite->save();

        return redirect()->back()->with('success', 'Request has been sent');

    }

    public function acceptFriendship(Invite $invite)
    {
        $currentUser = auth()->guard('web')->user();
        if($invite->user_to != $currentUser->id){
            return redirect()->back()->with('error', 'Wrong invite has been provided');
        }
        $friendship = new Friendship();
        $friendship->user_first = $currentUser->id;
        $friendship->user_second = $invite->user_from;
        $friendship->save();
        $invite->delete();
        return redirect()->back()->with('success', 'Request has been accept');
    }

    public function rejectFriendship(Invite $invite)
    {
        $currentUser = auth()->guard('web')->user();
        if($invite->user_to != $currentUser->id){
            return redirect()->back()->with('error', 'Wrong invite has been provided');
        }
        $invite->delete();
        return redirect()->back()->with('success', 'Request has been reject');
    }
}
