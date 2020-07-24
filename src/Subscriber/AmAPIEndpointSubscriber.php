<?php
/**
 * AmAPIEndpointSubscriber implements AbstractSubscriber
 *
 * AmAPIEndpointSubscriber implements AbstractSubscriber and acts as the class that handles the ajax endpoint calls.
 *
 * @link http://carlwuensche.com
 *
 * @package CarlWuensche\AMAPI
 * @since 1.0
 */

namespace CarlWuensche\AMAPI\Subscriber;

/**
 * The AmAPIEndpointSubscriber class is used to return and save JSON data we fetched from the API endpoint.
 *
 * Class AmAPIEndpointSubscriber
 *
 * @package CarlWuensche\AMAPI\Subscriber
 */
class AmAPIEndpointSubscriber extends AbstractSubscriber {

	/**
	 * AmAPIEndpointSubscriber constructor.
	 *
	 * @param string $hook The hook will be used when the Plugin class loads each of the Subscriber classes.
	 */
	public function __construct( string $hook ) {
		parent::__construct( $hook );
	}

	/**
	 * The load function implements the function from AbstractSubscriber. This function handles fetching and returning
	 * JSON data.
	 *
	 * @return mixed|void Returns JSON data.
	 */
	public function load() {
		$am_api_data  = get_transient( 'am_api_data' );
		$override_api = get_transient( 'am_override_api' );

		if ( isset( $_REQUEST['security_nonce'] ) ) {
			check_ajax_referer( 'am-security-nonce', 'security_nonce' );
		}

		if ( $override_api || false === $am_api_data ) {
			$api_request   = wp_remote_get( 'https://miusage.com/v1/challenge/1/' );
			$json_response = wp_remote_retrieve_body( $api_request );

			set_transient( 'am_api_data', $json_response, 3600 );
			delete_transient( 'am_override_api' );
			header( 'Content-Type: application/json' );

			echo $json_response;
		} else {
			header( 'Content-Type: application/json' );

			echo $am_api_data;
		}

		exit;

	}

}
