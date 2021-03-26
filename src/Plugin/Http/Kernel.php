<?php

namespace JamstackPress\Http;

use WP_REST_Server;

class Kernel
{
    /**
     * The prefix for the API routes.
     * 
     * @var string
     */
    protected static $prefix = 'jamstackpress/v1';

    /**
     * The API endpoints available.
     * 
     * @var array
     */
    protected static $endpoints = [
        'posts' => [
            'methods' => [WP_REST_Server::READABLE],
            'callback' => [Controllers\Posts::class, 'get'],
            'permission_callback' => '__return_true'
        ],
        'pages' => [
            'methods' => [WP_REST_Server::READABLE],
            'callback' => [Controllers\Pages::class, 'get'],
            'permission_callback' => '__return_true'
        ],
        'comments' => [
            'methods' => [WP_REST_Server::READABLE],
            'callback' => [Controllers\Comments::class, 'get'],
            'permission_callback' => '__return_true'
        ],
        'categories' => [
            'methods' => [WP_REST_Server::READABLE],
            'callback' => [Controllers\Taxonomies::class, 'categories'],
            'permission_callback' => '__return_true'
        ]
    ];

    /**
     * Boot the HTTP kernel.
     * 
     * @return void
     */
    public static function boot()
    {
        add_action('rest_api_init', [static::class, 'registerEndpoints']);
    }

    /**
     * Register the endpoints provided by the API.
     * 
     * @return void
     */
    public static function registerEndpoints()
    {
        foreach (static::$endpoints as $endpoint => $args) {
            register_rest_route(static::$prefix, $endpoint, $args);
        }
    }
}