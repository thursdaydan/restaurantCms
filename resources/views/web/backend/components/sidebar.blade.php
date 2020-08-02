<aside class="main-sidebar sidebar-dark-lightblue elevation-4">
    <a href="{{ url('/') }}" class="brand-link">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-child-indent text-sm" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->is('home') ? 'active' : null }}">@svg('solid/tachometer-alt', 'nav-icon') <p>Home</p></a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->is('pages') ? 'active' : null }}">@svg('solid/browser'exit, 'nav-icon') <p>Pages</p></a>
                </li>

                <li class="nav-item has-treeview {{ request()->is('menus*') ? 'menu-open' : null }}">
                    <a href="{{ route('menus.index') }}" class="nav-link {{ request()->is('menus*') ? 'active' : null }}">
                        @svg('solid/utensils', 'nav-icon')
                        <p>Menus @svg('solid/angle-left', 'right')</p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('menus.index') }}" class="nav-link {{ request()->is('menus*') ? 'active' : null }}">
                                @svg('regular/circle', 'nav-icon') <p>Menus</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->is('menus/categories*') ? 'active' : null }}">
                                @svg('regular/circle', 'nav-icon') <p>Categories</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('items.index') }}" class="nav-link {{ request()->is('menus/items*') ? 'active' : null }}">
                                @svg('regular/circle', 'nav-icon') <p>Items</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('types.index') }}" class="nav-link {{ request()->is('menus/types*') ? 'active' : null }}">
                                @svg('regular/circle', 'nav-icon') <p>Types</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : null }}">@svg('solid/user', 'nav-icon') <p>Users</p></a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
