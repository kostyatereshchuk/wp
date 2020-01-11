<?php


/**
 * Adds Theme Customizer fields.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mytheme_customize_register($wp_customize)
{
    $wp_customize->add_section('customize_test_section', array(
        'title' => __('Test section', 'customize'),
        'description' => __('Test section description', 'customize'),
        'priority' => 64,
    ));


    $wp_customize->add_setting('customize_test_image');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'customize_test_image',
        array(
            'label' => 'Test image',
            'section' => 'customize_test_section',
            'settings' => 'customize_test_image',
        )));


    $wp_customize->add_setting('customize_test_color', array(
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'customize_test_color', array(
        'label' => __('Test Color:', 'customize'),
        'section' => 'customize_test_section',
        'settings' => 'customize_test_color',
    )));

    $wp_customize->add_setting('customize_test_text', array(
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_test_text', array(
        'label' => __('Test text', 'customize'),
        'section' => 'customize_test_section',
        'settings' => 'customize_test_text',
    )));

    $wp_customize->add_setting('customize_test_textarea', array(
        'default' => '',
        'sanitize_callback' => 'wp_kses'
    ));
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize, 'customize_premium_copyright1', array(
                'label' => __('Test textarea', 'customize'),
                'section' => 'customize_test_section',
                'settings' => 'customize_test_textarea',
                'type' => 'textarea'
            )
        )
    );

    $wp_customize->add_setting('customize_test_select', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_test_select', array(
        'label' => __('Test select', 'customize'),
        'section' => 'customize_test_section',
        'settings' => 'customize_test_select',
        'type' => 'select',
        'choices' => array(
            '' => esc_attr__(' ', 'customize'),
            'option 1' => esc_attr__('Option 1', 'customize'),
            'option 2' => esc_attr__('Option 2', 'customize'),
        ),
    )));

    $wp_customize->add_setting('customize_test_radio', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_test_radio', array(
        'label' => __('Test radio', 'customize'),
        'section' => 'customize_test_section',
        'settings' => 'customize_test_radio',
        'type' => 'radio',
        'choices' => array(
            '1' => __('Option 1', 'customize'),
            '2' => __('Option 2', 'customize'),
            '3' => __('Option 3', 'customize'),
        ),
    )));

    function mytheme_customize_sanitize_checkbox($input)
    {
        if ($input) {
            return 1;
        }

        return 0;
    }

    $wp_customize->add_setting('customize_test_checkbox', array(
        'sanitize_callback' => 'mytheme_customize_sanitize_checkbox',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'customize_test_checkbox', array(
        'label' => __('Customize test checkbox:', 'customize'),
        'description' => 'Test description',
        'section' => 'customize_test_section',
        'settings' => 'customize_test_checkbox',
        'type' => 'checkbox',
    )));

}

add_action('customize_register', 'mytheme_customize_register');
