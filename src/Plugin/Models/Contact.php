<?php

namespace Plugin\Models;

class Contact extends Model
{
    /**
     * Return the object type.
     * 
     * @return array<int, string>
     */
    public static function type() : array
    {
        return ['jp_contact'];
    }

    /**
     * Return the object type's definition.
     * 
     * @return array<int, string>
     */
    public static function definition() : array
    {
        return [
            'enabled' => !! get_option(config('options.contact_route_enabled.id'), null),
            'labels' => [
                'name' => __('Contacts'),
                'singular_name' => __('Contact'),
            ],
            'public' => true,
            'has_archive' => false,
            'show_in_menu' => true,
        ];
    }
}
