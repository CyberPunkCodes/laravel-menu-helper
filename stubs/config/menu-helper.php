<?php

return [
    /*
    // EXAMPLE
    'demomenu' => [
        'header' => [
            'show' => true,
            'text' => 'Navigation',
        ],
        'items' => [
            // start: basic item
            [
                'title' => 'Home',
                'icon'  => '<i class="fa-solid fa-fw fa-house-chimney"></i>',
                'route' => 'dashboard',     // named route - `route` key only supports a single route as a string
                'link'  => ['dashboard'],   // use an array for a named route
            ],
            // end: basic item

            // start: dropdown item
            [
                'title'  => 'Account',
                'icon'   => '<i class="fa-solid fa-fw fa-user"></i>',
                // array of routes that match, wildcard supported
                'routes' => [
                    'user.*',
                    'change-password',
                ],
                'items'  => [
                    // first sub-item
                    [
                        'title' => 'Profile',
                        'route' => 'user.profile',      // singular `route` key only supports string
                        'link'  => ['user.profile'],    // array for named route
                    ],

                    // second sub-item
                    [
                        'title' => 'Change Password',
                        'route' => 'change-password',   // singular `route` key only supports string
                        'link'  => ['change-password'], // array for named route
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
        ],
    ],
    // END EXAMPLE
    */
];
