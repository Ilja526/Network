<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateValidationRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function delete(Post $post){
        $user = auth()->guard('web')->user();
        if($post->user_id != $user->id){
            return redirect()->route('home')->with('error', 'Error.');
        }
        if($post->image){
            $filepath = storage_path(sprintf('app/public/images/%s', $post->image));
            if(is_file($filepath)){
                unlink($filepath);
            }
        }
        $post->delete();
        return redirect()->route('home')->with('success', 'Post has been delete.');
    }

    public function create(PostCreateValidationRequest $request){

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

        Post::create([
            'user_id'=>$user->id,
            'content'=>$request->validated('content'),
            'image'=>$imageFilename,
            'file'=>$filename,
            'file_origin_name'=>$FileOriginName
        ]);

        return redirect()->route('home')->with('success', 'Post has been created.');
    }
}
