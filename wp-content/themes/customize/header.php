<?php
/**
 * The Header template
 */ 
 ?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">	
	<?php endif; ?>
	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'customize' ); ?></a>
	
		<?php if (esc_attr(get_theme_mod( 'social_media_activate_header' )) or esc_attr(get_theme_mod('customize_contacts_header_address')) or esc_attr(get_theme_mod('customize_contacts_header_phone')) ) { ?>
		
		<div class="social">
				<div class="fa-icons">
					<?php if (get_theme_mod( 'social_media_activate_header' )) {echo customize_social_section ();} ?>		

				</div>
				<div class="soc-right">
						<?php if (get_theme_mod('customize_contacts_header_address')) { ?><span><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo get_theme_mod('customize_contacts_header_address'); ?></span><?php } ?>
						<?php if (get_theme_mod('customize_contacts_header_phone')) { ?><span><i class="fa fa-volume-control-phone" aria-hidden="true"></i> <?php echo get_theme_mod('customize_contacts_header_phone'); ?></span><?php } ?>
				</div>
				<div class="clear"></div>
		</div>	 
		<?php } ?>

	<div class="nav-center">

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					
			<a href="#" id="menu-icon">	
				<span class="menu-button"> </span>
				<span class="menu-button"> </span>
				<span class="menu-button"> </span>
			</a>	

			</button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
			
		</nav><!-- #site-navigation -->
		<?php if ( get_theme_mod('customize_woo_cart_activate') == "2" and  customize_woocommerce_page ()) { do_action( 'your_theme_header_top' ); } ?>
		<?php if ( get_theme_mod('customize_woo_cart_activate') == "1") { do_action( 'your_theme_header_top' ); } ?>
	</div>

	<header id="masthead" class="site-header" role="banner">				

	
<!---------------- Deactivate Header Image ---------------->	
		
		<?php if (get_theme_mod('custom_header_position') != "deactivate" and has_header_image() !="") { ?>
		
<!---------------- All Pages Header Image ---------------->		
	
		<?php if ( get_theme_mod('custom_header_position') == "all" ) : ?>
		
		<div class="header-img" style="background-image: url('<?php header_image(); ?>');">	
		
			<?php if ( get_theme_mod('custom_header_overlay') != "off" ) { ?>
				<div class="dotted">
			<?php } ?>

			<div class="site-branding">
			
				<?php if ( has_custom_logo() ) : ?>
					
						<?php if ( is_front_page() && is_home() ) : ?>
							<?php if(get_theme_mod('customize_premium_site_title_animation')) : ?>
								<h1 class="site-title"><?php the_custom_logo(); ?></h1>
							<?php else : ?>
								<h1 class="site-title aniview" data-av-animation="bounceInDown"><?php the_custom_logo(); ?></h1>
							<?php endif; ?>							
						<?php else : ?>
							<?php if(get_theme_mod('customize_premium_site_title_animation')) : ?>						
								<p class="site-title"><?php the_custom_logo(); ?></p>
							<?php else : ?>
								<p class="site-title aniview" data-av-animation="bounceInDown"><?php the_custom_logo(); ?></p>
							<?php endif; ?>	
						<?php endif;

						$ap_description = esc_html (get_bloginfo( 'description', 'display' ));
						if ( $ap_description || is_customize_preview() ) : ?>
							<?php if(get_theme_mod('customize_premium_description_animation')) : ?>
								<p class="site-description"><?php echo $ap_description; /* WPCS: xss ok. */ ?></p>
							<?php else : ?>
								<p class="site-description aniview" data-av-animation="bounceInUp"><?php echo $ap_description; /* WPCS: xss ok. */ ?></p>
							<?php endif; ?>		
						<?php endif;  ?>
						
					<?php else : ?>
					
						<?php if ( is_front_page() && is_home() ) : ?>
							<?php if(get_theme_mod('customize_premium_site_title_animation')) : ?>
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php else : ?>	
								<h1 class="site-title aniview" data-av-animation="bounceInDown"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php endif; ?>	
						<?php else : ?>
							<?php if(get_theme_mod('customize_premium_site_title_animation')) : ?>
								<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php else : ?>	
								<p class="site-title aniview" data-av-animation="bounceInDown"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php endif; ?>	
						<?php endif;

						$ap_description = esc_html (get_bloginfo( 'description', 'display' ));
						if ( $ap_description || is_customize_preview() ) : ?>
							<?php if(get_theme_mod('customize_premium_description_animation')) : ?>
								<p class="site-description"><?php echo $ap_description; /* WPCS: xss ok. */ ?></p>
							<?php else : ?>	
								<p class="site-description aniview" data-av-animation="bounceInUp"><?php echo $ap_description; /* WPCS: xss ok. */ ?></p>
							<?php endif; ?>	
						
				<?php endif;  endif;  ?>			
			
			</div><!-- .site-branding -->
				
				
			<?php if ( get_theme_mod('custom_header_overlay') != "off" ) { ?>
				</div>
			<?php } ?>
			
		</div>
		
		<?php endif;  ?>
		
<!---------------- Home Page Header Image ---------------->
		
		<?php if ( ( is_front_page() || is_home() ) and get_theme_mod('custom_header_position') == "home" ) { ?>

		<div class="header-img" style="background-image: url('<?php header_image(); ?>');">	

			<?php if ( get_theme_mod('custom_header_overlay') != "off" ) { ?>
				<div class="dotted">
			<?php } ?>					

			<div class="site-branding">
			
				<?php if ( has_custom_logo() ) : ?>
					
						<?php if ( is_front_page() && is_home() ) : ?>
							<?php if(get_theme_mod('customize_premium_site_title_animation')) : ?>
								<h1 class="site-title"><?php the_custom_logo(); ?></h1>
							<?php else : ?>
								<h1 class="site-title aniview" data-av-animation="bounceInDown"><?php the_custom_logo(); ?></h1>
							<?php endif; ?>							
						<?php else : ?>
							<?php if(get_theme_mod('customize_premium_site_title_animation')) : ?>						
								<p class="site-title"><?php the_custom_logo(); ?></p>
							<?php else : ?>
								<p class="site-title aniview" data-av-animation="bounceInDown"><?php the_custom_logo(); ?></p>
							<?php endif; ?>	
						<?php endif;

						$ap_description = esc_html (get_bloginfo( 'description', 'display' ));
						if ( $ap_description || is_customize_preview() ) : ?>
							<?php if(get_theme_mod('customize_premium_description_animation')) : ?>
								<p class="site-description"><?php echo $ap_description; /* WPCS: xss ok. */ ?></p>
							<?php else : ?>
								<p class="site-description aniview" data-av-animation="bounceInUp"><?php echo $ap_description; /* WPCS: xss ok. */ ?></p>
							<?php endif; ?>		
						<?php endif;  ?>
						
					<?php else : ?>
					
						<?php if ( is_front_page() && is_home() ) : ?>
							<?php if(get_theme_mod('customize_premium_site_title_animation')) : ?>
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php else : ?>	
								<h1 class="site-title aniview" data-av-animation="bounceInDown"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php endif; ?>	
						<?php else : ?>
							<?php if(get_theme_mod('customize_premium_site_title_animation')) : ?>
								<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php else : ?>	
								<p class="site-title aniview" data-av-animation="bounceInDown"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php endif; ?>	
						<?php endif;

						$ap_description = esc_html (get_bloginfo( 'description', 'display' ));
						if ( $ap_description || is_customize_preview() ) : ?>
							<?php if(get_theme_mod('customize_premium_description_animation')) : ?>
								<p class="site-description"><?php echo $ap_description; /* WPCS: xss ok. */ ?></p>
							<?php else : ?>	
								<p class="site-description aniview" data-av-animation="bounceInUp"><?php echo $ap_description; /* WPCS: xss ok. */ ?></p>
							<?php endif; ?>	
						
				<?php endif;  endif;  ?>			
			
			</div><!-- .site-branding -->
						
				
			<?php if ( get_theme_mod('custom_header_overlay') != "off" ) { ?>
				</div>
			<?php } ?>					
		</div>
		
	<?php } 

	} ?> 

<!---------------- Default Header Image ---------------->

		<?php if ( get_theme_mod('custom_header_position') != "deactivate" and has_header_image() !="") { ?>
		
		<?php if ( get_theme_mod('custom_header_position') != "all") { ?>

		<?php if ( get_theme_mod('custom_header_position') != "home" ) { ?>

		<div class="header-img" style="background-image: url('<?php echo esc_url(get_template_directory_uri()). "/framework/images/header.jpg"; ?>');">	

			<?php if ( get_theme_mod('custom_header_overlay') != "off" ) { ?>
				<div class="dotted">
			<?php } ?>	
			
			<div class="site-branding">
			
				<?php if ( has_custom_logo() ) : ?>
					
						<?php if ( is_front_page() && is_home() ) : ?>
							<?php if(get_theme_mod('customize_premium_site_title_animation')) : ?>
								<h1 class="site-title"><?php the_custom_logo(); ?></h1>
							<?php else : ?>
								<h1 class="site-title aniview" data-av-animation="bounceInDown"><?php the_custom_logo(); ?></h1>
							<?php endif; ?>							
						<?php else : ?>
							<?php if(get_theme_mod('customize_premium_site_title_animation')) : ?>						
								<p class="site-title"><?php the_custom_logo(); ?></p>
							<?php else : ?>
								<p class="site-title aniview" data-av-animation="bounceInDown"><?php the_custom_logo(); ?></p>
							<?php endif; ?>	
						<?php endif;

						$ap_description = esc_html (get_bloginfo( 'description', 'display' ));
						if ( $ap_description || is_customize_preview() ) : ?>
							<?php if(get_theme_mod('customize_premium_description_animation')) : ?>
								<p class="site-description"><?php echo $ap_description; /* WPCS: xss ok. */ ?></p>
							<?php else : ?>
								<p class="site-description aniview" data-av-animation="bounceInUp"><?php echo $ap_description; /* WPCS: xss ok. */ ?></p>
							<?php endif; ?>		
						<?php endif;  ?>
						
					<?php else : ?>
					
						<?php if ( is_front_page() && is_home() ) : ?>
							<?php if(get_theme_mod('customize_premium_site_title_animation')) : ?>
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php else : ?>	
								<h1 class="site-title aniview" data-av-animation="bounceInDown"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php endif; ?>	
						<?php else : ?>
							<?php if(get_theme_mod('customize_premium_site_title_animation')) : ?>
								<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php else : ?>	
								<p class="site-title aniview" data-av-animation="bounceInDown"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php endif; ?>	
						<?php endif;

						$ap_description = esc_html (get_bloginfo( 'description', 'display' ));
						if ( $ap_description || is_customize_preview() ) : ?>
							<?php if(get_theme_mod('customize_premium_description_animation')) : ?>
								<p class="site-description"><?php echo $ap_description; /* WPCS: xss ok. */ ?></p>
							<?php else : ?>	
								<p class="site-description aniview" data-av-animation="bounceInUp"><?php echo $ap_description; /* WPCS: xss ok. */ ?></p>
							<?php endif; ?>	
						
				<?php endif;  endif;  ?>			
			
			</div><!-- .site-branding -->
				
			<?php if ( get_theme_mod('custom_header_overlay') != "off" ) { ?>
				</div>
			<?php } ?>	
							
		</div>
		
		<?php } } } ?>

	</header><!-- #masthead -->
	
	<?php if (( is_front_page() or is_home()) and !get_theme_mod ('customize_img_activate_home') ) { echo customize_home_images ();  } ?>		
	<?php if (( !is_front_page() or !is_home()) and !get_theme_mod ('customize_img_activate_all') ) { echo customize_home_images ();  } ?>	
			
	<div class="clear"></div>
	
	<div id="content" class="site-content">