<li class="sidebar-item py-2 pl-5 {{ $classIfRoute('active') }}">
    @if ($hasLink())
        <a href="{{ $getLink() }}" class="sidebar-link {{ $classIfRoute('active') }}">{{ $getTitle() }}</a>
    @else
        <span>{{ $getTitle() }}</span>
    @endif
</li>
