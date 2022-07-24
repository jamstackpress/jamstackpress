<?php

namespace Plugin\Admin;

class Kernel
{
    /**
     * The available pages.
     *
     * @var array<int, array<string, string>>
     */
    protected static $pages = [
        [
            'id' => 'jamstackpress',
            'title' => 'JAMStackPress',
            'menuTitle' => 'JAMStackPress',
            'capabilities' => 'manage_options',
            'callback' => 'renderPage',
            'icon' => 'dashicons-rest-api',
        ],
    ];

    /**
     * The available sections.
     *
     * @var array<int, array<string, string>
     */
    protected static $sections = [
        [
            'id' => 'jamstackpress-options',
            'title' => 'Settings',
            'callback' => null,
            'page' => 'jamstackpress-admin',
        ],
    ];

    /**
     * The available settings.
     *
     * @var array<int, array<string, string>
     */
    protected static $settings = [
        [
            'id' => 'jamstackpress_frontend_base_url',
            'title' => 'Frontend\'s base url',
            'callback' => 'renderFrontendBaseUrlOption',
            'page' => 'jamstackpress-admin',
            'section' => 'jamstackpress-options',
        ],
        [
            'id' => 'jamstackpress_build_webhook_url',
            'title' => 'Build webhook url',
            'callback' => 'renderBuildWebhookUrlOption',
            'page' => 'jamstackpress-admin',
            'section' => 'jamstackpress-options',
        ],
        [
            'id' => 'jamstackpress_human_readable_date',
            'title' => 'Human readable date',
            'callback' => 'renderHumanReadableDateOption',
            'page' => 'jamstackpress-admin',
            'section' => 'jamstackpress-options',
        ],
        [
            'id' => 'jamstackpress_full_slug_field',
            'title' => 'Routes - (full slug and front URL)',
            'callback' => 'renderFullSlugFieldOption',
            'page' => 'jamstackpress-admin',
            'section' => 'jamstackpress-options',
        ],
        [
            'id' => 'jamstackpress_seo_field',
            'title' => 'SEO',
            'callback' => 'renderSeoFieldOption',
            'page' => 'jamstackpress-admin',
            'section' => 'jamstackpress-options',
        ],
        [
            'id' => 'jamstackpress_featured_image_field',
            'title' => 'Fetaured images',
            'callback' => 'renderFeaturedImageFieldOption',
            'page' => 'jamstackpress-admin',
            'section' => 'jamstackpress-options',
        ],
        [
            'id' => 'jamstackpress_sitemap_endpoint',
            'title' => 'Sitemap endpoint',
            'callback' => 'renderSitemapEndpointOption',
            'page' => 'jamstackpress-admin',
            'section' => 'jamstackpress-options',
        ],
        [
            'id' => 'jamstackpress_jp_contact_enabled',
            'title' => 'Contact form endpoint',
            'callback' => 'renderContactEndpointOption',
            'page' => 'jamstackpress-admin',
            'section' => 'jamstackpress-options',
        ],
        [
            'id' => 'jamstackpress_contact_email',
            'title' => 'Contact Email',
            'callback' => 'renderContactEmailOption',
            'page' => 'jamstackpress-admin',
            'section' => 'jamstackpress-options',
        ],
        [
            'id' => 'jamstackpress_contact_fail_message',
            'title' => 'Contact Fail Message',
            'callback' => 'renderContactFailMessageOption',
            'page' => 'jamstackpress-admin',
            'section' => 'jamstackpress-options',
        ],
        [
            'id' => 'jamstackpress_contact_success_message',
            'title' => 'Contact Success Message',
            'callback' => 'renderContactSuccessMessageOption',
            'page' => 'jamstackpress-admin',
            'section' => 'jamstackpress-options',
        ],
        [
            'id' => 'jamstackpress_recaptcha_secret_key',
            'title' => 'reCaptcha Secret Key',
            'callback' => 'renderRecaptchaSecretKeyOption',
            'page' => 'jamstackpress-admin',
            'section' => 'jamstackpress-options',
        ],

    ];

    /**
     * The available options in the admin bar.
     *
     * @var array<int, array<string, string>
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
            'dependsOnOption' => 'jamstackpress_build_webhook_url',
        ],
    ];

    /**
     * The scripts appended to the footer.
     *
     * @var array<int, string>
     */
    protected static $scripts = [
        'triggerFrontendBuild',
    ];

    /**
     * Handle the statically called methods of the class, that are not
     * explicity defined.
     *
     * @param  string $method
     * @param  array<string, mixed>  $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        if ($pieces = preg_split('/(?=[A-Z])/', lcfirst($method))) {
            /* Check if we're calling a render method and include the
             * corresponding view. */
            if ('render' === strtolower($pieces[0]) && 'option' === strtolower(end($pieces))) {
                // Remove the first and last elements of the pieces array.
                array_shift($pieces);
                array_pop($pieces);

                // Get the view name.
                $view = _wp_to_kebab_case(implode($pieces));

                require_once 'views/options/'.$view.'.php';
            }
        }
    }

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
     *
     * @return void
     */
    public static function addMenuToAdminBar($adminBar)
    {
        foreach (static::$adminBar as $menu) {
            if (! is_admin() || array_key_exists('dependsOnOption', $menu)
            && ! get_option($menu['dependsOnOption'], null)) {
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
            $view = _wp_to_kebab_case($script);

            require_once 'views/scripts/'.$view.'.php';
        }
    }
}
