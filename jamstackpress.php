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
 * Version:           0.1.3
 * Author:            JAMStackPress
 * Author URI:        
 * License:           GPL version 3 or any later version
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: jamstackpress
 */


if (! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Autoloading of dependencies through Composer.
 * 
 * @see https://getcomposer.org/doc/01-basic-usage.md#autoloading
 */
require_once __DIR__ . '/vendor/autoload.php';

Plugin\Kernel::boot();