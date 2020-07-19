@extends('web.backend.layouts.app')

@section('title', __('sections/menuTypes.title'))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('types.index') }}">@yield('title')</a></li>
    <li class="breadcrumb-item active">@lang('sections/menuTypes.actions.edit')</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form role="form" method="POST" action="{{ route('types.update', $type->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Basic Details</h3>

                            <div class="card-tools">
                                @required <b> = required</b>
                            </div>
                        </div>

                        <div class="card-body row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Name @required</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $type->name) }}" placeholder="Name" required>
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
