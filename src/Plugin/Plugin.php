<?php

namespace JamstackPress;

use JamstackPress\Http\Api;
use JamstackPress\Database\Capsule;

class Plugin 
{
    /**
     * The plugin version.
     * 
     * @var string
     */
    public static $version = '0.0.1';

    /**
     * Boot the plugin.
     * 
     * @return void
     */
    public function boot()
    {
        // Register the database provider.
        Capsule::boot();

        // Register the API endpoints.
        Api::boot();
    }
}