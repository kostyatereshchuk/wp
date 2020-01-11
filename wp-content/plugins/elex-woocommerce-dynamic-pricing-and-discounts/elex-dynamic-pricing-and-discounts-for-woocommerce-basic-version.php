<?php
/**
	Plugin Name: ELEX Dynamic Pricing and Discounts for WooCommerce Basic Version
	Plugin URI: https://elextensions.com/plugin/elex-dynamic-pricing-and-discounts-plugin-for-woocommerce-free-version/
	Description: This plugin helps you to set discounts and pricing dynamically based on minimum quantity,weight,price and allow you to set maximum allowed discounts on every rule.
	Version: 1.0.3
        WC requires at least: 3.0.0
        WC tested up to: 3.8
	Author: ELEXtensions
	Author URI: https://elextensions.com/plugin/elex-dynamic-pricing-and-discounts-plugin-for-woocommerce-free-version/
*/
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

define('elex_dp_root_path_basic', plugin_dir_path(__FILE__));
if (!defined('WPINC')) {
    die;
}

if (!class_exists('woocommerce')) {

    add_action('admin_init', 'elex_dp_my_plugin_deactivate');
    if(!function_exists('elex_dp_my_plugin_deactivate')){
        function elex_dp_my_plugin_deactivate() {
            if (!class_exists('woocommerce')) {
                deactivate_plugins(plugin_basename(__FILE__));
                wp_safe_redirect(admin_url('plugins.php'));
            }
        }    
    }

}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-xa-dynamic-pricing-plugin-activator.php
 */
if (!function_exists('elex_dp_activate_dynamic_pricing_plugin_basic')) {

    function elex_dp_activate_dynamic_pricing_plugin_basic() {

        if (is_plugin_active('elex-woocommerce-dynamic-pricing-and-discounts-premium/elex-woocommerce-dynamic-pricing-and-discounts-premium.php')) {
            deactivate_plugins(basename(__FILE__));
            wp_die(__("Oops! You tried installing the Basic version without deactivating and deleting the Premium version. Kindly deactivate and delete Dynamic Pricing and Discounts for WooCommerce Extension and then try again", "eh-dynamic-pricing-discounts"), "", array('back_link' => 1));
        }
        if (!class_exists('woocommerce')) {
            exit('Please Install and Activate Woocommerce Plugin First, Then Try Again!!');
        }

        require_once plugin_dir_path(__FILE__) . 'includes/elex-dynamic-pricing-plugin-activator.php';
        Elex_dp_dynamic_pricing_plugin_Activator::activate();
    }

}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-xa-dynamic-pricing-plugin-deactivator.php
 */
if (!function_exists('elex_dp_deactivate_dynamic_pricing_plugin_basic')) {

    function elex_dp_deactivate_dynamic_pricing_plugin_basic() {
        if (!class_exists('woocommerce')) {
            new WP_Error('1', 'Dynamic Pricing And Discounts Plugin could not start because WooCommerce Plugin is Deactivated!!');
        }

        require_once plugin_dir_path(__FILE__) . 'includes/elex-dynamic-pricing-plugin-deactivator.php';
        Elex_dp_dynamic_pricing_plugin_Deactivator::deactivate();
    }

}


register_activation_hook(__FILE__, 'elex_dp_activate_dynamic_pricing_plugin_basic');
register_deactivation_hook(__FILE__, 'elex_dp_deactivate_dynamic_pricing_plugin_basic');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/elex-dynamic-pricing-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
if (!function_exists('elex_dp_run_dynamic_pricing_plugin')) {

    function elex_dp_run_dynamic_pricing_plugin() {
        $plugin = new Elex_dp_dynamic_pricing_plugin();
        $plugin->run();
    }

}
global $offers;
$offers = array();
if (!function_exists('elex_dp_plugin_settings_link')) {

    function elex_dp_plugin_settings_link($links) {
        $settings_link = '<a href="admin.php?page=dynamic-pricing-main-page&tab=product_rules">Settings</a>';
        $doc_link = '<a href="https://elextensions.com/plugin/dynamic-pricing-and-discounts-plugin-for-woocommerce/" target="_blank">' . __('Upgrade to premium', 'eha_multi_carrier_shipping') . '</a>';
        $support_link = '<a href="https://elextensions.com/support/" target="_blank">' . __('Support', 'eha_multi_carrier_shipping') . '</a>';

        array_unshift($links, $support_link);
        array_unshift($links, $doc_link);
        array_unshift($links, $settings_link);
        return $links;
    }

}


$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'elex_dp_plugin_settings_link');

try {
    elex_dp_run_dynamic_pricing_plugin();
} catch (Exception $e) {

}
