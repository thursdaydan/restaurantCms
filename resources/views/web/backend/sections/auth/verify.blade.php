@extends('web.backend.layouts.plain')

@section('content')
<div class="login-box">
    <div class="login-logo">
        {{ config('app.name', 'Laravel') }}
    </div>

    <div class="card">
        <div class="card-body login-card-body pb-0">
            <p class="login-box-msg">{{ __('Verify Your Email Address') }}</p>

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }},
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
            </form>
        </div>
    </div>
</div>
@endsection
