<?php

namespace Plugin\Support\Constants;

abstract class SeoPlugin
{
    const YOAST = 'yoast';

    const RANK_MATH = 'rank_math';

    /**
     * The list of supported plugins and
     * their mappings to internal values.
     *
     * @var array<string, string>
     */
    protected static $supported = [
        'Yoast SEO' => 'yoast',
        'Rank Math SEO' => 'rank_math',
    ];

    /**
     * Given the plugin name, return the corresponding
     * value from the enum.
     *
     * @param  string  $name
     * @return static
     */
    public static function from(string $name)
    {
        // Check if the plugin is not supported.
        if (! array_key_exists($name, static::$supported)) {
            return null;
        }

        return static::$supported[$name];
    }
}
