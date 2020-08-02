<div class="active tab-pane" id="structure">
    <ul class="tree">
        <li class="root">{{ $menu->name }}</li>

        @foreach($menu->categories as $category)
            <li class="folder">
                {{ $category->name }}

                <a href="{{ route('categories.edit', $category->id) }}" target="_blank">
                    {{ svg('regular/external-link-square') }}
                </a>

                <ul>
                    @foreach($category->items as $item)
                        <li class="file">
                            {{ $item->name }}

                            <a href="{{ route('items.edit', $item->id) }}" target="_blank">
                                {{ svg('regular/external-link-square') }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</div>
