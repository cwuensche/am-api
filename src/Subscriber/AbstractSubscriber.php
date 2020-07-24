<?php
/**
 * The AbstractSubscriber class is a template
 *
 * This file becomes a template for every class extending the Subscriber class. The hook name gets passed to the constructor
 * and we have an abstract function every class extending this class must implement.
 *
 * @link http://carlwuensche.com
 *
 * @package CarlWuensche\AMAPI
 * @since 1.0
 */

namespace CarlWuensche\AMAPI\Subscriber;

use CarlWuensche\AMAPI\Utilities\Registry;

/**
 * Class AbstractSubscriber
 *
 * @package CarlWuensche\AMAPI\Subscriber
 */
abstract class AbstractSubscriber {

	/**
	 * Used to store the name of the hook to use.
	 *
	 * @var string $hook
	 */
	protected $hook;

	/**
	 * Registry object.
	 *
	 * @var $registry
	 */
	protected $registry;

	/**
	 * AbstractSubscriber constructor.
	 *
	 * @param string $hook The hook string specifies the name of the hook we will use when the Plugin()->start() function is called.
	 */
	public function __construct( string $hook ) {
		$this->hook     = $hook;
		$this->registry = apply_filters( 'amapi_registry', null );
	}

	/**
	 * Returns the name of the hook passed to the AbstractSubscriber constructor. The string returned will be used to
	 * pass to the add_action() function.
	 *
	 * @return string
	 */
	public function get_hook() : string {
		return $this->hook;
	}

	/**
	 * The load function here is a template that every class extending AbstractSubscriber must implement.
	 *
	 * @return mixed
	 */
	abstract public function load();

}
