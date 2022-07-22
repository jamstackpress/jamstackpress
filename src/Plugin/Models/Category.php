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
     * Get slugs of every published category.
     *
     * @return array<int, string>
     */
    public static function getSlugs()
    {
        // Get the list of categories.
        $categories = get_categories([
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => true,
        ]);

        // Return the slugs of the categories
        // which have more than 4 posts.
        return array_filter(array_map(
            fn ($category) => $category->count > 4 ? sprintf('/%s/', $category->slug) : null,
            $categories
        ));
    }
}
