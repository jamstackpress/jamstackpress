<?php

namespace Plugin\Models;

use Exception;

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
        if (! property_exists(static::class, 'type') || ! static::$type) {
            throw new Exception(
                sprintf('No WordPress type specified for [%s].', static::class)
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
        if (! property_exists(static::class, 'appends') || ! static::$appends) {
            return;
        }

        // Register the "jamstackpress" field.
        register_rest_field(static::$type, 'jamstackpress', [
            'get_callback' => [static::class, 'getJamstackPressAttribute'],
            'update_callback' => null,
            'schema' => null,
        ]);
    }

    /**
     * Return the JamstackPress attribute.
     *
     * @return array<string, mixed>
     */
    public static function getJamstackPressAttribute($object)
    {
        // Loop through the defined appends in the model
        // and return the corresponding values for each
        // field.
        $values = array_map(
            function ($field) use ($object) {
                // Get the field accessor.
                $accessor = static::getAttributeAccessor($field);

                // Return the field with the value from the
                // given accessor.
                return [
                    $field => static::$accessor($object),
                ];
            },
            static::$appends
        );

        // Return the flatten array.
        return array_merge(...$values);
    }

    /**
     * Given an attribute, get the name of
     * attribute's accessor.
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
                sprintf('No accessor defined for %s in [%s].', $field, static::class)
            );
        }

        return $accessor;
    }
}
