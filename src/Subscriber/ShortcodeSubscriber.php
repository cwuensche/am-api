<?php
/**
 * ShortcodeSubscriber implements AbstractSubscriber
 *
 * ShortcodeSubscriber implements AbstractSubscriber and handles the shortcode code for displaying the output on the frontend.
 *
 * @link http://carlwuensche.com
 *
 * @package CarlWuensche\AMAPI
 * @since 1.0
 */

namespace CarlWuensche\AMAPI\Subscriber;

use CarlWuensche\AMAPI\WordPress\AMShortcode;

/**
 * Class ShortcodeSubscriber
 *
 * @package CarlWuensche\AMAPI\Subscriber
 */
class ShortcodeSubscriber extends AbstractSubscriber {

	/**
	 * ShortcodeSubscriber constructor.
	 *
	 * @param string $hook The hook will be used when the Plugin class loads each of the Subscriber classes.
	 */
	public function __construct( string $hook ) {
		parent::__construct( $hook );
	}

	/**
	 * The load function below implements the load function from AbstractSubscriber.
	 *
	 * @return mixed|void Adds the shortcode for the frontend.
	 */
	public function load() {

		add_shortcode( 'am_display', array( new AMShortcode(), 'display' ) );

	}

}
