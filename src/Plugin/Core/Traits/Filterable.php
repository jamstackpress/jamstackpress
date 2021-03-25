<?php

namespace JamstackPress\Core\Traits;

use Illuminate\Database\Eloquent\Builder;
use JamstackPress\Core\QueryFilter;

/**
 * @since 0.0.1
 */
trait Filterable 
{

    /**
     * Filter a result set.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \JamstackPress\Core\QueryFilter $filter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, QueryFilter $filter)
    {
        $filter->apply($query);
    }
}