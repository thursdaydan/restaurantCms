@extends('web.backend.layouts.app')

@section('title', __('sections/items.title'))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('items.index') }}">@yield('title')</a></li>
    <li class="breadcrumb-item active">Edit Item</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form role="form" method="POST" action="{{ route('items.update', $item->id) }}">
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
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $item->name) }}" placeholder="Name" required>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description @required</label>
                                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Description" required>{{ old('description', $item->description) }}</textarea>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="status_id">Status @required</label>
                                    <select class="form-control" id="status_id" name="status_id" required>
                                        <option value="">Please select a Status</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}" {{ old('status_id', $item->status_id) === $status->id ? 'selected' : null }}>{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="menu_id">Menu @required</label>
                                    <select class="form-control" id="menu_id" name="menu_id" required>
                                        <option value="">Please select a Menu</option>
                                        @foreach($menus as $menu)
                                            <option value="{{ $menu->id }}" {{ old('menu_id', $item->menu_id) === $menu->id ? 'selected' : null }}>{{ $menu->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- TODO: Need to make this list dynamic based on the menu selection --}}
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Please select a Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) === $category->id ? 'selected' : null }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="parent_id">Menu Item Parent</label>
                                    <select class="form-control" id="parent_id" name="parent_id">
                                        <option value="">Please select an Item</option>
                                        @foreach($items as $menuItem)
                                            <option value="{{ $menuItem->id }}" {{ old('parent_id', $menuItem->parent_id) === $menuItem->id ? 'selected' : null }}>{{ $menuItem->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="order">Order @required</label>
                                    <input type="number" min="0"class="form-control" id="order" name="order" value="{{ old('order', $item->order) }}" placeholder="Order" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pricing & Dietary Details</h3>
                        </div>

                        <div class="card-body row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="cost">Cost</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@svg('regular/pound-sign')</span>
                                        </div>

                                        <input type="text" class="form-control" id="cost" name="cost" value="{{ old('cost', $item->cost) }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="price">Price @required</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@svg('regular/pound-sign')</span>
                                        </div>

                                        <input type="text" class="form-control" id="price" name="price" value="{{ old('price', $item->price) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group" style="min-height: 70px;">
                                    <label for="gluten_free">Dietary Options</label> <br />

                                    <div class="pretty p-switch p-fill">
                                        <input type="checkbox" id="gluten_free" name="gluten_free" value="1" {{ old('gluten_free', $item->gluten_free) ? 'checked' : null }} />
                                        <div class="state p-primary">
                                            <label>Gluten Free</label>
                                        </div>
                                    </div>

                                    <div class="pretty p-switch p-fill">
                                        <input type="checkbox" id="vegetarian" name="vegetarian" value="1" {{ old('vegetarian', $item->vegetarian) ? 'checked' : null }} />
                                        <div class="state p-primary">
                                            <label>Vegetarian</label>
                                        </div>
                                    </div>

                                    <div class="pretty p-switch p-fill">
                                        <input type="checkbox" id="vegan" name="vegan" value="1" {{ old('vegan', $item->vegan) ? 'checked' : null }} />
                                        <div class="state p-primary">
                                            <label>Vegan</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="publish_at">Publish At</label>
                                    <input type="date" class="form-control" id="publish_at" name="publish_at" value="{{ old('publish_at', $item->publish_at) }}" placeholder="Publish Date">
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
