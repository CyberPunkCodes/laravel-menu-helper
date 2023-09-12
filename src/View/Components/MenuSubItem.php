<?php

namespace CyberPunkCodes\MenuHelper\View\Components;

use Illuminate\View\Component;
use CyberPunkCodes\MenuHelper\Exceptions\MenuHelperException;
use CyberPunkCodes\MenuHelper\Traits\MenuHelperItem;

class MenuSubItem extends Component
{
    use MenuHelperItem;

    /**
     * Create a new Menu Sub Item component instance.
     *
     * @return void
     */
    public function __construct($menu, $item, $parentId, $loop = null)
    {
        $this->menu = $menu;
        $this->item = $item;
        $this->parentId = $parentId;
        $this->loop = $loop;

        // if it's a collection, convert to array
        if ( $this->item instanceof \Illuminate\Support\Collection ) {
            $this->item = $this->item->toArray();
        }

        $this->validate();

        if (isset($item['show']) && ($item['show'] === false)) {
            $this->item = false;
        }
    }

    private function validate()
    {
        if ( ! isset($this->menu, $this->item) ) {
            throw new MenuHelperException("'menu' and 'item' attributes are required for menu sub-item component");
        }

        if ( ! is_string($this->menu) || empty($this->menu) ) {
            throw new MenuHelperException("'menu' must be a string and not empty.");
        }

        if ( ! is_array($this->item) ) {
            throw new MenuHelperException("'item' must be a collection or an array.");
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('menuhelper::' . $this->getMenu() . '.menu-subitem');
    }
}
