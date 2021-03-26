<?php

namespace JamstackPress;

class Kernel
{
    /**
     * The plugin version.
     * 
     * @var string
     */
    public static $version = '0.0.1';

    /**
     * The bootable plugin handlers.
     * 
     * @var array
     */
    protected static $bootable = [
        \JamstackPress\Http\Kernel::class,
        \JamstackPress\Database\Kernel::class
    ];

    /**
     * Boot the plugin kernel.
     * 
     * @return void
     */
    public static function boot()
    {
        foreach (static::$bootable as $class) {
            $class::boot();
        }
    }
}