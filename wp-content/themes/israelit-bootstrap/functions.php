<?php
function israelit_setup() {
	load_theme_textdomain( 'israelit', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );

	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'israelit' ),
	) );

	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'caption',
	) );
}
add_action( 'after_setup_theme', 'israelit_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function israelit_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'israelit' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'israelit' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'israelit_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function israelit_scripts() {
    wp_enqueue_style( 'israelit-bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );
    wp_enqueue_style( 'israelit-fontawesome-cdn', get_template_directory_uri() . '/assets/css/fontawesome.min.css' );
    wp_enqueue_style( 'israelit-style', get_stylesheet_uri() );

	//wp_enqueue_script('jquery');

    wp_enqueue_script('israelit-popper', get_template_directory_uri() . '/assets/js/popper.min.js', array(), '', true );
    wp_enqueue_script('israelit-bootstrapjs', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), '', true );

    wp_enqueue_script('israelit-themejs', get_template_directory_uri() . '/assets/js/theme-script.min.js', array(), '', true );
	wp_enqueue_script( 'israelit-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.min.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'israelit_scripts' );

/**
 * WooCommerce support.
 */
function israelit_woocommerce_support() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'israelit_woocommerce_support' );


require_once 'inc/customizer.php';
