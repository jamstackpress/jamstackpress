<?php

namespace JamstackPress\Http\Controllers;

use WP_REST_Request;
use WP_REST_Response;
use JamstackPress\Models\Term\Taxonomy;

class Taxonomies
{
    /**
     * Return a listing of the categories.
     * 
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public static function categories(WP_REST_Request $request)
    {
        return new WP_REST_Response(
            Taxonomy::isCategory()->get()
        );
    }
}