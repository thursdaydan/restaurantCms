@extends('web.backend.layouts.app')

@section('title', $menu->name)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('menus.index') }}">@yield('title')</a></li>
    <li class="breadcrumb-item active">Show Menu</li>
@endsection

@section('content')
    <div class="container-fluid">
        @include('web.backend.sections.menus._includes.status')

        <div class="row">
            @include('web.backend.sections.menus._includes.profile-sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#structure" data-toggle="tab">Structure</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            @include('web.backend.sections.menus._includes.structure')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
