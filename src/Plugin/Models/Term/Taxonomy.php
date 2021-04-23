<?php

namespace JamstackPress\Models\Term;

use Illuminate\Database\Eloquent\Builder;
use Sofa\Eloquence\Eloquence;
use JamstackPress\Models\Concerns\Filterable;
use JamstackPress\Models\Concerns\HasSelectableAttributes;
use Sofa\Eloquence\Mappable;
use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    use Eloquence, Filterable, HasSelectableAttributes, Mappable;

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
     * The model's fillable attributes.
     *
     * @var array
     */
    protected $fillable = [
        'term_taxonomy_id', 'term_id', 'taxonomy', 'description',
        'parent', 'count'
    ];

    /**
     * The model's hidden attributes.
     *
     * @var array
     */
    protected $hidden = [
        'laravel_through_key', 'term',
    ];

    /**
     * The model's attributes that are mapped with another name.
     * 
     * @var array
     */
    protected $maps = [
        'name' => 'term.name', 'slug' => 'term.slug', 
        'term_group' => 'term.term_group'
    ];

    /**
     * The attributes that should be appended.
     * 
     * @var array
     */
    protected $appends = [
        'name', 'slug', 'term_group' 
    ];

    /**
     * The relationships that should be always loaded.
     * 
     * @var array
     */
    protected $with = ['term'];

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