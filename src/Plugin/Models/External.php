<?php

namespace Plugin\Models;

use Plugin\Models\Contracts\WithCustomFields;

class External extends Model
{
    /**
     * Return the object type.
     * 
     * @return array<int, string>
     */
    public static function type() : array
    {
        return [];
    }

    /**
     * Return the list of custom fields
     * to be added to the model.
     * 
     * @return array<int, string>
     */
    public static function appends() : array
    {
        return [];
    }
}