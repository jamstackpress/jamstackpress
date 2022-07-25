<?php

namespace Plugin\Models;

use Exception;
use Plugin\Models\Contracts\Typeable;

abstract class Model implements Typeable
{
    /**
     * Initialize the model.
     * 
     * @return void
     */
    public static function boot()
    {
        // Register the custom post types defined
        // by the plugin.
        add_action('init', [static::class, 'registerCustomType']);

        // Register the custom fields.
        add_action('rest_api_init', [static::class, 'appendCustomFields']);
    }

    /**
     * Register the custom type (if defined).
     *
     * @return array<string, mixed>
     */
    public static function registerCustomType()
    {
        // Check if the definition method is defined.
        if (! method_exists(static::class, 'definition')) {
            return;
        }

        // Check if the type is enabled.
        if (! static::definition()['enabled']) {
            return;
        }

        // Register the custom type.
        register_post_Type(static::type()[0], static::definition());
    }

    /**
     * Append the defined custom fields to
     * the REST api.
     * 
     * @return void
     */
    public static function appendCustomFields()
    {
        if (! method_exists(static::class, 'appends')) {
            return;
        }

        // Register the "jamstackpress" field for each
        // type of object, in which we'll return all 
        // the custom fields.
        foreach (static::type() as $type) {
            register_rest_field($type, 'jamstackpress', [
                'get_callback' => [static::class, 'getJamstackPressAttribute'],
                'update_callback' => null,
                'schema' => null
            ]);
        }
    }

    /**
     * Return the "jamstackpress" attribute with
     * all the appended fields.
     * 
     * @param  array<string, mixed>  $object
     * @return array<int, array<string, mixed>>
     */
    public static function getJamstackPressAttribute($object)
    {
        // Loop through the defined appends
        // and get the corresponding values
        // for each field.
        return array_filter(array_merge(...array_map(
            function ($field) use ($object) {
                // Get the accessor.
                $accessor = static::getAttributeAccessor($field);

                // Return the field with the value from the
                // given accessor.
                return [
                    $field => static::$accessor($object),
                ];
            },
            static::appends()
        )));
    }

    /**
     * Given an attribute, get the name of
     * corresponding accessor.
     *
     * @param  string  $attribute
     * @return string
     */
    protected static function getAttributeAccessor(string $attribute)
    {
        // Get the name of the accessor.
        $accessor = sprintf(
            'get%sAttribute',
            implode('', array_map(fn ($part) => ucfirst($part), explode('_', $attribute)))
        );

        // Check if the accessor exists, or throw
        // an exception.
        if (! method_exists(static::class, $accessor)) {
            throw new Exception(
                sprintf('No accessor %s defined in [%s].', $accessor, static::class)
            );
        }

        return $accessor;
    }
}