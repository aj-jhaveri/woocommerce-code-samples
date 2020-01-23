<?php
/**
 * Plugin Name: WooCommerce Modifications Old
 * Version: 1.0.0
 * Plugin URI: https://slakedesign.com
 * Description: WooCommerce Modifications Plugin
 * Author: AJ
 * Author URI: https://slakedesign.com
 * Requires at least: 4.4.0
 * Tested up to: 4.6.0
 * Domain Path: /languages
 *
 * @package WordPress
 * @author  AJ
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


if ( ! class_exists( 'WooCommerce_Modifications' ) ) {

	/**
	 * Main Class.
	 */
	class WooCommerce_Modifications {


		/**
		* Plugin version.
		*
		* @var string
		*/
		const VERSION = '1.0.0';


		/**
		 * Instance of this class.
		 *
		 * @var object
		 */
		protected static $instance = null;

		/**
		 * Return an instance of this class.
		 *
		 * @return object single instance of this class.
		 */
		public static function get_instance() {
			if ( null === self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		private function __construct() {
			if ( ! class_exists( 'WooCommerce' ) ) {
				add_action( 'admin_notices', array( $this, 'fallback_notice' ) );
			} else {
				$this->load_plugin_textdomain();
				$this->includes();
			}
		}

        /**
         * Method to call and run all the things that you need to fire when your plugin is activated.
         *
         */
        public static function activate() {
            include_once 'includes/woocommerce-modifications-activate.php';
            WooCommerce_Modifications_Activate::activate();

        }

        /**
         * Method to call and run all the things that you need to fire when your plugin is deactivated.
         *
         */
        public static function deactivate() {
            include_once 'includes/woocommerce-modifications-deactivate.php';
            WooCommerce_Modifications_Deactivate::deactivate();
        }

		/**
		 * Method to includes our dependencies.
		 *
		 * @var string
		 */
		public function includes() {
			include_once 'includes/woocommerce-modifications-functionality.php';
		}

		/**
		 * Load the plugin text domain for translation.
		 *
		 * @access public
		 * @return bool
		 */
		public function load_plugin_textdomain() {
			$locale = apply_filters( 'wepb_plugin_locale', get_locale(), 'woocommerce-modifications' );

			//load_textdomain( 'woocommerce-modifications', trailingslashit( WP_LANG_DIR ) . 'woocommerce-modifications/woocommerce-modifications' . '-' . $locale . '.mo' );

			//load_plugin_textdomain( 'woocommerce-modifications', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

			return true;
		}

		/**
		 * Fallback notice.
		 *
		 * We need some plugins to work, and if any isn't active we'll show you!
		 */
		public function fallback_notice() {
			echo '<div class="error">';
			echo '<p>' . __( 'WooCommerce Modifications: Needs the WooCommerce Plugin activated.', 'woocommerce-modifications' ) . '</p>';
			echo '</div>';
		}
	}
}

/**
* Hook to run when your plugin is activated
*/
register_activation_hook( __FILE__, array( 'WooCommerce_Modifications', 'activate' ) );

/**
* Hook to run when your plugin is deactivated
*/
register_deactivation_hook( __FILE__, array( 'WooCommerce_Modifications', 'deactivate' ) );

/**
* Initialize the plugin.
*/
add_action( 'plugins_loaded', array( 'WooCommerce_Modifications', 'get_instance' ) );
