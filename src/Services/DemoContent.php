<?php

namespace CyberPunkCodes\MenuHelper\Services;

use Illuminate\Support\Facades\Route;
use CyberPunkCodes\MenuHelper\Exceptions\MenuHelperException;

class DemoContent
{
    public static function tailwindFaq()
    {
        return [
            //'header' => [
            //    'show' => false,
            //    'text' => '',
            //],
            'id' => 'accordionExample',
            'items' => self::getFaqItems(),
        ];
    }

    public static function bootstrapFaq()
    {
        return [
            //'header' => [
            //    'show' => false,
            //    'text' => '',
            //],
            'id' => 'accordionExample',
            'items' => self::getFaqItems(),
        ];
    }

    public static function getFaqItems()
    {
        return [
            [
                'target' => 'collapseOne',  // `$getTarget()`
                'id' => 'headingOne',       // `$getId()`
                'title' => 'Accordion 1',   // `$getTitle()`
                'text' => "<strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.",    // `$getText()`
                'custom' => [
                    //'foo' => 'bar',       // `$getCustom('foo')`
                ],
            ],
            [
                'expanded' => true,
                'target' => 'collapseTwo',
                'id' => 'headingTwo',
                'title' => 'Accordion 2',
                'text' => "<strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.",
                'custom' => [
                    //'foo' => 'bar',
                ],
            ],
            [
                'target' => 'collapseThree',
                'id' => 'headingThree',
                'title' => 'Accordion 3',
                'text' => "<strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.",
                'custom' => [
                    //'foo' => 'bar',
                ],
            ],
        ];
    }

    public static function getSidebarItems($framework = 'tailwind')
    {
        return [
            // start: basic item
            [
                'title' => 'Home',
                'icon'  => '<i class="fa-solid fa-fw fa-house-chimney"></i>',
                'route' => 'demo.' . $framework . '.advanced.index',
                'link'  => ['demo.' . $framework . '.advanced.index'],   // array, named route for the link
            ],
            // end: basic item

            // start: dropdown item
            [
                'title'  => 'Account',
                'icon'   => '<i class="fa-solid fa-fw fa-user"></i>',
                // array of routes that match, wildcard supported
                'routes' => [
                    'demo.' . $framework . '.advanced.profile.*',
                    'demo.' . $framework . '.advanced.test.foo',
                    'demo.' . $framework . '.advanced.test.bar'
                ],
                'items'  => [

                    // first sub-item
                    [
                        'title' => 'It Works Foo',
                        'route' => 'demo.' . $framework . '.advanced.test.foo',
                        'link'  => ['demo.' . $framework . '.advanced.test.foo'],
                    ],

                    // second sub-item
                    [
                        'title' => 'Profile',
                        'route' => 'demo.' . $framework . '.advanced.profile.show',
                        'link'  => ['demo.' . $framework . '.advanced.profile.show'],
                    ],

                    // third sub-item
                    [
                        'title' => 'It Works Bar',
                        'route' => 'demo.' . $framework . '.advanced.test.bar',
                        'link'  => ['demo.' . $framework . '.advanced.test.bar'],
                    ],
                ],
            ],
            // end: dropdown item

            // start: dropdown item
            [
                'title' => 'Posts',
                'icon'  => '<i class="fa-solid fa-fw fa-book"></i>',
                'routes' => ['demo.' . $framework . '.advanced.test2.*'],     // array of routes that match, wildcard supported
                'items' => [

                    // first sub-item
                    [
                        'title' => 'It Works Foo',
                        'route' => 'demo.' . $framework . '.advanced.test2.foo',
                        'link'  => ['demo.' . $framework . '.advanced.test2.foo'],
                    ],

                    // second sub-item
                    [
                        'title' => 'It Works Bar',
                        'route' => 'demo.' . $framework . '.advanced.test2.bar',
                        'link'  => ['demo.' . $framework . '.advanced.test2.bar', ['id' => '123']],
                    ],

                    // third sub-item
                    [
                        'title' => 'Extenal Link',
                        'link' => 'https://www.google.com',     // string for absolute link
                    ],

                    // fourth sub-item
                    [
                        'title' => 'Just Some Text',
                    ],

                ],
            ],
            // end: dropdown item
        ];
    }

    public static function tailwindSidebar()
    {
        return [
            'header' => [
                'show' => true,
                'text' => 'Navigation',
            ],
            'items' => self::getSidebarItems('tailwind'),
        ];
    }

    public static function bootstrapSidebar()
    {
        return [
            'header' => [
                'show' => true,
                'text' => 'Navigation',
            ],
            'items' => self::getSidebarItems('bootstrap'),
        ];
    }

    public static function loadTailwindRoutes()
    {
        self::loadDemoRoutes('tailwind');
    }

    public static function loadBootstrapRoutes()
    {
        self::loadDemoRoutes('bootstrap');
    }

    public static function loadDemoRoutes($framework = 'tailwind')
    {
        $allowed = ['tailwind', 'bootstrap'];

        if ( ! in_array($framework, $allowed) ) {
            throw new MenuHelperException("loadDemoRoutes() only accepts" . implode(', ', $allowed));
        }

        Route::get('/', function () use ($framework) {
            return view('menuhelper::demo.' . $framework . '.advanced-page', ['framework' => $framework]);
        })->name('index');

        Route::get('/profile/show', function () use ($framework) {
            return view('menuhelper::demo.' . $framework . '.advanced-page', ['framework' => $framework]);
        })->name('profile.show');

        Route::get('/profile/edit', function () use ($framework) {
            return view('menuhelper::demo.' . $framework . '.advanced-page', ['framework' => $framework]);
        })->name('profile.edit');

        Route::get('/profile/change-password', function () use ($framework) {
            return view('menuhelper::demo.' . $framework . '.advanced-page', ['framework' => $framework]);
        })->name('profile.change-password');

        Route::get('/test/foo', function () use ($framework) {
            return view('menuhelper::demo.' . $framework . '.advanced-page', ['framework' => $framework]);
        })->name('test.foo');

        Route::get('/test/bar', function () use ($framework) {
            return view('menuhelper::demo.' . $framework . '.advanced-page', ['framework' => $framework]);
        })->name('test.bar');

        Route::get('/test2/foo', function () use ($framework) {
            return view('menuhelper::demo.' . $framework . '.advanced-page', ['framework' => $framework]);
        })->name('test2.foo');

        Route::get('test2/bar', function () use ($framework) {
            return view('menuhelper::demo.' . $framework . '.advanced-page', ['framework' => $framework]);
        })->name('test2.bar');
    }
}
