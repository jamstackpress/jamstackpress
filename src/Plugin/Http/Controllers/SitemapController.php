<?php

namespace Plugin\Http\Controllers;

use Plugin\Models\Category;
use Plugin\Models\Post;
use WP_REST_Response;

class SitemapController
{
    /**
     * Display a listing of the resource.
     *
     * @return \WP_REST_Response
     */
    public static function get()
    {
        // TODO: Implement pagination.
        return new WP_REST_Response(array_merge(
            Post::getSlugs(),
            Category::getSlugs()
        ));
    }
}