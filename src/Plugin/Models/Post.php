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
        'dateString', 'fullSlug'
    ];

    /**
     * Interact with the date string attribute.
     * 
     * @param  array<string, mixed>  $post
     * @return string
     */
    public static function getDateStringAttribute(array $post)
    {
        // TODO: Implement as current wp decoupled function.
        return 'Date string value';
    }

    /**
     * Interact with the full slug attribute.
     * 
     * @param  array<string, mixed>  $post
     * @return string
     */
    public static function getFullSlugAttribute(array $post)
    {
        // TODO: Implement as current wp decoupled function.
        return [
            'slug' => str_replace(get_site_url(), '', $post['link']),
            'front_link' => str_replace(get_site_url(), 'frontendURL', $post['link']),
        ];
    }
}