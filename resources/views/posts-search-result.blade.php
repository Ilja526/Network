@extends('layouts.app')

@section('content')
@if($posts && $posts->count())
    @foreach($posts as $post)
        @include('post', ['post' => $post, 'allowDelete' => false])
    @endforeach
@else
    <div class="alert alert-danger text-lg-center" role="alert">
        Friends not found
    </div>
@endif
@endsection
