<?php

namespace JamstackPress\Http\Controllers;

use JamstackPress\Http\Filters\CategoryFilter;
use JamstackPress\Models\Term\Taxonomy;
use WP_REST_Request;
use WP_REST_Response;

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
            Taxonomy::isCategory()->filter(new CategoryFilter($request))
        );
    }
}