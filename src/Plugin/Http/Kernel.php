<?php

namespace Plugin\Http;

class Kernel
{
    /**
     * Boot the HTTP services of the
     * plugin.
     * 
     * @return void
     */
    public static function boot()
    {
        // Register the routes in the app.
        add_action('rest_api_init', [static::class, 'registerApiRoutes']);
    }

    /**
     * Register the routes defined in the config
     * file of the plugin.
     * 
     * @return void
     */
    public static function registerApiRoutes()
    {
        foreach (config('routes') as $endpoint => $args) {
            // Check if the endpoint is enabled.
            if (! $args['enabled']) {
                continue;
            }

            // Register the route.
            register_rest_route(
                config('plugin.route_prefix'), $endpoint, [
                    'methods' => $args['method'],
                    'callback' => $args['handler'],
                    'permission_callback' => '__return_true',
                ]
            );
        }
    }
}