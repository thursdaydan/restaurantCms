@extends('web.backend.layouts.app')

@section('title', __('sections/users.title'))

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
<li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card filter-card {{ request()->exists('submit') ? null : 'collapsed-card' }}">
                <div class="card-header">
                    <h3 class="card-title">@svg('solid/filter') Filter</h3>

                    <div class="card-tools">
                        @if (request()->exists('submit'))
                            <a href="{{ route('users.index') }}" class="btn btn-tool" title="Clear Filter">@svg('solid/sync')</a>
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
                    <form role="form" method="GET" class="d-md-flex w-100">
                        @csrf

                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', request('name')) }}" placeholder="Name">
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="{{ old('email', request('email')) }}" placeholder="Email" >
                            </div>
                        </div>

                        <div class="col-12 col-md-3">
                        </div>

                        <div class="col-12 col-md-3">
                            <label style="color: transparent;">|</label>
                            <button type="submit" name="submit" class="btn btn-block btn-primary float-right">Filter Users</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card index-card">
                <div class="card-header">
                    <h3 class="card-title">Users List</h3>

                    <div class="card-tools">
                        <a href="{{ route('users.create') }}" class="btn btn-xs btn-primary">@svg('regular/plus') Add User</a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <table class="table index-table">
                        <thead>
                            <tr>
                                <th>@lang('sections/users.fields.name')</th>
                                <th>@lang('sections/users.fields.email')</th>
                                <th>@lang('sections/users.fields.created')</th>
                                <th>@lang('sections/users.actions')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($users as $user)
                                <tr data-id="{{ $user->id }}" data-delete-url="{{ route('users.destroy', $user->id) }}" data-section="{{ Str::singular(__('sections/users.title')) }}">
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at ? $user->created_at->format('j F, Y') : null }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary" title="Edit">@svg('regular/edit')</a>
                                            <button type="button" class="btn btn-sm btn-danger btn-delete" title="Delete">@svg('regular/trash')</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="empty-table">No Users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    {{ $users->links() }}

                    <span class="float-right d-inline-block">
                        <small>{{ $users->total() }} {{ \Str::plural('user', $users->total()) }}</small>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
