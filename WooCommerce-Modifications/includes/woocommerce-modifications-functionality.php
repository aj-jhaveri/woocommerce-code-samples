<?php
/**
 * WooCommerce Modifications Functionality
 *
 * @category  Class
 * @package   WordPress
 * @author    AJ
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://slakedesign.com
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly.
}

/**
 * Class to manage breadcrumbs and vendor's custom fields.
 */
class WooCommerce_Modifications_Functionality {

	/**
	 * Constructor
	 */
	public function __construct() {
		
		/**
 		* Removes rating from woocommerce single product summary
 		*/
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		
		/**
 		* Add content after single product summary
 		*/
		
		add_action('woocommerce_after_single_product_summary', 'content_after_summary', 9);
		
		function content_after_summary() {  ?>
    		<div style="clear:both;">We can programmatically add some content here, below the summary with the woocommerce_after_single_product_summary action hook.</div>
		
		<?php 
		}
		
		/**
 		* Replace sale flash text with price savings
 		*/
		
		add_filter( 'woocommerce_sale_flash', 'woocommerce_custom_sale_flash', 10, 3 );
		
		function woocommerce_custom_sale_flash( $output_html, $post, $product ) {

    		$regular_price = method_exists( $product, 'get_regular_price' ) ? $product->get_regular_price() : $product->regular_price;
		$sale_price = method_exists( $product, 'get_sale_price' ) ? $product->get_sale_price() : $product->sale_price;
    		$saved_price = wc_price( $regular_price - $sale_price );
    		$output_html = '<span class="onsale">' . esc_html__( 'Save', 'woocommerce' ) . ' ' . $saved_price . '</span>';
    		return $output_html;
		}
	
		/**
 		* Rename "home" in breadcrumb
 		*/
		
		// Increased priority of execution for Storefront Theme
		add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_home_text', 20 );
		
		function wcc_change_breadcrumb_home_text( $defaults ) {
		$defaults['home'] = 'Slake Store';
		return $defaults;
		}
		
	}

}

return new WooCommerce_Modifications_Functionality();
