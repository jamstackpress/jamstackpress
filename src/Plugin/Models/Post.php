<?php

namespace Plugin\Models;

class Post extends Model
{
    /**
     * The model's WordPress object type.
     * 
     * @var string
     */
    public static $type = 'post';

    /**
     * The model's original endpoint.
     * 
     * @var string
     */
    public static $endpoint = '/wp/v2/posts';

    /**
     * The custom attributes appended to
     * the model, when calling the API.
     * 
     * @var array<int, string>
     */
    public static $appends = [
        'date_string', 'full_slug'
    ];

    /**
     * Interact with the date string attribute.
     * 
     * @param  array<string, mixed>  $post
     * @return string
     */
    public static function getDateStringAttribute(array $post)
    {
        // TODO: Implement.
        return '';
    }

    /**
     * Interact with the full slug attribute.
     * 
     * @param  array<string, mixed>  $post
     * @return string
     */
    public static function getFullSlugAttribute(array $post)
    {
        // TODO: Implement.
        return [];
    }
}