<?php

namespace JamstackPress;

/**
 * @since 0.0.1
 */
class Plugin 
{

    /**
     * Boot the plugin.
     * 
     * @return void
     */
    public function boot()
    {
        // Setup the ORM.
        Core\Database::boot();

        // Add the plugin actions.
        $this->add_actions();
    }

    /**
     * Register the plugin actions.
     * 
     * @return void
     */
    public function add_actions()
    {
        // Register the API endpoints.
        add_action('rest_api_init', [Http\Api::class, 'register_endpoints']);
    }
}