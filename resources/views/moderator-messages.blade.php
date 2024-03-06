@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Messages') }}
                        ({{$user->name}})
                    </div>
                    <div class="card">
                        @foreach($messages as $message)
                            <div class="card mt-3">
                                @if($message->image)
                                    <img class="card-img-top" src="{{ sprintf('/storage/images/%s', $message->image) }}">
                                @endif
                                <div class="card-body">
                                    {{$message->user->name}} | {{$message->created_at}}
                                    <br>
                                    {{ $message->content }}
                                    @if($message->file)
                                        <br>
                                        <a href="{{ sprintf('/storage/files/%s', $message->file) }}">{{ $message->file_origin_name }}</a>
                                    @endif
                                    <form action="{{ route('moderator.delete-message',$message) }}" method="POST">
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
