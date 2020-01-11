<?php
/*
* Plugin Name: Middle Test
* Description: Test plugin for the middle WordPress developer.
* Version: 1.0.0
*/


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * # Middle Test
 *
 * @class Middle_Test
 * @version 1.0.0
 */
class Middle_Test {

	/**
	 * @var Middle_Test - single instance of the class.
	 */
	protected static $_instance = null;

	/**
	 * Middle_Test instance.
	 *
	 * @static
	 * @return Middle_Test - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Contructor.
	 */
	public function __construct() {
        add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), array( $this, 'plugin_actions' ), 10, 4 );

        if ( is_admin() ) {
            require_once 'includes/admin/class-middle-test-admin-settings.php';
        }
	}

    /**
     * Reports page in the admin panel.
     */
    public function plugin_actions( $actions, $plugin_file, $plugin_data, $context ) {
        array_unshift($actions, "<a href=\"".menu_page_url('middle-test', false)."\">".esc_html__("Settings")."</a>");
        return $actions;
    }
}

Middle_Test::instance();



