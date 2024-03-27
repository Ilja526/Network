@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">

                                {{ __('Groups') }}
                            </div>
                            <div class="col-6 text-end">
                                <a href="{{ route("group.create") }}">{{ __('Create Group') }}</a>
                            </div>
                        </div>




                    </div>
                    <div class="card">
                        @foreach($groups as $group)
                            <div class="row">
                                <div class="col-6">
                                    {{ $group->name }}
                                </div>
                                <div class="col-6">

                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
