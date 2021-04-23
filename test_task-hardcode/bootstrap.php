<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://silent-overcoder.uxp.ru
 * @since             1.0.0
 * @package           Test_task_Hardcode
 *
 * @wordpress-plugin
 * Plugin Name:       test_task
 * Plugin URI:        http://silent-overcoder.uxp.ru
 * Description:       Register new post_type k0d and added new shortcode
 * Version:           1.0.0
 * Author:            Kyleshov Yuri
 * Author URI:        http://silent-overcoder.uxp.ru
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       test_task-hardcode
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_VERSION', '1.0.0' );
defined('SHORTCODE_URL') || define('SHORTCODE_URL', plugins_url('', __FILE__));

spl_autoload_register(function ($class) {

    $baseDir = __DIR__ . '/src/';

    $file = $baseDir . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

register_activation_hook(__FILE__, ['Core', 'activate']);
register_deactivation_hook(__FILE__, ['Core', 'deactivate']);
add_action('plugins_loaded', ['Core', 'init']);
add_action('plugins_loaded', ['PublicCore', 'init']);
add_action('plugins_loaded', ['AdminCore', 'init']);

