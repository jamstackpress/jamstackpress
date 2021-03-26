<?php

namespace JamstackPress\Http\Filters;

use JamstackPress\Http\Filters\Concerns\HasRelationships;
use JamstackPress\Http\QueryFilter;

/**
 * @since 0.0.1
 */
class CommentFilter extends QueryFilter
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
        $this->builder->where('comment_ID', $id);
    }

    /**
     * Filter by author name.
     * 
     * @param string $author
     * @return void
     */
    public function author($author = null)
    {
        $this->builder->where('comment_author', $author);
    }

    /**
     * Filter by post.
     * 
     * @param string $post
     * @return void
     */
    public function post($post = null)
    {
        $this->builder->where('comment_post_ID', $post);
    }

    /**
     * Filter by approvement status.
     * 
     * @param string $approved
     * @return void
     */
    public function approved($approved = null)
    {
        $this->builder->where('comment_approved', $approved);
    }
}