<?php

/**
 * JAMStackPress.
 * 
 * Power-up your WordPress site and get it ready for JAMStack.
 * 
 * @wordpress-plugin
 * Plugin Name:       JAMStackPress
 * Plugin URI:        https://github.com/jamstackpress/jamstackpress
 * GitHub Plugin URI: https://github.com/jamstackpress/jamstackpress
 * Description:       Power-up your WordPress site and get it ready for JAMStack.
 * Version:           0.0.1
 * Author:            JAMStackPress
 * Author URI:        
 * License:           GPL version 3 or any later version
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       jamstack-press
 */


 /**
 * Freemius Integration.
 * 
 * @see https://dashboard.freemius.com/#!/live/plugins/8016/integration/
 */


if ( ! function_exists( 'jam_fs' ) ) {
    // Create a helper function for easy SDK access.
    function jam_fs() {
        global $jam_fs;

        if ( ! isset( $jam_fs ) ) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';

            $jam_fs = fs_dynamic_init( array(
                'id'                  => '8016',
                'slug'                => 'jamstackpress',
                'type'                => 'plugin',
                'public_key'          => 'pk_444c369102867988cad4363ec8c6d',
                'is_premium'          => true,
                'premium_suffix'      => 'Premium',
                // If your plugin is a serviceware, set this option to false.
                'has_premium_version' => true,
                'has_addons'          => false,
                'has_paid_plans'      => true,
                'menu'                => array(
                    'slug'           => 'jamstackpress',
                    'support'        => false,
                ),
                // Set the SDK to work in a sandbox mode (for development & testing).
                // IMPORTANT: MAKE SURE TO REMOVE SECRET KEY BEFORE DEPLOYMENT.
                'secret_key'          => 'sk_z?S8-S^O[ksO3*#V$b(9EZ(43>9Nf',
            ) );
        }

        return $jam_fs;
    }

    // Init Freemius.
    jam_fs();
    // Signal that SDK was initiated.
    do_action( 'jam_fs_loaded' );
}


if (! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Autoloading of dependencies through Composer.
 * 
 * @see https://getcomposer.org/doc/01-basic-usage.md#autoloading
 */
require_once __DIR__ . '/vendor/autoload.php';

(new JamstackPress\Plugin)->boot();