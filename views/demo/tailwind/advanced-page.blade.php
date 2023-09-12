<x-menuhelper::layouts.tailwind>
    <div class="flex">
        <div class="flex w-1/4">
            <x-menuhelper::menu scope="global" menu="tailwind-advanced" />
        </div>
        <div class="flex flex-col w-3/4">
            <h1 class="mt-14 w-full text-center text-4xl">Tailwind Advanced Demo</h1>
            <p class="text-center mt-5">
                <a href="{{ route('demo.tailwind.basic.index') }}" class="text-blue-600">
                    Click here to view the basic demo
                </a>
            </p>
        </div>
    </div>
</x-menuhelper::layouts.tailwind>
