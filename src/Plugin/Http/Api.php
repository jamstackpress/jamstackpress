<?php

namespace JamstackPress\Http;

use JamstackPress\Http\Controllers\PostController;

class Api
{
    /**
     * The routes registered by the API.
     * 
     * @var array
     */
    protected static $endpoints = [
        'posts' => [
            'methods' => [\WP_REST_Server::READABLE],
            'callback' => [PostController::class, 'get']
        ],
    ];

    /**
     * The API endpoints prefix.
     * 
     * @var string
     */
    protected static $prefix = 'jamstackpress/v1';

    /**
     * Register the API endpoints.
     * 
     * @return void
     */
    public static function registerEndpoints()
    {
        add_action('rest_api_init', function() {
            foreach (static::$endpoints as $endpoint => $args) {
                register_rest_route(static::$prefix, $endpoint, $args);
            }
        });
    }
}