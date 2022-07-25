<?php

namespace Plugin\Http\Filters;

class ReplaceBackendUrlWithFrontendUrl
{
    /**
     * Replace backend base URL with front base url.
     *
     * @param  string  $content
     * @return string
     */
    public static function apply($data, $post, $context)
    {
        
        $content = $data->data['content']['rendered'];
        // Replace the home url with the frontend URL.
        $content = static::replaceHomeUrl($content);

        // Replace the urls that don't match any
        // uploaded media.
        $content = static::replaceUrlsExceptMedia($content);
        
        $data->data['content']['rendered'] = $content;
        
        return $data;
    }

    /**
     * Replace the home url with the
     * frontend url.
     *
     * @param  string  $content
     * @return string
     */
    protected static function replaceHomeUrl($content)
    {
        // Get the frontend url.
        $frontendUrl = get_option(config('options.frontend_url.id'));

        return str_replace(
            'href="/',
            trailingslashit('href="'.$frontendUrl),
            $content
        );
    }

    /**
     * Replace the url in the other links
     * that don't match an uploaded media link.
     *
     * @param  string  $content
     * @return string
     */
    protected static function replaceUrlsExceptMedia($content)
    {
        // Get the frontend url.
        $frontendUrl = get_option(config('options.frontend_url.id'));

        // Get the regex pattern.
        $pattern = sprintf(
            '(href=")%s((\/|")(?!wp-content\/uploads))',
            preg_quote(get_site_url(), '/'),
        );

        // Make the replacement.
        return preg_replace(
            "/$pattern/im",
            '$1'.$frontendUrl.'$2',
            $content
        );
    }
}