@extends('web.backend.layouts.plain')

@section('class', 'register-page')

@section('content')
<div class="register-box">
    <div class="register-logo">
        {{ config('app.name', 'Laravel') }}
    </div>

    <div class="card">
        <div class="card-body register-card-body pb-0">
            <p class="login-box-msg">{{ __('Register') }}</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="input-group mb-3">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="{{ __('Name') }}" required autocomplete="name" autofocus>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            @svg('solid/user')
                        </div>
                    </div>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ __('Email Address') }}" required autocomplete="email">

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
                        <button type="submit" class="btn btn-primary btn-block">{{ __('Register') }}</button>
                    </div>
                </div>
            </form>

            <p class="mt-5 mb-2">
                <a href="{{ url('login') }}" class="btn btn-link text-center pl-0">Already a member?</a>
            </p>
        </div>
    </div>
</div>
@endsection
