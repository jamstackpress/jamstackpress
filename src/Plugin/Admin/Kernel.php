<?php

namespace Plugin\Admin;

class Kernel
{
    /**
     * Boot the administration options.
     * 
     * @return void
     */
    public static function boot()
    {
        // Register the options.
        add_action('admin_init', [Setting::class, 'register']);

        // Register the administration pages.
        add_action('admin_menu', [Page::class, 'register']);

        // Register the sidebar options.
        add_action('admin_bar_menu', [Sidebar::class, 'register'], 99);

        // Register the footer scripts.
        add_action('admin_footer', [Script::class, 'register'], 99);
        add_action('wp_footer', [Script::class, 'register'], 99);
    }
}