<?php

namespace Plugin\Admin;

class Script
{
    /**
     * Return the list containing the 
     * defined scripts of the plugin.
     * 
     * @return array<int, string>
     */
    public static function scripts()
    {
        return [
            'callFrontendBuildWebhook',
        ];
    }

    /**
     * Register the corresponding scripts
     * of the plugin.
     * 
     * @return void
     */
    public static function register()
    {
        foreach (static::scripts() as $script) {
            require_once 'views/scripts/'._wp_to_kebab_case($script).'.php';
        }
    }
}