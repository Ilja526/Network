@extends('layouts.app')

@section('content')
@include('post-form')
<div class="container mt-3">
    @foreach($posts as $post)
        <div class="card mt-3">
            @if($post->image)
                <img class="card-img-top" src="{{ sprintf('/storage/images/%s', $post->image) }}">
            @endif
            <div class="card-body">
                {{ $post->content }}
                <form action="{{ route('post.delete',$post) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">delete</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
