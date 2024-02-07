@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Posts') }}
                        ({{$user->name}})
                    </div>
                    <div class="card">
                        @foreach($posts as $post)
                            <div class="card mt-3">
                                @if($post->image)
                                    <img class="card-img-top" src="{{ sprintf('/storage/images/%s', $post->image) }}">
                                @endif
                                <div class="card-body">
                                    {{$post->user->name}} | {{$post->created_at}}
                                    <br>
                                    {{ $post->content }}
                                    @if($post->file)
                                        <br>
                                        <a href="{{ sprintf('/storage/files/%s', $post->file) }}">{{ $post->file_origin_name }}</a>
                                    @endif
                                        <form action="{{ route('moderator.delete-post',$post) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger float-end">delete</button>
                                        </form>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>

@endsection
