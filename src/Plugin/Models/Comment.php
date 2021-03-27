<?php

namespace JamstackPress\Models;

use Illuminate\Database\Eloquent\Builder;
use JamstackPress\Models\Concerns\Filterable;
use JamstackPress\Models\Model;
use JamstackPress\Models\Contracts\WordPressEntitiable;
use WP_Comment;

class Comment extends Model implements WordPressEntitiable
{
    use Filterable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'comment_ID';

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'comment_id', 'comment_post_ID', 'comment_author',
        'comment_author_email', 'comment_author_url',
        'comment_author_ip', 'comment_date', 'comment_date_gmt',
        'comment_content', 'comment_karma', 'comment_approved',
        'comment_agent', 'comment_type', 'comment_parent',
        'user_id'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Return only the approved comments.
        static::addGlobalScope('is_approved', function(Builder $builder) {
            $builder->where('comment_approved', 1);
        });
    }

    /**
     * Transform the current model to its WordPress entity.
     * 
     * @return mixed
     */
    public function toWordPressEntity()
    {
        return new WP_Comment($this->toArray());
    }

    /**
     * Post relation for the comment.
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(\JamstackPress\Models\Post::class, 'comment_post_ID')
            ->withoutGlobalScopes();
    }
}