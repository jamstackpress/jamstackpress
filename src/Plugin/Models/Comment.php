<?php

namespace JamstackPress\Models;

use Illuminate\Database\Eloquent\Builder;
use Sofa\Eloquence\Eloquence;
use JamstackPress\Models\Concerns\Filterable;
use Sofa\Eloquence\Mappable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Eloquence, Filterable, Mappable;

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
     * The model's fillable attributes.
     *
     * @var array
     */
    protected $fillable = [
        'comment_ID', 'comment_post_ID', 'comment_author',
        'comment_author_email', 'comment_author_url',
        'comment_author_ip', 'comment_date', 'comment_date_gmt',
        'comment_content', 'comment_karma', 'comment_approved',
        'comment_agent', 'comment_type', 'comment_parent',
        'user_id'
    ];

    /**
     * The model's hidden attributes.
     *
     * @var array
     */
    protected $hidden = [
        'comment_ID', 'comment_post_ID', 'comment_author',
        'comment_author_email', 'comment_author_url',
        'comment_author_IP', 'comment_date', 'comment_date_gmt',
        'comment_content', 'comment_karma', 'comment_approved',
        'comment_agent', 'comment_type', 'comment_parent',
        'user_id'
    ];

    /**
     * The model's attributes that are mapped with another name.
     * 
     * @var array
     */
    protected $maps = [
        'id' => 'comment_ID', 'post_id' => 'comment_post_ID',
        'author' => 'comment_author', 'author_email' => 'comment_author_email',
        'author_url' => 'comment_author_url', 'author_ip' => 'comment_author_IP',
        'date' => 'comment_date', 'date_gmt' => 'comment_date_gmt',
        'content' => 'comment_content', 'karma' => 'comment_karma',
        'approved' => 'comment_approved', 'agent' => 'comment_agent',
        'type' => 'comment_type', 'parent' => 'comment_parent',
        'user_id' => 'user_id'
    ];

    /**
     * The attributes that should be appended.
     * 
     * @var array
     */
    protected $appends = [
        'id', 'post_id', 'author', 'author_email', 'author_url',
        'author_ip', 'date', 'date_gmt', 'content', 'karma',
        'approved', 'agent', 'type', 'parent', 'user_id',
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
     * Get the post's content.
     *
     * @param  string  $value
     * @return string
     */
    public function getContentAttribute($value)
    {
        return apply_filters('comment_text', $value);
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