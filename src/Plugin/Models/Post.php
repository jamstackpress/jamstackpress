<?php

namespace JamstackPress\Models;

use Illuminate\Database\Eloquent\Builder;
use JamstackPress\Models\Concerns\Filterable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Filterable;

    /**
     * The model's primary key.
     *
     * @var string
     */
    protected $primaryKey = 'ID';

    /**
     * The model's attributes.
     * 
     * @var array
     */
    protected $attributes = [
        'ID', 'post_author', 'post_date', 'post_date_gmt', 'post_content',
        'post_title', 'post_excerpt', 'post_status', 'comment_status', 'ping_status',
        'post_password', 'post_name', 'to_ping', 'pinged', 'post_modified',
        'post_modified_gmt', 'post_content_filtered', 'post_parent', 'guid',
        'menu_order', 'post_type', 'post_mime_type', 'comment_count'
    ];

    /**
     * The list of hidden attributes.
     * 
     * @var array
     */
    protected $hidden = [
        'post_password', 'ping_status', 'to_ping', 'pinged',
        'menu_order'
    ];

    /**
     * Returns the content attribute.
     * 
     * @param string $value
     * @return string
     */
    public function getPostContentAttribute($value)
    {
        // Apply the WordPress filters to the content.
        return apply_filters('the_content', $value);
    }

    /**
     * Returns the title attribute.
     * 
     * @param string $value
     * @return string
     */
    public function getPostTitleAttribute($value)
    {
        // Apply the WordPress filters to the title.
        return apply_filters('the_title', $value);
    }

    /**
     * Comments relation for a post.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(\JamstackPress\Models\Comment::class, 'comment_post_ID', 'ID');
    }
}