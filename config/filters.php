<?php

use Plugin\Http\Filters\AddSizeToImages;
use Plugin\Http\Filters\AddTargetToExternalUrls;
use Plugin\Http\Filters\ReplaceBackendUrlWithFrontendUrl;

return [
    /*
    |--------------------------------------------------------------------------
    | Filters.
    |--------------------------------------------------------------------------
    */
    'rest_prepare_post' => [
        'add_image_sizes' => [
            'method' => AddSizeToImages::class, 
            'enabled' => !! get_option(config('options.add_image_sizes_filter_enabled.id'), false),
        ],

        'blank_external' => [
            'method' => AddTargetToExternalUrls::class, 
            'enabled' => !! get_option(config('options.target_blank_filter_enabled.id'), false),
        ],

        'replace_urls' => [
            'method' => ReplaceBackendUrlWithFrontendUrl::class, 
            'enabled' => !! get_option(config('options.replace_filter_enabled.id'), false),
        ],
    ],
];