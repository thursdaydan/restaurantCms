@extends('web.backend.layouts.plain')

@section('class', 'login-page')

@section('content')
<div class="login-box">
    <div class="login-logo">
        {{ config('app.name', 'Laravel') }}
    </div>

    <div class="card">
        <div class="card-body login-card-body pb-0">
            <p class="login-box-msg">{{ __('Reset Password') }}</p>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" placeholder="{{ __('Email Address') }}" autocomplete="email" autofocus>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            @svg('solid/envelope')
                        </div>
                    </div>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" required autocomplete="new-password">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            @svg('solid/lock')
                        </div>
                    </div>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required autocomplete="new-password">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            @svg('solid/lock')
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('Reset Password') }}</button>
                    </div>
                </div>
            </form>

            <p class="mt-5 mb-2">
                <a href="{{ url('login') }}" class="btn btn-link pl-0">{{ __('Login') }}</a>
            </p>
        </div>
    </div>
</div>
@endsection
