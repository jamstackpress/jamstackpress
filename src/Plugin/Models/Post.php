<?php

namespace Plugin\Models;

use Plugin\Models\Contracts\WithCustomFields;
use Plugin\Support\Constants\SeoPlugin;
use RankMath\Post as RankMathPost;
use WP_Query;

class Post extends Model implements WithCustomFields
{
    /**
     * Return the object type.
     * 
     * @return array<int, string>
     */
    public static function type() : array
    {
        return ['post'];
    }

    /**
     * Return the list of custom fields
     * to be added to the model.
     * 
     * @return array<int, string>
     */
    public static function appends() : array
    {
        // Get the list of enabled fields.
        return array_keys(array_filter([
            'readable_date' => get_option(
                config('options.readable_date_field_enabled.id'), 
                null
            ),

            'featured_image' => get_option(
                config('options.featured_image_field_enabled.id'), 
                null
            ),

            'routes' => get_option(
                config('options.routes_field_enabled.id'), 
                null
            ),

            'seo' => get_option(
                config('options.seo_field_enabled.id'), 
                null
            ),
        ]));
    }

    /**
     * Interact with the readable date attribute.
     *
     * @param  array<string, mixed>  $object
     * @return string
     */
    public static function getReadableDateAttribute($object)
    {
        // Return null if readable date option is off
        return wp_date(
            get_option('date_format'),
            strtotime($object['date_gmt']),
        );
    }

    /**
     * Interact with the featured image attribute.
     * TODO: Implement for other post types.
     *
     * @param  array<string, mixed>  $object
     * @return
     */
    public static function getFeaturedImageAttribute($object)
    {
        // The available sizes.
        $sizes = [
            'thumbnail', 'medium',
            'medium_large', 'large',
        ];

        // Get the thumbnail id.
        $image = get_post_thumbnail_id($object['id']);

        // For each size, return the corresponding
        // featured image.
        return array_merge(...array_map(
            fn ($size) => [$size => wp_get_attachment_image_src($image, $size)[0] ?: null],
            $sizes
        ));
    }

    /**
     * Interact with the full slug attribute.
     *
     * @param  string  $link
     * @param  array<string, mixed>  $object
     * @return array<string, string>
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
     * @return array<string, string|null>
     */
    public static function getSeoAttribute($object)
    {
        // Return the fields that correspond
        // to the plugin.
        switch (getSeoPlugin()) {
            case SeoPlugin::RANK_MATH:
                // Create a new Rank Math post.
                $post = new RankMathPost($object);

                // Return the corresponding fields.
                return [
                    'title' => $post->get_metadata('title', null),
                    'description' => $post->get_metadata('description', null),
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
            'post_type' => static::type(),
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