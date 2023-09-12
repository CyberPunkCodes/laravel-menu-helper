<?php

namespace CyberPunkCodes\MenuHelper\Config;

use Illuminate\Support\Str;
use CyberPunkCodes\MenuHelper\Exceptions\MenuHelperException;

class MenuConfig
{
    /**
     * The menu id attribute
     */
    public $id;

    public $menu;

    public $scope;

    public $scopeWasSpecified;

    public $scopeWasDetermined = false;

    public $items = [];

    public $showHeader;

    public $headerText;

    public $demoMode = false;

    public function __construct(
        $menuAttributeRaw = null,
        $scopeAttributeRaw = null,
        $items = null,
        $showHeader = null,
        $headerText = null,
        $id = null,
    )
    {
        //dd($items);
        $this->id = $id ?? null;
        $this->demoMode = config('menu-helper.demoMode', false);

        $menuValue  = $this->cleanRawAttribute($menuAttributeRaw);
        $scopeValue = $this->cleanRawAttribute($scopeAttributeRaw);

        if ( $showHeader !== null ) {
            $this->showHeader = filter_var($showHeader, FILTER_VALIDATE_BOOLEAN);
        }

        if ( $headerText !== null ) {
            $this->headerText = $headerText;
        }

        if ( $menuValue === null ) {
            throw new MenuHelperException("Menu attribute is required.");
        }

        // determines the scope and menu name to use
        // scope can be passed as a value in the component, or prefixed in the menu name (`global.topnav`)
        $this->preProcessMenu($menuValue, $scopeValue);

        if ( isset($items) && ! empty($items) ) {
            $this->items = ($items instanceof \Illuminate\Support\Collection) ? $items->toArray() : $items;
        } else {
            $config = $this->getMenuConfigArray();

            if ( ! $this->isConfigValid($config) ) {
                throw new MenuHelperException("Config for '{$this->menu}' menu is invalid!");
            }

            if ( isset($config['id']) && ! empty($config['id']) ) {
                $this->id = (string) $config['id'];
            }

            if ( ($this->showHeader === null) && isset($config['header'], $config['header']['show']) ) {
                $this->showHeader = filter_var($config['header']['show'], FILTER_VALIDATE_BOOL);
            }

            if ( ($this->headerText === null) && isset($config['header']['text'], $config['header']['text']) ) {
                $this->headerText = $config['header']['text'];
            }

            $this->items = $config['items'];
        }

        // assign a random id if one wasn't set
        if ( ! $this->id ) {
            $this->id = 'mh_' . Str::random(10);
        }
    }

    /**
     * Determine if the config is valid (has items key/array)
     *
     * @param array $config The config array
     *
     * @return bool
     */
    public function isConfigValid($config)
    {
        if ( isset($config, $config['items']) && is_array($config['items']) ) {
            return true;
        }

        return false;
    }

    /**
     * Get the menu config array from config file
     *
     * @throws MenuHelperException
     *
     * @return array Returns the menu config array
     */
    public function getMenuConfigArray()
    {
        // if both menu and scope are known, load it up
        if ( isset($this->menu, $this->scope) ) {
            $menuData = ($this->scope === 'secondary') ?
                $this->getMenuFromSecondary($this->menu) :
                $this->getMenuFromGlobal($this->menu);

            if ( $menuData === false ) {
                throw new MenuHelperException("Error loading '{$this->menu}' from '{$this->scope}' config.");
            }

            return $menuData;
        }

        // scope isnt known, find it.

        // try global first
        $menuData = $this->getMenuFromGlobal($this->menu);

        // if not in global, try secondary
        if ( $menuData === false ) {
            $menuData = $this->getMenuFromSecondary($this->menu);

            // if not in secondary either..
            if ( $menuData === false ) {
                throw new MenuHelperException("Could not find '{$this->menu}' menu in any config.");
            } else {
                // was in secondary
                $this->scope = 'secondary';
                $this->scopeWasDetermined = true;
            }
        } else {
            // was in global
            $this->scope = 'global';
            $this->scopeWasDetermined = true;
        }

        return $menuData;
    }

    /**
     * Get menu from global config
     *
     * @param string $menu The name of the menu, ie: `sidebar`
     *
     * @return array|bool Returns the config array or false if the config file or menu was not found
     */
    public function getMenuFromGlobal($menu)
    {
        $configFileData = config('menu-helper');

        if ( ! isset($configFileData) || empty($configFileData) || ! is_array($configFileData) ) {
            return false;
        }

        if ( isset($configFileData[$menu]) && ! empty($configFileData[$menu]) && is_array($configFileData[$menu]) ) {
            return $configFileData[$menu];
        }

        return false;
    }

    /**
     * Get menu from secondary config
     *
     * @param string $menu The name of the menu, ie: `faq`
     *
     * @return array|bool Returns the config array or false if the config file or menu was not found
     */
    public function getMenuFromSecondary($menu)
    {
        $configFileData = config('menu-helper-secondary');

        if ( ! isset($configFileData) || empty($configFileData) || ! is_array($configFileData) ) {
            return false;
        }

        if ( isset($configFileData[$menu]) && ! empty($configFileData[$menu]) && is_array($configFileData[$menu]) ) {
            return $configFileData[$menu];
        }

        return false;
    }

    /**
     * Pre-process the menu
     *
     * If a `scope` attribute is passed to the menu component and the `menu` attribute also includes
     * a scope prefix (ie: `secondary.faq`), the `scope` attribute passed to the component will
     * override the scope prefix passed in with the menu.
     *
     * @param string $menu  The cleaned value from the menu attribute
     * @param string $scope The cleaned value from the scope attribute
     *
     * @throws MenuHelperException
     *
     * @return bool Returns true if processed without errors
     */
    public function preProcessMenu($menu, $scope = null)
    {
        if ( isset($menu) && is_string($menu) && ! empty($menu) )
        {
            // scope attribute was not passed
            if ( $scope === null )
            {
                // if menu name contains a scope prefix (ie: `secondary.faq`)
                if ( $this->menuContainsScope($menu) )
                {
                    $parts = explode('.', $menu);

                    if ( ! $this->isScopeValid($parts[0]) ) {
                        throw new MenuHelperException("Scope prefix must be 'global' or 'secondary'.");
                    }

                    $this->scope = $parts[0];
                    $this->menu  = $parts[1];
                    $this->scopeWasSpecified = true;
                } else {
                    // menu name did not contain a scope prefix
                    $this->scope = null;
                    $this->menu = $menu;
                    $this->scopeWasSpecified = false;
                }

                return true;

            } else {
                // scope attribute was passed
                if ( ! $this->isScopeValid($scope) ) {
                    throw new MenuHelperException("Scope must be 'global' or 'secondary'.");
                }

                // split the parts, ignore parted scope and override with passed scope
                if ( $this->menuContainsScope($menu) ) {
                    $parts = explode('.', $menu);
                    $menu = $parts[1];
                }

                $this->scope = $scope;
                $this->menu = $menu;
                $this->scopeWasSpecified = true;

                return true;
            }
        }

        throw new MenuHelperException('Failed to process menu config.');
    }

    /**
     * Is the scope valid
     *
     * @param string $scope The scope to check, must be `global` or `secondary.
     *
     * @return bool
     */
    public function isScopeValid($scope)
    {
        if ( isset($scope) && ! empty($scope) && is_string($scope) ) {
            if ( ($scope === 'global') || ($scope === 'secondary') ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Clean raw attribute
     *
     * This is really only for the `menu` and `scope` attributes.
     *
     * @param string $attributeValue Attribute should be a string
     *
     * @return void
     */
    public function cleanRawAttribute($attributeValue)
    {
        if ( isset($attributeValue) && ! empty($attributeValue) && is_string($attributeValue) ) {
            return empty(str_replace(' ', '', $attributeValue)) ? null : $attributeValue;
        }

        return null;
    }

    /**
     * Determine if the menu name contains a scope prefix
     *
     * @param string $value The menu name passed to the menu component's `menu` attribute
     *
     * @return bool
     */
    public function menuContainsScope($value)
    {
        return (strpos($value, '.') !== false) ? true : false;
    }
}
