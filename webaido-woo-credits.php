<?php
/*
 * Plugin Name:       Woocommerce Credits
 * Plugin URI:        https://webaido.com/plugins/woo-credits/
 * Description:       Credits Feature for WooCommerce.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Khoa
 * Author URI:        https://khoa.webaido.com/
 * License:           GPL v2 or later
 */

 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define('WOO_CREDIT_VERSION', '1.0.0');
if ( ! defined( 'WO0_CREDITS_PLUGIN_FILE' ) ) {
	define( 'WO0_CREDITS_PLUGIN_FILE', __FILE__ );
}

function activate_woo_credits_plugin() {
    require_once( plugin_dir_path( __FILE__ ) .'includes/class-woo-credits-activator.php');
    ClassWooCreditsActivator::activate();
}

function deactivate_woo_credits_plugin() {
    require_once( plugin_dir_path( __FILE__ ) .'includes/class-woo-credits-deactivator.php');
    ClassWooCreditsDeactivator::deactivate();
}

register_activation_hook( __FILE__,'activate_woo_credits_plugin');
register_deactivation_hook( __FILE__,'deactivate_woo_credits_plugin');

function run_webaido_woo_credits_plugin() {
    if (!class_exists('WoocommerceWooCreditPlugin')) {
        class WoocommerceWooCreditPlugin {
            public function __construct() {
                error_log('WoocommerceWooCreditPlugin Construct Running');
            }
            /**
             * Get the plugin url.
             *
             * @return string
             */
            public function plugin_url() {
                return untrailingslashit( plugins_url( '/', WO0_CREDITS_PLUGIN_FILE ) );
            }

            /**
             * Get the plugin path.
             *
             * @return string
             */
            public function plugin_path() {
                return untrailingslashit( plugin_dir_path( WO0_CREDITS_PLUGIN_FILE ) );
            }

            public function themes_path() {
                return $this->plugin_path() . '/templates/';
            }
            /**
             * Get the template path.
             *
             * @return string
             */
            public function template_path() {
                /**
                 * Filter to adjust the base templates path.
                 */
                return apply_filters( 'woo_credits_template_path', 'webaido-woo-credits/' ); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingSinceComment
            }

            public function wcredits_get_template(string $template_name, $args = array()) {
                wc_get_template($template_name, $args, $this->template_path(), $this->themes_path());
            }

            public function run() {
                error_log('Pluginging is runnning....');
                add_action('init', function() {
                    add_rewrite_endpoint('credits', EP_ROOT | EP_PAGES);
                });
                add_filter('woocommerce_account_menu_items', function($items) {
                    $items['credits'] = __('Credits', 'credits');
                    // error_log(print_r($items), true);
                    return $items;
                });
                add_action( 'woocommerce_account_credits_endpoint', array( $this,'add_woocommerce_credits') );
            }
            public function add_woocommerce_credits() {
                $this->wcredits_get_template('myaccount/credits.php');
            }
        }
        $woocommerceCreditPlugin = new WoocommerceWooCreditPlugin();
        $woocommerceCreditPlugin->run();
    } else {
        error_log('Woo credit class existed');
    }
};
add_action('init', function() {
    error_log('Plugin is initing');
    add_rewrite_endpoint('movies', EP_PERMALINK);
});

run_webaido_woo_credits_plugin();