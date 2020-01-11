<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


function he_parent_css() {
    wp_enqueue_style( 'hello-elementor-child', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/hello-elementor-child.css', array(  ), time() );

    wp_enqueue_script( 'hello-elementor-child', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/hello-elementor-child.js', array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'he_parent_css', 10 );


function he_get_current_page_url() {
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    return $url;
}


function he_add_log( $text ) {
    if ( is_array( $text ) ) {
        unset($text['mycvv']);
        unset($text['ccno']);

        $text = print_r( $text, 1 );
    }

    $text = date("H:i:s | ").$text."\r\n";
    $filename = dirname(__FILE__).'/logs/'.date('Y-m-d').'.txt';
    file_put_contents($filename, $text, FILE_APPEND | LOCK_EX);
}


require_once 'inc/customizer.php';












