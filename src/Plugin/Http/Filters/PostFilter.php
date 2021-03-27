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

    /**
     * Filter by type.
     * 
     * @param string $type
     * @return void
     */
    public function type($type)
    {
        $this->builder->withoutGlobalScope('type')
            ->where('post_type', $type);
    }

    /**
     * Filter by categories ids or slugs.
     * 
     * @param string $string
     * @return void
     */
    public function categories($string)
    {
        // The string can contain IDs or slugs.
        $categories = explode(',', $string);
        
        // Filter terms which ID or slug is included in the values.
        $this->builder->whereHas('categories.term', function($query) use ($categories) {
            $query->whereIn('term_id', array_filter($categories, function($category) {
                return is_numeric($category);
            }))->orWhereIn('slug', array_filter($categories, function($category) {
                return is_string($category);
            }));
        });
    }
}