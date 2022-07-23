<?php

namespace Plugin\Models;

class Contact extends Model
{
    /**
     * The model's WordPress object type.
     *
     * @var string
     */
    public static $type = 'jp_contact';

    /**
     * Indicate if the model is a custom
     * type.
     *
     * @var bool
     */
    public static $custom = true;

    /**
     * Arguments for the $args parameter
     * in order to register the post type
     *
     * @var array
     */
    public static $type_args = [
        'labels' => [
            'name' => 'Contacts',
            'singular_name' => 'Contact',
        ],
        'public' => true,
        'has_archive' => false,
        'show_in_menu' => true,
    ];
}
