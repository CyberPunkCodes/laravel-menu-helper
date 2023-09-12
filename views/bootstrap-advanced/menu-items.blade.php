@foreach($getItems() as $item)
    <x-menuhelper::menuItem :menu="$getMenu()" :item="$item" :parent-id="$getParentId()" :loop="$loop" />
@endforeach
