<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use App\Models\GroupInvite;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    private User $user;
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->user = auth()->guard('web')->user();
            return $next($request);
        });
    }

    public function index(){
        $groups = Group::where('user_id', $this->user->id)->get();
        return view('group-index', compact('groups')+['user'=>$this->user]);
    }


    public function create(){
        $group = new Group();
        return view('group-form', compact('group'));
    }

    public function store(GroupRequest $request){
        $group = Group::create($request->validated()+['user_id'=>$this->user->id]);
        $group->users()->sync([$this->user->id]);
        return redirect()->route('group.index');
    }

    public function edit(Group $group){
        if(!$this->validateGroup($group)){
            return redirect()->back()->with('error', 'access denied');
        }
        return view('group-form', compact('group'));
    }

    public function update(GroupRequest $request, Group $group){
        if(!$this->validateGroup($group)){
            return redirect()->back()->with('error', 'access denied');
        }
        $group->update($request->validated());
        return redirect()->route("group.index");
    }

    public function delete(Group $group){
        if(!$this->validateGroup($group)){
            return redirect()->back()->with('error', 'access denied');
        }
        $group->delete();
        return redirect()->back()->with('success', 'success');
    }

    public function validateGroup(Group $group){
        return (int) $group->user_id  === (int) $this->user->id;
    }

    public function invite(Group $group, User $user){
        if(!$this->validateGroup($group) ||
            isset($user->groups->keyBy('id')[$group->id]) ||
            isset($user->groupInvites->keyBy('group_id')[$group->id])
        ){
            return redirect()->back()->with('error', 'access denied');
        }
        GroupInvite::create([
            'group_id' => $group->id,
            'user_id' => $user->id
        ]);
        return redirect()->route("friend.search");
    }

    public function acceptInvite(GroupInvite $groupInvite){
        if((int) $groupInvite->user_id !== (int) $this->user->id){
            return redirect()->back()->with('error', 'access denied');

        }
        $groupInvite->group->users()->sync([$this->user->id]);
        $groupInvite->delete();
        return redirect()->route("friend.search");
    }

    public function rejectInvite(GroupInvite $groupInvite){
        if((int) $groupInvite->user_id !== (int) $this->user->id){
            return redirect()->back()->with('error', 'access denied');

        }
        $groupInvite->delete();
        return redirect()->route("friend.search");
    }
}
