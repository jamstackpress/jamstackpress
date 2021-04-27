<?php

namespace JamstackPress\Http\Filters;

use JamstackPress\Http\Filters\Filter;

class TagFilter extends Filter
{
    /**
     * Filter by ID.
     * 
     * @param int $id
     * @return void
     */
    public function id($id)
    {
        $this->builder->where('term_taxonomy_id', intval($id));
    }

    /**
     * Filter by slug.
     * 
     * @param mixed $slug
     * @return void
     */
    public function slug($slug)
    {
        $this->builder->whereHas('term', function ($query) use ($slug) {
            return $query->where('slug', '=', $slug);
        });
    }
}