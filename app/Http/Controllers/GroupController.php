<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
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
        return view('group-index', compact('groups'));
    }


    public function create(){
        $group = new Group();
        return view('group-form', compact('group'));
    }

    public function store(GroupRequest $request){
        Group::create($request->validated()+['user_id'=>$this->user->id]);
        return redirect()->route('group.index');
    }

    public function edit(){

    }

    public function update(){

    }

    public function delete(){

    }

    public function validateGroup(){

    }
}
