<?php

namespace JamstackPress\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
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
     * The model's fillable attributes.
     *
     * @var array
     */
    protected $fillable = [
        'term_id', 'name', 'slug', 'term_group'
    ];

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