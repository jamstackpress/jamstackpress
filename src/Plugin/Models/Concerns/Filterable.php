<?php

namespace JamstackPress\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use JamstackPress\Http\Filters\Filter;

trait Filterable
{
    /**
     * Apply the defined filters to the given
     * builder instance.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \JamstackPress\Models\Filters\Filter $filter
     * @return mixed
     */
    public function scopeFilter(Builder $builder, Filter $filter)
    {
        return $filter->apply($builder);
    }
}