<?php

namespace Plugin\Http;

use Plugin\Http\Controllers\SitemapController;
use Plugin\Http\Filters\FilterExternalUrls;
use Plugin\Http\Filters\ReplaceBackUrl;
use WP_REST_Server;

class Kernel
{
    /**
     * The routes prefix.
     *
     * @var string
     */
    public static $prefix = 'jamstackpress/v1';

    /**
     * The plugin routes.
     *
     * @var array<int, string>
     */
    public static $routes = [
        'sitemap' => [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [SitemapController::class, 'index'],
            'permission_callback' => '__return_true',
        ],
    ];

    /**
     * The filters for the REST Api. The key
     * represents the WordPress hook to which
     * the filters will be attached.
     *
     * @var array<string, string>
     */
    public static $filters = [
        'the_content' => [
            FilterExternalUrls::class,
            ReplaceBackUrl::class,
        ],
    ];

    /**
     * Initialize the HTTP service.
     *
     * @return void
     */
    public static function boot()
    {
        // Register the routes.
        add_action('rest_api_init', [static::class, 'registerRoutes']);

        // Register the filters.
        self::applyFilters();
    }

    /**
     * Register the plugin routes.
     *
     * @return void
     */
    public static function registerRoutes()
    {
        foreach (static::$routes as $endpoint => $args) {
            register_rest_route(
                static::$prefix,
                $endpoint,
                $args,
            );
        }
    }

    /**
     * Register the HTTP filters applied
     * to the REST Api.
     *
     * @return void
     */
    public static function applyFilters()
    {
        foreach (static::$filters as $hook => $filters) {
            foreach ($filters as $filter) {
                add_filter($hook, [$filter, 'apply']);
            }
        }
    }
}
