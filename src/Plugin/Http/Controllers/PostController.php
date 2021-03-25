<?php

namespace JamstackPress\Http\Controllers;

use JamstackPress\Models\Post;

class PostController
{
    /**
     * Return a listing of the resource.
     * 
     * @param \JamstackPress\Models\Post
     * @return mixed
     */
    public static function get(\WP_REST_Request $request)
    {
        return Post::get();
    }
}