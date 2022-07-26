<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Frontend build webhook.
    |--------------------------------------------------------------------------
    |
    | The URL of the webhook that triggers a build in the frontend site.
    |
    */

    'frontend_build_webhook' => [
        'id' => 'jamstackpress_frontend_build_webhook',
        'title' => __('Frontend build webhook'),
        'description' => __(
            'The url of the webhook that triggers a frontend build.'
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Frontend url.
    |--------------------------------------------------------------------------
    |
    | The URL of the frontend site.
    |
    */

    'frontend_url' => [
        'id' => 'jamstackpress_frontend_url',
        'title' => __('Frontend url'),
        'description' => __(
            'The url of the frontend site (for e.g.: <i>https://yourwordpress.com/</i>).'
        ),
    ],


    /*
    |--------------------------------------------------------------------------
    | Replace Backend Url with front end URL
    |--------------------------------------------------------------------------
    |
    | Indicate if the replacefilter is enabled.
    |
    */

    'replace_filter_enabled' => [
        'id' => 'jamstackpress_replace_filter_enabled',
        'title' => __('Replace backend with front end URL'),
        'description' => __(
            'Replace your WordPress base URL with the front-end URL defined in the plugin settings.'
        ),
    ],


    /*
    |--------------------------------------------------------------------------
    | Add _blank target to every external link at the content.
    |--------------------------------------------------------------------------
    |
    | Indicate if the target _blank filter is enabled.
    |
    */

    'target_blank_filter_enabled' => [
        'id' => 'jamstackpress_target_blank_filter_enabled',
        'title' => __('Add _blank target to every external link at the content'),
        'description' => __(
            'Add _blank target to every external link at the content'
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Add image sizes.
    |--------------------------------------------------------------------------
    |
    | Indicate if the filter to add the corresponding sizes to the
    | images is enabled.
    |
    */

    'add_image_sizes_filter_enabled' => [
        'id' => 'jamstackpress_add_image_sizes_filter_enabled',
        'title' => __('Add sizes to images'),
        'description' => __(
            'Calculate and set the corresponding sizes to the images in
            the content of the posts.'
        ),
    ],


    /*
    |--------------------------------------------------------------------------
    | Readable date.
    |--------------------------------------------------------------------------
    |
    | Indicate if the routes field should be added to the API.
    |
    */

    'readable_date_field_enabled' => [
        'id' => 'readable_date_field_enabled',
        'title' => __('Enable human readable date field'),
        'description' => __(
            'Contains a human readable 
            format of the post\'s creation date.',
        ),
    ],


    /*
    |--------------------------------------------------------------------------
    | Routes.
    |--------------------------------------------------------------------------
    |
    | Indicate if the routes field should be added to the API.
    |
    */

    'routes_field_enabled' => [
        'id' => 'jamstackpress_routes_field_enabled',
        'title' => __('Enable routes field'),
        'description' => __(
            'Contains the post slug and the full frontend post\'s url.',
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO.
    |--------------------------------------------------------------------------
    |
    | Indicate if the seo field should be added to the API.
    |
    */

    'seo_field_enabled' => [
        'id' => 'jamstackpress_seo_field_enabled',
        'title' => __('Enable SEO field'),
        'description' => __(
            'Contains the corresponding SEO title and description, with 
            support for multiple SEO plugins.',
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Featured image.
    |--------------------------------------------------------------------------
    |
    | Indicate if the featured image field should be added to the API.
    |
    */

    'featured_image_field_enabled' => [
        'id' => 'jamstackpress_featured_image_field_enabled',
        'title' => __('Enable featured image field'),
        'description' => __(
            'Contains the featured image URL in multiple sizes.',
        ),
    ],


    /*
    |--------------------------------------------------------------------------
    | Contact route enabled.
    |--------------------------------------------------------------------------
    |
    | Indicate if the contact route is enabled.
    |
    */

    'contact_route_enabled' => [
        'id' => 'jamstackpress_contact_route_enabled',
        'title' => __('Enable contact route'),
        'description' => __(
            'Enable a contact route at <i>/jamstackpress/v1/contact</i> with reCaptcha verification 
            (this also enables a contact post type and fires an 
            email notificacion).'
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Contact notification email
    |--------------------------------------------------------------------------
    |
    | The receiver of the notification that is sent when a new contact is made.
    |
    */

    'contact_notification_email' => [
        'id' => 'jamstackpress_contact_notification_email',
        'title' => __('Contact email'),
        'description' => __(
            'The e-mail address that receives a notification when a contact is made.'
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | reCaptcha secret key.
    |--------------------------------------------------------------------------
    |
    | The secret key to validate a reCaptcha token.
    |
    */

    'recaptcha_secret_key' => [
        'id' => 'recaptcha_secret_key',
        'title' => __('reCaptcha secret key'),
        'description' => __('The secret key to validate a reCaptcha token.'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Successful contact message.
    |--------------------------------------------------------------------------
    |
    | The message to return when a contact was successfully made.
    |
    */

    'successful_contact_message' => [
        'id' => 'jamstackpress_successful_contact_message',
        'title' => __('Successful contact message'),
        'description' => __('The message to return when a contact was successfully made.'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Failed contact message.
    |--------------------------------------------------------------------------
    |
    | The message to return when a contact failed.
    |
    */

    'failed_contact_message' => [
        'id' => 'jamstackpress_failed_contact_message',
        'title' => __('Failed contact message'),
        'description' => __('The message to return when a contact failed.'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Sitemap route enabled.
    |--------------------------------------------------------------------------
    |
    | Indicate if the sitemap route is enabled.
    |
    */

    'sitemap_route_enabled' => [
        'id' => 'jamstackpress_sitemap_route_enabled',
        'title' => __('Enable sitemap route'),
        'description' => __(
            'Enable the sitemap route.'
        ),
    ],


];