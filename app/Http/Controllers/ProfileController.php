<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateValidationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(){
        $user = auth()->guard('web')->user();
        return view('profile', compact('user'));
    }
    public function update(ProfileUpdateValidationRequest $request){
        $data = ['name'=>$request->validated('name'), 'email'=>$request->validated('email')];
        $password = $request->validated('password');
        if($password !== null){
            $data['password'] = Hash::make($password);
        }
        $user = auth()->guard('web')->user();
        $user->update($data);
        return redirect()->route('home');
    }
}
