<?php

namespace Plugin\Http;

use Plugin\Http\Controllers\PostController;
use Plugin\Http\Controllers\SitemapController;
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
        'posts' => [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [PostController::class, 'index'],
            'permission_callback' => '__return_true',
        ],
        'sitemap' => [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [SitemapController::class, 'index'],
            'permission_callback' => '__return_true',
        ],
    ];

    /**
     * Initialize the HTTP service.
     *
     * @return void
     */
    public static function boot()
    {
        add_action('rest_api_init', [static::class, 'registerRoutes']);
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
}
