<?php

namespace Plugin\Http\Filters;

use DOMDocument;

class AddTargetToExternalUrls
{
    /**
     * Add the target to all external urls.
     *
     * @param  WP_REST_Response  $response
     * @param  WP_Post  $post
     * @param  WP_REST_Request  $request
     * @return string
     */
    public static function apply($response, $post, $request)
    {
        $content = $response->data['content']['rendered'];
        
        // Discard a null or empty content.
        if (! $content || empty($content)) {
            return $content;
        }

        // Create the DOM document with the
        // corresponding encoding.
        $dom = new DOMDocument('1.0', 'utf-8');

        // Load the content into the DOM.
        @$dom->loadHTML(mb_convert_encoding(
            $content, 'HTML-ENTITIES', 'UTF-8'
        ));

        // Loop through the content anchors
        // and check if they are external.
        foreach ($dom->getElementsByTagName('a') as $anchor) {
            // If the anchor's url is external,
            // add the target attribute.
            if (static::isExternalUrl($anchor->getAttribute('href'))) {
                $anchor->setAttribute('target', '_blank');
            }
        }
        
        // Replace the content in the response.
        $response->data['content']['rendered'] = $dom->saveHTML();

        return $response;
    }

    /**
     * Return a boolean indicating if the given string
     * corresponds to an external URL.
     *
     * @param  string  $url
     * @return bool
     */
    public static function isExternalUrl(string $url)
    {
        // Get the frontend URL.
        $frontendUrl = get_option(config('options.frontend_url.id'));

        return substr($url, 0, strlen(get_site_url())) != get_site_url()
            && substr($url, 0, strlen($frontendUrl)) != $frontendUrl
            && substr($url, 0, 3) != 'tel'
            && substr($url, 0, 6) != 'mailto';
    }
}