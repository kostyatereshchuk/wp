<?php if( ! defined( 'ABSPATH' ) ) exit;
function customize_premium_animation() { ?>
<style>

	.sp-title {
		-webkit-animation-duration: 0.6s;
		animation-duration: 0.6s;
		-webkit-animation-fill-mode: both;
		animation-fill-mode: both;
		-webkit-transition: all 0.1s ease-in-out;
		-moz-transition: all 0.1s ease-in-out;
		-o-transition: all 0.1s ease-in-out;
		-ms-transition: all 0.1s ease-in-out;
		transition: all 0.1s ease-in-out;

	}

	.main-navigation ul li:hover > .sub-menu {
		-webkit-animation-duration: <?php echo get_theme_mod( 'customize_premium_sub_menu_animation_speed' ); ?>s;
		animation-duration: <?php echo get_theme_mod( 'customize_premium_sub_menu_animation_speed' ); ?>s;
		-webkit-animation-fill-mode: both;
		animation-fill-mode: both;
		-webkit-transition: all 0.1s ease-in-out;
		-moz-transition: all 0.1s ease-in-out;
		-o-transition: all 0.1s ease-in-out;
		-ms-transition: all 0.1s ease-in-out;
		transition: all 0.1s ease-in-out;

	}

	.site-title {
		display: block;
		-webkit-animation-duration: <?php echo get_theme_mod( 'customize_premium_site_title_animation_speed' ); ?>s !important;
		animation-duration: <?php echo get_theme_mod( 'customize_premium_site_title_animation_speed' ); ?>s !important;
		-webkit-animation-fill-mode: both;
		animation-fill-mode: both;
		-webkit-transition: all 0.1s ease-in-out;
		-moz-transition: all 0.1s ease-in-out;
		-o-transition: all 0.1s ease-in-out;
		-ms-transition: all 0.1s ease-in-out;
		transition: all 0.1s ease-in-out;
	}

	.site-description {
		display: block;
		-webkit-animation-duration: <?php echo get_theme_mod( 'customize_premium_description_animation_speed' ); ?>s !important;
		animation-duration: <?php echo get_theme_mod( 'customize_premium_description_animation_speed' ); ?>s !important;
		-webkit-animation-fill-mode: both;
		animation-fill-mode: both;
		-webkit-transition: all 0.1s ease-in-out;
		-moz-transition: all 0.1s ease-in-out;
		-o-transition: all 0.1s ease-in-out;
		-ms-transition: all 0.1s ease-in-out;
		transition: all 0.1s ease-in-out;
	}

	.sp-slider-back {
		display: block;
		-webkit-animation-duration: <?php echo get_theme_mod( 'customize_premium_animations_slider_speed' ); ?>s !important;
		animation-duration: <?php echo get_theme_mod( 'customize_premium_animations_slider_speed' ); ?>s !important;
		-webkit-animation-fill-mode: both;
		animation-fill-mode: both;
		-webkit-transition: all 0.1s ease-in-out;
		-moz-transition: all 0.1s ease-in-out;
		-o-transition: all 0.1s ease-in-out;
		-ms-transition: all 0.1s ease-in-out;
		transition: all 0.1s ease-in-out;
	}

	#seos-gallery a, .album a {
		-webkit-animation-duration: <?php echo get_theme_mod( 'customize_premium_animation_gallery_speed' ); ?>s !important;
		animation-duration: <?php echo get_theme_mod( 'customize_premium_animation_gallery_speed' ); ?>s !important;
		-webkit-animation-fill-mode: both;
		animation-fill-mode: both;
		-webkit-transition: all 0.1s ease-in-out;
		-moz-transition: all 0.1s ease-in-out;
		-o-transition: all 0.1s ease-in-out;
		-ms-transition: all 0.1s ease-in-out;
		transition: all 0.1s ease-in-out;
		width: 250px;
		height: 170px;	
	}

	.sp-image {
		-webkit-animation-duration: <?php echo get_theme_mod( 'customize_premium_animation_home_images_speed' ); ?>s !important;
		animation-duration: <?php echo get_theme_mod( 'customize_premium_animation_home_images_speed' ); ?>s !important;
		-webkit-animation-fill-mode: both;
		animation-fill-mode: both;
		-webkit-transition: all 0.1s ease-in-out;
		-moz-transition: all 0.1s ease-in-out;
		-o-transition: all 0.1s ease-in-out;
		-ms-transition: all 0.1s ease-in-out;
		transition: all 0.1s ease-in-out;
	}

	.testimonials-boxes {	
		display: block;
		-webkit-animation-duration: <?php echo get_theme_mod( 'customize_premium_animations_testimonial_speed' ); ?>s !important;
		animation-duration: <?php echo get_theme_mod( 'customize_premium_animations_testimonial_speed' ); ?>s !important;
		-webkit-animation-fill-mode: both;
		animation-fill-mode: both;
		-webkit-transition: all 0.1s ease-in-out;
		-moz-transition: all 0.1s ease-in-out;
		-o-transition: all 0.1s ease-in-out;
		-ms-transition: all 0.1s ease-in-out;
		transition: all 0.1s ease-in-out;
	}

	aside section {	
		display: block;
		-webkit-animation-duration: <?php echo get_theme_mod( 'customize_premium_animation_sidebar_speed' ); ?>s !important;
		animation-duration: <?php echo get_theme_mod( 'customize_premium_animation_sidebar_speed' ); ?>s !important;
		-webkit-animation-fill-mode: both;
		animation-fill-mode: both;
		-webkit-transition: all 0.1s ease-in-out;
		-moz-transition: all 0.1s ease-in-out;
		-o-transition: all 0.1s ease-in-out;
		-ms-transition: all 0.1s ease-in-out;
		transition: all 0.1s ease-in-out;
	}

	#colophon {
		display: block;
		-webkit-animation-duration: <?php echo get_theme_mod( 'customize_premium_animation_footer_speed' ); ?>s !important;
		animation-duration: <?php echo get_theme_mod( 'customize_premium_animation_footer_speed' ); ?>s !important;
		-webkit-animation-fill-mode: both;
		animation-fill-mode: both;
		-webkit-transition: all 0.1s ease-in-out;
		-moz-transition: all 0.1s ease-in-out;
		-o-transition: all 0.1s ease-in-out;
		-ms-transition: all 0.1s ease-in-out;
		transition: all 0.1s ease-in-out;
	}
	
	article {
		display: block;
		-webkit-animation-duration: <?php echo get_theme_mod( 'customize_premium_animation_content_speed' ); ?>s !important;
		animation-duration: <?php echo get_theme_mod( 'customize_premium_animation_content_speed' ); ?>s !important;
		-webkit-animation-fill-mode: both;
		animation-fill-mode: both;
		-webkit-transition: all 0.1s ease-in-out;
		-moz-transition: all 0.1s ease-in-out;
		-o-transition: all 0.1s ease-in-out;
		-ms-transition: all 0.1s ease-in-out;
		transition: all 0.1s ease-in-out;
	}	
</style>
<?php }

add_action('wp_head', 'customize_premium_animation');