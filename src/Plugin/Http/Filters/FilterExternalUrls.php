<?php

namespace Plugin\Http\Filters;
use DOMDocument;
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
        if (!$content || empty($content)) {
            return $content;
        }
    
        //FrontEnd URL
        $front_url = get_option('jamstackpress_frontend_base_url');
        // Create the document.
        $dom = new DOMDocument();
        $dom->encoding = 'utf-8';
        @$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
        // Load all the images.
        $anchors = $dom->getElementsByTagName('a');
        // Set the new width and height of all the images.
        foreach ($anchors as $a) {
            $href = $a->getAttribute('href');
    
            if (substr($href, 0, strlen(get_site_url())) != get_site_url()
                && substr($href, 0, strlen($front_url)) != $front_url
                && substr($href, 0, 3) != 'tel' && substr($href, 0, 6) != 'mailto') {
                $a->setAttribute('target', '_blank');
            }
        }
        return $dom->saveHTML();
    }
}
