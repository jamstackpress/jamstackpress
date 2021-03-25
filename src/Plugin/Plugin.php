<?php

namespace JamstackPress;

use JamstackPress\Http\Api;

class Plugin
{
    /**
     * The plugin current version.
     * 
     * @var string
     */
    public static $version = '0.0.1';

    /**
     * Bootup the plugin instance.
     * 
     * @return void
     */
    public function boot()
    {
        $this->registerApiRoutes();
    }

    /**
     * Register the API routes that will be accessible.
     * 
     * @return void
     */
    private function registerApiRoutes()
    {
        Api::registerEndpoints();
    }
}