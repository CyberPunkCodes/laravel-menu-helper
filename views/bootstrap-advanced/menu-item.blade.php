@if ($isDropdown() == true)

    <li class="border rounded-2 mb-2 {{ $classIfRoute('active') }}">
        <button class="btn btn-toggle d-flex text-start w-100 align-items-center {{ $classIfNotRoute('collapsed') }}" data-bs-toggle="collapse" data-bs-target="{{ $getTarget('#') }}" aria-expanded="{{ $routeIsMatch(true) }}">
            {!! $getIcon() !!}
            <span class="ps-3">{{ $getTitle() }}</span>
        </button>
        <div id="{{ $getTarget() }}" class="collapse {{ $classIfRoute('show') }}">
            <div class="divider border-top mb-1 mx-auto w-75"></div>
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                @foreach ($getSubItems() as $subItem)
                    <x-menuhelper::menuSubItem :menu="$getMenu()" :item="$subItem" :parent-id="$getParentId()" :loop="$getLoop()" />
                @endforeach
            </ul>
        </div>
    </li>

@else

    <li class="border rounded-2 mb-2 {{ $classIfRoute('active') }}">
        <a href="{{ $getLink() }}" class="btn text-start w-100">
            {!! $getIcon() !!}
            <span class="ps-2">{{ $getTitle() }}</span>
        </a>
    </li>

@endif
