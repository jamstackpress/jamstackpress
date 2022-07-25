<?php

use Noodlehaus\Config;
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

if (! function_exists('config')) {
    /**
     * Return the given configuration.
     * 
     * @param  string  $path
     * @param  mixed  $default
     * @return string|null
     */
    function config(string $path, $default = null)
    {
        // Get the path parts.
        $path = explode('.', $path);
        $file = $path[0];

        // Check if we should load all the options
        // in the file.
        if (count($path) < 2) {
            return Config::load(
                trailingslashit(dirname(__DIR__, 3)).'/config/'.$file.'.php'
            )->all();
        }

        // Get the option path.
        array_shift($path);

        // Return the option.
        return Config::load(
            trailingslashit(dirname(__DIR__, 3)).'/config/'.$file.'.php'
        )->get(implode('.', $path), $default);
    }
}