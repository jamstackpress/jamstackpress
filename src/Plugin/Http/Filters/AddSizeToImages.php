<?php

namespace Plugin\Http\Filters;

use DOMDocument;
use FasterImage\FasterImage;

class AddSizeToImages
{
    /**
     * Loop through the content images and add the
     * sizes to those that don't have them.
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

        // Get the content images.
        $images = $dom->getElementsByTagName('img');

        // Discard if there are no images.
        if (! count($images)) {
            return $response;
        }

        // Get the image sources.
        $sources = array_map(
            fn ($image) => $image->getAttribute('src'),
            iterator_to_array($images)
        );

        // Get the sizes of the images.
        $sizes = (new FasterImage)->batch($sources);

        // Loop through the images and set the
        // corresponding size.
        foreach ($images as $image) {
            // Check if the size was retrieved.
            if (count($sizes[$image->getAttribute('src')]['size']) < 2) {
                static::setImageSize($image);
                continue;
            }

            static::setImageSize(
                $image, 
                ...$sizes[$image->getAttribute('src')]['size']
            );
        }

        // Replace the content in the response.
        $response->data['content']['rendered'] = $dom->saveHTML();
        
        return $response;
    }

    /**
     * Given an image and the corresponding size, set
     * the size on the image.
     * 
     * @param  \DOMElement  $image
     * @param  int  $width  (optional)
     * @param  int  $height  (optional)
     * @return void
     */
    public static function setImageSize($image, $width = null, $height = null)
    {
        // Set the defailt "srcset" attribute.
        if (! $image->getAttribute('srcset')) {
            $image->setAttribute('srcset', sprintf(
                '%1$s 1024w, %1$s 300w, %1$s 768w, %1$s 1200w, %1$s 1302w',
                $image->getAttribute('src')
            ));
        }

        // Set the image dimensions.
        $image->setAttribute('width', $width ?: 420);
        $image->setAttribute('height', $height ?: 420);
        $image->setAttribute('sizes', '70vmin');
    }
}