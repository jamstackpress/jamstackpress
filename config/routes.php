<?php

use Plugin\Http\Controllers\ContactController;
use Plugin\Http\Controllers\SitemapController;

return [

    /*
    |--------------------------------------------------------------------------
    | Contact.
    |--------------------------------------------------------------------------
    */

    'contact' => [
        'method' => WP_REST_Server::CREATABLE,
        'handler' => [ContactController::class, 'store'],
        'enabled' => !! get_option(config('options.contact_route_enabled.id'), false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Sitemap.
    |--------------------------------------------------------------------------
    */

    'sitemap' => [
        'method' => WP_REST_Server::READABLE,
        'handler' => [SitemapController::class, 'get'],
        'enabled' => !! get_option(config('options.sitemap_route_enabled.id'), false),
    ],
];