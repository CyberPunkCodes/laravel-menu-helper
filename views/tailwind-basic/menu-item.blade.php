@php
$buttonBaseClass = 'accordion-button relative flex items-center w-full py-4 px-5 border-0 transition focus:outline-none text-left text-base';
@endphp

<div
    x-init="function() {
        let expanded = {{ $isExpanded(true) }};

        if (expanded) {
            this.openedId = this.id;
        }
    }"
    x-data="{
        id: {{ $loop->iteration }},
        get open() {
            return this.openedId === this.id;
        },
        set open(value) {
            this.openedId = value ? this.id : null;
        },
        firstLoop: {{ $isFirstLoop(true) }},
        lastLoop: {{ $isLastLoop(true) }},
    }"
    @class([
        'accordion-item bg-white border border-gray-200',
        'rounded-t' => $loop->first,
        'rounded-b' => $loop->last,
    ])
>
    <h2 id="{{ $getId('id') }}" class="accordion-header mb-0">
        <button
            type="button"
            @click="toggle(); function toggle() { open = ! open; this.openedId = this.id}"
            @class([
                $buttonBaseClass,
                'text-black' => $isCollapsed(),
                'text-white' => $isExpanded(),
                'rounded-t' => $loop->first,
                'rounded-b' => $loop->last && ! $isExpanded(),
                'rounded-none' => ! $loop->first && ! $loop->last,
                'bg-indigo-500' => $isCollapsed(),
                'bg-indigo-700' => $isExpanded(),
                'collapsed' => $isCollapsed(),
            ])
            :class="{
                'text-black': ! open,
                'text-white': open,
                'bg-indigo-500': ! open,
                'bg-indigo-700': open,
                'collapsed': ! open,
                'rounded-b': ! open && lastLoop,
            }"
        >
            {{ $getTitle() }}
        </button>
    </h2>
    <div
        x-cloak
        x-show="open"
        x-collapse.duration.650ms
        id="{{ $getTarget() }}"
        @class([
            'accordion-collapse collapse',
        ])
    >
        <div class="accordion-body py-4 px-5">
            {!! $getText() !!}
        </div>
    </div>
</div>
