<?php

namespace JamstackPress\Admin;

use Illuminate\Support\Str;

class Kernel
{
    /**
     * The available pages.
     * 
     * @var array
     */
    protected static $pages = [
        [
            'id' => 'jamstackpress',
            'title' => 'JAMStackPress',
            'menuTitle' => 'JAMStackPress',
            'capabilities' => 'manage_options',
            'callback' => 'renderPage',
            'icon' => 'dashicons-rest-api'
        ]
    ];

    /**
     * The available sections.
     * 
     * @var array
     */
    protected static $sections = [
        [
            'id' => 'jamstackpress-options',
            'title' => 'Settings',
            'callback' => null,
            'page' => 'jamstackpress-admin'
        ]
    ];

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
            'id' => 'jamstackpress_build_webhook_url',
            'title' => 'Build webhook url',
            'callback' => 'renderBuildWebhookUrlOption',
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
     * The available options in the admin bar.
     * 
     * @var array
     */
    protected static $adminBar = [
        [
            'id' => 'jamstackpress',
            'title' => 'JAMStackPress',
            'href' => 'admin.php?page=jamstackpress',
            'meta' => ['title' => 'JAMStackPress'],
        ],
        [
            'id' => 'jamstackpress_build_frontend',
            'parent' => 'jamstackpress',
            'title' => 'Trigger frontend build',
            'href' => '#',
            'meta' => ['title' => 'Trigger frontend build'],
            'dependsOnOption' => 'jamstackpress_build_webhook_url'
        ]
    ];

    /**
     * The scripts appended to the footer.
     * 
     * @var array
     */
    protected static $scripts = ['triggerFrontendBuild'];

    /**
     * Boot the administration kernel.
     * 
     * @return void
     */
    public static function boot()
    {
        add_action('admin_init', [static::class, 'registerSettings']);
        add_action('admin_menu', [static::class, 'addMenuPageToSidebar']);
        add_action('admin_bar_menu', [static::class, 'addMenuToAdminBar'], 99);
        add_action('admin_footer', [static::class, 'addScriptsToFooter'], 99);
        add_action('wp_footer', [static::class, 'addScriptsToFooter'], 99);
    }

    /**
     * Add the menu page to the admin panel's sidebar.
     * 
     * @return void
     */
    public static function addMenuPageToSidebar()
    {
        // Add all the corresponding pages.
        foreach (static::$pages as $page) {
            add_menu_page(
                $page['title'],
                $page['menuTitle'],
                $page['capabilities'],
                $page['id'], 
                [static::class, $page['callback']],
                $page['icon']
            );
        }
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
        // Register the corresponding sections.
        foreach (static::$sections as $section) {
            add_settings_section(
                $section['id'],
                __($section['title'], 'jamstackpress'),
                $section['callback'],
                $section['page']
            );
        }

        // Add the corresponding settings fields.
        foreach (static::$settings as $setting) {
            register_setting(
                $setting['section'],
                $setting['id']
            );

            add_settings_field(
                $setting['id'],
                __($setting['title'], 'jamstackpress'),
                [static::class, $setting['callback']],
                $setting['page'],
                $setting['section']
            );
        }
    }

    /**
     * Adds a new menu to the admin bar menu.
     * 
     * @param mixed $adminBar
     * @return void
     */
    public static function addMenuToAdminBar($adminBar)
    {
        foreach (static::$adminBar as $menu) {
            if (!is_admin() || array_key_exists('dependsOnOption', $menu) &&
            !get_option($menu['dependsOnOption'], null)) {
                continue;
            }

            $adminBar->add_menu($menu);
        }
    }

    /**
     * Add custom scripts to the WordPress footer.
     * 
     * @return void
     */
    public static function addScriptsToFooter()
    {
        foreach (static::$scripts as $script) {
            $view = Str::kebab($script);

            require_once 'views/scripts/' . $view . '.php';
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