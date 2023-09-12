<x-menuhelper::layouts.bootstrap>
    <h1 class="text-center my-4">Bootstrap Basic Demo</h1>
    <p align="center">
        <a href="{{ route('demo.bootstrap.advanced.index') }}" class="text-blue-600">
            Click here to view the advanced demo
        </a>
    </p>

    <br />

    <x-menuhelper::menu scope="secondary" menu="bootstrap-basic" />
</x-menuhelper::layouts.bootstrap>
