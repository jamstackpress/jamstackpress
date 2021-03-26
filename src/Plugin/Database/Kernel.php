<?php

namespace JamstackPress\Database;

use Illuminate\Database\Capsule\Manager;

class Kernel
{
    /**
     * The manager instance.
     * 
     * @var \Illuminate\Database\Capsule\Manager
     */
    protected static $manager = null;

    /**
     * Boot the database Capsule.
     * 
     * @return void
     */
    public static function boot()
    {
        // If the instance is already created, do nothing.
        if (static::$manager) {
            return;
        }

        global $wpdb;

        // Create the manager.
        static::$manager = new Manager;

        // Add the connection.
        static::$manager->addConnection([
            'driver' => 'mysql',
            'host' => $wpdb->dbhost,
            'database' => $wpdb->dbname,
            'prefix' => $wpdb->prefix,
            'username' => $wpdb->dbuser,
            'password' => $wpdb->dbpassword
        ]);

        // Boot the Eloquent ORM.
        static::$manager->bootEloquent();
    }

    /**
     * Get the Capsule instance.
     * 
     * @return \Illuminate\Database\Capsule\Manager
     */
    public static function manager()
    {
        return static::$manager;
    }
}