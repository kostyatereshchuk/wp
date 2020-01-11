<?php
/*
 * Plugin Name: UE Tracker - UTM Track and Analyze Leads For Elementor
 * Description: Discover which marketing campaigns are actually profitable and which are wasting your time & money. UE Tracker - UTM Track and Analyze Elementor Leads by Gemplan plug-in collects the source of the lead and shows it in the WordPress Dashboard along with the lead details. This add-on for Elementor tracks the effectiveness of your marketing campaigns and helps you identify the winners.
 * Plugin URI:  https://www.gemplan.co.il/ue-tracker/ 
 * Author URI:  https://www.gemplan.co.il/en/home-en/
 * Author:      Gemplan
 * Version:     1.0
 *
 * Text Domain: en
 * Domain Path: /languages
 *
 * License:     GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 */

//Check if Elementor PRO activated
function UETR_general_admin_notice(){
    $plugin = "elementor-pro/elementor-pro.php";
    $check = is_plugin_active( $plugin );
    if(!$check) {
        echo '<div class="notice notice-warning is-dismissible">
             <p>Please Activate Elementor PRO plugin to use UTM Track and Analyze</p>
         </div>';
    }
}
add_action('admin_notices', 'UETR_general_admin_notice');

//ranking notification
function UETR_ranking_admin_notice(){
    $max_shows = 3;
    $uid = get_current_user_id();
    $key = "ue_track_shows";
    $key_is_show = "ue_track_is_show";
    $is_shows = get_user_meta( $uid, $key_is_show, true );
    if(get_user_meta( $uid, $key, true )){
        $shows = get_user_meta( $uid, $key, true );
    } else{
        $shows = 0;
    }
    if($shows < $max_shows && $is_shows) {
        echo '<div id="ue_track_shows" class="notice notice-info is-dismissible" data-test="'.$shows.'" data-test2="'.$is_shows.'">
             <p>We love it when you have all the data you need and everything is simple and clear. If you enjoy it too, rate us. We also like to see the data :)</p>
         </div>';
        echo '<script>            
                var action = "update_notice_count";
                var user = "<?php echo get_current_user_id();?>";
                var nonce = "<?php echo wp_create_nonce( \'update_notification_count\' ); ?>";
                jQuery("#ue_track_shows").on("click", function() {
                    jQuery.getJSON(ajaxurl, \'action=\' + action+ \'&user=\' + user + \'&nonce=\' + nonce, function (resp) {
                    console.log(resp);
                });
                });</script>';
    }
}
add_action('admin_notices', 'UETR_ranking_admin_notice');
function UETR_ranking_admin_notice_func($user_login, $user){
    $key = "ue_track_is_show";
    update_user_meta( $user->ID, $key, "true" );
}
add_action('wp_login', 'UETR_ranking_admin_notice_func', 10, 2 );


// Add Menu item in admin panel
add_action('admin_menu', 'UETR_Add_My_Admin_Link');
function UETR_Add_My_Admin_Link()
{
    add_menu_page(
        'UE Tracker',
        'UE Tracker',
        'manage_options',
        'ue-tracker-utm-track-and-analyze-leads-for-elementor/get_data.php',
        '',
        plugins_url('ue-tracker-utm-track-and-analyze-leads-for-elementor/assets/images/logo.svg')
    );
}

/*
Action on activate plugin
- Create table "collects" that contain all form created in Elementor PRO
- Create table "utm_builder" that contain created UTM links
*/
function UETR_collects_activate()
{
    global $wpdb;

    $table_name = $wpdb->prefix . "collects";

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  form_name varchar(60) NOT NULL,
  PRIMARY KEY  (id)
) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    $table_name = $wpdb->prefix . "utm_builder";

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  source varchar(60) NOT NULL,
  medium varchar(60) NOT NULL,
  name varchar(60) NOT NULL,
  term varchar(60) NOT NULL,
  content varchar(60) NOT NULL,
  url varchar(300) NOT NULL,
  date varchar(16) NOT NULL,
  PRIMARY KEY  (id)
) $charset_collate;";

    dbDelta($sql);

}
register_activation_hook(__FILE__, 'UETR_collects_activate');


/*
 This action catch Elementor PRO form submit and if need create table for current form and put data from form in this table
 */
add_action('elementor_pro/forms/new_record', function ($record, $handler) {

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    global $wpdb;
    $table_name = $wpdb->prefix . "collects";
    $charset_collate = $wpdb->get_charset_collate();

    $form_name = $record->get_form_settings('form_name');
    $new_table_name = $table_name . "_";
    $raw_fields = $record->get('fields');

    $page_url = $record->get('meta')['page_url']['value'];

    $request_date = date("Y-m-d");

    $parts = parse_url($page_url);
    parse_str($parts['query'], $params);

    $fields = [];
    $form_fields = "";
    foreach ($raw_fields as $id => $field) {
        $fields[$id] = $field['value'];
        $form_fields .= $id . " varchar(100),";
    }
    $form_fields .= "date varchar(16),";
    $form_fields .= "utm_source varchar(100),";
    $form_fields .= "utm_medium varchar(100),";
    $form_fields .= "utm_campaign varchar(100),";
    $form_fields .= "utm_term varchar(100),";
    $form_fields .= "utm_content varchar(100),";

    foreach ($params as $id => $field){
        if($id == 'utm_source' || $id == 'utm_medium' || $id == 'utm_campaign' || $id == 'utm_term' || $id == 'utm_content' ){
            $fields[$id] = $field;
        }
    }
    $fields["date"] = $request_date;

    $query = "SELECT id FROM " . $table_name . " WHERE form_name = '" . $form_name . "'";
    $tables = $wpdb->get_results($query, ARRAY_A);
    if (count($tables) == 0) {
        $table_id = $wpdb->insert($table_name, array('form_name' => $form_name), array('%s', '%d'));
        $new_table_name .= $wpdb->insert_id;
        $sql = "CREATE TABLE $new_table_name (
              id mediumint(9) NOT NULL AUTO_INCREMENT,
              $form_fields
              PRIMARY KEY  (id)
            ) $charset_collate;";

        dbDelta($sql);
    } else {
        $table_id = $tables[0]['id'];
        $new_table_name .= $table_id;
    }

    $wpdb->insert($new_table_name, $fields);
}, 10, 2);


add_action( 'wp_ajax_write_utm', 'UETR_write_utm' );
function UETR_write_utm()
{
    $ins_id = 0;
    global $wpdb;
    $table_name = $wpdb->prefix . "utm_builder";
    if (isset($_GET['nonce'])){
        if ( wp_verify_nonce( $_GET['nonce'], 'create_utm' ) ){
            $uid = sanitize_text_field($_GET['user']);
            $key = "ue_track_is_show";
            update_user_meta($uid, $key, "true");

            $data['source'] = sanitize_text_field($_GET['source']);
            $data['medium'] = sanitize_text_field($_GET['medium']);
            $data['name'] = sanitize_text_field($_GET['name']);
            $data['term'] = sanitize_text_field($_GET['term']);
            $data['content'] = sanitize_text_field($_GET['content']);
            $data['url'] = esc_url($_GET['url']);
            $data['date'] = date('Y-m-d');

            $ins_id = $wpdb->insert($table_name, $data);
        }
    }

    return $ins_id;
}

add_action( 'wp_ajax_update_notice_count', 'UETR_update_notice_count' );
function UETR_update_notice_count()
{
    $ret = 0;
    if (isset($_GET['nonce'])) {
        if (wp_verify_nonce($_GET['nonce'], 'update_notification_count')) {
            $uid = sanitize_text_field($_GET['user']);
            $key = "ue_track_shows";
            $key_is_show = "ue_track_is_show";
            update_user_meta($uid, $key_is_show, "");
            if (get_user_meta($uid, $key, true)) {
                $count = (int)get_user_meta($uid, $key, true) + 1;
                $ret = update_user_meta($uid, $key, $count);
            } else {
                $ret = update_user_meta($uid, $key, 1);
            }
        }
    }

    return $ret;
}

function UETR_scripts() {
    wp_enqueue_script( 'popper', plugin_dir_url(__FILE__) . 'assets/js/popper.js');
    wp_enqueue_script( 'bootstrap', plugin_dir_url(__FILE__) . 'assets/js/bootstrap.min.js');
    wp_enqueue_script( 'select2', plugin_dir_url(__FILE__) . 'assets/js/select2.min.js');
    wp_enqueue_script( 'perfect-scrollbar', plugin_dir_url(__FILE__) . 'assets/js/perfect-scrollbar.min.js');
    wp_enqueue_script( 'tablefilter', plugin_dir_url(__FILE__) . 'assets/js/tablefilter.js');
    wp_enqueue_script( 'chart', plugin_dir_url(__FILE__) . 'assets/js/Chart.min.js');
    wp_enqueue_script( 'mymoment', plugin_dir_url(__FILE__) . 'assets/js/moment.min.js');
    wp_enqueue_script( 'popper', plugin_dir_url(__FILE__) . 'assets/js/popper.js');
    wp_enqueue_script( 'daterangepicker', plugin_dir_url(__FILE__) . 'assets/js/daterangepicker.min.js');
    wp_enqueue_script( 'main', plugin_dir_url(__FILE__) . 'assets/js/main.js');

    wp_enqueue_style( 'admin', plugin_dir_url(__FILE__) . 'assets/css/admin.css' );
    wp_enqueue_style( 'bootstrap', plugin_dir_url(__FILE__) . 'assets/css/bootstrap.min.css' );
    wp_enqueue_style( 'font-awesome', plugin_dir_url(__FILE__) . 'assets/css/font-awesome.min.css' );
    wp_enqueue_style( 'animate', plugin_dir_url(__FILE__) . 'assets/css/animate.css' );
    wp_enqueue_style( 'select2', plugin_dir_url(__FILE__) . 'assets/css/select2.min.css' );
    wp_enqueue_style( 'perfect-scrollbar', plugin_dir_url(__FILE__) . 'assets/css/perfect-scrollbar.css' );
    wp_enqueue_style( 'util', plugin_dir_url(__FILE__) . 'assets/css/util.css' );
    wp_enqueue_style( 'main', plugin_dir_url(__FILE__) . 'assets/css/main.css' );
    wp_enqueue_style( 'tablefilter', plugin_dir_url(__FILE__) . 'assets/css/tablefilter.css' );
    wp_enqueue_style( 'chart', plugin_dir_url(__FILE__) . 'assets/css/Chart.min.css' );
    wp_enqueue_style( 'daterangepicker', plugin_dir_url(__FILE__) . 'assets/css/daterangepicker.css' );
}
add_action( 'wp_enqueue_scripts', 'UETR_scripts' );

