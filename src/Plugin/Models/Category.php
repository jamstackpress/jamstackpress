<?php

namespace Plugin\Models;

class Category extends Model
{
    /**
     * The model's WordPress object type.
     *
     * @var string
     */
    public static $type = 'category';

    /**
     * The custom attributes appended to
     * the model, when calling the API.
     *
     * @var array<int, string>
     */
    public static $appends = [
    ];

    /**
     * Get slugs of every published category.
     *
     * @return array
     */
    public static function getSlugs()
    {
        $slugs = [];

        $categories = get_categories([
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => true,
        ]);

        foreach ($categories as $cat) {
            // TODO: sitemap options (show cats with x number of posts)
            if ($cat->count > 4) {
                array_push($slugs, '/'.$cat->slug.'/');
            }
        }
        // TODO:  extend for more  taxonomies types
        return array_values($slugs);
    }
}
