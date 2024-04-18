<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Http\Requests\PostCreateValidationRequest;
use App\Models\Group;
use App\Models\GroupInvite;
use App\Models\GroupPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $groupInvite->group->users()->attach($this->user->id);
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

    public function showGroupPosts(Group $group){
        return view('group-show-posts', compact('group'));
    }

    public function createGroupPost(Group $group, PostCreateValidationRequest $request){

        $user = auth()->guard('web')->user();
        $imageFilename = null;
        $image = $request->validated('image');
        if($image){
            $extension = $image->extension();
            $imageFilename = $extension === '' ? Str::uuid() : sprintf('%s.%s', Str::uuid(), $extension);
            $image->storeAs('images', $imageFilename, 'public');
        }

        $filename = null;
        $FileOriginName = null;
        $file = $request->validated('file');
        if($file){
            $extension = $file->extension();
            $filename = $extension === '' ? Str::uuid() : sprintf('%s.%s', Str::uuid(), $extension);
            $file->storeAs('files', $filename, 'public');
            $FileOriginName = $file->getClientOriginalName();
        }

        GroupPost::create([
            'user_id'=>$user->id,
            'group_id'=>$group->id,
            'content'=>$request->validated('content'),
            'image'=>$imageFilename,
            'file'=>$filename,
            'file_origin_name'=>$FileOriginName
        ]);

        return redirect()->back()->with('success', 'Post has been created.');
    }

    public function deleteGroupPost(GroupPost $groupPost){
        if((int) $groupPost->user_id === (int) $this->user->id){
            $groupPost->delete();
        }

        return redirect()->back()->with('success', 'Post has been deleted.');
    }
}
