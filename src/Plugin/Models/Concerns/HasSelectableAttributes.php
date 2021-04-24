<?php

namespace JamstackPress\Models\Concerns;

trait HasSelectableAttributes
{
    /**
     * The selectable attributes that are not eager loaded
     * nor appended to the model.
     * 
     * @var array
     */
    protected $extra = [];

    /**
     * Return the selectable attributes of the
     * model.
     * 
     * @return void
     */
    public function getSelectableAttributes()
    {
        return array_diff(
            array_unique(
                array_merge(
                    array_keys($this->maps),
                    $this->appends,
                    $this->with
                ),
            ),
            $this->hidden
        );
    }
}