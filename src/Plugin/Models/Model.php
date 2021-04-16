<?php

namespace JamstackPress\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    /**
     * Get the model's selectable attributes.
     * 
     * @return array
     */
    public function getSelectableAttributes()
    {
        return array_merge($this->fillable, $this->appends);
    }
}