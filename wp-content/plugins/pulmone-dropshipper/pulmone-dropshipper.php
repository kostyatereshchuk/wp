<?php
/*
* Plugin Name: Pulmone Dropshipper
* Description: Automating fulfillment process with dropshipper.
* Version: 1.0.0
* Author: PulmOne
* Author URI: https://www.pulm-one.com/
* License: GPL2
*/


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * # Pulmone Dropshipper
 *
 * @class Pulmon_Dropshipper
 * @version 1.0.0
 */
class Pulmone_Dropshipper {

	/**
	 * @var Pulmon_Dropshipper - single instance of the class.
	 */
	protected static $_instance = null;

	/**
	 * Pulmon_Dropshipper instance.
	 *
	 * @static
	 * @return Pulmon_Dropshipper - Main instance
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

        //add_action( 'admin_init', array( $this, 'send_email' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

        require_once 'includes/class-pulmone-dropshipper-order.php';

        if ( is_admin() ) {
            require_once 'includes/admin/class-pulmone-dropshipper-settings.php';
            require_once 'includes/admin/class-pulmone-dropshipper-tracking.php';
        }

	}

    /**
     * Include assets.
     */
	public function admin_enqueue_scripts() {
        wp_enqueue_style('pulmon-dropshipper-admin', plugin_dir_url( __FILE__ ).'assets/css/admin.css');
    }

    /**
     * Reports page in the admin panel.
     */
    public function plugin_actions( $actions, $plugin_file, $plugin_data, $context ) {
        array_unshift($actions, "<a href=\"".menu_page_url('pulmone-dropshipper', false)."\">".esc_html__("Settings")."</a>");
        return $actions;
    }

    /**
     * Track shipment url.
     */
    public function get_tracking_url( $tracking_number ) {
        return 'https://wwwapps.ups.com/tracking/tracking.cgi?tracknum=' . $tracking_number;
    }

    /**
     * Update dropshipper_tracking_data, dropshipper_tracking_numbers and dropshipper_scheduled_delivery_dates.
     */
    public function update_tracking_data( $order_id, $new_dropshipper_tracking_data ) {
        $dropshipper_tracking_numbers = '';
        $dropshipper_tracking_numbers_html = '';
        $dropshipper_scheduled_delivery_dates = '';
        $unique_dates = array();
        foreach ( $new_dropshipper_tracking_data as $index => $tracking_item ) {
            if ($dropshipper_tracking_numbers) {
                $dropshipper_tracking_numbers .= ', ';
                $dropshipper_tracking_numbers_html .= ', ';
            }
            $dropshipper_tracking_numbers .= $tracking_item['tracking_number'];
            $dropshipper_tracking_numbers_html .= '<a target="_blank" href="' . $this->get_tracking_url($tracking_item['tracking_number']) . '">' . $tracking_item['tracking_number'] . '</a>';

            if ( !in_array( $tracking_item['scheduled_delivery_date'], $unique_dates ) ) {
                if ( count( $unique_dates ) ) {
                    $dropshipper_scheduled_delivery_dates .= ', ';
                }
                $dropshipper_scheduled_delivery_dates .= $tracking_item['scheduled_delivery_date'];
                $unique_dates[ $tracking_item['scheduled_delivery_date'] ] = $tracking_item['scheduled_delivery_date'];
            }
        }
        update_post_meta( $order_id, 'dropshipper_tracking_data', $new_dropshipper_tracking_data );
        update_post_meta( $order_id, 'dropshipper_tracking_numbers', $dropshipper_tracking_numbers );
        update_post_meta( $order_id, 'dropshipper_tracking_numbers_html', $dropshipper_tracking_numbers_html );
        update_post_meta( $order_id, 'dropshipper_scheduled_delivery_dates', $dropshipper_scheduled_delivery_dates );

        $this->log( 'Update tracking data | Order #' . $order_id . ' | dropshipper_tracking_numbers = ' . $dropshipper_tracking_numbers );
    }

    /**
     * Write log to file in logs directory.
     */
    function log( $text ) {
        $text = date("H:i:s | ").$text."\r\n";
        file_put_contents(dirname(__FILE__).'/logs/'.date('Y-m-d').'.txt', $text, FILE_APPEND | LOCK_EX);
    }
}


/**
 * Main instance of Pulmon_Dropshipper.
 *
 * Returns the main instance of Pulmon_Dropshipper to prevent the need to use globals.
 */
function pulmone_dropshipper() {
    return Pulmone_Dropshipper::instance();
}

// Global for backwards compatibility.
$GLOBALS['pulmone_dropshipper'] = pulmone_dropshipper();




/**
 * Set cron schedule after plugin activation.
 */
register_activation_hook(__FILE__, 'pulmone_dropshipper_activation');
function pulmone_dropshipper_activation() {
    if ( ! wp_next_scheduled ( 'pulmone_dropshipper_hourly_event' ) ) {
        wp_schedule_event(time(), 'hourly', 'pulmone_dropshipper_hourly_event');
    }
}
add_action('pulmone_dropshipper_hourly_event', 'pulmone_dropshipper_hourly_action');
function pulmone_dropshipper_hourly_action() {


    require_once 'includes/class-pulmone-dropshipper-mail-parser.php';

    $parser = new Pulmone_Dropshipper_Mail_Parser();
    $parser->update_orders_tracking_data();


}

/**
 * Clear cron schedule after plugin activation.
 */
register_deactivation_hook(__FILE__, 'pulmone_dropshipper_deactivation');
function pulmone_dropshipper_deactivation() {
    wp_clear_scheduled_hook('pulmone_dropshipper_hourly_event');
}


/*if (isset($_GET['test'])) {
    ini_set('display_errors', 1);
    add_action('wp_loaded', 'pulmone_dropshipper_hourly_action');
}*/
