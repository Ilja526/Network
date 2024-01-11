@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 mb-3">
            @if($friendships->count())
                <ul class="list-group mt-3">
                    @foreach($friendships as $friendship)
                        <li class="list-group-item">{{ $friendship->user_first()->name}}
                            friendly
                            {{ $friendship->user_second()->name}}
                            <a href="{{ route("messages.show", $friendship) }}">Messages</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="col-lg-12">
            @if($invites->count())
                <ul class="list-group mt-3">
                    @foreach($invites as $invite)
                        <li class="list-group-item">{{ $invite->user_from()->name}}
                            <form action="{{ route('friend.accept', $invite) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Accept Friendship</button>
                            </form>
                            <form action="{{ route('friend.reject', $invite) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Reject Friendship</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="col-lg-12">
            <form method="GET" action="{{ route('friend.search') }}">
            <div class="card">
                <div class="card-header">
                    Search For Friends
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label for="content" class="col-md-4 col-form-label text-md-end">{{ __('Search Value') }}</label>

                        <div class="col-md-6">
                            <input id="content" class="form-control @error('content') is-invalid @enderror" value="{{ request('content') }}" name="content">

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Search') }}
                    </button>
                </div>
            </div>
            </form>
            @if($users !== null)
                @if($users->count() === 0)
                    <div class="alert alert-warning mt-3">
                        Friends Are Not Found
                    </div>
                @else
                    <ul class="list-group mt-3">
                        @foreach($users as $user)
                            <li class="list-group-item">{{ $user->name }}
                            <form action="{{ route('friend.request', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">Request Friendship</button>
                            </form>

                            </li>
                        @endforeach
                    </ul>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
