<?php
/**
 * This file extends the WordPress List Table class
 *
 * The List Table class gets extended and customized to suit the needs of our use-case.
 *
 * @link http://carlwuensche.com
 *
 * @package CarlWuensche\AMAPI
 * @since 1.0
 */

namespace CarlWuensche\AMAPI\Admin;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Class Am_API_List
 *
 * @package CarlWuensche\AMAPI\Admin
 */
class Am_API_List extends \WP_List_Table {

	/**
	 * Am_API_List constructor.
	 */
	public function __construct() {
		parent::__construct(
			array(
				'singular' => __( 'Awesome Motive List', 'am-api' ),
				'plural'   => __( 'Awesome Motive List', 'am-api' ),
				'ajax'     => false,
			)
		);
	}

	/**
	 * The prepare_items() function is used to prepare everything used to populate the table including the column names
	 * and data.
	 */
	public function prepare_items() {
		$columns  = $this->get_columns();
		$hidden   = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();

		$data = $this->table_data();

		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->items           = $data;
	}

	/**
	 * The table_data() function represents the data that will be used to populate the data.
	 *
	 * @return array $data The data array returned represents data saved from the API.
	 */
	public function table_data() {
		$action = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );

		if ( ! empty( $action ) && 'refresh' === $action ) {

			$ajax_refresh = wp_remote_post(
				admin_url( 'admin-ajax.php' ),
				array(
					'body' => array(
						'action' => 'am_api_endpoint',
						'method' => 'POST',
					),
				)
			);

		}

		$endpoint_data = get_transient( 'am_api_data' );
		$data          = array();

		if ( ! empty( $endpoint_data ) && false !== $endpoint_data ) {
			$endpoint_data_array = json_decode( $endpoint_data );
			foreach ( $endpoint_data_array as $edata ) {
				if ( null !== $edata && isset( $edata->rows ) ) {
					foreach ( $edata->rows as $row ) {
						$data[] = array(
							'id'    => $row->id,
							'fname' => $row->fname,
							'lname' => $row->lname,
							'email' => $row->email,
							'date'  => gmdate( get_option( 'date_format' ), $row->date ),
						);
					}
				}
			}
		}

		return $data;
	}

	/**
	 * Function used to finish an implementation of get_sortable_columns().
	 *
	 * @return array Returns an empty array. This is here just to implement all required functions.
	 */
	public function get_sortable_columns() {
		return array();
	}

	/**
	 * Function used to finish an implementation of get_hidden_columns().
	 *
	 * @return array Returns an empty array. This is here just to implement all required functions.
	 */
	public function get_hidden_columns() {
		return array();
	}

	/**
	 * Function used to store the table header columns.
	 *
	 * @return array $columns Returns an array of columns we are displaying in the table.
	 */
	public function get_columns() {
		$columns = array(
			'id'    => __( 'ID', 'am-api' ),
			'fname' => __( 'First Name', 'am-api' ),
			'lname' => __( 'Last Name', 'am-api' ),
			'email' => __( 'Email', 'am-api' ),
			'date'  => __( 'Date', 'am-api' ),
		);

		return $columns;
	}

	/**
	 * This function allows us to specify the default value for each specified item in the array.
	 *
	 * @param array  $item The array of columns.
	 * @param string $column_name The name of the column we're dealing with.
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'id':
			case 'fname':
			case 'lname':
			case 'email':
			case 'date':
			default:
				return $item[ $column_name ];
		}
	}

}
