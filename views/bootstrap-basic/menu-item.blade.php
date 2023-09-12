<div class="accordion-item">
    <h2 id="{{ $getId('id') }}" class="accordion-header">
        <button
            type="button"
            @class([
                'accordion-button',
                'collapsed' => $isCollapsed(),
            ])
            data-bs-toggle="collapse"
            data-bs-target="{{ $getTarget('#') }}"
            aria-expanded="{{ $isExpanded(true) }}"
            aria-controls="{{ $getTarget() }}"
        >
            {{ $getTitle() }}
        </button>
    </h2>
    <div
        id="{{ $getTarget() }}"
        @class([
            'accordion-collapse collapse',
            'show' =>  $isExpanded(),
        ])
        aria-labelledby="{{ $getId('id') }}"
        data-bs-parent="#{{ $getParentId() }}"
    >
        <div class="accordion-body">
            {!! $getText() !!}
        </div>
    </div>
</div>
