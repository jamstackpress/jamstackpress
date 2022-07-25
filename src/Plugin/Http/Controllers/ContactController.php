<?php

namespace Plugin\Http\Controllers;

use Plugin\Models\Contact;
use WP_REST_Response;

class ContactController extends Controller
{

    /**
     * Endpoint route.
     *
     * @var string
     */
    public static $route = 'contact';

    /**
     * Contact form endpoint.
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public static function store($request)
    {
        // TODO: Refactor.
        $params = $request->get_json_params();
        $failMessage = get_option('jamstackpress_contact_fail_message');
        $successMessage = get_option('jamstackpress_contact_success_message');

        // Verify the recaptcha token.
        $response = json_decode(
            wp_remote_retrieve_body(
                wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
                    'headers' => ['Content-Type', 'application/json'],
                    'body' => [
                        'secret' => get_option('jamstackpress_recaptcha_secret_key'),
                        'response' => $params['recaptcha_token'],
                    ],
                ])
            ),
            true
        );

        // If there is an error, return the message.
        if (! $response['success']) {
            return new WP_REST_Response(['success' => false, 'message' => $failMessage]);
        }

        // Create the contact post.
        $contactId = wp_insert_post([
            'post_title' => $params['subject'],
            'post_type' => Contact::$type,
            'post_content' => sprintf(
                '<b>Name: </b>%s<br /><b>Email: </b>%s<br /><b>Subject: </b>%s<br /><b>Menssage:</b><br/>%s',
                sanitize_text_field($params['name']),
                sanitize_text_field($params['email']),
                sanitize_text_field($params['subject']),
                sanitize_text_field($params['message'])
            ),
            'post_status' => 'publish',
        ]);

        // Error creating the contact post.
        if (empty($contactId)) {
            return new WP_REST_Response(['success' => false, 'message' => $failMessage]);
        }

        // Send an email to the configured email addresses.
        $success = wp_mail(
            get_option('jamstackpress_contact_email'),
            sanitize_text_field($params['subject']),
            sprintf(
                '<b>Name: </b>%s<br /><b>Email: </b>%s<br /><b>Subject: </b>%s<br /><b>Menssage:</b><br/>%s',
                sanitize_text_field($params['name']),
                sanitize_text_field($params['email']),
                sanitize_text_field($params['subject']),
                sanitize_text_field($params['message'])
            ),
            ['Content-Type: text/html; charset=UTF-8']
        );

        return new WP_REST_Response([
            'success' => $success,
            'message' => $success ? $successMessage : $failMessage,
        ]);
    }
}
