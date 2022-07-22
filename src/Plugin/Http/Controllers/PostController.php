<?php

namespace Plugin\Http\Controllers;

use Plugin\Models\Post;
use WP_REST_Request;
use WP_REST_Response;

class PostController
{
    /**
     * Display a listing of the resource.
     *
     * @return \WP_REST_Response
     */
    public static function index(WP_REST_Request $request)
    {
        return new WP_REST_Response(Post::fromRequest($request));
    }
}
