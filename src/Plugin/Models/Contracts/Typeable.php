<?php

namespace Plugin\Models\Contracts;

interface Typeable
{
    public static function type() : array;
}