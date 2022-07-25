<?php

namespace Plugin\Http\Controllers;

class Controller
{
    /**
     * Check if custom endpoint
     * JP plugin is enabled
     *
     * @return bool
     */
    public static function isEnabled()
    {
        return get_option(sprintf('jamstackpress_%s_enabled', static::$route));
    }
}