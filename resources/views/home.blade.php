@extends('layouts.app')

@section('content')
@include('post-form')
<div class="container mt-3">
    @foreach($posts as $post)
        @include('post', ['post' => $post, 'allowDelete' => true])
    @endforeach
</div>
@endsection
