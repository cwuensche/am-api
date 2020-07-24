<?php
/**
 * Contains the start function
 *
 * This file is what actually registers all the hooks with WordPress so every hook we added gets called properly by WordPress.
 *
 * @link http://carlwuensche.com
 *
 * @package CarlWuensche\AMAPI
 * @since 1.0
 */

namespace CarlWuensche\AMAPI;

use CarlWuensche\AMAPI\Utilities\Registry;

/**
 * Class Plugin
 *
 * @package CarlWuensche\AMAPI
 */
class Plugin {

	/**
	 * Contains the registry array object.
	 *
	 * @var Registry
	 */
	private $registry;

	/**
	 * Plugin constructor.
	 *
	 * @param Registry $registry Returns the registry object set in the main plugin file.
	 */
	public function __construct( Registry $registry ) {
		$this->registry = $registry;
	}

	/**
	 * Loops through all the items stored in the registry and adds the name of the hook passed to each of them.
	 */
	public function start() {
		array_map(
			function ( $subscriber ) {
				add_action( $subscriber->get_hook(), array( $subscriber, 'load' ) );
			},
			$this->registry->get_registered_subscribers()
		);
	}
}
