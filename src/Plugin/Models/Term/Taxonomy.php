<?php

namespace JamstackPress\Models\Term;

use Illuminate\Database\Eloquent\Builder;
use JamstackPress\Models\Concerns\Filterable;
use Illuminate\Database\Eloquent\Model;
use JamstackPress\Models\Contracts\WordPressEntitiable;
use WP_Taxonomy;

class Taxonomy extends Model implements WordPressEntitiable
{
    use Filterable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'term_taxonomy';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'term_taxonomy_id';

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'term_taxonomy_id', 'term_id', 'taxonomy', 'description',
        'parent', 'count'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['term'];

    /**
     * Transform the current model to its WordPress entity.
     * 
     * @return mixed
     */
    public function toWordPressEntity()
    {
        return new WP_Taxonomy($this->toArray());
    }

    /**
     * Term relation for the taxonomy.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function term()
    {
        return $this->belongsTo(\JamstackPress\Models\Term::class, 'term_id', 'term_id');
    }

    /**
     * Get the taxonomies corresponding to a category.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeIsCategory(Builder $builder)
    {
        return $builder->where('taxonomy', 'category');
    }

    /**
     * Get the taxonomies corresponding to a post tag.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeIsPostTag(Builder $builder)
    {
        return $builder->where('taxonomy', 'post_tag');
    }
}