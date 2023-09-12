<x-menuhelper::layouts.tailwind>
    <h1 class="text-center font-bold text-3xl my-4">Tailwind Basic Demo</h1>

    <p class="text-center mt-5">
        <a href="{{ route('demo.tailwind.advanced.index') }}" class="text-blue-600">
            Click here to view the advanced demo
        </a>
    </p>

    <br />

    <x-menuhelper::menu scope="secondary" menu="tailwind-basic" />
</x-menuhelper::layouts.tailwind>
