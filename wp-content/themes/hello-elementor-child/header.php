<?php
/**
 * The template for displaying the header
 *
 * This is the template that displays all of the <head> section, opens the <body> tag and adds the site's header.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>

<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <?php $viewport_content = apply_filters( 'hello_elementor_viewport_content', 'width=device-width, initial-scale=1' ); ?>
        <meta name="viewport" content="<?php echo esc_attr( $viewport_content ); ?>">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <?php wp_head(); ?>
    </head>
<body <?php body_class(); ?>>

Test Image: <?php echo get_theme_mod( 'customize_test_image' ); ?><br>
Test Color: <?php echo get_theme_mod( 'customize_test_color' ); ?><br>
Test Text: <?php echo get_theme_mod( 'customize_test_text' ); ?><br>
Test Textarea: <?php echo get_theme_mod( 'customize_test_textarea' ); ?><br>
Test Select: <?php echo get_theme_mod( 'customize_test_select' ); ?><br>
Test Radio: <?php echo get_theme_mod( 'customize_test_radio' ); ?><br>
Test Checkbox: <?php echo get_theme_mod( 'customize_test_checkbox' ); ?><br>

<?php
hello_elementor_body_open();

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
    get_template_part( 'template-parts/header' );
}
