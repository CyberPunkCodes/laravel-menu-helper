<?php

namespace CyberPunkCodes\MenuHelper\View\Components;

use Illuminate\View\Component;
use CyberPunkCodes\MenuHelper\Exceptions\MenuHelperException;

/**
 * MenuItems View Component Class
 *
 * MenuItems are a child component of the main `Menu` component.
 */
class MenuItems extends Component
{
    private $parentId;

    private $menu;

    private $items;

    /**
     * Create a new 'menu-items' component instance.
     *
     * The `menu` and `items` params should be determined by MenuConfig in the Menu component class.
     * It is not intended to manually pass these values, but instead, use `$getMenu()` and
     * `$getItems()` in your component's view file. All the data it needs to operate gets determined
     * by the first and main Menu component and gets passed down to the child components.
     *
     * Only the main Menu component needs to know the scope because the scope is only needed when
     * loading the items from the config file. Since they are passed down from parent components, so
     * they are only loaded from the config file once, the scope is not needed anymore. The `menu`
     * is the only thing needed so it can load the correct view files for the matching menu.
     *
     * @param string $menu The menu determined by MenuConfig in parent Menu component
     * @param array|Collection $items The items determined by MenuConfig in parent Menu component
     *
     * @return void
     */
    public function __construct($menu, $items, $parentId)
    {
        $this->menu  = $menu;
        $this->items = $items;
        $this->parentId = $parentId;

        // if it's a collection, convert to array
        if ( $this->items instanceof \Illuminate\Support\Collection ) {
            $this->items = $this->items->toArray();
        }

        $this->validate();
    }

    private function validate()
    {
        if ( ! isset($this->menu, $this->items) ) {
            throw new MenuHelperException("'menu' and 'items' attributes are required for menu items component");
        }

        if ( ! is_string($this->menu) || empty($this->menu) ) {
            throw new MenuHelperException("'menu' must be a string and not empty.");
        }

        if ( ! is_array($this->items) ) {
            throw new MenuHelperException("'items' must be a collection or an array.");
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('menuhelper::' . $this->getMenu() . '.menu-items');
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    public function getMenu()
    {
        return $this->menu;
    }

    public function getItems()
    {
        return $this->items;
    }
}
