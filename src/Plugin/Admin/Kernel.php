<?php

namespace JamstackPress\Admin;

use Illuminate\Support\Str;

class Kernel
{
    /**
     * The current saved settings.
     * 
     * @var array
     */
    protected static $currentSettings;

    /**
     * The available settings.
     * 
     * @var array
     */
    protected static $settings = [
        [
            'id' => 'jamstackpress_frontend_base_url',
            'title' => 'Frontend\'s base url',
            'callback' => 'renderFrontendBaseUrlOption',
            'page' => 'jamstackpress-admin',
            'section' => 'jamstackpress-options'
        ],
        [
            'id' => 'jamstackpress_human_readable_date',
            'title' => 'Human readable date',
            'callback' => 'renderHumanReadableDateOption',
            'page' => 'jamstackpress-admin',
            'section' => 'jamstackpress-options'
        ],
        [
            'id' => 'jamstackpress_full_slug_field',
            'title' => 'Full slug field',
            'callback' => 'renderFullSlugFieldOption',
            'page' => 'jamstackpress-admin',
            'section' => 'jamstackpress-options'
        ],
    ];

    /**
     * Boot the administration kernel.
     * 
     * @return void
     */
    public static function boot()
    {
        add_action('admin_menu', [static::class, 'addMenuPageToSidebar']);
		add_action('admin_init', [static::class, 'registerSettings']);
    }

    /**
     * Add the menu page to the admin panel's sidebar.
     * 
     * @return void
     */
    public static function addMenuPageToSidebar()
    {
        add_menu_page(
            'JamstackPress',
            'JamstackPress',
            'manage_options',
            'jamstackpress',
            [static::class, 'renderPage' ],
            'dashicons-rest-api',
        );
	}

    /**
     * Render the options page.
     * 
     * @return void
     */
    public static function renderPage()
    {
        // Render the page view.
        require_once 'views/page.php';
	}

    /**
     * Register the settings and sections corresponding to the
     * plugin's options.
     * 
     * @return void
     */
    public static function registerSettings()
    {
        // Register the general section.
		add_settings_section(
			'jamstackpress-options',
			'Settings',
			null,
			'jamstackpress-admin'
		);

        // Add the corresponding settings fields.
        foreach (static::$settings as $setting) {
            register_setting(
                'jamstackpress-options',
                $setting['id']
            );

            add_settings_field(
                $setting['id'],
                $setting['title'],
                [static::class, $setting['callback']],
                $setting['page'],
                $setting['section']
            );
        }
    }

    /**
     * Handle the statically called methods of the class, that are not
     * explicity defined.
     * 
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        if ($pieces = preg_split('/(?=[A-Z])/', lcfirst($method))) {
            /* Check if we're calling a render method and include the 
             * corresponding view. */
            if (Str::lower($pieces[0]) === 'render' && Str::lower(end($pieces)) === 'option') {
                // Remove the first and last elements of the pieces array.
                array_shift($pieces);
                array_pop($pieces);

                // Get the view name.
                $view = Str::kebab(implode($pieces));

                require_once 'views/options/' . $view . '.php';
            }
        }
    }
}