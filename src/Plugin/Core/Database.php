<?php

namespace JamstackPress\Core;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * @since 0.0.1
 */
class Database 
{

    /**
     * The database instance.
     * 
     * @var \Illuminate\Database\Capsule\Manager
     */
    private static $instance = null;

    /**
     * Create the database instance.
     * 
     * @return void
     */
    private function __construct()
    {
        global $wpdb;

        // Create the Capsule.
        self::$instance = new Capsule();

        // Set up the connection.
        self::$instance->addConnection([
            'driver' => 'mysql',
            'prefix' => $wpdb->prefix,
            'host' => $wpdb->dbhost,
            'database' => $wpdb->dbname,
            'username' => $wpdb->dbuser,
            'password' => $wpdb->dbpassword
        ]);

        // Boot Eloquent ORM.
        self::$instance->bootEloquent();
    }

    /**
     * Boot the Capsule.
     * 
     * @return void
     */
    public static function boot()
    {
        new self();
    }

    /**
     * Return the Capsule instance.
     * 
     * @return \Illuminate\Database\Capsule\Manager
     */
    public static function instance()
    {
        return self::$instance;
    }
}