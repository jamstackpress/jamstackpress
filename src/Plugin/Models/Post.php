<?php

namespace JamstackPress\Models;

use Illuminate\Database\Eloquent\Builder;
use JamstackPress\Models\Concerns\Filterable;
use JamstackPress\Admin\Helper as AdminHelper;
use JamstackPress\Models\Model;
use JamstackPress\Models\Contracts\WordPressEntitiable;
use WP_Post;

class Post extends Model implements WordPressEntitiable
{
    use Filterable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ID';

    /**
     * The model's fillable attributes.
     *
     * @var array
     */
    protected $fillable = [
        'ID', 'post_author', 'post_date', 'post_date_gmt',
        'post_content', 'post_title', 'post_excerpt', 'post_status',
        'comment_status', 'ping_status', 'post_password', 'post_name',
        'to_ping', 'pinged', 'post_modified', 'post_modified_gmt',
        'post_content_filtered', 'post_parent', 'guid', 'menu_order',
        'post_type', 'post_mime_type', 'comment_count'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'ping_status', 'post_password', 'to_ping', 'pinged',
        'menu_order', 'post_mime_type', 'full_slug'
    ];

    /**
     * The attributes that should be appended.
     * 
     * @var array
     */
    protected $appends = ['full_slug'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Return only the posts with type "post".
        static::addGlobalScope('type', function(Builder $builder) {
            $builder->where('post_type', 'post');
        });

        // Return only the published posts.
        static::addGlobalScope('is_published', function(Builder $builder) {
            $builder->where('post_status', 'publish');
        });
    }

    /**
     * Transform the current model to its WordPress entity.
     * 
     * @return mixed
     */
    public function toWordPressEntity()
    {
        return new WP_Post($this->toArray());
    }

    /**
     * Return an array with the list of selectable attributes
     * of the model.
     * 
     * @return void
     */
    public function getSelectableAttributes()
    {
        $attributes = parent::getSelectableAttributes();

        // Full slug field.
        if (!get_option('jamstackpress_full_slug_field', false)) {
            unset($attributes[array_search('full_slug', $attributes)]);
        }

        return $attributes;
    }

    /**
     * Get the post's title.
     *
     * @param  string  $value
     * @return string
     */
    public function getPostTitleAttribute($value)
    {
        return apply_filters('the_title', $value);
    }

    /**
     * Get the post's content.
     *
     * @param  string  $value
     * @return string
     */
    public function getPostContentAttribute($value)
    {
        return apply_filters('the_content', $value);
    }

    /**
     * Get the post's full slug attribute.
     * 
     * @return string
     */
    public function getFullSlugAttribute()
    {
        // Get the frontend url.
        $frontendUrl = get_option('jamstackpress_frontend_base_url', get_site_url());
        if (empty($frontendUrl)) {
            $frontendUrl = get_site_url();
        }

        /* Get the permalink created by WordPress, and return the
         * mutations we need. */
        return [
            'slug' => str_replace(
                get_site_url(), 
                '', 
                get_permalink($this->attributes['ID'])
            ),
            'front_url' => str_replace(
                get_site_url(), 
                trim($frontendUrl, '/'),  
                get_permalink($this->attributes['ID'])
            )
        ];
    }

    /**
     * Comment relation for the post.
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(\JamstackPress\Models\Comment::class, 'comment_post_ID');
    }

    /**
     * Terms relation for the post.
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function terms()
    {
        return $this->hasManyThrough(
            \JamstackPress\Models\Term\Taxonomy::class,
            \JamstackPress\Models\Term\Relationship::class,
            'object_id',
            'term_taxonomy_id'
        );
    }

    /**
     * The categories associated to the post.
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function categories()
    {
        return $this->terms()->where('taxonomy', 'category');
    }

    /**
     * The tags associated to the post.
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function tags()
    {
        return $this->terms()->where('taxonomy', 'post_tag');
    }
}