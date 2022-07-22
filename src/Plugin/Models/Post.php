<?php

namespace Plugin\Models;

use Plugin\Support\Constants\SeoPlugin;
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
     * The custom attributes appended to
     * the model, when calling the API.
     *
     * @var array<int, string>
     */
    public static $appends = [
        'date_string', 'routes', 'seo',
    ];

    /**
     * Interact with the date string attribute.
     *
     * @param  array<string, mixed>  $object
     * @return string
     */
    public static function getDateStringAttribute($object)
    {
        // Set the locale.
        setlocale(LC_TIME, '');
        setlocale(LC_TIME, get_locale().'.UTF-8');

        // Add compatiblity with Bogo translate plugin,
        // if the plugin is installed and configured.
        /** @see https://es.wordpress.org/plugins/bogo/ */
        if (! empty($object['meta']['_locale'])) {
            setlocale(LC_TIME, $object['meta']['_locale'].'.UTF-8');
        }

        return strftime(
            '%d %B, %Y',
            strtotime($object['date_gmt'])
        );
    }

    /**
     * Interact with the full slug attribute.
     *
     * @param  string  $link
     * @param  array<string, mixed>  $object
     * @return array
     */
    public static function getRoutesAttribute($object)
    {
        return [
            'slug' => str_replace(
                get_site_url(), '', $object['link'],
            ),

            'front_link' => str_replace(
                get_site_url(),
                get_option('jamstackpress_frontend_base_url', get_site_url()),
                $object['link']
            ),
        ];
    }

    /**
     * Returns the corresponding post metadata according
     * to the configured plugin's SEO plugin.
     *
     * @param  array<string, mixed>  $object
     * @return mixed
     */
    public static function getSeoAttribute($object)
    {
        // Get the installed plugin.
        $plugin = getSeoPlugin();

        // Return the fields that correspond
        // to the plugin.
        switch ($plugin) {
            case SeoPlugin::RANK_MATH:
                return [
                    'title' => get_post_meta($object['id'], 'rank_math_title', true),
                    'description' => get_post_meta($object['id'], 'rank_math_description', true),
                ];

            case SeoPlugin::YOAST:
                return [
                    'title' => YoastSEO()->meta->for_post($object['id'])->title,
                    'description' => YoastSEO()->meta->for_post($object['id'])->description,
                ];

            default:
                return [
                    'title' => null,
                    'description' => null,
                ];
        }
    }

    /**
     * Get slugs of every published posts.
     *
     * @return array<int, string>
     */
    public static function getSlugs()
    {
        // Create the query for published posts.
        // TODO: Implement for other post types.
        $query = new WP_Query([
            'post_type' => [
                static::$type,
            ],
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => [
                'type' => 'DESC',
            ],
        ]);

        // Return the slugs for the selected
        // query posts.
        return array_map(
            fn ($post) => str_replace(get_site_url(), '', get_permalink($post->ID)),
            $query->posts,
        );
    }
}
