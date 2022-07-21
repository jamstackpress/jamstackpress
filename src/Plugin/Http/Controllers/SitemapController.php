<?php

namespace Plugin\Http\Controllers;

use Plugin\Models\Post;
use Plugin\Models\Category;

class SitemapController
{
    /**
     * Display a listing of the resource.
     * 
     * @return  array of slugs
     */
    public static function index()
    {
        // TODO: Implement pagination?
        
        return array_merge(Post::getSlugs(), Category::getSlugs());
    }
}