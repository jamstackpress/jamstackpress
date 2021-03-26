<?php

namespace JamstackPress\Models;

use JamstackPress\Models\Concerns\Filterable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Filterable;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'comment_ID';

    /**
     * The list of attributes of the model.
     * 
     * @var array
     */
    protected $attributes = [
        'comment_ID', 'comment_post_ID', 'comment_author', 
        'comment_author_email', 'comment_author_url', 'comment_author_IP',
        'comment_date', 'comment_date_gmt', 'comment_content', 'comment_karma',
        'comment_approved', 'comment_agent', 'comment_type', 'comment_parent',
        'user_id'
    ];

    /**
     * Post relation for a comment.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function post()
    {
        return $this->belongsTo(\JamstackPress\Models\Post::class, 'comment_post_ID', 'ID');
    }
}