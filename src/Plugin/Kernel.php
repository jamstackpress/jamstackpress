<?php

namespace Plugin;

use Plugin\Admin\Kernel as AdminKernel;
use Plugin\Http\Kernel as HttpKernel;
use Plugin\Models\Post;
use Plugin\Models\Contact;

class Kernel
{
    /**
     * The bootable services.
     *
     * @var array<int, string>
     */
    public static $services = [
        HttpKernel::class,
        AdminKernel::class,
    ];

    /**
     * The bootable models.
     *
     * @var array<int, string>
     */
    public static $models = [
        Post::class,
        Contact::class,
    ];

    /**
     * Initialize the plugin.
     *
     * @return void
     */
    public static function boot()
    {
        // Register the services.
        foreach (static::$services as $service) {
            $service::boot();
        }

        // Register the models.
        foreach (static::$models as $model) {
            $model::boot();
        }
    }
}
