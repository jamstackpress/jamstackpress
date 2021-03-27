<?php

namespace JamstackPress\Models\Term;

use JamstackPress\Models\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Relationship extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'term_relationships';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'term_taxonomy_id';
}