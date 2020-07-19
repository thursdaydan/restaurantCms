@extends('web.backend.layouts.app')

@section('title', 'Dashboard')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
