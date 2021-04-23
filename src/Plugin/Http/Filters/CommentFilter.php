<?php

namespace JamstackPress\Http\Filters;

use JamstackPress\Http\Filters\Filter;

class CommentFilter extends Filter
{
    /**
     * Filter by ID.
     * 
     * @param int $id
     * @return void
     */
    public function id($id)
    {
        $this->builder->where('comment_ID', intval($id));
    }

    /**
     * Filter by status.
     * 
     * @param mixed $status
     * @return void
     */
    public function approved($status)
    {
        $this->builder->withoutGlobalScope('is_approved');

        if ($status !== 'all') {
            $this->builder
                ->where('comment_approved', intval(boolval($status)));
        }
    }

    /**
     * Filter by post.
     * 
     * @param int $id
     * @return void
     */
    public function post($id)
    {
        $this->builder->where('comment_post_ID', intval($id));
    }

    /**
     * Filter by user id.
     * 
     * @param int $id
     * @return void
     */
    public function user($id)
    {
        $this->builder->where('user_id', intval($id));
    }
}