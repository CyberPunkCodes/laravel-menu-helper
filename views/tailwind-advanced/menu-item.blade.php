
@if ($isDropdown() == true)

    <li class="sidebar-item mt-1 px-3 py-2 border rounded {{ $classIfRoute('active') }}" x-data="{ show: {{ $boolIfRoute() }} }">

        <a @click="show = ! show" :class="{ opened: show }" class="sidebar-link relative flex items-center w-full cursor-pointer expandable {{ $classIfRoute('opened') }}">
            {!! $getIcon() !!}
            <span class="pl-3">{{ $getTitle() }}</span>
        </a>

        <ul x-collapse.duration.500ms x-show="show" class="sidebar-dropdown list-unstyled {{ $classIfRoute('show') }}">
            <div class="divider border-t mt-2 mb-1 mx-auto w-11/12"></div>
            @foreach ($getSubItems() as $subItem)
                <x-menuhelper::menuSubItem :menu="$getMenu()" :item="$subItem" :parent-id="$getParentId()" :loop="$getLoop()" />
            @endforeach
        </ul>
    </li>

@else

    <li class="sidebar-item mt-1 px-3 py-2 border rounded {{ $classIfRoute('active') }}">
        <a class="sidebar-link relative flex items-center w-full" href="{{ $getLink() }}">
            {!! $getIcon() !!}
            <span class="pl-3">{{ $getTitle() }}</span>
        </a>
    </li>

@endif
