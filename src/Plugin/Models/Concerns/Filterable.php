<?php

namespace JamstackPress\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use JamstackPress\Http\QueryFilter;

trait Filterable
{
    /**
     * Filter a result set.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \JamstackPress\Http\QueryFilter $filter
     * @return void
     */
    public function scopeFilter(Builder $builder, QueryFilter $filter)
    {
        return $filter->apply($builder);
    }
}