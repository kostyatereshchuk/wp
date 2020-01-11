<?php if( ! defined( 'ABSPATH' ) ) exit;

function customize_premium_animation_classes () { ?>
	<script type="text/javascript">


		jQuery(document).ready(function() {
				jQuery('.sp-title').addClass("hidden").viewportChecker({
					classToAdd: 'animated flipInY',
					offset: 0  
				   }); 
		});
		

	
	<?php if ( get_theme_mod('customize_premium_site_title_animation')) { ?>
		jQuery(document).ready(function() {
				jQuery('.site-title').addClass("hidden").viewportChecker({
					classToAdd: 'animated <?php echo get_theme_mod('customize_premium_site_title_animation'); ?>', // Class to add to the elements when they are visible
					offset: 0  
				   }); 
		});  
	<?php } ?>

	<?php if ( get_theme_mod('customize_premium_description_animation')) { ?>
		jQuery(document).ready(function() {
				jQuery('.site-description').addClass("hidden").viewportChecker({
					classToAdd: 'animated <?php echo get_theme_mod('customize_premium_description_animation'); ?>', // Class to add to the elements when they are visible
					offset: 0  
				   }); 
		});  
	<?php } ?>
	
	<?php if ( get_theme_mod('customize_premium_animation_gallery')) { ?>
		jQuery(document).ready(function() {
				jQuery('#seos-gallery a, .album a').addClass("hidden").viewportChecker({
					classToAdd: 'animated <?php echo get_theme_mod('customize_premium_animation_gallery'); ?>', // Class to add to the elements when they are visible
					offset: 0  
				   }); 
		});  
	<?php } ?>

	<?php if ( get_theme_mod('customize_premium_animations_slider')) { ?>
		jQuery(document).ready(function() {
				jQuery('.sp-slider-back').addClass("hidden").viewportChecker({
					classToAdd: 'animated <?php echo get_theme_mod('customize_premium_animations_slider'); ?>', // Class to add to the elements when they are visible
					offset: 0  
				   }); 
		});  
	<?php } ?>

	<?php if ( get_theme_mod('customize_premium_animation_home_images')) { ?>
		jQuery(document).ready(function() {
				jQuery('.sp-image').addClass("hidden").viewportChecker({
					classToAdd: 'animated <?php echo get_theme_mod('customize_premium_animation_home_images'); ?>', // Class to add to the elements when they are visible
					offset: 0  
				   }); 
		});  
	<?php } ?>

	<?php if ( get_theme_mod('customize_premium_animations_testimonial')) { ?>
		jQuery(document).ready(function() {
				jQuery('.testimonials-boxes').addClass("hidden").viewportChecker({
					classToAdd: 'animated <?php echo get_theme_mod('customize_premium_animations_testimonial'); ?>', // Class to add to the elements when they are visible
					offset: 0  
				   }); 
		});  
	<?php } ?>

	<?php if ( get_theme_mod('customize_premium_animation_sidebar')) { ?>
		jQuery(document).ready(function() {
				jQuery('aside section').addClass("hidden").viewportChecker({
					classToAdd: 'animated <?php echo get_theme_mod('customize_premium_animation_sidebar'); ?>', // Class to add to the elements when they are visible
					offset: 0  
				   }); 
		});  
	<?php } ?>

	<?php if ( get_theme_mod('customize_premium_animation_content')) { ?>
		jQuery(document).ready(function() {
				jQuery('article').addClass("hidden").viewportChecker({
					classToAdd: 'animated <?php echo get_theme_mod('customize_premium_animation_content'); ?>', // Class to add to the elements when they are visible
					offset: 0  
				   }); 
		});  
	<?php } ?>
	
	<?php if ( get_theme_mod('customize_premium_animation_footer')) { ?>
		jQuery(document).ready(function() {
				jQuery('#colophon').addClass("hidden").viewportChecker({
					classToAdd: 'animated <?php echo get_theme_mod('customize_premium_animation_footer'); ?>', // Class to add to the elements when they are visible
					offset: 0  
				   }); 
		});  
	<?php } ?>
	
	</script>
<?php } 

add_action('wp_footer', 'customize_premium_animation_classes');				   
				   
		
		