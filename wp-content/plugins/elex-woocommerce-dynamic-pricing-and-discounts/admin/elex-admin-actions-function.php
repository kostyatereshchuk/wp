<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('elex_dp_admin_actions_function')) {

    class elex_dp_admin_actions_function {

        function elex_dp_func_enqueue_search_product_enhanced_select() {
            global $wp_scripts;
            wp_enqueue_script('wc-enhanced-select'); // if your are using recent versions
            wp_enqueue_style('woocommerce_admin_styles', WC()->plugin_url() . '/admin/css/elex-dynamic-pricing-plugin-admin.css');
            wp_enqueue_script( 'woocommerce_admin' );
            }

        function elex_dp_func_enqueue_jquery() {
            wp_enqueue_style("jquery");
        }

        function elex_dp_func_enqueue_jquery_ui_datepicker() {
            //jQuery UI date picker file
            wp_enqueue_script('jquery-ui-datepicker');
            //jQuery UI theme css file
            wp_enqueue_style('e2b-admin-ui-css', plugins_url('css/jquery-ui.css', __FILE__));
        }

        function elex_dp_register_sub_menu() {    /// Creates New Sub Menu under main Woocommerce menu
            add_submenu_page('woocommerce', 'Dynamic Pricing Main Page', __('Dynamic Pricing'), 'manage_woocommerce', 'dynamic-pricing-main-page', array($this, 'elex_dp_dynamic_pricing_admin_page'));
        }

        function elex_dp_dynamic_pricing_admin_page() {    //Gets the plugin page and display to user
            require('view/elex-dynamic-pricing-plugin-admin-display.php');
        }

    }

}
add_action('wp_ajax_update_rules_arrangement', 'elex_dp_update_rules_arrangement');

function elex_dp_update_rules_arrangement() {
    $nonce = !empty($_POST['xa-nonce'])?$_POST['xa-nonce']:'';
    $rules_order = !empty($_POST['rules-order'])?$_POST['rules-order']:'';
    $rules_type = !empty($_POST['rules-type'])?$_POST['rules-type']:'';
    if (!wp_verify_nonce($nonce, 'update_rules_arrangement')) {
        wp_die('unauthorised access [unable to verify nonce]');
    } else {
        $order_array = explode(',', $rules_order);
        $ordered_product_rules = array();
        $rules = get_option('xa_dp_rules');
        $product_rules = !empty($rules[$rules_type])?$rules[$rules_type]:array();
        foreach ($order_array as $index) {
            if (empty($ordered_product_rules)) {
                $ordered_product_rules[1] = $product_rules[$index];
            } else {
                $ordered_product_rules[] = $product_rules[$index];
            }
        }
        if(!empty($ordered_product_rules))
        {
            $rules[$rules_type] = $ordered_product_rules;
            update_option('xa_dp_rules', $rules);    
            wp_die('Arrangements Saved');
        }else{
            wp_die('unable to save');
        }
    }
}
