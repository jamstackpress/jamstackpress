<?php

namespace JamstackPress\Models;

use Illuminate\Database\Eloquent\Builder;

class Page extends Post
{
    /**
     * The model's primary key.
     *
     * @var string
     */
    protected $primaryKey = 'ID';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Return only the posts with type "page".
        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('post_type', 'page');
        });
    }
}