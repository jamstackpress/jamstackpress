<?php

namespace Plugin\Models;

use WP_Query;

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
        'jamstackpress',
    ];

    /**
     * Interact with the date string attribute.
     *
     * @param array<string, mixed> $post
     * @param mixed                $object
     *
     * @return string
     */
    public static function getDateStringAttribute($object)
    {
        // multilingual lang code (bogo translate plugin compatibility)
        if (!empty($object['meta']['_locale'])) {
            $post_lang = $object['meta']['_locale'];
            $post_lang = $post_lang.'.UTF-8';
        }
        // Get the date
        $date_gmt = $object['date_gmt'];

        // Set locale
        // multilingual lang code (bogo translate plugin compatibility)
        if (isset($post_lang)) {
            setlocale(LC_TIME, $post_lang);
        // Not multilingual
        } else {
            setlocale(LC_TIME, [get_locale().'.UTF-8']);
        }

        $timestamp = strtotime($date_gmt);

        return strftime('%d %B, %Y', $timestamp);
    }

    /**
     * Interact with the full slug attribute.
     *
     * @param string $link
     * @param mixed  $object
     *
     * @return array
     */
    public static function getFullSlugAttribute($object)
    {
        $replace = [
            get_site_url() => '',
        ];

        $replace_2 = [
            get_site_url() => get_option('jamstackpress_frontend_base_url', get_site_url()),
        ];

        $url_full_front = str_replace(array_keys($replace_2), $replace_2, $object['link']);
        $full_slug = str_replace(array_keys($replace), $replace, $object['link']);

        return [
            'slug' => $full_slug,
            'front_link' => $url_full_front,
        ];
    }

    /**
     * Get slugs of every published posts.
     *
     * @return array
     */
    public static function getSlugs()
    {
        // Define array of slugs
        $slugs = [];

        // Get published posts
        $published_posts = new WP_Query([
            'post_type' => array_filter([
                static::$type,
                // TODO: Implement option for more post types
                // post_type_exists('ht_kb') ? 'ht_kb' : null,
            ]),
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => ['type' => 'DESC'],
        ]);

        // published posts
        foreach ($published_posts->posts as $post) {
            // Populate array of slugs, removing the site url part
            array_push($slugs, str_replace(get_site_url(), '', get_permalink($post->ID)));
        }

        // return only the values
        return array_values($slugs);
    }

    /**
     * Returns the corresponding post metadata according
     * to the configured plugin's SEO plugin.
     *
     * @param array $object
     *
     * @return mixed
     */
    public static function getSeoMetaFields($object)
    {
        $seo_plugin = 'yoast';

        if ('yoast' != $seo_plugin) {
            return ['title' => get_post_meta($object['id'], 'rank_math_title', true), 'description' => get_post_meta($object['id'], 'rank_math_description', true)];
        }

        return ['title' => YoastSEO()->meta->for_post($object['id'])->title, 'description' => YoastSEO()->meta->for_post($object['id'])->description];
    }

    /**
     * Generate the jamstackpress object with every
     * field.
     *
     * @param mixed $object
     *
     * @return array
     */
    public static function getJamstackpressAttribute($object)
    {
        return ['routes' => self::getFullSlugAttribute($object),
            'date_string' => self::getDateStringAttribute($object),
            'seo' => self::getSeoMetaFields($object), ];
    }
}
