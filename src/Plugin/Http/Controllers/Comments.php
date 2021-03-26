<?php

namespace JamstackPress\Http\Controllers;

use JamstackPress\Models\Comment;
use JamstackPress\Http\Filters\CommentFilter;
use WP_REST_Request;
use WP_REST_Response;

class Comments
{
    /**
     * Return a listing of the resource.
     * 
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public static function get(WP_REST_Request $request)
    {
        return new WP_REST_Response(
            Comment::filter(new CommentFilter($request))
        );
    }
}