<?php

namespace JamstackPress\Http\Controllers;

use JamstackPress\Models\Comment;
use JamstackPress\Http\Filters\CommentFilter;

/**
 * @since 0.0.1
 */
class CommentController 
{

    /**
     * Return a listing of the resource.
     * 
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public static function get(\WP_REST_Request $request)
    {
        return Comment::filter(new CommentFilter($request))->get();
    }
}