<?php if( ! defined( 'ABSPATH' ) ) exit;

/************ Home Page Images ************/ 
 
function customize_home_images () {
 
?>
 

<div class="h-images">

	<?php if(get_theme_mod('customize_home_image_1')) { ?>
		<div class="h-single-image">
			<?php if(get_theme_mod('customize_home_image_title_1')) { ?><div class="h-image-title"><?php echo get_theme_mod('customize_home_image_title_1'); ?></div><?php } ?>
			<a href="<?php echo get_theme_mod('customize_home_image_url_1'); ?>">
				<img src="<?php echo get_theme_mod('customize_home_image_1'); ?>" alt="Image 1">
			</a>
		</div>
	<?php } ?>

	<?php if(get_theme_mod('customize_home_image_2')) { ?>
		<div class="h-single-image">
			<?php if(get_theme_mod('customize_home_image_title_2')) { ?><div class="h-image-title"><?php echo get_theme_mod('customize_home_image_title_2'); ?></div><?php } ?>
			<a href="<?php echo get_theme_mod('customize_home_image_url_2'); ?>">
				<img src="<?php echo get_theme_mod('customize_home_image_2'); ?>" alt="Image 2">
			</a>
		</div>
	<?php } ?>

	<?php if(get_theme_mod('customize_home_image_3')) { ?>
		<div class="h-single-image">
			<?php if(get_theme_mod('customize_home_image_title_3')) { ?><div class="h-image-title"><?php echo get_theme_mod('customize_home_image_title_3'); ?></div><?php } ?>
			<a href="<?php echo get_theme_mod('customize_home_image_url_3'); ?>">
				<img src="<?php echo get_theme_mod('customize_home_image_3'); ?>" alt="Image 3">
			</a>
		</div>
	<?php } ?>
</div>

 <?php }