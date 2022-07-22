<?php

namespace Plugin\Http\Filters;

class ReplaceBackUrl
{
    /**
     * Replace backend base URL with front base url.
     *
     * @param  string  $content
     * @return string
     */
    public static function apply($content)
    {
        {  //Replace any references to the home url of the backend with the front home url
            $replace = [
                //TODO: Detect of the wp installation is using or not trailing slash
                'href="/' => 'href="' . get_option('jamstackpress_frontend_base_url') . '/',
            ];
            $content = str_replace(array_keys($replace), $replace, $content);
            
           //Replace any references to the backend base url with the front base url
            $pattern = sprintf('(href=")%s((\/|")(?!wp-content\/uploads))', preg_quote(get_site_url(), '/'));
            $content = preg_replace("/$pattern/im", '$1' . get_option('jamstackpress_frontend_base_url') . '$2', $content);
    
            return $content;
        }
    }
}
