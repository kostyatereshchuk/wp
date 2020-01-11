<?php if( ! defined( 'ABSPATH' ) ) exit;
/**
 * Sample implementation of the Custom Header feature.
 *
 */
function customize_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'customize_custom_header_args', array(
		'default-image' => get_template_directory_uri() . '/framework/images/header.jpg',	
		'default-text-color'     => 'fff',
		'width'                  => 1135,
		'height'                 => 600,
		'flex-height'            => true,
		'flex-width'            => true,
		'wp-head-callback'       => 'customize_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'customize_custom_header_setup' );

register_default_headers( array(
    'img1' => array(
        'url'           => get_stylesheet_directory_uri() . '/framework/images/header.jpg',
        'thumbnail_url' => get_stylesheet_directory_uri() . '/framework/images/header.jpg',
        'description'   => esc_html__( 'Default Image 1', 'customize' )
    ),	
	
    'img2' => array(
        'url'           => get_stylesheet_directory_uri() . '/framework/images/header.gif',
        'thumbnail_url' => get_stylesheet_directory_uri() . '/framework/images/header.gif',
        'description'   => esc_html__( 'Default Image 2', 'customize' )
    ),

));

if ( ! function_exists( 'customize_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @see customize_custom_header_setup().
 */
function customize_header_style() {
	$customize_header_text_color = get_header_textcolor();

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
		<?php
			// Has the text been hidden?
			if ( ! display_header_text() ) :
		?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
			.site-title,
			.site-description {
				display: none !important;
			}
		<?php
			// If the user has set a custom color for the text use that.
			else :
		?>
			header .site-branding .site-title a, header .header-img .site-title a, header .header-img .site-description,
			header  .site-branding .site-description {
				color: #<?php echo esc_attr( $customize_header_text_color ); ?>;
			}
		<?php endif; ?>
	</style>
	<?php
}
endif;

/**
 * Custom Header Options
 */

add_action( 'customize_register', 'customize_customize_custom_header_meta' );

function customize_customize_custom_header_meta($wp_customize ) {
	
    $wp_customize->add_setting(
        'custom_header_position',
        array(
			'priority'   => 1,
            'default'    => 'default',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'customize_sanitize_select',			
        )
    );

    $wp_customize->add_control(
        'custom_header_position',
        array(
            'settings' => 'custom_header_position',	
			'priority'    => 1,
            'label'    => __( 'Activate Header Image:', 'customize' ),
            'section'  => 'header_image',
            'type'     => 'select',
            'choices'  => array(
                'deactivate' => __( 'Deactivate Header Image', 'customize' ),
                'default' => __( 'Default Image', 'customize' ),
                'all' => __( 'All Pages', 'customize' ),
                'home'  => __( 'Home Page', 'customize' )
            ),
			'default'    => 'deactivate'
        )
    );
	
    $wp_customize->add_setting(
        'custom_header_overlay',
        array(
            'default'    => 'on',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'customize_sanitize_overlay',			
        )
    );

    $wp_customize->add_control(
        'custom_header_overlay',
        array(
            'settings' => 'custom_header_overlay',
			'priority'    => 1,			
            'label'    => __( 'Hide Overlay:', 'customize' ),
            'section'  => 'header_image',
            'type'     => 'select',
            'choices'  => array(
                '' => __( ' ', 'customize' ),
                'on' => __( 'Show Overlay', 'customize' ),
                'off'  => __( 'Hide Overlay', 'customize' )
            ),
			'default'    => 'on'
        )
    );

	$wp_customize->add_setting( 'header_image_full_width', array(
		'default' => '',
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'customize_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'header_image_full_width', array(
		'type' => 'checkbox',
		'priority' => 1,
		'section' => 'header_image',
		'label' => __( 'Activate Width 100%: ', 'customize' ),
	) );
	
	$wp_customize->add_setting( 'header_height', array(
		'default' => '',
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'header_height', array(
		'type' => 'number',
		'priority' => 1,
		'section' => 'header_image',
		'label' => __( 'Custom Height: ', 'customize' ),
		'description' => __( 'Min-height 200px.', 'customize' ),
		'input_attrs' => array(
			'min' => 200,
			'max' => 1000,
			'step' => 1,
		),
	) );
	
    $wp_customize->add_setting(
        'custom_header_background_attachment',
        array(
            'default'    => '',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'customize_sanitize_background_attachment',			
        )
    );

    $wp_customize->add_control(
        'custom_header_background_attachment',
        array(
            'settings' => 'custom_header_background_attachment',	
			'priority'    => 1,
            'label'    => __( 'Background Attachment:', 'customize' ),
            'section'  => 'header_image',
            'type'     => 'select',
            'choices'  => array(
                ' ' => __( ' ', 'customize' ),
                'inherit' => __( 'Inherit', 'customize' ),
                'fixed' => __( 'Fixed', 'customize' )
            ),
			'default'    => ''
        )
    );
	
    $wp_customize->add_setting(
        'custom_header_background_size',
        array(
            'default'    => 'cover',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'customize_sanitize_background_size',			
        )
    );

    $wp_customize->add_control(
        'custom_header_background_size',
        array(
            'settings' => 'custom_header_background_size',	
			'priority'    => 1,
            'label'    => __( 'Background Size:', 'customize' ),
            'section'  => 'header_image',
            'type'     => 'select',
            'choices'  => array(
                'auto' => __( 'Auto', 'customize' ),
                'cover' => __( 'Cover', 'customize' ),
                'contain, cover' => __( 'Contain, Cover', 'customize' ),
                'contain' => __( 'Contain', 'customize' ),
                'initial' => __( 'Initial', 'customize' ),
                '50% 50%' => __( '50% 50%', 'customize' ),
                '100% 50%' => __( '100% 50%', 'customize' ),
                '50% 100%' => __( '50% 100%', 'customize' ),
                '100% 100%' => __( '100% 100%', 'customize' ),
            ),
			'default'    => 'cover'
        )
    );
	
    $wp_customize->add_setting(
        'custom_header_background_position',
        array(
            'default'    => 'inherit',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'customize_sanitize_background_position',			
        )
    );

    $wp_customize->add_control(
        'custom_header_background_position',
        array(
            'settings' => 'custom_header_background_position',	
			'priority'    => 1,
            'label'    => __( 'Background Position:', 'customize' ),
            'section'  => 'header_image',
            'type'     => 'select',
            'choices'  => array(
                'initial' => __( 'initial', 'customize' ),
                'left top' => __( 'left top', 'customize' ),
                'left center' => __( 'left center', 'customize' ),
                'left bottom' => __( 'left bottom', 'customize' ),
                'right top' => __( 'right top', 'customize' ),
                'right bottom' => __( 'right bottom', 'customize' ),
                'right center' => __( 'right center', 'customize' ),
                'center top' => __( 'center top', 'customize' ),
                'center center' => __( 'center center', 'customize' ),
                'center bottom' => __( 'center bottom', 'customize' ),
                '50% 50%' => __( '50% 50%', 'customize' ),
                '100% 100%' => __( '100% 100%', 'customize' ),
            ),
			'default'    => 'inherit'
        )
    );

    $wp_customize->add_setting(
        'custom_header_image_repeat',
        array(
            'default'    => 'no-repead',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'customize_sanitize_image_repeat',			
        )
    );

    $wp_customize->add_control(
        'custom_header_image_repeat',
        array(
            'settings' => 'custom_header_image_repeat',	
			'priority'    => 1,
            'label'    => __( 'Image Repaed:', 'customize' ),
            'section'  => 'header_image',
            'type'     => 'select',
            'choices'  => array(
                'no-repeat' => __( 'No Repeat', 'customize' ),			
                'repeat' => __( 'Repeat', 'customize' )
            ),
			'default'    => 'no-repeat'
        )
    );
	
    $wp_customize->add_setting(
        'custom_header_image_shadow',
        array(
            'default'    => 'show',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'customize_sanitize_image_shadow',			
        )
    );

    $wp_customize->add_control(
        'custom_header_image_shadow',
        array(
            'settings' => 'custom_header_image_shadow',	
			'priority'    => 1,
            'label'    => __( 'Header Shadow:', 'customize' ),
            'section'  => 'header_image',
            'type'     => 'select',
            'choices'  => array(
				'show' => __( 'Show', 'customize' ),
                'hide' => __( 'Hide', 'customize' )
            ),
			'default'    => 'show'
        )
    );		
}

function customize_customize_css () { ?>
	<style>
		<?php if(get_theme_mod('header_height')) { ?> .header-img { height: <?php echo esc_attr(get_theme_mod('header_height')); ?>px; } <?php } ?>
		<?php if(get_theme_mod('custom_header_image_repeat') == "repeat") { ?> .header-img { background-repeat: repeat !important;} <?php } ?>
		<?php if(get_theme_mod('custom_header_image_shadow') =="hide") { ?> .header-img { -webkit-box-shadow: none !important; } <?php } ?>
		<?php if(get_theme_mod('custom_header_background_attachment')) { ?> .header-img { background-attachment: <?php echo esc_attr(get_theme_mod('custom_header_background_attachment')); ?>; } <?php } ?>
		<?php if(get_theme_mod('custom_header_background_size')) { ?> .header-img { background-size: <?php echo esc_attr(get_theme_mod('custom_header_background_size')); ?>; } <?php } ?>
		<?php if(get_theme_mod('custom_header_background_position')) { ?> .header-img { background-position: <?php echo esc_attr(get_theme_mod('custom_header_background_position')); ?>; } <?php } ?>
		<?php if(get_theme_mod('header_image_full_width')) { ?> .site-header { width: 100%; margin-top: 0px; } <?php } ?>
	
	</style>
<?php	
}

add_action('wp_head','customize_customize_css');

function customize_sanitize_background_attachment( $input ) {
	$valid = array(
                ' ' => __( ' ', 'customize' ),
                'inherit' => __( 'Inherit', 'customize' ),
                'fixed' => __( 'Fixed', 'customize' )
	);
	
	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

function customize_sanitize_image_repeat( $input ) {
	$valid = array(
                'no-repeat' => __( 'No Repeat', 'customize' ),			
                'repeat' => __( 'Repeat', 'customize' )
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

function customize_sanitize_image_shadow( $input ) {
	$valid = array(
				'show' => __( 'Show', 'customize' ),
                'hide' => __( 'Hide', 'customize' )
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

function customize_sanitize_select( $input ) {
	$valid = array(
                'deactivate' => __( 'Deactivate Header Image', 'customize' ),
                'default' => __( 'Default Image', 'customize' ),
                'all' => __( 'All Pages', 'customize' ),
                'home'  => __( 'Home Page', 'customize' )
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

function customize_sanitize_overlay( $input ) {
	$valid = array(
        '' => __( ' ', 'customize' ),
        'on' => __( 'Show Overlay', 'customize' ),
        'off'  => __( 'Hide Overlay', 'customize' )
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

function customize_sanitize_background_size( $input ) {
	$valid = array(
                'auto' => __( 'Auto', 'customize' ),
                'cover' => __( 'Cover', 'customize' ),
                'contain, cover' => __( 'Contain, Cover', 'customize' ),
                'contain' => __( 'Contain', 'customize' ),
                'initial' => __( 'Initial', 'customize' ),
                '50% 50%' => __( '50% 50%', 'customize' ),
                '100% 50%' => __( '100% 50%', 'customize' ),
                '50% 100%' => __( '50% 100%', 'customize' ),
                '100% 100%' => __( '100% 100%', 'customize' ),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}
function customize_sanitize_background_position ( $input ) {
	$valid = array(
                'initial' => __( 'initial', 'customize' ),
                'left top' => __( 'left top', 'customize' ),
                'left center' => __( 'left center', 'customize' ),
                'left bottom' => __( 'left bottom', 'customize' ),
                'right top' => __( 'right top', 'customize' ),
                'right bottom' => __( 'right bottom', 'customize' ),
                'right center' => __( 'right center', 'customize' ),
                'center top' => __( 'center top', 'customize' ),
                'center center' => __( 'center center', 'customize' ),
                'center bottom' => __( 'center bottom', 'customize' ),
                '50% 50%' => __( '50% 50%', 'customize' ),
                '100% 100%' => __( '100% 100%', 'customize' ),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}