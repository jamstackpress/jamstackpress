<?php

namespace JamstackPress\Http;

/**
 * @since 0.0.1
 */
class Api 
{

    /**
     * The API endpoints prefix.
     * 
     * @var string
     */
    private static $prefix = 'jamstackpress/v1';

    /**
     * The endpoints registered by the API.
     * 
     * @var array
     */
    private static $endpoints = [
        'posts' => [
            'methods' => \WP_REST_Server::READABLE,
            'callback' => [Controllers\PostController::class, 'get'],
            'permission_callback' => '__return_true'
        ],
        'comments' => [
            'methods' => \WP_REST_Server::READABLE,
            'callback' => [Controllers\CommentController::class, 'get'],
            'permission_callback' => '__return_true'
        ]
    ];

    /**
     * Bootstrap the API functionalities.
     * 
     * @return void
     */
    public static function register_endpoints()
    {
        foreach (self::$endpoints as $endpoint => $parameters) {
            register_rest_route(
                self::$prefix,
                $endpoint,
                $parameters
            );
        }
    }
}