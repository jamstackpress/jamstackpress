<?php

namespace JamstackPress\Models;

use JamstackPress\Models\Model;
use JamstackPress\Models\Contracts\WordPressEntitiable;
use WP_Term;

class Term extends Model implements WordPressEntitiable
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'terms';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'term_id';

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'term_id', 'name', 'slug', 'term_group'
    ];

    /**
     * Transform the current model to its WordPress entity.
     * 
     * @return mixed
     */
    public function toWordPressEntity()
    {
        return new WP_Term($this->toArray());
    }

    /**
     * Taxonomy relation for the term.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function taxonomy()
    {
        return $this->hasOne(\JamstackPress\Models\Term\Taxonomy::class, 'term_id', 'term_id');
    }
}