<?php

namespace JamstackPress\Models;

use Illuminate\Database\Eloquent\Builder;
use JamstackPress\Models\Post;

class Page extends Post
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Return only the posts with type "page".
        static::addGlobalScope('is_page', function(Builder $builder) {
            $builder->where('post_type', 'page');
        });

        // Return only the published posts.
        static::addGlobalScope('is_published', function(Builder $builder) {
            $builder->where('post_status', 'publish');
        });
    }
}