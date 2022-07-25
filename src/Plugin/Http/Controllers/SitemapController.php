<?php

namespace Plugin\Http\Controllers;

use Plugin\Models\Category;
use Plugin\Models\Post;
use WP_REST_Response;

class SitemapController extends Controller
{
    /**
     * Endpoint route.
     *
     * @var string
     */
    public static $route = 'sitemap';

    /**
     * Display a listing of the resource.
     *
     * @return \WP_REST_Response
     */
    public static function index()
    {
        // TODO: Implement pagination.
        return new WP_REST_Response(array_merge(
            Post::getSlugs(),
            Category::getSlugs()
        ));
    }
}
