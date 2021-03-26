<?php

namespace JamstackPress\Http\Filters;

use JamstackPress\Http\Filters\Filter;

class CommentFilter extends Filter
{
    /**
     * Filter by ID.
     * 
     * @param string $id
     * @return void
     */
    public function id($id)
    {
        $this->builder->where('comment_id', $id);
    }

    /**
     * Filter by status.
     * 
     * @param string $status
     * @return void
     */
    public function status($status)
    {
        $this->builder->withoutGlobalScope('is_approved')
            ->where('comment_approved', (int) $status);
    }

    /**
     * Filter by post.
     * 
     * @param string $id
     * @return void
     */
    public function post($id)
    {
        $this->builder->where('comment_post_id', $id);
    }
}