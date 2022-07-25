<?php

namespace Plugin\Http;

class Kernel
{
     /**
     * The filters for the REST Api. The key
     * represents the WordPress hook to which
     * the filters will be attached.
     *
     * @var array<string, string>
     */
    public static $filters = [
        'rest_prepare_post' => [
            AddTargetToExternalUrls::class,
            ReplaceBackendUrlWithFrontendUrl::class,
        ],
    ];

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

        // Register the filters.
        self::applyFilters();
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
                add_filter($hook, [$filter, 'apply'], 10, 3);
            }
        }
    }
}