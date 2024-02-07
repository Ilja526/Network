@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Message') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('messages.create', $friendship) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="content" class="col-md-4 col-form-label text-md-end">{{ __('Content') }}</label>

                                <div class="col-md-6">
                                    <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content">{{ old('content') }}</textarea>

                                    @error('Content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>

                                <div class="col-md-6">
                                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image">

                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="file" class="col-md-4 col-form-label text-md-end">{{ __('File') }}</label>

                                <div class="col-md-6">
                                    <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file">

                                    @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                @if(Auth::user()->id == $message->user_id)
                    <form action="{{ route('messages.delete',$message) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger float-end">delete</button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach

@endsection
