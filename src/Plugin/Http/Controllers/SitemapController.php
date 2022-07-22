<?php

namespace Plugin\Http\Controllers;

use Plugin\Models\Category;
use Plugin\Models\Post;

class SitemapController
{
    /**
     * Display a listing of the resource.
     *
     * @return array<int, string>
     */
    public static function index()
    {
        // TODO: Implement pagination.
        return array_merge(
            Post::getSlugs(), 
            Category::getSlugs()
        );
    }
}
