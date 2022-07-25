<?php

namespace Plugin\Admin;

class Kernel
{
    /**
<<<<<<< HEAD
     * Boot the administration options.
     * 
=======
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
            'id' => 'jamstackpress_sitemap_enabled',
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
>>>>>>> 4190e8aad0a05bc5b2564f83b29757d377e88f29
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