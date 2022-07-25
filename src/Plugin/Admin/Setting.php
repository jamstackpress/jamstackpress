<?php

namespace Plugin\Admin;

class Setting
{
    /**
     * Return the list containing the 
     * defined sections of the administration panel.
     * 
     * @return array<int, array<string, mixed>>
     */
    public static function sections()
    {
        return [
            [
                'id' => 'jamstackpress-options',
                'title' => __('Settings'),
                'callback' => null,
                'page' => 'jamstackpress-admin',
            ]
        ];
    }

    /**
     * Register the corresponding sections
     * and settings of the plugin.
     * 
     * @return void
     */
    public static function register()
    {
        // Register the defined sections.
        foreach (static::sections() as $section) {
            add_settings_section(...array_values($section));
        }

        // Register the plugin options.
        foreach (config('options') as $key => $option) {
            // Register the option
            register_setting('jamstackpress-options', $option['id']);

            // Create the array for registration.
            $field = [
                'id' => $option['id'],
                'title' => $option['title'],
                'callback' => [
                    static::class, 'render'.str_replace('_', '', ucwords($key, '_')).'Option'
                ],
                'page' => 'jamstackpress-admin',
                'section' => 'jamstackpress-options',
            ];

            // Register the option field.
            add_settings_field(...array_values($field));
        }
    }

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
        // Split the method into pieces.
        if ($pieces = preg_split('/(?=[A-Z])/', lcfirst($method))) {
            // Check if we're calling a renderer.
            if (
                strtolower($pieces[0]) == 'render' 
                && strtolower(end($pieces)) == 'option'
            ) {
                // Remove the first and last elements
                // of the method name.
                array_shift($pieces);
                array_pop($pieces);

                // Get the corresponding option definition.
                $option = config('options.'.strtolower(implode('_', $pieces)));

                // Require the corresponding view.
                require_once 
                    'views/options/'
                    . _wp_to_kebab_case(implode($pieces)) 
                    . '.php';
            }
        }
    }
}