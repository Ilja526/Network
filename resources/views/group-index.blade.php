@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 justify-content-center">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                {{ __('Groups Invites') }}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        @foreach($user->groups as $group)
                            <div class="row">
                                <div class="col-6">
                                    <a href=""> {{ $group->name }} </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8 justify-content-center">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                {{ __('Groups') }}
                            </div>
                            <div class="col-6 text-end">
                                <a href="{{ route('group.create') }}">{{ __('Create Group') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        @foreach($groups as $group)
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route("group.edit", $group) }}"> {{ $group->name }} </a>
                                </div>
                                <div class="col-6 text-end">
                                    <form method="POST" action="{{ route("group.delete", $group) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
