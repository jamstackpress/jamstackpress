<?php

namespace Plugin\Http\Filters;

class ReplaceBackendUrlWithFrontendUrl
{
    /**
     * Replace backend base URL with front base url.
     *
     * @param  WP_REST_Response  $response
     * @param  WP_Post  $post
     * @param  WP_REST_Request  $request
     * @return string
     */
    public static function apply($response, $post, $request)
    {
        $content = $response->data['content']['rendered'];

        // Replace the home url with the frontend URL.
        $content = static::replaceHomeUrl($content);

        // Replace the urls that don't match any
        // uploaded media.
        $content = static::replaceUrlsExceptMedia($content);

        // Replace the content in the response.
        $response->data['content']['rendered'] = $content;
        
        return $response;
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