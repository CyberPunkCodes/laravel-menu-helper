<?php

namespace CyberPunkCodes\MenuHelper\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;
use CyberPunkCodes\MenuHelper\Exceptions\MenuHelperException;
use CyberPunkCodes\MenuHelper\Traits\MenuHelperItem;

class MenuItem extends Component
{
    use MenuHelperItem;

    /**
     * Create a new component instance.
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
            $this->showItem = false;
        }

        // expanded and collapsed should always be the opposite of eachother
        if ( isset($item['expanded'], $item['collapsed']) ) {
            $this->expanded = filter_var($item['expanded'], FILTER_VALIDATE_BOOL);
            $this->collapsed = filter_var($item['collapsed'], FILTER_VALIDATE_BOOL);
        } elseif ( isset($item['expanded']) ) {
            $this->expanded = filter_var($item['expanded'], FILTER_VALIDATE_BOOL);
            $this->collapsed = ! $this->expanded;
        } elseif ( isset($item['collapsed']) ) {
            $this->collapsed = filter_var($item['collapsed'], FILTER_VALIDATE_BOOL);
            $this->expanded = ! $this->collapsed;
        }

        // fail safes

        if ( ($this->expanded === true) && ($this->collapsed === true) ) {
            throw new MenuHelperException("'collapsed' and 'expanded' both can't be true.");
        }

        if ( ($this->expanded === false) && ($this->collapsed === false) ) {
            throw new MenuHelperException("'collapsed' and 'expanded' both can't be false.");
        }

        // randomly generate a target if none specified
        if ( ! isset($this->item['target']) || empty($this->item['target']) ) {
            $this->item['target'] = 'mh_' . Str::random(12);
        }
    }

    private function validate()
    {
        if ( ! isset($this->menu, $this->item) ) {
            throw new MenuHelperException("'menu' and 'item' attributes are required for menu item component");
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
        return view('menuhelper::' . $this->menu . '.menu-item');
    }
}
