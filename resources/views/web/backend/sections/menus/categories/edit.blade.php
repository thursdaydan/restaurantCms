@extends('web.backend.layouts.app')

@section('title', __('sections/categories.title'))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">@yield('title')</a></li>
    <li class="breadcrumb-item active">Edit Category</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form role="form" method="POST" action="{{ route('categories.update', $category->id) }}">
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
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}" placeholder="Name" required>
                                </div>

                                <div class="form-group">
                                    <label for="subtitle">Subtitle</label>
                                    <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ old('subtitle', $category->subtitle) }}" placeholder="Subtitle">
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Description">{{ old('description', $category->description) }}</textarea>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="status_id">Status @required</label>
                                    <select class="form-control" id="status_id" name="status_id" required>
                                        <option value="">Please select a Status</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}" {{ old('status_id', $category->status_id) === $status->id ? 'selected' : null }}>{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="menu_id">Menu @required</label>
                                    <select class="form-control" id="menu_id" name="menu_id" required>
                                        <option value="">Please select a Menu</option>
                                        @foreach($menus as $menu)
                                            <option value="{{ $menu->id }}" {{ old('menu_id', $category->menu_id) === $menu->id ? 'selected' : null }}>{{ $menu->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="order">Order @required</label>
                                    <input type="number" min="0"class="form-control" id="order" name="order" value="{{ old('order', $category->order) }}" placeholder="Order" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Extra Details</h3>
                        </div>

                        <div class="card-body row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="publish_at">Publish At</label>
                                    <input type="date" class="form-control" id="publish_at" name="publish_at" value="{{ old('publish_at', $category->publish_at) }}" placeholder="Publish Date">
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="5" placeholder="Notes">{{ old('notes', $category->notes) }}</textarea>
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
