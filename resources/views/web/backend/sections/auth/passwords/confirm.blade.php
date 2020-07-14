@extends('web.backend.layouts.plain')

@section('class', 'login-page')

@section('content')
<div class="login-box">
    <div class="login-logo">
        {{ config('app.name', 'Laravel') }}
    </div>

    <div class="card">
        <div class="card-body login-card-body pb-0">
            <p class="login-box-msg">{{ __('Please confirm your password before continuing.') }}</p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="input-group mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" autocomplete="current-password">

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
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Confirm Password') }}</button>
                </div>
            </form>

            @if (Route::has('password.request'))
                <p class="mt-5 mb-2">
                    <a href="{{ route('password.request') }}" class="btn btn-link pl-0">{{ __('Forgot Your Password?') }}</a>
                </p>
            @endif
        </div>
    </div>
</div>
@endsection
