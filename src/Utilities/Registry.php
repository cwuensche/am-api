<?php
/**
 * Registry creates a Registry object
 *
 * The Registry class creates a "factory" of objects that will be used when we loop through the array to figure out which hooks to add.
 *
 * @link http://carlwuensche.com
 *
 * @package CarlWuensche\AMAPI
 * @since 1.0
 */

namespace CarlWuensche\AMAPI\Utilities;

use CarlWuensche\AMAPI\Subscriber\AbstractSubscriber;

/**
 * Class Registry
 *
 * @package CarlWuensche\AMAPI\Utilities
 */
class Registry {

	/**
	 * This is an array used to store all the objects for the registry.
	 *
	 * @var array
	 */
	private $registry;

	/**
	 * Registry constructor.
	 */
	public function __construct() {
		$this->registry = array();
	}

	/**
	 * The add function adds the object to the given key in registry.
	 *
	 * @param string $id The $id key is what we will use to associate the $obj with.
	 * @param object $obj This is an object we add with the given $id key.
	 * @throws \Exception Throws an exception if the key already exists in the registry array.
	 */
	public function add( $id, $obj ) {
		if ( isset( $this->registry[ $id ] ) ) {
			throw new \Exception( __( 'An object already exists for this given key.', 'am-api' ) );
		}

		$this->registry[ $id ] = $obj;
	}

	/**
	 * The get function will get the row from the array using the $id key.
	 *
	 * @param string $id The id key we will use to check to see if it exists in the array.
	 * @return mixed|null
	 * @throws \Exception Exception thrown if no object exists for the key.
	 */
	public function get( $id ) {
		if ( ! isset( $this->registry[ $id ] ) ) {
			throw new \Exception( __( 'No object exists for the specified key.', 'am-api' ) );
		}
		return $this->registry[ $id ] ?? null;
	}

	/**
	 * We will use the returned data to fetch the classes that will be used to add hooks for.
	 *
	 * @return array $subscribers Returns array of the subscribers.
	 */
	public function get_registered_subscribers() {
		$subscribers = array();

		foreach ( $this->registry as $object ) {
			if ( $object instanceof AbstractSubscriber ) {
				$subscribers[] = $object;
			}
		}

		return array_filter( $subscribers );
	}

}
