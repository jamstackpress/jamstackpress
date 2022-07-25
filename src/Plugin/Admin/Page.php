<?php

namespace Plugin\Admin;

class Page
{
    /**
     * Return the list containing the 
     * defined pages of the administration panel.
     * 
     * @return array<int, array<string, mixed>>
     */
    public static function pages()
    {
        return [
            [
                'title' => 'JAMStackPress',
                'menuTitle' => 'JAMStackPress',
                'capabilities' => 'manage_options',
                'id' => 'jamstackpress',
                'callback' => [static::class, 'renderPage'],
                'icon' => 'dashicons-rest-api',
            ],
        ];
    }

    /**
     * Register the corresponding pages
     * of the plugin.
     * 
     * @return void
     */
    public static function register()
    {
        foreach (static::pages() as $page) {
            add_menu_page(...array_values($page));
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
}