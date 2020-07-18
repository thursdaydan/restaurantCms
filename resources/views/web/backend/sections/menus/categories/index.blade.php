@extends('web.backend.layouts.app')

@section('title', __('sections/categories.title'))

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
                            <h3 class="card-title">@svg('solid/filter') Filter</h3>

                            <div class="card-tools">
                                @if (request()->exists('submit'))
                                    <a href="{{ route('categories.index') }}" class="btn btn-tool" title="Clear Filter">@svg('solid/sync') Clear Filter</a>
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
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', request('name')) }}" placeholder="Name">
                                    </div>

                                    <div class="form-group">
                                        <label for="author_id">Created By</label>
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
                                        <label for="status_id">Status</label>
                                        <select class="form-control" id="status_id" name="status_id">
                                            <option value="">Please select a Status</option>
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->id }}" {{ old('status_id', request('status_id')) == $status->id ? 'selected' : null }}>{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="created_at">Created At</label>
                                        <input type="text" id="created_at" class="form-control range-picker" name="created_at" value="{{ old('created_at', request('created_at')) }}" placeholder="Created At" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="menu_id">Menu</label>
                                        <select class="form-control" id="menu_id" name="menu_id">
                                            <option value="">Please select a Category</option>
                                            @foreach($menus as $menu)
                                                <option value="{{ $menu->id }}" {{ old('menu_id', request('menu_id')) == $menu->id ? 'selected' : null }}>{{ $menu->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="publish_at">Publish Date</label>
                                        <input type="text" id="publish_at" class="form-control range-picker" name="publish_at" value="{{ old('publish_at', request('publish_at')) }}" placeholder="Publish Date" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="col-12 col-md-3 float-right">
                                <button type="submit" name="submit" class="btn btn-block btn-primary float-right">Filter Categories</button>
                            </div>
                        </div>
                    </div>
                </form>

                <svg class="icon" id="settings-icon">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicon-cog"></use>
                </svg>

                <div class="card index-card">
                    <div class="card-header">
                        <h3 class="card-title">Categories List</h3>

                        <div class="card-tools">
                            <a href="{{ route('categories.create') }}" class="btn btn-xs btn-primary">@svg('regular/plus') Add Category</a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <table class="table index-table">
                            <thead>
                                <tr>
                                    <th>@lang('sections/categories.fields.name')</th>
                                    <th>@lang('sections/categories.fields.status')</th>
                                    <th>@lang('sections/categories.fields.menu')</th>
                                    <th>@lang('sections/categories.fields.publish_at')</th>
                                    <th>@lang('sections/categories.fields.author')</th>
                                    <th>@lang('sections/categories.fields.created_at')</th>
                                    <th>@lang('sections/categories.actions')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($menuCategories as $category)
                                    <tr data-id="{{ $category->id }}" data-delete-url="{{ route('categories.destroy', $category->id) }}" data-section="{{ Str::singular(__('sections/categories.title')) }}">
                                        <td>{{ $category->name }}</td>
                                        <td><span class="badge" style="color: {{ $category->status->text_colour }}; background: {{ $category->status->background_colour }}">{{ $category->status->name }}</span></td>
                                        <td>{{ $category->menu->name }}</td>
                                        <td>{{ $category->publish_at ? $category->publish_at->format('j F, Y') : null }}</td>
                                        <td>{{ $category->author->name }}</td>
                                        <td>{{ $category->created_at->format('j F, Y') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-primary btn-edit" title="Edit">@svg('regular/edit')</a>
                                                <button type="button" class="btn btn-sm btn-danger btn-delete" title="Delete">@svg('regular/trash')</button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="empty-table">No Categories found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer">
                        {{ $menuCategories->links() }}

                        <span class="float-right d-inline-block">
                            <small><span class="itemsCount">{{ $menuCategories->total() }}</span> <span class="itemsVerb">{{ \Str::plural('category', $menuCategories->total()) }}</span></small>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
