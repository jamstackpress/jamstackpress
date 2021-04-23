<?php

namespace JamstackPress\Models;

use Illuminate\Database\Eloquent\Builder;
use Sofa\Eloquence\Eloquence;
use JamstackPress\Models\Concerns\Filterable;
use JamstackPress\Models\Concerns\HasSelectableAttributes;
use Sofa\Eloquence\Mappable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use Eloquence, Filterable, HasSelectableAttributes, Mappable;

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
     * The model's hidden attributes.
     *
     * @var array
     */
    protected $hidden = [
        'ID', 'post_author', 'post_date', 'post_date_gmt',
        'post_content', 'post_title', 'post_excerpt', 'post_status',
        'ping_status', 'post_password', 'post_name', 'to_ping', 
        'pinged', 'post_modified', 'post_modified_gmt', 'post_content_filtered', 
        'post_parent', 'guid', 'menu_order', 'post_type', 'post_mime_type',
    ];

    /**
     * The model's attributes that are mapped with another name.
     * 
     * @var array
     */
    protected $maps = [
        'id' => 'ID', 'author' => 'post_author', 'date' => 'post_date',
        'date_gmt' => 'post_date_gmt', 'content' => 'post_content',
        'title' => 'post_title', 'excerpt' => 'post_excerpt',
        'status' => 'post_status', 'slug' => 'post_name',
        'modified' => 'post_modified', 'modified_gmt' => 'post_modified_gmt',
        'parent' => 'post_parent', 'type' => 'post_type'
    ];

    /**
     * The attributes that should be appended.
     * 
     * @var array
     */
    protected $appends = [
        'id', 'author', 'date', 'date_gmt', 'content',
        'title', 'excerpt', 'status', 'slug', 'modified',
        'modified_gmt', 'parent', 'type', 'full_slug',
        'readable_date',
    ];

    /**
     * The relationships that should be always loaded.
     * 
     * @var array
     */
    protected $with = ['categories'];

    /**
     * The attributes toggled by the plugin.
     * 
     * @var array
     */
    protected $toggled = [
        'full_slug' => 'jamstackpress_full_slug_field', 
        'readable_date' => 'jamstackpress_human_readable_date'
    ];

    /**
     * Create the model's instance.
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Disable the attributes toggled by the plugin.
        foreach ($this->toggled as $attribute => $toggler) {
            if (!get_option($toggler, false)) {
                $this->makeHidden($attribute);
            }
        }
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Return only the posts with type "post".
        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('post_type', 'post');
        });

        // Return only the published posts.
        static::addGlobalScope('is_published', function (Builder $builder) {
            $builder->where('post_status', 'publish');
        });
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
        // Get the frontend's url.
        $frontendUrl = trim(get_option('jamstackpress_frontend_base_url', get_site_url()), '/');

        // Replace the backend url with the frontend's url.
        $replaces = [
            // The urls with the format href="/"
            'href="/' => sprintf('href="%1$s', $frontendUrl),

            // The urls with the format href="https://backend-example.com"
            sprintf('href="%1$s', get_site_url()) => sprintf('href="%1$s', $frontendUrl)
        ];
    
        return apply_filters(
            'the_content', 
            str_replace(array_keys($replaces), array_values($replaces), $value)
        );
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
     * Get the post's readable date attribute.
     * 
     * @return string
     */
    public function getReadableDateAttribute()
    {
        // Set the date according to the locale.
        return get_the_date('', $this->attributes['ID']);
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