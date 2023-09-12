<x-menuhelper::layouts.bootstrap>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3 p-0">
                <x-menuhelper::menu scope="global" menu="bootstrap-advanced" />
            </div>
            <div class="col-9 text-center">
                <h1 class="mt-5">Bootstrap Advanced Demo</h1>
                <a href="{{ route('demo.bootstrap.basic.index') }}" class="text-blue-600">
                    Click here to view the basic demo
                </a>
            </div>
        </div>
    </div>
</x-menuhelper::layouts.bootstrap>
