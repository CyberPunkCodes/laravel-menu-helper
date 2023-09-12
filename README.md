# Laravel Menu Helper

Laravel Menu Helper can make working with menus extremely easy. Whether it be a top navbar, a left
sidebar, FAQ, or anything else. If it's a menu, it can help :)

Menus can be a pain, especially when you need to handle logic for various things, like determining
if the user is on a matching route, adding an `active` class, or you need to make modifications to
the data on the fly.

With Laravel Menu Helper, you build your menus with a config array of the data and view components
broken down to manage them easier. The components have their own methods that allow you to take
control over your menus.

Since Laravel can cache the config files, you don't have to use them. The items can be passed directly
into the component allowing you to load them from a database, use RBAC to toggle whether the item
is shown, perform collection operations on the data, cache each user's menu, whatever you need.

[TOC]

## Intro

The `basic` menu stubs are simple 1-level menus. The most obvious example of a basic menu is a FAQ
section. You have multiple sections, each with a header (`title`) and `text`. It doesn't have to be
a FAQ section, you could use this for pricing boxes on your homepage, or anything else that doesn't
require multiple levels.

The `advanced` stubs are for multiple level menus. It could be a top navbar, sidebar, mobile menu,
etc. The advanced stubs include methods that allow you to determine if the current menu item (in the
loop) is the current route so you can do something different, like apply a class, or detect if the
menu item has children (is a dropdown). Allowing you to easily create multi-level menus.

There isn't a difference between `basic` and `advanced` under the hood. They both use the same
Components, the difference is how they are used. All of the same methods are available. With a basic
menu, we just have a title and text and aren't checking if there are children items or if we are on
a specific route. Though, you can use those methods to do so. Using the basic stub doesn't limit you.
The stub just had a different way of looking at the menu. Just because the basic stub uses the `text`
field, doesn't mean the advanced can't. You could use it to pass a popup hover message. Just because
the advanced stub uses icons, doesn't mean you can't in the basic. You just have to use the methods
in the view components to utilize them. If you are creating a multi-level menu, start with the
advanced because it already includes the subitem view component and methods to handle the looping.

Keep in mind, you can also create your own stubs to re-use in multiple projects. You could create
your own Bulma stub with the basic CSS classes needed. Drop it in, modify it, and have a menu built
in 5 minutes on future projects.

## Installation

To install this package, run:

```bash
composer require cyberpunkcodes/laravel-menu-helper
```

It is recommended that you view the demo the first time you use this package so you have a better
understanding of what you are working with as a baseline to expand upon. Included are 2 types of
menu stubs to use as a starting point: `basic` and `advanced`. Both `basic` and `advanced` have
Bootstrap and Tailwind stubs to choose from: `basic-bootstrap`, `basic-tailwind`, `advanced-bootstrap`,
`advanced-tailwind`.

## Demo Mode

To enable demo mode, add the Menu Helper Demo Mode key to your project's `.env` file:

```bash
MH_DEMOMODE=true
```

Demo mode activates the demo routes, views, and config so you can check out some live examples.
There is a demo page that will help you navigate and review the various menu examples.

Navigate to `/demo/` and you will be presented with 2 options, Tailwind and Bootstrap. Each
one has their own basic and advanced examples.

The Tailwind and Bootstrap demos are using their CDN links so they work out of the box for this demo.
When generating your own menus, you will need to have your own CSS and JavaScript (if necessary). This
does not handle any of the CSS or JavaScript to make the menus works. It assumes you already have them
installed to your template, because, at this point, you should.

## Building

First, lets publish the config files:

```bash
php artisan vendor:publish --tag=menuhelper-config
```

This will generate `menu-helper` and `menu-helper-secondary` in your app's config directory.

The `menu-helper` config file is the global config. The intention is to place all of your menus that
will load on every (or most) page loads. Things like a top navbar or left sidebar, for example.

The `menu-helper-secondary` config file is for things that aren't on every page. Since the menu
config arrays can get fairly big, we split them. Things like the config for your FAQ menu, would go
here in the secondary config. It is only needed if they are on your FAQ page, so it doesn't need to
be lugged around for every other page load.

Now that you have installed the package with Composer and have checked out the demos, you can now
build your own menu. You just have to know which stub you want to use as a baseline. If you don't
want Tailwind or Bootstrap, then you can pick either one and modify it to fit your needs.

The stub values in the `make:menu name --stub=` command correspond to the menu names in the demo. So
if you want to see an example of a Bootstrap sidebar, open the `/demo/bootstrap/advanced` URL. If you
want to use that as a starting menu template, you can generate it with `php artisan make:menu
left-sidebar --stub=bootstrap-advanced`, where `left-sidebar` is the name of the menu you want to
create.

Remember, the stub names match the demo routes. `/demo/bootstrap/basic` is `bootstrap-basic`.
`/demo/tailwind/advanced` is `tailwind-advanced`. If you have made your own custom stubs, then it is the
folder name. Refer to the [Creating Stubs](#creating-stubs) section for more info.

If you do not specify a stub, and just run `php artisan make:menu my-menu`, it will default to the
Tailwind advanced stub/template.

### Basic Menu Config

We can pass a lot through our menu config array. For now, let's just keep it simple. You can check
out the [Advanced Usage](#advanced-usage) section for info about showing/hiding a menu item or sub-item, detecting if
the item matches the current route, and more.

#### FAQ Example

Let's start with a FAQ example, which is based off the basic stub:

```php
[
    'my-menu' => [
        'expanded' => true,         // `$isExpanded()` - Optional - Default: false
        'target' => 'collapseOne',  // `$getTarget()` - Optional
        'id' => 'headingOne',       // `$getId()` - Optional - A random `mh_` prefixed id if empty
        'title' => 'Accordion 1',   // `$getTitle()`
        'text' => "<strong>This is the first item's...",    // `$getText()`
    ],
]
```

**Note:** `my-menu` is the name of your menu that you generate with the `make:menu` command.

Only `title` and `text` are really required here. The rest are helpful when using JavaScript.

Remember, all of the options are still available to us. You can specify an icon, custom data, link,
whatever you need. It comes down to how you use this data (the logic flow and methods used) in the
view components. Since this is a single level menu without sub-items, the `menu-subitem.blade.php`
view file is not needed. That is really the only difference between basic and advanced. The advanced
assumes you will need multiple levels, so it includes a `menu-subitem` blade file. You could use the
advanced stub and delete the subitem view file if your menu will only ever be 1 level, as well as
remove the if/else checking in the `menu-item` blade file.

#### Navbar Example

Most of you are going to be looking for a navbar menu. So if you aren't sure, then you probably are.

Here is an example of a sidebar menu built from an advanced stub:

```php
[
    'my-menu' => [
        // start: single item
        [
            'title' => 'Home',              // `$getTitle()`
            'icon'  => '<i class="fa-solid fa-fw fa-house-chimney"></i>',   // `$hasIcon()`, `$getIcon()`
            'route' => 'dashboard',         // named route - `route` key only supports a single route as a string
            //'routes' => ['dashboard'],    // we could also use an array list of all routes that match
            'link'  => ['dashboard'],       // `$getLink()`named route for the link, null = no link
        ],
        // end: single item

        // start: dropdown item
        [
            'title' => 'Posts',
            'icon'  => '<i class="fa-solid fa-fw fa-book"></i>',
            'routes' => ['posts.*'],     // route matching: array list of all routes that match
            'items' => [

                // first sub-item
                [
                    'title' => 'All Posts',
                    'route' => ['posts.index'],
                    'link'  => ['posts.index'],
                ],

                // second sub-item
                [
                    'title' => 'Create Post',
                    'route' => ['posts.create'],
                    'link'  => ['posts.create', ['foo' => 'bar']],
                ],
            ],
        ],
        // end: dropdown item
    ]
]
```

**Note:** `my-menu` is the name of your menu that you generate with the `make:menu` command.

Notice that this array is a bit different. It doesn't have `text` but instead has an `items` key.
Items holds an array of each "sub-item".

The "Home item" doesn't have any "items", or "sub-items" as they are referred to in the view
components. It is the first level, or only level if you aren't needing child or sub-items. It also
supports route matching. This route matching allows us to do something different with this menu
item. We could give it an `active` class to change the background, font color, or whatever we want.

The "Profile item" has "sub-items", keyed as `items`. It uses route matching to match the `posts.*`
wildcard. We could use this to add an `expanded` class which reveals the sub-items. It also has an
`icon`, which can be any HTML you need. You will need to install any extra fonts or font libraries
yourself.

The "Profile sub-items" are simpler, and use a `title`, `route`, and `link`. Again, route matching
is supported here. Typically it would be the route exactly and not a wildcard.

### Building The Menu Views

Now that you have a menu config array, you need the view files to bring it all together. This is
where your understanding of the demo comes in. Or.. you could just guess and wing it. Whatever works
for you :)

Here is the format of the make menu command:

```bash
php artisan make:menu {name} {--stub=tailwind-advanced}
```

**Note:** If you don't specify with the `--stub` option, then `tailwind-advanced` is used.

**Included Stubs:**

 - tailwind-advanced
 - tailwind-basic
 - bootstrap-advanced
 - bootstrap-basic

You can also create your own stubs. Refer to the [Creating Stubs](docs/creating-stubs.md) section
for more info.

Example generating a menu named `my-menu` using the `bootstrap-advanced` as a boilerplate:

```bash
php artisan make:menu my-menu --stub=bootstrap-advanced
```

The views for the menu will be generated at `resources/views/vendor/menuhelper/my-menu`.

**Note:** The menu name must match the name used in your config file. Also, this does not install
any CSS or JavaScript. If you are using Bootstrap or Tailwind, FontAwesome, etc.. then you need to
install them yourself.

### Add The Menu To Your Layout

Ok, now you have the config and views created. It's time to drop the menu into your layout.

Wherever you want the menu to be, add the Menu Helper menu component:

```blade
<x-menuhelper::menu scope="global" menu="my-menu" />
```

The scope can be `global` or `secondary`, and the `menu` must match the menu name you used in the
previous steps. It is recommended to always pass the scope. If your menu is a secondary menu, and you
don't specify, it will look in the global menu config first. Then in the secondary if it doesn't
find it. We can save some resources and specify the `secondary` scope. Always specifying it even
when it's global can help with code clarity.

Now your menu is created and ready for you to customize it.

### Advanced Menu Config

@TODO

## Customizing

This is where the fun begins and your menu comes to life. Remember, there is no CSS or JavaScript
included. You have to do that yourself.

You need to understand the view components that make up the menus and the helper functions
available that can help you build menus quickly and easily.

### View Component Files

The only differences between the `basic` examples and `advanced` examples, are that the `basic` ones do
not have a `menu-subitem` and their config array does not have `items`. It was just `title` and
`text`. So it is basically 1 level. The `advanced` examples do have the `menu-subitem`s view files
and their config array has `items`. Meaning it is more than 1 level, the parent elements can have
child elements. Typical of a top navbar or left sidebar.

 - menu.blade.php - The wrapping content around the menu
 - menu-items.blade.php - Typically no styling here at all, it just loops and creates the `menu-item`
 - menu-item.blade.php - The actual menu item itself (ie: Account)
 - menu-subitem.blade.php - The child of the item above (ie: Change Password under Account item)

Again, you may not need `menu-subitem` if your menu is and only will be, 1 level.

### Helper Methods

Each view component has their own helper methods available to them. The examples show you some of
the most necessary ones that allow you to pull off a nice menu after you have paired it with CSS and
JavaScript. Some methods are exclusive to the component, others are available all the way down the
chain.

#### Menu Component

The following methods are available to the menu component `menu.blade.php`:

 - getConfig() - Probably don't need this. It holds the whole menu's config.
 - getScope() - `global` or `secondary`. Not sure why you would need this, but it's available :)
 - getMenu() - The name of the menu, ie: `left-sidebar`
 - getMenuId() - The id of the menu for use in your HTML. If not defined, a random `mh_` prefixed id is generated
 - getItems() - Gets the items of the menu
 - showHeader() - (bool) Whether or not to show the header
 - getHeaderText() - The header text. Useful for displaying text, like `Navigation` before your menu

To render the menu component, place it in your template/layout wherever you want it to go:

```php
<x-menuhelper::menu scope="global" menu="left-sidebar" />
```

Remember, scope must be either `global` or `secondary` and match the config file. The menu must
match a menu configured in your config file and the name of a menu in your
`resources/views/vendor/menuhelper` directory, ie: `resources/views/vendor/menuhelper/left-sidebar`.



#### Menu Items Component

The menu items component is really basic. It simply takes the data in the menu and passes it down
the chain. It's the foreach loop that passes what it knows down to a menu item.

The following methods are available to the menu items component `menu-items.blade.php`:

 - getParentId() - Gets the id of the whole menu (same as `getMenuId()` from above menu component)
 - getMenu() - The name of the menu, ie: `left-sidebar`
 - getItems() - Gets the items of the menu

To render the menu items component, call it from the menu component:

```php
<x-menuhelper::menuItems :menu="$getMenu()" :items="$getItems()" :parent-id="$getMenuId()" />
```

#### Menu Item Component

The menu item component is the 1st level item itself. This item can have child elements. If you look
in any of the advanced stub examples, we use `$isDropdown()` to determine if the item is a dropdown
item. If it is, we do a few things differently and render a `menu-subitem` component. If not, then
we use the item's link/icon/title directly. If your menu is and will only be 1 level deep, then you
do not have to check if it's a dropdown and can just display the data directly.

The following methods are available to the menu item component `menu-item.blade.php`:

 - shouldRender() - (bool) Whether or not the item should be shown
 - getParentId() - The main menu's id (passed all the way down)
 - getId() - The id of the item itself
 - getMenu() - The name of the menu
 - getItem() - The data of the item
 - isDropdown() - (bool) Whether or not the item has sub-items (children)
 - hasTitle() - (bool) Whether or not the item has a title
 - getTitle() - Get the item's title
 - getText() - Get the item's text (used in the FAQ usage, not sidebar)
 - hasIcon() - (bool) Whether or not the item has an icon
 - getIcon() - Get the icon (html)
 - hasLink() - (bool) Whether or not the item has a link
 - getLink() - Get the item's link
 - hasSubItems() - Same as `isDropdown()`
 - getSubItems() - Get the sub items
 - getRoutes() - Get the item's routes (used by `routeIsMatch()`)
 - routeIsMatch($returnAsString = false) - Determines whether the current route matches the item's route
 - classIfRoute($class = 'active', $fallback = '') - Return a class if the route is a match, or another if not
 - classIfNotRoute($class = 'active') - Return a class if the route is not a match
 - boolIfRoute($returnAsString = true) - Returns a boolean (or string representation) if the route is a match
 - getCustom($key) - Get the value of custom data passed to the item
 - getLoop() - Get the Laravel loop object (passed into `menu-item` by the loop created in `menu-items`)
 - isFirstLoop() - Is the first iteration in the loop (first item being processed)
 - isLastLoop() - Is the last iteration in the loop (last item being processed)
 - getTarget() - Get the item's target (useful for JS)
 - isExpanded($returnAsString = false) - Whether or not the item is (or should be) expanded. `'expanded' => true` in config
 - isCollapsed($returnAsString = false) - Opposite of `isExpanded()`. If an item is not expanded, it's collapsed

To render a menu item component, call it from the menu items component in a foreach loop:

```php
@foreach($getItems() as $item)
    <x-menuhelper::menuItem :menu="$getMenu()" :item="$item" :parent-id="$getParentId()" :loop="$loop" />
@endforeach
```

#### Menu Sub Item

Since a sub-item is basically an item with no child items of it's own, it has some of the same
helper methods.

 - shouldRender() - (bool) Whether or not the sub-item should be shown
 - getMenu() - The name of the menu
 - getSubItem() - Get the sub-item's data
 - getRoute() - Get the sub-item's route
 - routeIsMatch($returnAsString = false) - Determines whether the current route matches the sub-item's route
 - classIfRoute($class = 'active', $fallback = '') - Return a class if the route is a match, or another if not
 - boolIfRoute($returnString = true) - Returns a boolean (or string representation) if the route is a match
 - hasLink() - (bool) Whether or not the sub-item has a link
 - getLink($fallback = '') - Get the sub-item's link
 - getTitle() - Get the sub-item's title

To render a menu sub item component, call it from the menu item component:

```php
@foreach ($getSubItems() as $subItem)
    <x-menuhelper::menuSubItem :menu="$getMenu()" :subItem="$subItem" />
@endforeach
```

In your menu item component, you will want to check if the item has sub-items by using either the
`isDropdown()` or `hasSubItems()` methods.

Refer to the source code for a better understanding: [src/View/Components/MenuItem.php](src/View/Components/MenuItem.php)

### Creating Stubs

@TODO

---

This repo and documentation is not complete. I have made some changes that might have thrown off this
documentation. I needed to wrap it up and use this menu helper in a project, so I just needed to get
it pushed.

The custom stubs probably won't work yet. There is whitelist checking, so it probably needs to look
through the stubs directory and see if a directory with that name exists.

Feel free to ask a question or dig through the code and issue a PR.
