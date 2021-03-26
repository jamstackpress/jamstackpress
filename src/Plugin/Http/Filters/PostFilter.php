<?php

namespace JamstackPress\Http\Filters;

use JamstackPress\Http\Filters\Filter;

class PostFilter extends Filter
{
    /**
     * Filter by ID.
     * 
     * @param string $id
     * @return void
     */
    public function id($id)
    {
        $this->builder->where('id', $id);
    }

    /**
     * Filter by status.
     * 
     * @param string $status
     * @return void
     */
    public function status($status)
    {
        $this->builder->withoutGlobalScope('is_published')
            ->where('post_status', $status);
    }

    /**
     * Filter by slug.
     * 
     * @param string $slug
     * @return void
     */
    public function slug($slug)
    {
        $this->builder->where('post_name', $slug);
    }
}