<?php

namespace CyberPunkCodes\MenuHelper\Traits;

trait MenuHelperItem
{
    /**
     * @var string The name of the menu. ie: `left-sidebar`
     */
    public $menu;

    /**
     * @var array Holds the config array data for the MenuItem or MenuSubItem, item/subitem.
     */
    public $item;

    public $loop;

    public $expanded = false;

    public $collapsed = true;

    /**
     * @var string The HTML `id` value for the menu itself. Could be a `ul`, `div`, `nav`, etc.
     */
    public $parentId;

    /**
     * Whether or not the item should be shown
     *
     * @var bool
     */
    public $showItem = true;

    /**
     * The result of `routeIsMatch()`, if it's ran.
     *
     * Since it would be common to call `$classIfRoute()` and `$boolIfRoute()` in the views
     * several times for each list item, we cache it in the Class.
     *
     * @var bool|null
     */
    public $routeIsMatchResult;

    /**
     * Determine if the component should be rendered.
     *
     * @return bool
     */
    public function shouldRender()
    {
        return $this->showItem === true ? true : false;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // you must override this
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    public function getMenu()
    {
        return $this->menu;
    }

    public function getMenuName()
    {
        return $this->getMenu();
    }

    public function getItem()
    {
        return $this->item;
    }

    public function getId()
    {
        if ( isset($this->item['id']) && ! empty($this->item['id']) ) {
            return $this->item['id'];
        }

        return '';
    }

    public function getTarget($prefix = null)
    {
        if ( isset($this->item['target']) ) {
            return $prefix ? $prefix . $this->item['target'] : $this->item['target'];
        }

        return '';
    }

    /**
     * Determine if the item has a title
     *
     * @return bool
     */
    public function hasTitle(): bool
    {
        return (isset($this->item['title']) && ! empty($this->item['title'])) ? true : false;
    }

    /**
     * Get the item's title
     *
     * Get title text for the item (ie: Home, About, Contact, etc.)
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->item['title'] ?? '';
    }

    /**
     * Determine if the item has text
     *
     * @return bool
     */
    public function hasText(): bool
    {
        return (isset($this->item['text']) && ! empty($this->item['text'])) ? true : false;
    }

    /**
     * Get the item's text
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->item['text'] ?? '';
    }

    /**
     * Determine if the item has an icon
     *
     * @return bool
     */
    public function hasIcon(): bool
    {
        return (isset($this->item['icon']) && ! empty($this->item['icon'])) ? true : false;
    }

    /**
     * Get the item's icon
     *
     * WARNING: This will not be escaped. Do not pass user generated data for the icons!
     *
     * @return string
     */
    public function getIcon(): string
    {
        return $this->item['icon'] ?? '';
    }

    /**
     * Determine if the
     *
     * @return bool
     */
    public function hasLink(): bool
    {
        return (isset($this->item['link']) && ! empty($this->item['link'])) ? true : false;
    }

    /**
     * Get the link for the menu sub-item
     *
     * The link can be an array or string. If a string is used, it will be passed directly to the
     * view as is. If you want to use named routes, wrap it in an array like so: `['user.profile']`.
     *
     * If you need to pass parameters, use an associative array with the `params` key. To do so, you
     * must also pass a `name` key matching the route name. ie: `'user.profile'`. The absolute key is
     * optional and determines whether the `route()` method should generate absolute links or not. It
     * defaults to `true`.
     *
     *
     * @param string $fallback The fallback link to use if the link was invalid, or false. Default: ''
     *
     * @return string
     */
    public function getLink($fallback = ''): string
    {
        if ( isset($this->item['link']) && ! empty($this->item['link']) ) {

            if ( is_array($this->item['link']) ) {
                if ( array_key_exists('name', $this->item['link']) ) {
                    $name = $this->item['link']['name'];
                    $params = $this->item['link']['params'] ?? [];
                    $absolute = $this->item['link']['absolute'] ?? true;

                    return route($name, $params, $absolute);
                }

                $name = $this->item['link'][0] ?? false;
                $params = $this->item['link'][1] ?? [];
                $absolute = isset($this->item['link'][2]) ? filter_var($this->item['link'][2], FILTER_VALIDATE_BOOL) : true;

                if ( is_string($name) ) {
                    return route($name, $params, $absolute);
                }
            }

            if ( is_string($this->item['link']) ) {
                return $this->item['link'];
            }
        }

        return $fallback;
    }

    /**
     * Determine if the item has sub-items (children)
     *
     * @return bool
     */
    public function hasSubItems(): bool
    {
        return isset($this->item['items']) && is_array($this->item['items']) && ! empty($this->item['items']);
    }

    /**
     * Get the item's sub-items
     *
     * This returns an empty array if there are no sub-items, so it doesn't break `foreach` loops.
     *
     * @return array
     */
    public function getSubItems(): array
    {
        return $this->hasSubItems() ? $this->item['items'] : [];
    }

    public function hasCustom($key = null)
    {
        if ( isset($key, $this->item['custom'], $this->item['custom'][$key]) ) {
            return true;
        }

        return false;
    }

    public function getCustom($key = null)
    {
        if ( $key === null ) {
            return $this->item['custom'];
        }

        if ( isset($this->item['custom'], $this->item['custom'][$key]) ) {
            return $this->item['custom'][$key];
        }

        return '';
    }

    public function isExpanded($returnAsString = false)
    {
        if ( $returnAsString ) {
            return $this->expanded ? 'true' : 'false';
        }

        return $this->expanded;
    }

    public function isCollapsed($returnAsString = false)
    {
        if ( $returnAsString ) {
            return $this->collapsed ? 'true' : 'false';
        }

        return $this->collapsed;
    }

    /**
     * Determin if the item is a regular item or a dropdown (ie: dropdown menu with children)
     *
     * @return bool
     */
    public function isDropdown(): bool
    {
        return $this->hasSubItems();
    }

    /**
     * Determine if the current route (page) is a match
     *
     * You should use `$classIfRoute()` or `$boolIfRoute()` in your view file. However, this
     * method is available if you need more flexibility. Used directly, you could basically
     * "if/else" on an entire section of html (instead of just a class name or boolean).
     *
     * The result is stored after the first time this is ran so it doesn't have to do unnecessary
     * and expensive route checks. Basically, class caching.
     *
     * @param bool $returnAsString Default: false - Whether or not to return an string representation of the boolean
     *
     * @return bool|string
     */
    public function routeIsMatch($returnAsString = false)
    {
        if ( $this->routeIsMatchResult !== null ) {
            if ( $returnAsString ) {
                return ($this->routeIsMatchResult == true) ? 'true' : 'false';
            }

            return $this->routeIsMatchResult;
        }

        $routes = $this->getRoutes();

        if ( is_array($routes) ) {
            foreach ($routes as $route) {
                if ( request()->routeIs($route) ) {
                    $this->routeIsMatchResult = true;
                    return $returnAsString ? 'true' : true;
                }
            }
        } else {
            // single route as string passed via `route`
            if ( request()->routeIs($routes) ) {
                $this->routeIsMatchResult = true;
                return $returnAsString ? 'true' : true;
            }
        }

        $this->routeIsMatchResult = false;
        return $returnAsString ? 'false' : false;
    }

    /**
     * Return a CSS class name if the current route (page) is a match
     *
     * This is intended to be used by the view files. If the current route (page) is a match for
     * this item's route, it will return the class.
     *
     * It allows you to dynamically place `active`, `show`, `expanded`, `closed`, or any other classes
     * you need in the html based off of whether or not the route is a match.
     *
     * If the route is not a match, the fallback will be used. By default, it is an empty string. You
     * could use `$classIfRoute('active', 'inactive')` which will use `active` if the route is a match
     * or `inactive` if it is not.
     *
     * @param string $class The class to use if the current route is a matach
     * @param string $fallback Default: '' - The class to use if the current route is not a match
     *
     * @return string
     */
    public function classIfRoute($class = 'active', $fallback = ''): string
    {
        return $this->routeIsMatch() ? $class : $fallback;
    }

    public function classIfNotRoute($class = 'active', $fallback = ''): string
    {
        return ! $this->routeIsMatch() ? $class : $fallback;
    }

    /**
     * Return a boolean if the current route (page) is a match
     *
     * This is intended to be used by the view files. If the current route (page) is a match for
     * this item's route, it will return true|false.
     *
     * By default, this will return a string representation of the boolean. So it will return
     * `'true'` instead of an actual boolean `true`. This allows it to be used inside of
     * JavaScript, such as with AlipineJS.
     *
     * @param bool $returnAsString Default: true - Whether or not to return an string representation of the boolean
     *
     * @return string|bool
     */
    public function boolIfRoute($returnAsString = true)
    {
        if ($returnAsString) {
            return $this->routeIsMatch() ? 'true' : 'false';
        }

        return $this->routeIsMatch() ? true : false;
    }

    /**
     * Get this item's route that should result in a match
     *
     * The route should be either an array or string. Anything else will be considered invalid
     * and not a match. This allows you to insert a nav item using `'route' => false` and it will
     * never be in an active state. Useful for a link to an external site, or anything you want
     * on the menu, but don't need to do anything special (highlighting, expanding).
     *
     * Only the first item in a `route` array config value will be used. A "MenuSubItem" is
     * intended for the very last item in a menu. It has no children elements and is usually
     * the actual page the user is on. Which is only 1 page. An array is accepted to keep the
     * config options following the same pattern. All routes, whether item or sub-item, allow
     * a string or an array. A `MenuItem` has children, a `MenuSubItem` does not.
     *
     * @return string|false
     */
    public function getRoute()
    {
        if ( isset($this->item['route']) && ! empty($this->item['route']) ) {
            if ( is_string($this->item['route']) || is_array($this->item['route']) ) {
                return is_array($this->item['route']) ?
                    $this->item['route'][0] :
                    $this->item['route'];
            }
        }

        return false;
    }

    /**
     * Get this item's route(s) that should result in a match
     *
     * The route(s) should be either an array or string. Anything else will be considered invalid
     * and not a match. This allows you to insert a nav item using `'route' => false` and it will
     * never be in an active state. Useful for a link to an external site, or anything you want
     * on the menu, but don't need to do anything special (highlighting, expanding).
     *
     * @return array|null
     */
    public function getRoutes()
    {
        if (isset($this->item['routes']) && ! empty($this->item['routes'])) {
            if (is_string($this->item['routes']) || is_array($this->item['routes'])) {
                return is_string($this->item['routes']) ? [$this->item['routes']] : $this->item['routes'];
            }
        }

        return $this->getRoute() ?? [];

        //return [];
    }

    public function getLoop()
    {
        return $this->loop;
    }

    public function isFirstLoop($returnAsString = false)
    {
        if ( $returnAsString === true ) {
            return $this->loop->first ? 'true' : 'false';
        }

        return $this->loop->first ?? false;
    }

    public function isLastLoop($returnAsString = false)
    {
        if ( $returnAsString === true ) {
            return $this->loop->last ? 'true' : 'false';
        }
        return $this->loop->last ?? false;
    }
}
