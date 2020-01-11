<?php if (!defined('ABSPATH')) exit;
/**
 * Theme Customizer
 *
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function customize_customize_register($wp_customize)
{
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';


    /***********************************************************************************
     * Sanitize Functions
     ***********************************************************************************/

    function customize_sanitize_checkbox($input)
    {
        if ($input) {
            return 1;
        }
        return 0;
    }

    /***********************************************************************************/

    function customize_sanitize_social($input)
    {
        $valid = array(
            '' => esc_attr__(' ', 'customize'),
            '_self' => esc_attr__('_self', 'customize'),
            '_blank' => esc_attr__('_blank', 'customize'),
        );

        if (array_key_exists($input, $valid)) {
            return $input;
        } else {
            return '';
        }
    }

    /***********************************************************************************/

    function customize_sanitize_woo_cart($input)
    {
        $valid = array(
            '1' => esc_attr__('Activate WooCommerce Cart', 'customize'),
            '' => esc_attr__('Deactivate WooCommerce Cart', 'customize'),
            '2' => esc_attr__('Activate the cart only on the WooCommerce pages', 'customize'),
        );

        if (array_key_exists($input, $valid)) {
            return $input;
        } else {
            return '';
        }
    }

    /************************************  Customize Animations  ***********************************************/

    function customize_animations()
    {
        $array = array(
            'default0' => esc_attr__('Deactivate Animation', 'customize'),
            '' => esc_attr__('Default', 'customize'),
            'fadeIn' => esc_attr__('fadeIn', 'customize'),
            'flipInX' => esc_attr__('flipInX', 'customize'),
            'flip' => esc_attr__('flip', 'customize'),
            'flipInY' => esc_attr__('flipInY', 'customize'),
            'bounce' => esc_attr__('bounce', 'customize'),
            'bounceIn' => esc_attr__('bounceIn', 'customize'),
            'bounceInDown' => esc_attr__('bounceInDown', 'customize'),
            'bounceInLeft' => esc_attr__('bounceInLeft', 'customize'),
            'bounceInRight' => esc_attr__('bounceInRight', 'customize'),
            'bounceInUp' => esc_attr__('bounceInUp', 'customize'),
            'fadeInDownBig' => esc_attr__('fadeInDownBig', 'customize'),
            'fadeInLeft' => esc_attr__('fadeInLeft', 'customize'),
            'fadeInLeftBig' => esc_attr__('fadeInLeftBig', 'customize'),
            'fadeInRight' => esc_attr__('fadeInRight', 'customize'),
            'fadeInRightBig' => esc_attr__('fadeInRightBig', 'customize'),
            'fadeInUp' => esc_attr__('fadeInUp', 'customize'),
            'fadeInUpBig' => esc_attr__('fadeInUpBig', 'customize'),
            'flash' => esc_attr__('flash', 'customize'),
            'headShake' => esc_attr__('headShake', 'customize'),
            'hinge' => esc_attr__('hinge', 'customize'),
            'jello' => esc_attr__('jello', 'customize'),
            'lightSpeedIn' => esc_attr__('lightSpeedIn', 'customize'),
            'pulse' => esc_attr__('pulse', 'customize'),
            'rollIn' => esc_attr__('rollIn', 'customize'),
            'rotateIn' => esc_attr__('rotateIn', 'customize'),
            'rotateInDownLeft' => esc_attr__('rotateInDownLeft', 'customize'),
            'rotateInDownRight' => esc_attr__('rotateInDownRight', 'customize'),
            'rotateInUpLeft' => esc_attr__('rotateInUpLeft', 'customize'),
            'rotateInUpRight' => esc_attr__('rotateInUpRight', 'customize'),
            'shake' => esc_attr__('shake', 'customize'),
            'slideInDown' => esc_attr__('slideInDown', 'customize'),
            'slideInLeft' => esc_attr__('slideInLeft', 'customize'),
            'slideInRight' => esc_attr__('slideInRight', 'customize'),
            'slideInUp' => esc_attr__('slideInUp', 'customize'),
            'swing' => esc_attr__('swing', 'customize'),
            'tada' => esc_attr__('tada', 'customize'),
            'wobble' => esc_attr__('wobble', 'customize'),
            'zoomIn' => esc_attr__('zoomIn', 'customize'),
            'zoomInDown' => esc_attr__('zoomInDown', 'customize'),
            'zoomInLeft' => esc_attr__('zoomInLeft', 'customize'),
            'zoomInRight' => esc_attr__('zoomInRight', 'customize'),
            'zoomInUp' => esc_attr__('zoomInUp', 'customize'),
        );
        return $array;
    }

    function customize_sanitize_animations($input)
    {

        $valid = customize_animations();

        if (array_key_exists($input, $valid)) {
            return $input;
        } else {
            return '';
        }
    }

    /***********************************************************************************/
    function customize_my_fonts()
    {
        $array = array(
            '' => 'default',
            'Arial' => 'Arial',
            'Helvetica' => 'Helvetica',
            'Times New Roman' => 'Times New Roman',
            'Times' => 'Times',
            'Courier New' => 'Courier New',
            'Courier' => 'Courier',
            'Verdana' => 'Verdana',
            'Georgia' => 'Georgia',
            'Palatino' => 'Palatino',
            'Garamond' => 'Garamond',
            'Bookman' => 'Bookman',
            'Comic Sans MS' => 'Comic Sans MS',
            'Trebuchet MS' => 'Trebuchet MS',
            'Impact' => 'Impact'
        );
        return $array;
    }

    /***********************************************************************************/

    function customize_sanitize_fonts($input)
    {

        $valid = customize_my_fonts();

        if (array_key_exists($input, $valid)) {
            return $input;
        } else {
            return '';
        }
    }

    /***********************************************************************************/

    function customize_sanitize_home($input)
    {
        $valid = array(
            '' => esc_attr__(' ', 'customize'),
            '1' => esc_attr__('1 Column', 'customize'),
            '2' => esc_attr__('2 Columns', 'customize'),
            '3' => esc_attr__('1 Column No Sidebar', 'customize'),
            '4' => esc_attr__('2 Column No Sidebar', 'customize'),
        );

        if (array_key_exists($input, $valid)) {
            return $input;
        } else {
            return '';
        }
    }


    /********************************************
     * Theme Color Scheme
     *********************************************/

    $wp_customize->add_section('customize_color_scheme', array(
        'title' => __('Color Scheme', 'customize'),
        'priority' => 1,
    ));

    $wp_customize->add_setting('customize_theme_color_scheme', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'customize_theme_color_scheme', array(
        'label' => __('Color Scheme', 'customize'),
        'description' => '<div class="seos-help"><div class="arrow-faq"></div><img class="seos-img" src="' . CUSTOMIZE_THEME_URI . '/framework/images/faq.gif" /><img class="hidden-help" src="' . CUSTOMIZE_THEME_URI . '/framework/images/colors.jpg" /></div>' . __(' The option changes all of the default colors. Back to top button color, icons color, buttons color, sidebar title color and link hover color.', 'customize'),
        'section' => 'customize_color_scheme',
        'settings' => 'customize_theme_color_scheme'
    )));

    /***********************************************************************************
     * Home Page Columns
     ***********************************************************************************/

    $wp_customize->add_section('customize_home_columns', array(
        'title' => __('Home Page Columns', 'customize'),
        'priority' => 1,
    ));

    $wp_customize->add_setting('customize_homepage_columns', array(
        'sanitize_callback' => 'customize_sanitize_home',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_homepage_columns', array(
        'label' => __('Home Page Columns', 'customize'),
        'section' => 'customize_home_columns',
        'settings' => 'customize_homepage_columns',
        'type' => 'select',
        'choices' => array(
            '' => esc_attr__(' ', 'customize'),
            '1' => esc_attr__('1 Column', 'customize'),
            '2' => esc_attr__('2 Columns', 'customize'),
            '3' => esc_attr__('1 Column No Sidebar', 'customize'),
            '4' => esc_attr__('2 Column No Sidebar', 'customize'),
        ),
    )));

    /***********************************************************************************
     * Home Page Images
     ***********************************************************************************/


    $wp_customize->add_panel('customize_home_page_images_panel', array(
        'title' => __('Home Page Images', 'customize'),
        'priority' => 3,
    ));

    $wp_customize->add_section('customize_home_page_images_general', array(
        'title' => __('General ', 'customize'),
        'panel' => 'customize_home_page_images_panel',
        'priority' => 5,
    ));

    $wp_customize->add_setting('customize_img_activate_home', array(
        'default' => '',
        'sanitize_callback' => 'customize_sanitize_checkbox',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_img_activate_home', array(
        'label' => __('Dectivate Images on Home Page', 'customize'),
        'section' => 'customize_home_page_images_general',
        'settings' => 'customize_img_activate_home',
        'type' => 'checkbox',
    )));

    $wp_customize->add_setting('customize_img_activate_all', array(
        'default' => '',
        'sanitize_callback' => 'customize_sanitize_checkbox',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_img_activate_all', array(
        'label' => __('Dectivate Images on All Pages', 'customize'),
        'section' => 'customize_home_page_images_general',
        'settings' => 'customize_img_activate_all',
        'type' => 'checkbox',
    )));


    $wp_customize->add_section('customize_home_page_images_1', array(
        'title' => __('Home Page Images 1', 'customize'),
        'panel' => 'customize_home_page_images_panel',
        'priority' => 5,
    ));

    $wp_customize->add_setting('customize_home_image_1', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(
        new WP_Customize_Image_Control($wp_customize, 'customize_home_image_1',
            array(
                'label' => __('Home Page Image', 'customize'),
                'description' => __('Width:250px, Height:150px', 'customize'),
                'section' => 'customize_home_page_images_1',
                'settings' => 'customize_home_image_1',
            )
        )
    );

    $wp_customize->add_setting('customize_home_image_title_1', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_home_image_title_1', array(
        'section' => 'customize_home_page_images_1',
        'settings' => 'customize_home_image_title_1',
        'label' => __('Home Page Image Title', 'customize'),
        'type' => 'text'
    )));

    $wp_customize->add_setting('customize_home_image_url_1', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_home_image_url_1', array(
        'section' => 'customize_home_page_images_1',
        'settings' => 'customize_home_image_url_1',
        'label' => __('Home Page Image URL', 'customize'),
        'type' => 'url'
    )));


    /***********************************************************************************/

    $wp_customize->add_section('customize_home_page_images_2', array(
        'title' => __('Home Page Images 2', 'customize'),
        'panel' => 'customize_home_page_images_panel',
        'priority' => 5,
    ));

    $wp_customize->add_setting('customize_home_image_2', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(
        new WP_Customize_Image_Control($wp_customize, 'customize_home_image_2',
            array(
                'label' => __('Home Page Image', 'customize'),
                'description' => __('Width:250px, Height:150px', 'customize'),
                'section' => 'customize_home_page_images_2',
                'settings' => 'customize_home_image_2',
            )
        )
    );

    $wp_customize->add_setting('customize_home_image_title_2', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_home_image_title_2', array(
        'section' => 'customize_home_page_images_2',
        'settings' => 'customize_home_image_title_2',
        'label' => __('Home Page Image Title', 'customize'),
        'type' => 'text'
    )));

    $wp_customize->add_setting('customize_home_image_url_2', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_home_image_url_2', array(
        'section' => 'customize_home_page_images_2',
        'settings' => 'customize_home_image_url_2',
        'label' => __('Home Page Image URL', 'customize'),
        'type' => 'url'
    )));

    /***********************************************************************************/

    $wp_customize->add_section('customize_home_page_images_3', array(
        'title' => __('Home Page Images 3', 'customize'),
        'panel' => 'customize_home_page_images_panel',
        'priority' => 5,
    ));

    $wp_customize->add_setting('customize_home_image_3', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(
        new WP_Customize_Image_Control($wp_customize, 'customize_home_image_3',
            array(
                'label' => __('Home Page Image', 'customize'),
                'description' => __('Width:250px, Height:150px', 'customize'),
                'section' => 'customize_home_page_images_3',
                'settings' => 'customize_home_image_3',
            )
        )
    );

    $wp_customize->add_setting('customize_home_image_title_3', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_home_image_title_3', array(
        'section' => 'customize_home_page_images_3',
        'settings' => 'customize_home_image_title_3',
        'label' => __('Home Page Image Title', 'customize'),
        'type' => 'text'
    )));

    $wp_customize->add_setting('customize_home_image_url_3', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_home_image_url_3', array(
        'section' => 'customize_home_page_images_3',
        'settings' => 'customize_home_image_url_3',
        'label' => __('Home Page Image URL', 'customize'),
        'type' => 'url'
    )));


    /***********************************************************************************
     * Animations
     ***********************************************************************************/


    /************************************** Site Title Animation ******************************************/

    $wp_customize->add_panel('customize_premium_animations', array(
        'title' => __('Animations', 'customize'),
        'priority' => 4,
    ));

    $wp_customize->add_section('customize_premium_section_animations', array(
        'title' => __('Site Title Animation', 'customize'),
        'panel' => 'customize_premium_animations',
        'priority' => 4,
    ));

    $wp_customize->add_setting('customize_premium_site_title_animation', array(
        'sanitize_callback' => 'customize_sanitize_animations',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_premium_site_title_animation', array(
        'label' => __('Site Title Animation', 'customize'),
        'section' => 'customize_premium_section_animations',
        'settings' => 'customize_premium_site_title_animation',
        'type' => 'select',
        'choices' => customize_animations(),
    )));

    $wp_customize->add_setting('customize_premium_site_title_animation_speed', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_premium_site_title_animation_speed', array(
        'label' => __('Animation Speed:', 'customize'),
        'section' => 'customize_premium_section_animations',
        'settings' => 'customize_premium_site_title_animation_speed',
        'type' => 'range',
        'input_attrs' => array(
            'min' => 0.1,
            'max' => 5,
            'step' => 0.1,
        ),
    )));


    /************************************** Site Tagline Animation ******************************************/


    $wp_customize->add_section('customize_premium_section_description_animations', array(
        'title' => __('Site Tagline Animation', 'customize'),
        'panel' => 'customize_premium_animations',
        'priority' => 4,
    ));

    $wp_customize->add_setting('customize_premium_description_animation', array(
        'sanitize_callback' => 'customize_sanitize_animations',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_premium_description_animation', array(
        'label' => __('Site Tagline Animation', 'customize'),
        'section' => 'customize_premium_section_description_animations',
        'settings' => 'customize_premium_description_animation',
        'type' => 'select',
        'choices' => customize_animations(),
    )));

    $wp_customize->add_setting('customize_premium_description_animation_speed', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_premium_description_animation_speed', array(
        'label' => __('Animation Speed:', 'customize'),
        'section' => 'customize_premium_section_description_animations',
        'settings' => 'customize_premium_description_animation_speed',
        'type' => 'range',
        'input_attrs' => array(
            'min' => 0.1,
            'max' => 5,
            'step' => 0.1,
        ),
    )));

    /***********************************************************************************
     * Typography
     ***********************************************************************************/

    $wp_customize->add_panel('customize_typography_panel', array(
        'title' => __('Typography', 'customize'),
        'priority' => 5,
    ));


    $wp_customize->add_section('customize_typography_section', array(
        'title' => __('Fonts', 'customize'),
        'priority' => 64,
        'panel' => 'customize_typography_panel',
    ));

    $wp_customize->add_setting('customize_typography_title_fonts', array(
        'sanitize_callback' => 'customize_sanitize_fonts',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_typography_title_fonts', array(
        'section' => 'customize_typography_section',
        'settings' => 'customize_typography_title_fonts',
        'label' => __('Site Title Fonts', 'customize'),
        'type' => 'select',
        'choices' => customize_my_fonts(),
    )));


    $wp_customize->add_setting('customize_typography_tagline_fonts', array(
        'sanitize_callback' => 'customize_sanitize_fonts',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_typography_tagline_fonts', array(
        'section' => 'customize_typography_section',
        'label' => __('Site Tagline Fonts', 'customize'),
        'settings' => 'customize_typography_tagline_fonts',
        'type' => 'select',
        'choices' => customize_my_fonts(),
    )));


    $wp_customize->add_setting('customize_typography_menu_fonts', array(
        'sanitize_callback' => 'customize_sanitize_fonts',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_typography_menu_fonts', array(
        'section' => 'customize_typography_section',
        'label' => __('Menu Fonts', 'customize'),
        'settings' => 'customize_typography_menu_fonts',
        'type' => 'select',
        'choices' => customize_my_fonts(),
    )));

    $wp_customize->add_setting('customize_typography_contant_fonts', array(
        'sanitize_callback' => 'customize_sanitize_fonts',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_typography_contant_fonts', array(
        'section' => 'customize_typography_section',
        'label' => __('Contant Fonts', 'customize'),
        'settings' => 'customize_typography_contant_fonts',
        'type' => 'select',
        'choices' => customize_my_fonts(),
    )));

    $wp_customize->add_setting('customize_typography_headings_fonts', array(
        'sanitize_callback' => 'customize_sanitize_fonts',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_typography_headings_fonts', array(
        'section' => 'customize_typography_section',
        'label' => __('Headings Fonts', 'customize'),
        'settings' => 'customize_typography_headings_fonts',
        'type' => 'select',
        'choices' => customize_my_fonts(),
    )));

    /********************************************** Font Size ******************************************/

    $wp_customize->add_section('customize_font_size_section', array(
        'title' => __('Font Size', 'customize'),
        'priority' => 64,
        'panel' => 'customize_typography_panel',
    ));

    $wp_customize->add_setting('customize_typography_title_font_size', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_typography_title_font_size', array(
        'section' => 'customize_font_size_section',
        'settings' => 'customize_typography_title_font_size',
        'label' => __('Site Title Font Size', 'customize'),
        'type' => 'range',
        'input_attrs' => array(
            'min' => 10,
            'max' => 150,
            'step' => 1,
        ),
    )));


    /***********************************************************************************/

    $wp_customize->add_setting('customize_typography_tagline_font_size', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_typography_tagline_font_size', array(
        'section' => 'customize_font_size_section',
        'settings' => 'customize_typography_tagline_font_size',
        'label' => __('Site Tagline Font Size', 'customize'),
        'type' => 'range',
        'input_attrs' => array(
            'min' => 10,
            'max' => 150,
            'step' => 1,
        ),
    )));

    /***********************************************************************************/

    $wp_customize->add_setting('customize_typography_nav_font_size', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_typography_nav_font_size', array(
        'section' => 'customize_font_size_section',
        'settings' => 'customize_typography_nav_font_size',
        'label' => __('Menu Font Size', 'customize'),
        'type' => 'range',
        'input_attrs' => array(
            'min' => 10,
            'max' => 50,
            'step' => 1,
        ),
    )));

    /***********************************************************************************/

    $wp_customize->add_setting('customize_typography_contant_font_size', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_typography_contant_font_size', array(
        'section' => 'customize_font_size_section',
        'settings' => 'customize_typography_contant_font_size',
        'label' => __('Content Font Size', 'customize'),
        'type' => 'range',
        'input_attrs' => array(
            'min' => 10,
            'max' => 50,
            'step' => 1,
        ),
    )));

    /***********************************************************************************/

    $wp_customize->add_setting('customize_typography_sidebar_title_font_size', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_typography_sidebar_title_font_size', array(
        'section' => 'customize_font_size_section',
        'settings' => 'customize_typography_sidebar_title_font_size',
        'label' => __('Sidebar Title Font Size', 'customize'),
        'type' => 'range',
        'input_attrs' => array(
            'min' => 10,
            'max' => 50,
            'step' => 1,
        ),
    )));


    /***********************************************************************************/

    $wp_customize->add_setting('customize_typography_footer_title_font_size', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_typography_footer_title_font_size', array(
        'section' => 'customize_font_size_section',
        'settings' => 'customize_typography_footer_title_font_size',
        'label' => __('Footer Title Font Size', 'customize'),
        'type' => 'range',
        'input_attrs' => array(
            'min' => 10,
            'max' => 50,
            'step' => 1,
        ),
    )));
    /***********************************************************************************/

    $wp_customize->add_setting('customize_typography_h1_font_size', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_typography_h1_font_size', array(
        'section' => 'customize_font_size_section',
        'settings' => 'customize_typography_h1_font_size',
        'label' => __('H1 Font Size', 'customize'),
        'type' => 'range',
        'input_attrs' => array(
            'min' => 10,
            'max' => 50,
            'step' => 1,
        ),
    )));

    /***********************************************************************************/

    $wp_customize->add_setting('customize_typography_h2_font_size', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_typography_h2_font_size', array(
        'section' => 'customize_font_size_section',
        'settings' => 'customize_typography_h2_font_size',
        'label' => __('H2 Font Size', 'customize'),
        'type' => 'range',
        'input_attrs' => array(
            'min' => 10,
            'max' => 50,
            'step' => 1,
        ),
    )));

    /***********************************************************************************/

    $wp_customize->add_setting('customize_typography_h3_font_size', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_typography_h3_font_size', array(
        'section' => 'customize_font_size_section',
        'settings' => 'customize_typography_h3_font_size',
        'label' => __('H3 Font Size', 'customize'),
        'type' => 'range',
        'input_attrs' => array(
            'min' => 10,
            'max' => 50,
            'step' => 1,
        ),
    )));

    /***********************************************************************************/

    $wp_customize->add_setting('customize_typography_h4_font_size', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_typography_h4_font_size', array(
        'section' => 'customize_font_size_section',
        'settings' => 'customize_typography_h4_font_size',
        'label' => __('H4 Font Size', 'customize'),
        'type' => 'range',
        'input_attrs' => array(
            'min' => 10,
            'max' => 50,
            'step' => 1,
        ),
    )));

    /***********************************************************************************/

    $wp_customize->add_setting('customize_typography_h5_font_size', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_typography_h5_font_size', array(
        'section' => 'customize_font_size_section',
        'settings' => 'customize_typography_h5_font_size',
        'label' => __('H5 Font Size', 'customize'),
        'type' => 'range',
        'input_attrs' => array(
            'min' => 10,
            'max' => 50,
            'step' => 1,
        ),
    )));

    /***********************************************************************************/

    $wp_customize->add_setting('customize_typography_h6_font_size', array(
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_typography_h6_font_size', array(
        'section' => 'customize_font_size_section',
        'settings' => 'customize_typography_h6_font_size',
        'label' => __('H6 Font Size', 'customize'),
        'type' => 'range',
        'input_attrs' => array(
            'min' => 10,
            'max' => 50,
            'step' => 1,
        ),
    )));

    /***********************************************************************************
     * Social media option
     ***********************************************************************************/

    $wp_customize->add_section('customize_social_section', array(
        'title' => __('Social Media', 'customize'),
        'description' => __('Social media buttons', 'customize'),
        'priority' => 64,
    ));

    $wp_customize->add_setting('social_media_activate_header', array(
        'sanitize_callback' => 'customize_sanitize_checkbox',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'social_media_activate_header', array(
        'description' => '<div class="seos-help"><img class="seos-img" src="' . CUSTOMIZE_THEME_URI . '/framework/images/faq.gif" /><img class="hidden-help" src="' . CUSTOMIZE_THEME_URI . '/framework/images/social.jpg" /></div>' . __(' Check and activate header social icons.', 'customize'),
        'label' => __('Activate Header Social Icons:', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'social_media_activate_header',
        'type' => 'checkbox',
    )));

    $wp_customize->add_setting('social_media_activate', array(
        'sanitize_callback' => 'customize_sanitize_checkbox',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'social_media_activate', array(
        'label' => __('Activate Footer Social Icons:', 'customize'),
        'description' => '<div class="seos-help"><img class="seos-img" src="' . CUSTOMIZE_THEME_URI . '/framework/images/faq.gif" /><img class="hidden-help" src="' . CUSTOMIZE_THEME_URI . '/framework/images/f-social.jpg" /></div>' . __(' Check and activate footer social icons.', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'social_media_activate',
        'type' => 'checkbox',
    )));

    $wp_customize->add_setting('customize_social_link_type', array(
        'sanitize_callback' => 'customize_sanitize_social',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_social_link_type', array(
        'label' => __('Link Type', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_social_link_type',
        'type' => 'select',
        'choices' => array(
            '' => esc_attr__(' ', 'customize'),
            '_self' => esc_attr__('_self', 'customize'),
            '_blank' => esc_attr__('_blank', 'customize'),
        ),
    )));

    $wp_customize->add_setting('social_media_color', array(
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'social_media_color', array(
        'label' => __('Social Icons Color:', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'social_media_color',
    )));

    $wp_customize->add_setting('social_media_hover_color', array(
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'social_media_hover_color', array(
        'label' => __('Social Hover Icons Color:', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'social_media_hover_color',
    )));

    $wp_customize->add_setting('customize_facebook', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_facebook', array(
        'label' => __('Enter Facebook url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_facebook',
    )));

    $wp_customize->add_setting('customize_twitter', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_twitter', array(
        'label' => __('Enter Twitter url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_twitter',
    )));

    $wp_customize->add_setting('customize_google', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_google', array(
        'label' => __('Enter Google+ url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_google',
    )));

    $wp_customize->add_setting('customize_linkedin', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_linkedin', array(
        'label' => __('Enter Linkedin url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_linkedin',
    )));


    $wp_customize->add_setting('customize_rss', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_rss', array(
        'label' => __('Enter RSS url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_rss',
    )));

    $wp_customize->add_setting('customize_pinterest', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_pinterest', array(
        'label' => __('Enter Pinterest url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_pinterest',
    )));

    $wp_customize->add_setting('customize_youtube', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_youtube', array(
        'label' => __('Enter Youtube url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_youtube',
    )));

    $wp_customize->add_setting('customize_vimeo', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_vimeo', array(
        'label' => __('Enter Vimeo url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_vimeo',
    )));


    $wp_customize->add_setting('customize_instagram', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_instagram', array(
        'label' => __('Enter Ynstagram url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_instagram',
    )));

    $wp_customize->add_setting('customize_stumbleupon', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_stumbleupon', array(
        'label' => __('Enter Stumbleupon url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_stumbleupon',
    )));

    $wp_customize->add_setting('customize_flickr', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_flickr', array(
        'label' => __('Enter Flickr url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_flickr',
    )));


    $wp_customize->add_setting('customize_dribbble', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_dribbble', array(
        'label' => __('Enter Dribbble url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_dribbble',
    )));

    $wp_customize->add_setting('customize_digg', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_digg', array(
        'label' => __('Enter Digg url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_digg',
    )));

    $wp_customize->add_setting('customize_skype', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_skype', array(
        'label' => __('Enter Skype url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_skype',
    )));

    $wp_customize->add_setting('customize_deviantart', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_deviantart', array(
        'label' => __('Enter Deviantart url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_deviantart',
    )));

    $wp_customize->add_setting('customize_yahoo', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_yahoo', array(
        'label' => __('Enter Yahoo url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_yahoo',
    )));

    $wp_customize->add_setting('customize_reddit_alien', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_reddit_alien', array(
        'label' => __('Enter Reddit Alien url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_reddit_alien',
    )));


    $wp_customize->add_setting('customize_paypal', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_paypal', array(
        'label' => __('Enter Paypal url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_paypal',
    )));

    $wp_customize->add_setting('customize_dropbox', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_dropbox', array(
        'label' => __('Enter Dropbox url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_dropbox',
    )));

    $wp_customize->add_setting('customize_soundcloud', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_soundcloud', array(
        'label' => __('Enter Soundcloud url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_soundcloud',
    )));


    $wp_customize->add_setting('customize_vk', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_vk', array(
        'label' => __('Enter VK url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_vk',
    )));

    $wp_customize->add_setting('customize_envelope', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_envelope', array(
        'label' => __('Enter Envelope url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_envelope',
    )));

    $wp_customize->add_setting('customize_address_book', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_address_book', array(
        'label' => __('Enter Address Book url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_address_book',
    )));

    $wp_customize->add_setting('customize_address_apple', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_address_apple', array(
        'label' => __('Enter Apple url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_address_apple',
    )));

    $wp_customize->add_setting('customize_address_apple', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_address_amazon', array(
        'label' => __('Enter Amazon url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_address_amazon',
    )));

    $wp_customize->add_setting('customize_address_slack', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_address_slack', array(
        'label' => __('Enter Slack url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_address_slack',
    )));

    $wp_customize->add_setting('customize_address_slideshare', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_address_slideshare', array(
        'label' => __('Enter Slideshare url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_address_slideshare',
    )));

    $wp_customize->add_setting('customize_address_wikipedia', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_address_wikipedia', array(
        'label' => __('Enter Wikipedia url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_address_wikipedia',
    )));

    $wp_customize->add_setting('customize_address_wordpress', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_address_wordpress', array(
        'label' => __('Enter WordPress url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_address_wordpress',
    )));

    $wp_customize->add_setting('customize_address_odnoklassniki', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_address_odnoklassniki', array(
        'label' => __('Enter Odnoklassniki url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_address_odnoklassniki',
    )));

    $wp_customize->add_setting('customize_address_tumblr', array(
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_address_tumblr', array(
        'label' => __('Enter Tumblr url', 'customize'),
        'section' => 'customize_social_section',
        'settings' => 'customize_address_tumblr',
    )));


    /***********************************************************************************
     * Sidebar Options
     ***********************************************************************************/

    $wp_customize->add_section('customize_sidebar', array(
        'title' => __('Sidebar Options', 'customize'),
        'priority' => 64,
    ));

    $wp_customize->add_setting('customize_sidebar_width', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_sidebar_width', array(
        'label' => __('Sidebar Width:', 'customize'),
        'section' => 'customize_sidebar',
        'settings' => 'customize_sidebar_width',
        'type' => 'range',
        'input_attrs' => array(
            'min' => 10,
            'max' => 50,
            'step' => 1,
        ),
    )));

    $wp_customize->add_setting('customize_sidebar_position', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_sidebar_position', array(
        'label' => __('Sidebar Position', 'customize'),
        'section' => 'customize_sidebar',
        'settings' => 'customize_sidebar_position',
        'type' => 'radio',
        'choices' => array(
            '1' => __('Left', 'customize'),
            '2' => __('Right', 'customize'),
            '3' => __('No Sidebar', 'customize'),
        ),

    )));

    /***********************************************************************************
     * Contacts
     ***********************************************************************************/

    $wp_customize->add_section('customize_contacts', array(
        'title' => __('Header Contacts', 'customize'),
        'priority' => 1,
    ));

    $wp_customize->add_setting('customize_contacts_header_phone', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_contacts_header_phone', array(
        'label' => __('Phone Number', 'customize'),
        'description' => '<div class="seos-help"><div class="arrow-faq"></div><img class="seos-img" src="' . CUSTOMIZE_THEME_URI . '/framework/images/faq.gif" /><img class="hidden-help" src="' . CUSTOMIZE_THEME_URI . '/framework/images/phone.jpg" /></div>' . __('  Add content and activate the phone.', 'customize'),

        'section' => 'customize_contacts',
        'settings' => 'customize_contacts_header_phone',
        'type' => 'text'
    )));


    $wp_customize->add_setting('customize_contacts_header_address', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_contacts_header_address', array(
        'label' => __('Address', 'customize'),
        'description' => '<div class="seos-help"><div class="arrow-faq"></div><img class="seos-img" src="' . CUSTOMIZE_THEME_URI . '/framework/images/faq.gif" /><img class="hidden-help" src="' . CUSTOMIZE_THEME_URI . '/framework/images/address.jpg" /></div>' . __(' Add content and activate the address.', 'customize'),

        'section' => 'customize_contacts',
        'settings' => 'customize_contacts_header_address',
        'type' => 'text'
    )));

    /********************************************
     * Sidebar Title Background
     *********************************************/

    $wp_customize->add_setting('customize_aside_background_color', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'customize_aside_background_color', array(
        'label' => __('Sidebar Title Background Color', 'customize'),
        'section' => 'customize_sidebar',
        'settings' => 'customize_aside_background_color'
    )));

    /********************************************
     * Sidebar Title Color
     *********************************************/

    $wp_customize->add_setting('customize_aside_title_color', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'customize_aside_title_color', array(
        'label' => __('Sidebar Title Color', 'customize'),
        'section' => 'customize_sidebar',
        'settings' => 'customize_aside_title_color'
    )));

    /********************************************
     * Sidebar Background
     *********************************************/

    $wp_customize->add_setting('customize_aside_background_color1', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'customize_aside_background_color1', array(
        'label' => __('Sidebar Background Color', 'customize'),
        'section' => 'customize_sidebar',
        'settings' => 'customize_aside_background_color1'
    )));

    /********************************************
     * Sidebar Link Color
     *********************************************/

    $wp_customize->add_setting('customize_aside_link_color', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'customize_aside_link_color', array(
        'label' => __('Sidebar Link Color', 'customize'),
        'section' => 'customize_sidebar',
        'settings' => 'customize_aside_link_color'
    )));

    /********************************************
     * Sidebar Link Hover Color
     *********************************************/

    $wp_customize->add_setting('customize_aside_link_hover_color', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'customize_aside_link_hover_color', array(
        'label' => __('Sidebar Link Hover Color', 'customize'),
        'section' => 'customize_sidebar',
        'settings' => 'customize_aside_link_hover_color'
    )));

    /***********************************************************************************
     * Disable Options
     ***********************************************************************************/

    $wp_customize->add_section('customize_disable_section', array(
        'title' => __('Disable Options', 'customize'),
        'priority' => 94,
    ));

    $wp_customize->add_setting('customize_disable_comment_link', array(
        'sanitize_callback' => 'customize_sanitize_checkbox',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_disable_comment_link', array(
        'label' => __('Disable Comments Link:', 'customize'),
        'section' => 'customize_disable_section',
        'settings' => 'customize_disable_comment_link',
        'type' => 'checkbox',
    )));

    $wp_customize->add_setting('customize_disable_entry_date', array(
        'sanitize_callback' => 'customize_sanitize_checkbox',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_disable_entry_date', array(
        'label' => __('Disable Entry Date:', 'customize'),
        'section' => 'customize_disable_section',
        'settings' => 'customize_disable_entry_date',
        'type' => 'checkbox',
    )));

    $wp_customize->add_setting('customize_disable_author', array(
        'sanitize_callback' => 'customize_sanitize_checkbox',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_disable_author', array(
        'label' => __('Disable Author:', 'customize'),
        'section' => 'customize_disable_section',
        'settings' => 'customize_disable_author',
        'type' => 'checkbox',
    )));

    $wp_customize->add_setting('customize_disable_tags_links', array(
        'sanitize_callback' => 'customize_sanitize_checkbox',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_disable_tags_links', array(
        'label' => __('Disable Tags Links:', 'customize'),
        'section' => 'customize_disable_section',
        'settings' => 'customize_disable_tags_links',
        'type' => 'checkbox',
    )));


    $wp_customize->add_setting('customize_disable_single_post_title', array(
        'sanitize_callback' => 'customize_sanitize_checkbox',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_disable_single_post_title', array(
        'label' => __('Disable Single Post Title:', 'customize'),
        'section' => 'customize_disable_section',
        'settings' => 'customize_disable_single_post_title',
        'type' => 'checkbox',
    )));

    $wp_customize->add_setting('customize_disable_single_page_title', array(
        'sanitize_callback' => 'customize_sanitize_checkbox',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_disable_single_page_title', array(
        'label' => __('Disable Single Page Title:', 'customize'),
        'section' => 'customize_disable_section',
        'settings' => 'customize_disable_single_page_title',
        'type' => 'checkbox',
    )));


    /***********************************************************************************
     * WooCommerce Cart Options
     ***********************************************************************************/

    $wp_customize->add_section('customize_woo_cart', array(
        'title' => __('WooCommerce Cart Options', 'customize'),
        'description' => __('WooCommerce is a free eCommerce plugin that allows you to sell anything, beautifully. Built to integrate seamlessly with WordPress, WooCommerce is the worlds favorite eCommerce solution that gives both store owners and developers complete control. Before using woocommerce cart options you need install WooCommerce. <a target="_blank" href="https://wordpress.org/plugins/woocommerce/">Download here.</a><br />', 'customize'),

        'priority' => 94,
    ));

    $wp_customize->add_setting('customize_woo_cart_activate', array(
        'sanitize_callback' => 'customize_sanitize_woo_cart',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_woo_cart_activate', array(
        'label' => __('Activate WooCommerce Cart', 'customize'),
        'section' => 'customize_woo_cart',
        'settings' => 'customize_woo_cart_activate',
        'type' => 'select',
        'choices' => array(
            '1' => esc_attr__('Activate WooCommerce Cart', 'customize'),
            '' => esc_attr__('Deactivate WooCommerce Cart', 'customize'),
            '2' => esc_attr__('Activate the cart only on the WooCommerce pages', 'customize'),
        ),
    )));

    $wp_customize->add_setting('customize_activate_blinker', array(
        'sanitize_callback' => 'customize_sanitize_checkbox',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_activate_blinker', array(
        'label' => __('When the cart is not empty activate blinker.', 'customize'),
        'section' => 'customize_woo_cart',
        'settings' => 'customize_activate_blinker',
        'type' => 'checkbox',
    )));

    /***********************************************************************************
     * Back to top button
     ***********************************************************************************/

    $wp_customize->add_section('customize_to_top_section', array(
        'title' => __('Back to top button', 'customize'),
        'priority' => 94,
    ));

    $wp_customize->add_setting('customize_activate_to_top', array(
        'sanitize_callback' => 'customize_sanitize_checkbox',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_activate_to_top', array(
        'label' => __('Deactivate back to top button:', 'customize'),
        'section' => 'customize_to_top_section',
        'settings' => 'customize_activate_to_top',
        'type' => 'checkbox',
    )));

    $wp_customize->add_setting('customize_to_top_text', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_to_top_text', array(
        'label' => __('Back to top button text:', 'customize'),
        'section' => 'customize_to_top_section',
        'settings' => 'customize_to_top_text',
        'type' => 'text',
    )));


    /********************************************
     * Footer Options
     *********************************************/

    $wp_customize->add_section('footer_options', array(
        'title' => __('Footer Options', 'customize'),
        'priority' => 70,
    ));

    /********************************************* Footer Background *********************************************/

    $wp_customize->add_setting('customize_premium_footer_background', array(
        'default' => ' ',
        'sanitize_callback' => 'sanitize_hex_color'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'customize_premium_footer_background', array(
        'label' => __('Footer Background', 'customize'),
        'section' => 'footer_options',
        'settings' => 'customize_premium_footer_background'
    )));

    /******************************************** Footer Colors *********************************************/

    $wp_customize->add_setting('customize_premium_footer_color', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'customize_premium_footer_color', array(
        'label' => __('Footer Color', 'customize'),
        'section' => 'footer_options',
        'settings' => 'customize_premium_footer_color'
    )));

    /********************************************* Footer Hover Color *********************************************/

    $wp_customize->add_setting('customize_premium_footer_hover_color', array(
        'default' => ' ',
        'sanitize_callback' => 'sanitize_hex_color'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'customize_premium_footer_hover_color', array(
        'label' => __('Footer Hover Color', 'customize'),
        'section' => 'footer_options',
        'settings' => 'customize_premium_footer_hover_color'
    )));

    /******************************************** Footer Title Color ********************************************/

    $wp_customize->add_setting('customize_premium_footer_title_color', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'customize_premium_footer_title_color', array(
        'label' => __('Footer Title Color', 'customize'),
        'section' => 'footer_options',
        'settings' => 'customize_premium_footer_title_color'
    )));

    /******************************************** Footer Deactivat *********************************************/


    $wp_customize->add_setting('customize_premium_copyright1', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses'
    ));
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize, 'customize_premium_copyright1', array(
                'label' => __('Custom Copyright Text', 'customize'),
                'section' => 'footer_options',
                'settings' => 'customize_premium_copyright1',
                'type' => 'textarea'
            )
        )
    );
}
add_action('customize_register', 'customize_customize_register');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function customize_customize_preview_js()
{
    wp_enqueue_script('customize_customizer', get_template_directory_uri() . '/framework/js/customizer.js', array('customize-preview'), '20151215', true);
}

add_action('customize_preview_init', 'customize_customize_preview_js');


function customize_customize_all_css()
{
    ?>
    <style type="text/css">

        <?php if ( get_theme_mod('custom_header_position') == "deactivate") { ?>
        .site-header {
            display: none;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_aside_background_color')) { ?>#content aside h2 {
            background: <?php echo esc_attr (get_theme_mod('customize_aside_background_color')); ?> !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_aside_background_color1')) { ?>#content aside ul, #content .widget {
            background: <?php echo esc_attr (get_theme_mod('customize_aside_background_color1')); ?>;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_aside_title_color')) { ?>#content aside h2 {
            color: <?php echo esc_attr (get_theme_mod('customize_aside_title_color')); ?>;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_aside_link_color')) { ?>#content aside a {
            color: <?php echo esc_attr (get_theme_mod('customize_aside_link_color')); ?>;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_aside_link_hover_color')) { ?>#content aside a:hover {
            color: <?php echo esc_attr (get_theme_mod('customize_aside_link_hover_color')); ?>;
        }

        <?php } ?>

        <?php if(get_theme_mod('social_media_color')) { ?>
        .social .fa-icons i {
            color: <?php echo esc_attr (get_theme_mod('social_media_color')); ?> !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('social_media_hover_color')) { ?>
        .social .fa-icons i:hover {
            color: <?php echo esc_attr (get_theme_mod('social_media_hover_color')); ?> !important;
        }

        <?php } ?>

        <?php if(get_theme_mod('customize_titles_setting_1')) { ?>
        .single-title, .sr-no-sidebar .entry-title, .full-p .entry-title {
            display: none !important;
        }

        <?php } ?>

        <?php if(get_theme_mod('customize_typography_title_fonts',false)) { ?>
        header .site-title a {
            font-family: '<?php echo get_theme_mod('customize_typography_title_fonts'); ?>', sans-serif !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_typography_tagline_fonts',false)) { ?>
        header .site-description {
            font-family: '<?php echo get_theme_mod('customize_typography_tagline_fonts'); ?>', sans-serif !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_typography_menu_fonts',false)) { ?>
        .main-navigation ul li a {
            font-family: '<?php echo get_theme_mod('customize_typography_menu_fonts'); ?>', sans-serif !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_typography_contant_fonts',false)) { ?>
        body, button, input, select, textarea, a, article header, article header h1, article header, .tags-links a, .tags-links {
            font-family: '<?php echo get_theme_mod('customize_typography_contant_fonts'); ?>', sans-serif !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_typography_headings_fonts',false)) { ?>
        h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
            font-family: '<?php echo get_theme_mod('customize_typography_headings_fonts'); ?>', sans-serif !important;
        }

        <?php } ?>


        <?php if(get_theme_mod('customize_typography_title_font_size')) { ?>
        header .site-title a {
            font-size: <?php echo get_theme_mod('customize_typography_title_font_size'); ?>px !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_typography_tagline_font_size')) { ?>
        header .site-branding .site-description {
            font-size: <?php echo get_theme_mod('customize_typography_tagline_font_size'); ?>px !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_typography_nav_font_size')) { ?>
        .main-navigation ul li a {
            font-size: <?php echo get_theme_mod('customize_typography_nav_font_size'); ?>px !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_typography_contant_font_size')) { ?>
        article p {
            font-size: <?php echo get_theme_mod('customize_typography_contant_font_size'); ?>px !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_typography_sidebar_title_font_size')) { ?>
        #content aside h2 {
            font-size: <?php echo get_theme_mod('customize_typography_sidebar_title_font_size'); ?>px !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_typography_footer_title_font_size')) { ?>
        footer .footer-widgets .widget-title {
            font-size: <?php echo get_theme_mod('customize_typography_footer_title_font_size'); ?>px !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_typography_h1_font_size')) { ?>
        h1, h1 a {
            font-size: <?php echo get_theme_mod('customize_typography_h1_font_size'); ?>px !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_typography_h2_font_size')) { ?>
        h2, h2 a {
            font-size: <?php echo get_theme_mod('customize_typography_h2_font_size'); ?>px !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_typography_h3_font_size')) { ?>
        h3, h3 a {
            font-size: <?php echo get_theme_mod('customize_typography_h2_font_size'); ?>px !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_typography_h4_font_size')) { ?>
        h4, h4 a {
            font-size: <?php echo get_theme_mod('customize_typography_h2_font_size'); ?>px !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_typography_h5_font_size')) { ?>
        h5, h5 a {
            font-size: <?php echo get_theme_mod('customize_typography_h2_font_size'); ?>px !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_typography_h6_font_size')) { ?>
        h6, h6 a {
            font-size: <?php echo get_theme_mod('customize_typography_h2_font_size'); ?>px !important;
        }

        <?php } ?>


        <?php if(get_theme_mod('customize_disable_comment_link')) { ?>
        .comments-link, .entry-footer .fa-comment {
            display: none;
        !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_disable_entry_date')) { ?>
        .posted-on {
            display: none;
        !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_disable_author')) { ?>
        .entry-meta .author, .entry-meta .byline {
            display: none;
        !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_disable_single_post_title')) { ?>
        .app-post .entry-header .entry-title, .sr-no-sidebar .entry-title, .seos-full-width .entry-title {
            display: none;
        !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_disable_single_page_title')) { ?>
        .app-page .entry-header .entry-title {
            display: none;
        !important;
        }

        <?php } ?>


        <?php if(get_theme_mod('customize_disable_tags_links')) { ?>
        .tags-links {
            display: none;
        !important;
        }

        <?php } ?>

        <?php if(get_theme_mod('customize_premium_footer_background')) { ?>
        #seos-footer, .footer-center, #colophon {
            background: <?php echo get_theme_mod('customize_premium_footer_background'); ?> !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_premium_footer_color')) { ?>#seos-footer, .site-footer a, .footer-widgets a, .site-info a, .footer-center, .footer-center a, #colophon a, #colophon {
            color: <?php echo get_theme_mod('customize_premium_footer_color'); ?> !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_premium_footer_hover_color')) { ?>#seos-footer a:hover, .footer-center a:hover, #colophon a:hover {
            color: <?php echo get_theme_mod('customize_premium_footer_hover_color'); ?> !important;
        }

        <?php } ?>
        <?php if(get_theme_mod('customize_premium_footer_title_color')) { ?>#seos-footer .widget-title, .footer-center .widget-title {
            color: <?php echo get_theme_mod('customize_premium_footer_title_color'); ?> !important;
        }

        <?php } ?>
    </style>

    <?php
}

add_action('wp_head', 'customize_customize_all_css');

/**************************************
 * Sidebar Options
 **************************************/


function customize_sidebar_width()
{
    if (get_theme_mod('customize_sidebar_width')) {

        $customize_content_width = 96;
        $customize_sidebar_width = esc_attr(get_theme_mod('customize_sidebar_width'));
        $customize_sidebar_sum = $customize_content_width - $customize_sidebar_width;

        ?>
        <style>
            #content aside {
                width: <?php echo esc_attr(get_theme_mod('customize_sidebar_width')); ?>% !important;
            }

            #content main {
                width: <?php echo esc_attr($customize_sidebar_sum); ?>% !important;
            }
        </style>

    <?php }
}

add_action('wp_head', 'customize_sidebar_width');


/*********************************************************************************************************
 * Sidebar Position
 **********************************************************************************************************/

function customize_sidebar()
{
    $option_sidebar = get_theme_mod('customize_sidebar_position');
    if ($option_sidebar == '2') {
        wp_enqueue_style('seos-right-sidebar', get_template_directory_uri() . '/css/right-sidebar.css');
    }

    $option_sidebar = get_theme_mod('customize_sidebar_position');
    if ($option_sidebar == '3') {
        wp_enqueue_style('seos-no-sidebar', get_template_directory_uri() . '/css/no-sidebar.css');
    }
}

add_action('wp_enqueue_scripts', 'customize_sidebar');


function customize_customize_customize_styles_seos($input)
{ ?>
    <style type="text/css">
        #customize-theme-controls #accordion-panel-customize_buy_panel .accordion-section-title,
        #customize-theme-controls #accordion-panel-customize_buy_panel > .accordion-section-title {
            background: #562B0C;
            color: #FFFFFF;
            box-shadow: inset 0 0 0 #333333, inset 0 13px 28px #333333, inset 0 0 0 #333333;
        }

        #customize-theme-controls #accordion-panel-customize_buy_panel .accordion-section-title:hover {
            color: #eee;
            box-shadow: inset 0 0 0 #333333, inset 13 -13px 18px #333333, inset 0 0 0 #333333;
        }

        .seos-info button a {
            color: #FFFFFF;
        }

        #customize-theme-controls #accordion-section-customize_buy_section .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section1 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section2 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section3 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section4 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section5 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section6 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section7 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section8 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section9 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section10 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section11 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section12 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section13 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section14 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section15 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section16 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section17 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section18 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section19 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section20 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section21 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section22 .accordion-section-title:after,
        #customize-theme-controls #accordion-section-customize_buy_section23 .accordion-section-title:after {
            font-size: 13px;
            font-weight: bold;
            content: "Premium";
            float: right;
            right: 40px;
            position: relative;
            color: #FF0000;
        }

        #_customize-input-seos_setting0, #customize-control-seos_setting0 {
            display: none !important;
        }

        #customize-theme-controls option[value="Arial"] {
            font-family: 'Arial', sans-serif;
        }

        #customize-theme-controls option[value="Helvetica"] {
            font-family: 'Helvetica', sans-serif;
        }

        #customize-theme-controls option[value="Times New Roman"] {
            font-family: 'Times New Roman', sans-serif;
        }

        #customize-theme-controls option[value="Times"] {
            font-family: 'Times', sans-serif;
        }

        #customize-theme-controls option[value="Courier New"] {
            font-family: 'Courier New', sans-serif;
        }

        #customize-theme-controls option[value="Courier"] {
            font-family: 'Courier', sans-serif;
        }

        #customize-theme-controls option[value="Verdana"] {
            font-family: 'Verdana', sans-serif;
        }

        #customize-theme-controls option[value="Georgia"] {
            font-family: 'Georgia', sans-serif;
        }

        #customize-theme-controls option[value="Palatino"] {
            font-family: 'Palatino', sans-serif;
        }

        #customize-theme-controls option[value="Garamond"] {
            font-family: 'Garamond', sans-serif;
        }

        #customize-theme-controls option[value="Garamond"] {
            font-family: 'Garamond', sans-serif;
        }

        #customize-theme-controls option[value="Bookman"] {
            font-family: 'Bookman', sans-serif;
        }

        #customize-theme-controls option[value="Comic Sans MS"] {
            font-family: 'Comic Sans MS', sans-serif;
        }

        #customize-theme-controls option[value="Trebuchet MS"] {
            font-family: 'Trebuchet MS', sans-serif;
        }

        #customize-theme-controls option[value="Impact"] {
            font-family: 'Impact', sans-serif;
        }


        .hidden-help {
            display: none;
        }

        .seos-img {
            width: 20px;
            height: 20px;
        }

        .seos-help {
            position: relative;
            display: inline;
        }

        .seos-help:hover .seos-img {
            opacity: 0.7;
        }

        .seos-help:hover .hidden-help {
            display: block;
            border: 8px solid #333;
            position: fixed;
            top: 180px;
            left: 100px;
            z-index: 99999999999;
            margin-left: 200px;

        }

        .arrow-faq {
            display: none;
        }

        .seos-help:hover .arrow-faq {
            position: absolute;
            width: 50px;
            height: 50px;
            background: #333;
            display: inline-block;
            -ms-transform: rotate(45deg); /* IE 9 */
            -webkit-transform: rotate(45deg); /* Chrome, Safari, Opera */
            transform: rotate(45deg);
            left: 277px;
            margin-top: 35px;
        }


        .customize-control-range input {
            -webkit-appearance: none;
            width: 100%;
            height: 25px;
            background: #d3d3d3;
            outline: none;
            opacity: 0.7;
            -webkit-transition: .2s;
            transition: opacity .2s;
        }

        .customize-control-range input:hover {
            opacity: 1;
        }

        .customize-control-range input::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 25px;
            height: 25px;
            background: #4CAF50;
            cursor: pointer;
        }

        .customize-control-range input::-moz-range-thumb {
            width: 25px;
            height: 25px;
            background: #4CAF50;
            cursor: pointer;
        }

    </style>
<?php }

add_action('customize_controls_print_styles', 'customize_customize_customize_styles_seos');


/************************************** Color Scheme CSS ****************************************/

function customize_color_scheme()
{
    if (get_theme_mod('customize_theme_color_scheme')) { ?>

        <style type="text/css">

            #totop {
                background: <?php echo get_theme_mod('customize_theme_color_scheme'); ?>;
            }

            #content aside h2 {
                background: <?php echo get_theme_mod('customize_theme_color_scheme'); ?>;
            }

            article .fa {
                color: <?php echo get_theme_mod('customize_theme_color_scheme'); ?>;
            }

            a:hover {
                color: <?php echo get_theme_mod('customize_theme_color_scheme'); ?>;
            }

            input[type="submit"] {
                background: <?php echo get_theme_mod('customize_theme_color_scheme'); ?>;
            }

            .social .fa-icons i:hover {
                color: <?php echo get_theme_mod('customize_theme_color_scheme'); ?>;
            }

            .pagination a, .pagination span {
                background-color: <?php echo get_theme_mod('customize_theme_color_scheme'); ?>;
            }

        </style>

        <?php
    }
}

add_action('wp_head', 'customize_color_scheme');