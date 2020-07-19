@extends('web.backend.layouts.app')

@section('title', __('sections/menuTypes.title'))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form role="form" method="GET">
                    @csrf

                    <div class="card filter-card {{ request()->exists('submit') ? null : 'collapsed-card' }}">
                        <div class="card-header">
                            <h3 class="card-title">@svg('solid/filter') @lang('sections/menuTypes.filter.title')</h3>

                            <div class="card-tools">
                                @if (request()->exists('submit'))
                                    <a href="{{ route('types.index') }}" class="btn btn-tool" title="Clear Filter">@svg('solid/sync') @lang('sections/menuTypes.filter.clear')</a>
                                @endif

                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    @if (request()->exists('submit'))
                                        @svg('solid/plus', 'filter-collapsed-icon d-none')
                                        @svg('solid/minus', 'filter-expanded-icon')
                                    @else
                                        @svg('solid/plus', 'filter-collapsed-icon')
                                        @svg('solid/minus', 'filter-expanded-icon d-none')
                                    @endif
                                </button>
                            </div>
                        </div>

                        <div class="card-body row">
                            <div class="d-md-flex w-100">
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="name">@lang('sections/menuTypes.fields.name')</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', request('name')) }}" placeholder="Name">
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="created_at">@lang('sections/menuTypes.fields.created_at')</label>
                                        <input type="text" id="created_at" class="form-control range-picker" name="created_at" value="{{ old('created_at', request('created_at')) }}" placeholder="Publish Date" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                </div>

                                <div class="col-12 col-md-3">
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="col-12 col-md-3 float-left">
                                <div class="pretty p-switch p-fill">
                                    <input type="checkbox" id="with_archived" name="with_archived" value="1" {{ old('with_archived', request('with_archived')) ? 'checked' : null }} />
                                    <div class="state p-primary">
                                        <label>@lang('sections/menuTypes.archived')</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-3 float-right">
                                <button type="submit" name="submit" class="btn btn-block btn-primary float-right">@lang('sections/menuTypes.filter.action')</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="card index-card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('sections/menuTypes.sub_title')</h3>

                        <div class="card-tools">
                            <a href="{{ route('types.create') }}" class="btn btn-xs btn-primary" title="@lang('sections/menuTypes.actions.create')">@svg('regular/plus') @lang('sections/menuTypes.actions.create')</a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <table class="table index-table">
                            <thead>
                            <tr>
                                <th>@lang('sections/menuTypes.fields.name')</th>
                                <th>@lang('sections/menuTypes.fields.created_at')</th>
                                <th>@lang('sections/menuTypes.fields.actions')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse ($types as $type)
                                <tr data-id="{{ $type->id }}" data-delete-url="{{ route('types.destroy', $type->id) }}" data-restore-url="{{ route('types.restore', $type->id) }}" data-section="{{ Str::singular(__('sections/menuTypes.title')) }}">
                                    <td>
                                        {{ ! $type->trashed() ? svg('solid/circle', 'icon-sm text-transparent') : svg('solid/circle', 'icon-sm text-red') }}
                                        {{ $type->name }}
                                    </td>
                                    <td>{{ $type->created_at->format('j F, Y') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('types.edit', $type->id) }}" class="btn btn-sm btn-primary btn-edit" title="@lang('sections/menuTypes.actions.edit')">@svg('regular/edit')</a>

                                            @if (! $type->trashed())
                                                <button type="button" class="btn btn-sm btn-danger btn-delete" title="@lang('sections/menuTypes.actions.delete')">@svg('regular/trash')</button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-primary btn-restore" title="@lang('sections/menuTypes.actions.restore')">@svg('regular/trash-restore')</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="empty-table">@lang('sections/menuTypes.empty')</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer">
                        {{ $types->links() }}

                        <span class="float-right d-inline-block">
                            <small><span class="itemsCount">{{ $types->total() }}</span> <span class="itemsVerb">{{ \Str::plural('type', $types->total()) }}</span></small>
                        </span>
                    </div>
                </div>

                @svg('solid/circle', ' icon-sm text-red') <b> = @lang('sections/menuTypes.archived')</b>
            </div>
        </div>
    </div>
@endsection
