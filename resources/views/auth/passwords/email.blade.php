@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="wrapper">
                <div class="logo">
                    <img src="https://cdn.icon-icons.com/icons2/50/PNG/256/ning_social_10631.png" alt="">
                </div>
                <div class="text-center mt-4 name">{{ __('Reset Password') }}</div>

                <div class="card-body">

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3 mt-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @if(session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="text-center fs-6">
                            <button type="submit" class="btn btn-dark">
                                    {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
