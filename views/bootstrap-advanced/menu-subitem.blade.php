<li class="py-2 ps-5 {{ $classIfRoute('active') }}">
    @if ($hasLink())
        <a href="{{ $getLink() }}" class="text-decoration-none {{ $classIfRoute('active') }}">{{ $getTitle() }}</a>
    @else
        <span>{{ $getTitle() }}</span>
    @endif
</li>
