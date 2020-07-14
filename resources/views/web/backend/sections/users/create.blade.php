@extends('web.backend.layouts.app')

@section('title', __('sections/users.title'))

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('users.index') }}">@yield('title')</a></li>
<li class="breadcrumb-item active">Add User</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <form role="form" method="POST" action="{{ route('users.store') }}">
                @csrf

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add User</h3>

                        <div class="card-tools">
                            @required <b> = required</b>
                        </div>
                    </div>

                    <div class="card-body row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">Name @required</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Name" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address @required</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="password">Password @required</label>
                                <input type="password" class="form-control" id="password" name="password" value="" placeholder="Password" required>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password @required</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="" placeholder="Confirm Password" required>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary">@svg('solid/save') Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
