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
        // Include the plugin file.
        include_once ABSPATH.WPINC.'/plugin.php';

        // Check if any of the installed plugins
        // corresponds to a supported SEO plugin and
        // return the internal value.
        foreach (get_plugins() as $plugin) {
            if ($plugin = SeoPlugin::from($plugin['Name'])) {
                return $plugin;
            }
        }
    }
}
