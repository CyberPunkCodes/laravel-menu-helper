<?php

namespace CyberPunkCodes\MenuHelper\View\Components;

use Illuminate\View\Component;
use CyberPunkCodes\MenuHelper\Config\MenuConfig;

class Menu extends Component
{
    public $config;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($scope = null, $menu = null, $items = null, $showHeader = null, $headerText = null, $id = null)
    {
        $this->config = new MenuConfig($menu, $scope, $items, $showHeader, $headerText, $id);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('menuhelper::' . $this->getMenu() . '.menu');
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getScope()
    {
        return $this->config->scope;
    }

    public function getMenu()
    {
        return $this->config->menu;
    }

    public function getMenuId()
    {
        return $this->config->id;
    }

    public function getItems()
    {
        return $this->config->items;
    }

    public function showHeader()
    {
        return $this->config->showHeader;
    }

    public function getHeaderText()
    {
        return $this->config->headerText;
    }
}
