<nav class="left-sidebar navbar navbar-light bg-light bg-white">
    <div class="container-fluid">

        <ul id="{{ $getMenuId() }}" class="list-unstyled ps-0 mt-5 w-100">
            @if ($showHeader())
                <li class="sidebar-header">
                    {{ $getHeaderText() }}
                </li>
            @endif

            <x-menuhelper::menuItems :menu="$getMenu()" :items="$getItems()" :parent-id="$getMenuId()" />
        </ul>

    </div>
</nav>
