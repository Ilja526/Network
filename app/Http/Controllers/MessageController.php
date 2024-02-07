<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\Friendship;
use App\Models\Message;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function show(Friendship $friendship){
        $messages = Message::where('friendship_id', $friendship->id)->orderBy('id', 'desc')->get();
        return view('messages', compact('messages', 'friendship'));
    }

    public function create(Friendship $friendship, MessageRequest $request){
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

        Message::create([
            'user_id'=>$user->id,
            'friendship_id' => $friendship->id,
            'content'=>$request->validated('content'),
            'image'=>$imageFilename,
            'file'=>$filename,
            'file_origin_name'=>$FileOriginName
        ]);

        return redirect()->back()->with('success', 'Message has been created.');
    }

    public function delete(Message $message){
        $user = auth()->guard('web')->user();
        if($user->id == $message->user_id){
            $message->delete();
        }
        return redirect()->back()->with('success', 'Message has been delete.');
    }
}
