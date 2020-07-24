<?php
/**
 * Main file that initializes everything
 *
 * This file initializes everything. We define some constants and register all the hooks that will get fired.
 *
 * @link http://carlwuensche.com
 *
 * @package CarlWuensche\AMAPI
 * @since 1.0
 */

/**
 *
 *
 * Plugin Name: Awesome Motive API
 * Version: 1.0
 * Plugin URI: http://carlwuensche.com
 * Description: Fetches API data from an endpoint using modern programming methodology.
 * Author: Carl Wuensche
 * Author URI: http://carlwuensche.com
 * Text Domain: am-api
 * License:     GPL-3.0+
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @copyright   2020 Carl Wuensche
 */

namespace CarlWuensche\AMAPI;

use CarlWuensche\AMAPI\Subscriber\AdminMenuSubscriber;
use CarlWuensche\AMAPI\Subscriber\AmAPIEndpointSubscriber;
use CarlWuensche\AMAPI\Utilities\Registry;
use CarlWuensche\AMAPI\Subscriber\ShortcodeSubscriber;
use CarlWuensche\AMAPI\Subscriber\AdminScriptsSubscriber;
use CarlWuensche\AMAPI\Subscriber\LanguageSubscriber;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

define( 'AM_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'AM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once __DIR__ . '/vendor/autoload.php';

$registry = new Registry();

add_filter(
	'amapi_registry',
	function() use ( $registry ) {
		return $registry;
	}
);

$registry->add(
	'amAPIEndpointAdminSubscriber',
	new AmAPIEndpointSubscriber( 'wp_ajax_am_api_endpoint' )
);

$registry->add(
	'amAPIEndpointFrontendSubscriber',
	new AmAPIEndpointSubscriber( 'wp_ajax_nopriv_am_api_endpoint' )
);

$registry->add(
	'amAPIAdminMenu',
	new AdminMenuSubscriber( 'admin_menu' )
);

$registry->add(
	'shortcodeSubscriber',
	new ShortcodeSubscriber( 'init' )
);

$registry->add(
	'languageTranslator',
	new LanguageSubscriber( 'init' )
);

$registry->add(
	'adminScripts',
	new AdminScriptsSubscriber( 'admin_enqueue_scripts' )
);

if ( class_exists( '\WP_CLI' ) ) {
	\WP_CLI::add_command( 'am_test_refresh_api', array( 'CarlWuensche\AMAPI\WordPress\CLI_Command', 'am_test_refresh_api' ) );
}

/**
 * Start the "plugin" by looping through every item related to the subscribers and pass the hook name to add_action.
 */
( new Plugin( $registry ) )->start();
