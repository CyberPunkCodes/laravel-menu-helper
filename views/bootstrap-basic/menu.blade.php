<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-8">
            <div id="{{ $getMenuId() }}" class="accordion">
                <x-menuhelper::menuItems :menu="$getMenu()" :items="$getItems()" :parent-id="$getMenuId()" />
            </div>
        </div>
    </div>
</div>
