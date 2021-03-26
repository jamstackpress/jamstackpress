<?php

namespace JamstackPress\Http\Controllers;

use JamstackPress\Models\Page;
use JamstackPress\Http\Filters\PageFilter;
use WP_REST_Response;

/**
 * @since 0.0.1
 */
class PageController 
{
    /**
     * Return a listing of the resource.
     * 
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public static function get(\WP_REST_Request $request)
    {
        return new WP_REST_Response(Page::filter(new PageFilter($request)));
    }
}