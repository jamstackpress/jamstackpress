<?php

namespace Plugin\Models;

use Exception;
use WP_REST_Request;
use WP_REST_Server;


class Model
{
    /**
     * Initialize the model.
     * 
     * @return void
     */
    public static function boot()
    {
        // Check if the WordPress type for the model is set.
        if (! property_exists(get_called_class(), 'type') || ! static::$type) {
            throw new Exception(
                sprintf('No WordPress type specified for [%s].', get_called_class())
            );
        }

        add_action('rest_api_init', [static::class, 'provideCustomFields']);
    }

    /**
     * Initialize the model's custom fields, if any
     * specified.
     * 
     * @return void
     */
    public static function provideCustomFields()
    {
        if (! property_exists(get_called_class(), 'appends') || ! static::$appends) {
            return;
        }

        foreach (static::$appends as $attribute) {
            // Get the attribute as camel case.
            $fn = implode('', array_map(fn ($part) => ucfirst($part), explode('_', $attribute)));

            register_rest_field(static::$type, $attribute, [
                'get_callback' => [static::class, sprintf('get%sAttribute', $fn)],
                'update_callback' => null,
                'schema' => null,
            ]);
        }
    }

    /**
     * Return a resource of the model from a 
     * WordPress's request.
     * 
     * @param  \WP_REST_Request  $request
     * @return array<string, mixed>
     */
    public static function fromRequest(WP_REST_Request $request)
    {
        // Check if the endpoint is set in the model.
        if (! property_exists(get_called_class(), 'endpoint') || ! static::$endpoint) {
            throw new Exception(
                sprintf('No endpoint specified for [%s].', get_called_class())
            );
        }

        return rest_get_server()->response_to_data(
            rest_do_request(
                tap(new WP_REST_Request($request->get_method(), static::$endpoint))
                    ->set_query_params($request->get_params()),
            ), true
        );
    }
}