@extends('web.backend.layouts.app')

@section('title', __('sections/items.title'))

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
                            <h3 class="card-title">@svg('solid/filter') @lang('sections/items.filter.title')</h3>

                            <div class="card-tools">
                                @if (request()->exists('submit'))
                                    <a href="{{ route('items.index') }}" class="btn btn-tool" title="@lang('sections/items.filter.clear')">@svg('solid/sync') @lang('sections/items.filter.clear')</a>
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
                                        <label for="name">@lang('sections/items.fields.name')</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', request('name')) }}" placeholder="Name">
                                    </div>

                                    <div class="form-group">
                                        <label for="publish_at">@lang('sections/items.fields.publish_at')</label>
                                        <input type="text" id="publish_at" class="form-control range-picker" name="publish_at" value="{{ old('publish_at', request('publish_at')) }}" placeholder="Publish Date" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="status_id">@lang('sections/items.fields.status')</label>
                                        <select class="form-control" id="status_id" name="status_id">
                                            <option value="">Please select a Status</option>
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->id }}" {{ old('status_id', request('status_id')) == $status->id ? 'selected' : null }}>{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="author_id">@lang('sections/items.fields.author')</label>
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
                                        <label for="menu_id">@lang('sections/items.fields.menu')</label>
                                        <select class="form-control" id="menu_id" name="menu_id">
                                            <option value="">Please select a Menu</option>
                                            @foreach($menus as $menu)
                                                <option value="{{ $menu->id }}" {{ old('menu_id', request('menu_id')) == $menu->id ? 'selected' : null }}>{{ $menu->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="created_at">@lang('sections/items.fields.created_at')</label>
                                        <input type="text" id="created_at" class="form-control range-picker" name="created_at" value="{{ old('created_at', request('created_at')) }}" placeholder="Created At" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="category_id">@lang('sections/items.fields.category')</label>
                                        <select class="form-control" id="category_id" name="category_id">
                                            <option value="">Please select a Menu</option>
                                            @foreach($menuCategories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', request('category_id')) == $category->id ? 'selected' : null }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group" style="min-height: 70px;">
                                        <label for="gluten_free">@lang('sections/items.fields.dietary_options')</label> <br />

                                        <div class="pretty p-switch p-fill">
                                            <input type="checkbox" id="gluten_free" name="gluten_free" value="1" {{ old('gluten_free', request('gluten_free')) ? 'checked' : null }} />
                                            <div class="state p-primary">
                                                <label>@lang('sections/items.fields.gluten_free')</label>
                                            </div>
                                        </div>

                                        <div class="pretty p-switch p-fill">
                                            <input type="checkbox" id="vegetarian" name="vegetarian" value="1" {{ old('vegetarian', request('vegetarian')) ? 'checked' : null }} />
                                            <div class="state p-primary">
                                                <label>@lang('sections/items.fields.vegetarian')</label>
                                            </div>
                                        </div>

                                        <div class="pretty p-switch p-fill">
                                            <input type="checkbox" id="vegan" name="vegan" value="1" {{ old('vegan', request('vegan')) ? 'checked' : null }} />
                                            <div class="state p-primary">
                                                <label>@lang('sections/items.fields.vegan')</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="col-12 col-md-3 float-left">
                                <div class="pretty p-switch p-fill">
                                    <input type="checkbox" id="with_archived" name="with_archived" value="1" {{ old('with_archived', request('with_archived')) ? 'checked' : null }} />
                                    <div class="state p-primary">
                                        <label>@lang('sections/items.archived')</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-3 float-right">
                                <button type="submit" name="submit" class="btn btn-block btn-primary float-right">@lang('sections/items.filter.action')</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="card index-card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('sections/items.sub_title')</h3>

                        <div class="card-tools">
                            <a href="{{ route('items.create') }}" class="btn btn-xs btn-primary">@svg('regular/plus') @lang('sections/items.actions.create')</a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <table class="table index-table">
                            <thead>
                                <tr>
                                    <th>@lang('sections/items.fields.name')</th>
                                    <th>@lang('sections/items.fields.status')</th>
                                    <th>@lang('sections/items.fields.menu')</th>
                                    <th>@lang('sections/items.fields.category')</th>
                                    <th>@lang('sections/items.fields.price')</th>
                                    <th title="@lang('sections/items.fields.gluten_free')">@lang('sections/items.fields.gf')</th>
                                    <th title="@lang('sections/items.fields.vegetarian')">@lang('sections/items.fields.v')</th>
                                    <th title="@lang('sections/items.fields.vegan')">@lang('sections/items.fields.ve')</th>
                                    <th>@lang('sections/items.fields.publish_at')</th>
                                    <th>@lang('sections/items.fields.author')</th>
                                    <th>@lang('sections/items.fields.created_at')</th>
                                    <th>@lang('sections/items.fields.actions')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($items as $item)
                                    <tr data-id="{{ $item->id }}" data-delete-url="{{ route('items.destroy', $item->id) }}" data-restore-url="{{ route('items.restore', $item->id) }}" data-section="{{ Str::singular(__('sections/items.title')) }}">
                                        <td>
                                            {{ ! $item->trashed() ? svg('solid/circle', 'icon-sm text-transparent') : svg('solid/circle', 'icon-sm text-red') }}
                                            {{ $item->name }}
                                        </td>
                                        <td><span class="badge" style="color: {{ $item->status->text_colour }}; background: {{ $item->status->background_colour }}">{{ $item->status->name }}</span></td>
                                        <td>{{ $item->menu->name }}</td>
                                        <td>{{ $item->category->name ?? null }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->gluten_free ? svg('solid/check-circle', 'green__colour__500') : svg('solid/times-circle', 'red__colour__500') }}</td>
                                        <td>{{ $item->vegetarian ? svg('solid/check-circle', 'green__colour__500') : svg('solid/times-circle', 'red__colour__500') }}</td>
                                        <td>{{ $item->vegan ? svg('solid/check-circle', 'green__colour__500') : svg('solid/times-circle', 'red__colour__500') }}</td>
                                        <td>{{ $item->publish_at ? $item->publish_at->format('j F, Y') : null }}</td>
                                        <td>{{ $item->author->name }}</td>
                                        <td>{{ $item->created_at->format('j F, Y') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-primary btn-edit" title="@lang('sections/items.actions.edit')">@svg('regular/edit')</a>

                                                @if (! $item->trashed())
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete" title="@lang('sections/items.actions.delete')">@svg('regular/trash')</button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-primary btn-restore" title="@lang('sections/items.actions.restore')">@svg('regular/trash-restore')</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="empty-table">@lang('sections/items.empty')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer">
                        {{ $items->links() }}

                        <span class="float-right d-inline-block">
                            <small><span class="itemsCount">{{ $items->total() }}</span> <span class="itemsVerb">{{ \Str::plural('item', $items->total()) }}</span></small>
                        </span>
                    </div>
                </div>

                @svg('solid/circle', ' icon-sm text-red') <b> = @lang('sections/items.archived')</b>
            </div>
        </div>
    </div>
@endsection
