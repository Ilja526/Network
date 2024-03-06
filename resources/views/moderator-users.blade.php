@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Users') }}
                    </div>
                    <div class="card">
                        @foreach($users as $user)
                            <div class="mb-3">
                                {{ $user->name }}
                                ({{ $user->email }})
                                <a href="{{ route('moderator.posts', $user) }}">Posts</a>
                                <a href="{{ route('moderator.messages', $user) }}">Messages</a>
                            @if(!$user->moderator)
                                <form class="d-inline" action="{{ route('moderator.create-moderator',$user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-success btn btn-sm float-end">Create Moderator</button>
                                </form>
                                @elseif($user->id != Auth::user()->id)
                                    <form class="d-inline" action="{{ route('moderator.delete-moderator',$user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-danger btn btn-sm float-end">Delete Moderator</button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
    </div>

@endsection
