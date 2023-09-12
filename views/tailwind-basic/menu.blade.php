<div x-data="{ openedId: null }" id="{{ $getMenuId() }}" class="w-full md:w-3/5 mx-auto">
    <x-menuhelper::menuItems :menu="$getMenu()" :items="$getItems()" :parent-id="$getMenuId()" />
</div>
