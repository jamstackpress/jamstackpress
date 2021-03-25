<?php

namespace JamstackPress\Database;

use Illuminate\Database\Capsule\Manager;

class Capsule
{
    /**
     * Create the manager instance.
     * 
     * @return void
     */
    public static function boot()
    {
        /* We're going to use the WordPress WPDB class
         * to get the default settings of our connection. */
        global $wpdb;

        // Boot the capsule.
        $capsule = new Manager;

        // Add the connection.
        $capsule->addConnection([
            'driver' => 'mysql',
            'prefix' => $wpdb->prefix,
            'host' => $wpdb->dbhost,
            'database' => $wpdb->dbname,
            'username' => $wpdb->dbuser,
            'password' => $wpdb->dbpassword
        ]);

        // Make the instance available through static methods.
        $capsule->setAsGlobal();

        // Boot Eloquent.
        $capsule->bootEloquent();
    }
}