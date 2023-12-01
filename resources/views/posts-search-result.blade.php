@extends('layouts.app')

@section('content')
@if($posts && $posts->count())
    @foreach($posts as $post)
            @include('post', ['post' => $post, 'allowDelete' => $post->user_id == Auth::user()->id])
    @endforeach
@else
    <div class="alert alert-danger text-lg-center" role="alert">
        Friends not found
    </div>
@endif
@endsection
