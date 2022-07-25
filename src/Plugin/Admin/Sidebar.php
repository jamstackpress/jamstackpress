<?php

namespace Plugin\Admin;

class Sidebar
{
    /**
     * Return the list containing the 
     * defined sidebar options for the administration
     * sidebar.
     * 
     * @return array<int, array<string, mixed>>
     */
    public static function sidebar()
    {
        return [
            [
                'id' => 'jamstackpress',
                'title' => 'JAMStackPress',
                'href' => 'admin.php?page=jamstackpress',
                'meta' => ['title' => 'JAMStackPress'],
                'enabled' => true,
            ],
            [
                'id' => 'jamstackpress_sidebar_trigger_frontend_build',
                'parent' => 'jamstackpress',
                'title' => __('Trigger frontend build'),
                'href' => '#',
                'meta' => ['title' => __('Trigger frontend build')],
                'enabled' => !! get_option(config('options.frontend_build_webhook.id'), null),
            ],
        ];
    }

    /**
     * Register the corresponding sidebar options
     * of the plugin.
     * 
     * @param  object  $bar
     * @return void
     */
    public static function register($bar)
    {
        // Check if we're in an administration page.
        if (! is_admin()) {
            return;
        }

        // Register the options.
        foreach (static::sidebar() as $option) {
            // Check if the dependant option is enabled.
            if (! $option['enabled']) {
                continue;
            }

            // Add the page.
            $bar->add_menu($option);
        }
    }
}