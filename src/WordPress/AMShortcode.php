<?php
/**
 * AMShortcode is used to display content we have called and saved from the ajax endpoint
 *
 * AMShortcode outputs the content from the ajax endpoint.
 *
 * @link http://carlwuensche.com
 *
 * @package CarlWuensche\AMAPI
 * @since 1.0
 */

namespace CarlWuensche\AMAPI\WordPress;

/**
 * Class AMShortcode
 *
 * @package CarlWuensche\AMAPI\WordPress
 */
class AMShortcode {

	/**
	 * This function outputs the shortcode content and makes a call to our own AJAX endpoint for the frontend.
	 *
	 * @return false|string The AJAX content from javascript gets called and returned into the various html containers.
	 */
	public function display() {
		global $post;

		if ( has_shortcode( $post->post_content, 'am_display' ) ) {
			ob_start();
			$security_nonce = wp_create_nonce( 'am-security-nonce' );
			?>
			<h1 class="am-title"></h1>
			<table class="am-table">
				<thead class="am-table-header">

				</thead>
				<tbody class="am-table-body">

				</tbody>
			</table>
			<script type="text/javascript">
				let xhr = new XMLHttpRequest();
				let am_ajaxurl = "<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>";
				let security_nonce = "<?php echo $security_nonce; ?>";
				xhr.open('POST', am_ajaxurl, true );
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
				xhr.onload = function() {
					if ( xhr.status >= 200 && xhr.status < 300 ) {
						let responseJSON = JSON.parse( xhr.responseText );
						let responseTitle = ( responseJSON.hasOwnProperty('title') ) ? responseJSON.title : '';
						let responseHeaders = ( responseJSON.hasOwnProperty('data') && responseJSON.data.hasOwnProperty('headers') ) ? responseJSON.data.headers : [];
						let responseRows = ( responseJSON.hasOwnProperty('data') && responseJSON.data.hasOwnProperty('rows') ) ? responseJSON.data.rows : [];

						document.querySelector('.am-title').innerHTML = responseTitle;

						for ( var i = 0; i < responseHeaders.length; i++ ) {
							let thHeader = document.createElement('th');
							thHeader.innerHTML = responseHeaders[i];
							document.querySelector('.am-table-header').append(
								thHeader);
						}
						for ( const row in responseRows ) {
							let first_name = responseRows[row].fname;
							let last_name = responseRows[row].lname;
							let id = responseRows[row].id;
							let email = responseRows[row].email;
							let date = responseRows[row].date;
							let dateObj = new Date(date*1000);
							let months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
							let month = months[dateObj.getMonth() ];
							let formattedDate = month + " " + dateObj.getDate() + ", " + dateObj.getFullYear();
							let new_table_row = document.createElement('tr');
							let id_cell = document.createElement('td');
							let first_name_cell = document.createElement('td');
							let last_name_cell = document.createElement('td');
							let email_cell = document.createElement('td');
							let date_cell = document.createElement('td');
							id_cell.innerHTML = id;
							first_name_cell.innerHTML = first_name;
							last_name_cell.innerHTML = last_name;
							email_cell.innerHTML = email;
							date_cell.innerHTML = formattedDate;
							new_table_row.append(id_cell);
							new_table_row.append(first_name_cell);
							new_table_row.append(last_name_cell);
							new_table_row.append(email_cell);
							new_table_row.append(date_cell);
							document.querySelector('.am-table-body').append(new_table_row);

						}
					}
				}

				xhr.send(
					"action=am_api_endpoint&security_nonce=" + security_nonce
				);
			</script>
			<?php
			return ob_get_clean();
		}

	}

}
