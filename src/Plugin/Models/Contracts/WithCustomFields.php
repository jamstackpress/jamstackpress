<?php

namespace Plugin\Models\Contracts;

interface WithCustomFields
{
    public static function appends() : array;
}