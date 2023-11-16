@extends('layouts.app')

@section('content')
@if($posts && $posts->count())
    @foreach($posts as $post)
        @include('post', ['post' => $post, 'allowDelete' => false])
    @endforeach
@else
    Friends not found
@endif
@endsection
