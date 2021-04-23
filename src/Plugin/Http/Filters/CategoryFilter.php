<?php

namespace JamstackPress\Http\Filters;

use JamstackPress\Http\Filters\Filter;

class CategoryFilter extends Filter
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
     * Filter by status.
     * 
     * @param mixed $status
     * @return void
     */
    public function slug($slug)
    {
        $this->builder->whereHas('term', function ($query) use ($slug) {
            return $query->where('slug', '=', $slug);
        });
    }

    /**
     * Filter by post count.
     * 
     * @param mixed $hideEmpty
     * @return void
     */
    public function hideEmpty($hideEmpty)
    {
        if (boolval($hideEmpty)) {
            $this->builder->where('count', '>', 0);
        };
    }
}