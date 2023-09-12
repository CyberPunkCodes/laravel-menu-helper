<div class="left-sidebar w-full">
    <ul id="{{ $getMenuId() }}" class="w-full px-5 mt-12">
        @if ($showHeader())
            <li class="pl-2 text-gray-500 mb-3">
                {{ $getHeaderText() }}
            </li>
        @endif

        <x-menuhelper::menuItems :menu="$getMenu()" :items="$getItems()" :parent-id="$getMenuId()" />
    </ul>
</div>
