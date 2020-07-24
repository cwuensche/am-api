<?php
/**
 * This is the file that handles the admin page
 *
 * The admin page file contains an APIPage class with a display function that outputs the content for the admin page.
 *
 * @link http://carlwuensche.com
 *
 * @package CarlWuensche\AMAPI
 * @since 1.0
 */

namespace CarlWuensche\AMAPI\Admin;

use CarlWuensche\AMAPI\Admin\Am_API_List;

/**
 * Class APIPage
 *
 * @package CarlWuensche\AMAPI\Admin
 */
class APIPage {

	/**
	 * This function displays the table content for the admin page.
	 */
	public function display() {
		?>
		<div id="am-api-header">
			<img class="am-api-header-logo" src="<?php echo esc_url( AM_PLUGIN_URL . 'assets/images/logo.svg' ); ?>">
		</div>
		<div class="am-container">
			<?php
				$am_api_table = new Am_API_List();
				$am_api_table->prepare_items();
				$am_api_table->display();
			?>
				<p class="am-api-submit">
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=am-api-page&action=refresh' ) ); ?>" class="am-api-btn am-api-btn-orange">Refresh API</a>
				</p>
		</div>
		<?php
	}

}
