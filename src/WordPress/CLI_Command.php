<?php
/**
 * CLI_Command is used to create a custom command
 *
 * The CLI_Command command adds a transient we will use to check to see if we should override a 1 hour limit set by the API.
 *
 * @link http://carlwuensche.com
 *
 * @package CarlWuensche\AMAPI
 * @since 1.0
 */

namespace CarlWuensche\AMAPI\WordPress;

/**
 * Class CLI_Command
 *
 * @package CarlWuensche\AMAPI\WordPress
 */
class CLI_Command {

	/**
	 * Adds a transient that allows the refresh of the API data next time it's called.
	 * It's set to expire after an hour because the default time limit for the API would be hit already.
	 */
	public static function am_test_refresh_api() {
		set_transient( 'am_override_api', true, 3600 );

		\WP_CLI::success( __( 'The API data will be refreshed the next time you hit the API.', 'am-api' ) );
	}

}
