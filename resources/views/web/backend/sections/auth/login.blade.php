@extends('web.backend.layouts.plain')

@section('class', 'login-page')

@section('content')
<div class="login-box">
    <div class="login-logo">
        {{ config('app.name', 'Laravel') }}
    </div>

    <div class="card">
        <div class="card-body login-card-body pb-0">
            <p class="login-box-msg">{{ __('Login') }}</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ __('Email') }}" required autocomplete="email" autofocus>

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
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" required autocomplete="current-password">

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

                <div class="row">
                    <div class="col-8">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                        </div>
                    </div>

                    <div class="col-4">
                        <button type="submit" class="btn btn-primary float-right">{{ __('Login') }}</button>
                    </div>
                </div>
            </form>

            <p class="mt-5 mb-2">
                @if (Route::has('password.request'))
                    <a class="btn btn-link pl-0" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                @endif
            </p>
        </div>
    </div>
</div>
@endsection
