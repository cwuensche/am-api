<?php
/**
 * LanguageSubscriber implements AbstractSubscriber
 *
 * LanguageSubscriber implements AbstractSubscriber and adds translatable language domain so we can translate everything.
 *
 * @link http://carlwuensche.com
 *
 * @package CarlWuensche\AMAPI
 * @since 1.0
 */

namespace CarlWuensche\AMAPI\Subscriber;

/**
 * The LanguageSubscriber class is used to add a text domain.
 *
 * Class LanguageSubscriber
 *
 * @package CarlWuensche\AMAPI\Subscriber
 */
class LanguageSubscriber extends AbstractSubscriber {

	/**
	 * LanguageSubscriber constructor.
	 *
	 * @param string $hook The hook will be used when the Plugin class loads each of the Subscriber classes.
	 */
	public function __construct( string $hook ) {
		parent::__construct( $hook );
	}


	/**
	 * Implemented from AbstractSubscriber.
	 */
	public function load() {
		load_plugin_textdomain(
			'am-api',
			false,
			dirname( plugin_basename( __FILE__ ) . '/assets/languages' )
		);
	}
}
