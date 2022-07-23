<?php

namespace Plugin\Http\Controllers;

use WP_REST_Response;
use Plugin\Models\Contact;
class ContactController
{
    /**
     * Contact form endpoint.
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public static function index($request)
    {
        $params = $request->get_json_params();
        $failMessage = get_option('wpdecoupled_contact_fail');
        $successMessage = get_option('wpdecoupled_contact_success');

        // Verify the recaptcha token.
        $response = json_decode(
            wp_remote_retrieve_body(
                wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
                    'headers' => ['Content-Type', 'application/json'],
                    'body' => [
                        'secret' => get_option('wpdecoupled_recaptcha_secret_key'),
                        'response' => $params['recaptcha_token'],
                    ],
                ])
            ),
            true
        );

        // Si hay error devolvemos el mensaje.
        if (!$response['success']) {
            return new WP_REST_Response(['success' => false, 'message' => $failMessage]);
        }

        // Create the contact post.
        $contactId = wp_insert_post([
            'post_title' => $params['subject'],
            'post_type' => Contact::$type,
            'post_content' => sprintf(
                '<b>Name: </b>%s<br /><b>Email: </b>%s<br /><b>Subject: </b>%s<br /><b>Mensaage:</b><br/>%s',
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
            get_option('wpdecoupled_contact_emails'),
            sanitize_text_field($params['subject']),
            sprintf(
                '<b>Name: </b>%s<br /><b>Email: </b>%s<br /><b>Subject: </b>%s<br /><b>Mensaage:</b><br/>%s',
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
