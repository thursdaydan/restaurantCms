<div class="col-md-3">
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <h3 class="profile-username text-center">{{ $menu->name }}</h3>
            <p class="text-muted text-center">{{ $menu->status->name }}</p>

            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item"><b>Categories</b> <a class="float-right">{{ $menu->categories->count() }}</a></li>
                <li class="list-group-item"><b>Items</b> <a class="float-right">{{ $menu->items->count() }}</a></li>
            </ul>

            <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-warning btn-block"><b>Edit</b> {{ svg('regular/edit') }}</a>
        </div>
    </div>
</div>
