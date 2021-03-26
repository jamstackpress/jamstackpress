<?php

namespace JamstackPress\Http;

class Api
{
    /**
     * The endpoints prefix.
     * 
     * @var string
     */
    protected static $prefix = 'jamstackpress/v1';

    /**
     * The endpoints available through the API.
     * 
     * @var array
     */
    protected static $endpoints = [
        'comments' => [
            'methods' => \WP_REST_Server::READABLE,
            'callback' => [Controllers\CommentController::class, 'get'],
            'permission_callback' => '__return_true'
        ],
        'pages' => [
            'methods' => \WP_REST_Server::READABLE,
            'callback' => [Controllers\PageController::class, 'get'],
            'permission_callback' => '__return_true'
        ],
        'posts' => [
            'methods' => \WP_REST_Server::READABLE,
            'callback' => [Controllers\PostController::class, 'get'],
            'permission_callback' => '__return_true'
        ],
    ];

    /**
     * Bootstrap the API.
     * 
     * @return void
     */
    public static function boot()
    {
        // Create a new rest_api_init hook.
        add_action('rest_api_init', function() {
            foreach (static::$endpoints as $endpoint => $args) {
                register_rest_route(
                    static::$prefix,
                    $endpoint,
                    $args
                );
            }
        });
    }
}