<?php

namespace Plugin\Support\Constants;

abstract class SeoPlugin
{
    const YOAST = 'yoast';

    const RANK_MATH = 'rank_math';

    /**
     * The list of supported plugins and
     * their mappings to the plugin name.
     *
     * @var array<string, string>
     */
    protected static $supported = [
        'rank_math' => 'seo-by-rank-math/rank-math.php',
        'yoast' => 'wordpress-seo/wp-seo.php',
    ];

    /**
     * Get the first active plugin of the supported
     * list.
     *
     * @return static
     */
    public static function getActive()
    {
        // Include the plugin file.
        if (! function_exists('is_plugin_active')) {
            include_once ABSPATH.'wp-admin/includes/plugin.php';
        }

        // Loop through the list and get the first
        // active plugin.
        foreach (static::$supported as $plugin => $file) {
            if (is_plugin_active($file)) {
                return $plugin;
            }
        }
    }
}
