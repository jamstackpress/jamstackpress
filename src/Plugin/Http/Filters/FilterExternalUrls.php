<?php

namespace Plugin\Http\Filters;

class FilterExternalUrls
{
    /**
     * Add the target to all external urls.
     *
     * @param  string  $content
     * @return string
     */
    public static function apply($content)
    {
        return $content;
    }
}
