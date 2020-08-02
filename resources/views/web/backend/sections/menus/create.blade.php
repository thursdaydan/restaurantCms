@extends('web.backend.layouts.app')

@section('title', __('sections/menus.title'))

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('menus.index') }}">@yield('title')</a></li>
<li class="breadcrumb-item active">@lang('sections/menus.actions.create')</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <form role="form" method="POST" action="{{ route('menus.store') }}">
                @csrf

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">>@lang('sections/menus.headings.basic_card')</h3>

                        <div class="card-tools">
                            @required <b> = >@lang('sections/menus.required')</b>
                        </div>
                    </div>

                    <div class="card-body row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">>@lang('sections/menus.fields.name') @required</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Name" required>
                            </div>

                            <div class="form-group">
                                <label for="description">@lang('sections/menus.fields.description') @required</label>
                                <textarea class="form-control" id="description" name="description" rows="5" placeholder="Description" required>{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="status_id">@lang('sections/menus.fields.status') @required</label>
                                <select class="form-control" id="status_id" name="status_id" required>
                                    <option value="">Please select a Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}" {{ old('status_id') === $status->id ? 'selected' : null }}>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="type_id">@lang('sections/menus.fields.type') @required</label>
                                <select class="form-control" id="type_id" name="type_id" required>
                                    <option value="">Please select a Type</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}" {{ old('type_id') === $type->id ? 'selected' : null }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('sections/menus.heading.extra_card')</h3>
                    </div>

                    <div class="card-body row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="header_text">@lang('sections/menus.fields.header_text')</label>
                                <textarea class="form-control" id="header_text" name="header_text" rows="5" placeholder="Header Text">{{ old('header_text') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="footer_text">@lang('sections/menus.fields.footer_text')</label>
                                <textarea class="form-control" id="footer_text" name="footer_text" rows="5" placeholder="Footer Text">{{ old('footer_text') }}</textarea>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="publish_at">@lang('sections/menus.fields.publish_at')</label>
                                <input type="text" class="form-control date-picker conditional-required" id="publish_at" name="publish_at" value="{{ old('publish_at') }}" placeholder="Publish Date" data-condition="status_id === '3'" />
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="5" placeholder="Notes">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary">@svg('solid/save') @lang('sections/menus.actions.save')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
