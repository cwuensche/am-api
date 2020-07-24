<?php
/**
 * AdminMenuSubscriber implements AbstractSubscriber
 *
 * AdminMenuSubscriber implements AbstractSubscriber and adds a menu to the admin menu page.
 *
 * @link http://carlwuensche.com
 *
 * @package CarlWuensche\AMAPI
 * @since 1.0
 */

namespace CarlWuensche\AMAPI\Subscriber;

use CarlWuensche\AMAPI\Admin\APIPage;

/**
 * The AdminMenuSubscriber class is used to create admin menu pages.
 *
 * Class AdminMenuSubscriber
 *
 * @package CarlWuensche\AMAPI\Subscriber
 */
class AdminMenuSubscriber extends AbstractSubscriber {

	/**
	 * AdminMenuSubscriber constructor.
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
		add_menu_page(
			__( 'Awesome Motive API Test', 'am-api' ),
			__( 'Awesome Motive API Test', 'am-api' ),
			'manage_options',
			'am-api-page',
			array( new APIPage(), 'display' )
		);
	}
}
