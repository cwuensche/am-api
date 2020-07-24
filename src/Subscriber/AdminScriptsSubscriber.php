<?php
/**
 * AdminScriptsSubscriber implements AbstractSubscriber
 *
 * AdminScriptsSubscriber implements AbstractSubscriber and enqueues the css file on the admin page for this plugin.
 *
 * @link http://carlwuensche.com
 *
 * @package CarlWuensche\AMAPI
 * @since 1.0
 */

namespace CarlWuensche\AMAPI\Subscriber;

/**
 * Class AdminScriptsSubscriber
 *
 * @package CarlWuensche\AMAPI\Subscriber
 */
class AdminScriptsSubscriber extends AbstractSubscriber {

	/**
	 * AdminScriptsSubscriber constructor.
	 *
	 * @param string $hook The hook will be used when the Plugin class loads each of the Subscriber classes.
	 */
	public function __construct( string $hook ) {
		parent::__construct( $hook );
	}

	/**
	 * This function implements the AbstractSubscriber function and enqueues the css file in the 'am-api-page' page.
	 */
	public function load() {
		global $pagenow;
		$current_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );

		if ( 'am-api-page' === $current_page && 'admin.php' === $pagenow ) {
			wp_enqueue_style( 'amapi_style', AM_PLUGIN_URL . 'assets/css/style.min.css', array(), '1.0' );
		}

	}
}
