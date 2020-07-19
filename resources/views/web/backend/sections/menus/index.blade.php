@extends('web.backend.layouts.app')

@section('title', __('sections/menus.title'))

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
                            <h3 class="card-title">@svg('solid/filter') @lang('sections/menus.filter.title')</h3>

                            <div class="card-tools">
                                @if (request()->exists('submit'))
                                    <a href="{{ route('menus.index') }}" class="btn btn-tool" title="Clear Filter">@svg('solid/sync') @lang('sections/menus.filter.clear')</a>
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
                                        <label for="name">@lang('sections/menus.fields.name')</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', request('name')) }}" placeholder="Name">
                                    </div>

                                    <div class="form-group">
                                        <label for="author_id">@lang('sections/menus.fields.author')</label>
                                        <select class="form-control" id="author_id" name="author_id">
                                            <option value="">Please select an Author</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ old('author_id', request('author_id')) == $user->id ? 'selected' : null }}>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="status_id">@lang('sections/menus.fields.status')</label>
                                        <select class="form-control" id="status_id" name="status_id">
                                            <option value="">Please select a Status</option>
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->id }}" {{ old('status_id', request('status_id')) == $status->id ? 'selected' : null }}>{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="created_at">@lang('sections/menus.fields.created_at')</label>
                                        <input type="text" id="created_at" class="form-control range-picker" name="created_at" value="{{ old('created_at', request('created_at')) }}" placeholder="Created At" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="type_id">@lang('sections/menus.fields.type')</label>
                                        <select class="form-control" id="type_id" name="type_id">
                                            <option value="">Please select a Type</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type->id }}" {{ old('type_id', request('type_id')) == $type->id ? 'selected' : null }}>{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="publish_at">@lang('sections/menus.fields.publish_at')</label>
                                        <input type="text" id="publish_at" class="form-control range-picker" name="publish_at" value="{{ old('publish_at', request('publish_at')) }}" placeholder="Publish Date" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="col-12 col-md-3 float-left">
                                <div class="pretty p-switch p-fill">
                                    <input type="checkbox" id="with_archived" name="with_archived" value="1" {{ old('with_archived', request('with_archived')) ? 'checked' : null }} />
                                    <div class="state p-primary">
                                        <label>@lang('sections/menus.archived')</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-3 float-right">
                                <button type="submit" name="submit" class="btn btn-block btn-primary float-right">@lang('sections/menus.filter.action')</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="card index-card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('sections/menus.sub_title')</h3>

                        <div class="card-tools">
                            <a href="{{ route('menus.create') }}" class="btn btn-xs btn-primary" title="@lang('sections/menus.actions.create')">@svg('regular/plus') @lang('sections/menus.actions.create')</a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <table class="table index-table">
                            <thead>
                                <tr>
                                    <th>@lang('sections/menus.fields.name')</th>
                                    <th>@lang('sections/menus.fields.status')</th>
                                    <th>@lang('sections/menus.fields.type')</th>
                                    <th>@lang('sections/menus.fields.publish_at')</th>
                                    <th>@lang('sections/menus.fields.author')</th>
                                    <th>@lang('sections/menus.fields.created_at')</th>
                                    <th>@lang('sections/menus.fields.actions')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($menus as $menu)
                                    <tr data-id="{{ $menu->id }}" data-delete-url="{{ route('menus.destroy', $menu->id) }}" data-restore-url="{{ route('menus.restore', $menu->id) }}" data-section="{{ Str::singular(__('sections/menus.title')) }}">
                                        <td>
                                            {{ ! $menu->trashed() ? svg('solid/circle', 'icon-sm text-transparent') : svg('solid/circle', 'icon-sm text-red') }}
                                            {{ $menu->name }}
                                        </td>
                                        <td><span class="badge" style="color: {{ $menu->status->text_colour }}; background: {{ $menu->status->background_colour }}">{{ $menu->status->name }}</span></td>
                                        <td>{{ $menu->type->name }}</td>
                                        <td>{{ $menu->publish_at ? $menu->publish_at->format('j F, Y') : null }}</td>
                                        <td>{{ $menu->author->name }}</td>
                                        <td>{{ $menu->created_at->format('j F, Y') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-sm btn-primary btn-edit" title="@lang('sections/menus.actions.edit')">@svg('regular/edit')</a>
                                                <a href="{{ route('menus.show', $menu->id) }}" class="btn btn-sm btn-primary" title="@lang('sections/menus.actions.show')">@svg('regular/eye')</a>

                                                @if (! $menu->trashed())
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete" title="@lang('sections/menus.actions.delete')">@svg('regular/trash')</button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-primary btn-restore" title="@lang('sections/menus.actions.restore')">@svg('regular/trash-restore')</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="empty-table">@lang('sections/menus.empty')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer">
                        {{ $menus->links() }}

                        <span class="float-right d-inline-block">
                            <small><span class="itemsCount">{{ $menus->total() }}</span> <span class="itemsVerb">{{ \Str::plural('menu', $menus->total()) }}</span></small>
                        </span>
                    </div>
                </div>

                @svg('solid/circle', ' icon-sm text-red') <b> = @lang('sections/menus.archived')</b>
            </div>
        </div>
    </div>
@endsection
