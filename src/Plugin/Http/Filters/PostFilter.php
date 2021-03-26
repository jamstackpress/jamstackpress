<?php

namespace JamstackPress\Http\Filters;

use JamstackPress\Http\Filters\Concerns\HasRelationships;
use JamstackPress\Http\QueryFilter;

/**
 * @since 0.0.1
 */
class PostFilter extends QueryFilter
{
    use HasRelationships;

    /**
     * Filter by ID.
     * 
     * @param int $id
     * @return void
     */
    public function id($id = null)
    {
        $this->builder->where('ID', $id);
    }

    /**
     * Filter by slug.
     * 
     * @param string $slug
     * @return void
     */
    public function slug($slug = null)
    {
        $this->builder->where('post_name', $slug);
    }

    /**
     * Filter by status.
     * 
     * @param string $status
     * @return void
     */
    public function status($status = null)
    {
        $this->builder->where('post_status', $status);
    }
}