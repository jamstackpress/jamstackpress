<?php

use Plugin\Support\Constants\SeoPlugin;
use Plugin\Support\HigherOrderTapProxy;

if (! function_exists('tap')) {
    /**
     * Call the given Closure with the given value then return the value.
     *
     * @param mixed         $value
     * @param null|callable $callback
     *
     * @return mixed
     */
    function tap($value, $callback = null)
    {
        if (is_null($callback)) {
            return new HigherOrderTapProxy($value);
        }

        $callback($value);

        return $value;
    }
}

if (! function_exists('getSeoPlugin')) {
    /**
     * Return the name of the installed
     * SEO plugin, if any.
     *
     * @return string|null
     */
    function getSeoPlugin()
    {
        return SeoPlugin::getActive();
    }
}
