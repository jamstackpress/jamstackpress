<?php

namespace JamstackPress\Http\Controllers;

use JamstackPress\Models\Post;
use JamstackPress\Http\Filters\PostFilter;
use WP_REST_Response;

/**
 * @since 0.0.1
 */
class PostController 
{
    /**
     * Return a listing of the resource.
     * 
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public static function get(\WP_REST_Request $request)
    {
        return new WP_REST_Response(Post::filter(new PostFilter($request))->get());
    }
}