<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateValidationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit(){
        $user = auth()->guard('web')->user();
        return view('profile', compact('user'));
    }
    public function update(ProfileUpdateValidationRequest $request){
        $user = auth()->guard('web')->user();
        $imageFilename = $user->image;
        $image = $request->validated('image');
        if($image){
            if($imageFilename) {
                $filepath = storage_path(sprintf('app/public/images/%s', $imageFilename));
                if (is_file($filepath)) {
                    unlink($filepath);
                }
            }
            $extension = $image->extension();
            $imageFilename = $extension === '' ? Str::uuid() : sprintf('%s.%s', Str::uuid(), $extension);
            $image->storeAs('images', $imageFilename, 'public');
        }

        $data = ['name'=>$request->validated('name'), 'email'=>$request->validated('email'), 'image'=>$imageFilename];
        $password = $request->validated('password');
        if($password !== null){
            $data['password'] = Hash::make($password);
        }
        $user->update($data);
        return redirect()->route('home');
    }
}
