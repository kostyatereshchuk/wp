<?php
/**
 * The main template file

 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header(); ?>


<div id="content-center">
	<?php if ( is_front_page() || is_home() and (get_theme_mod('customize_homepage_columns') == "1")) { ?> <div> <?php } ?>	
	<?php if ( is_front_page() || is_home() and (get_theme_mod('customize_homepage_columns') == "2")) { ?> <div class="ig-home"> <?php } ?>
	<?php if ( is_front_page() || is_home() and (get_theme_mod('customize_homepage_columns') == "3")) { ?> <div class="s-home-no-sidebar"> <?php } ?>
	<?php if ( is_front_page() || is_home() and (get_theme_mod('customize_homepage_columns') == "4")) { ?> <div class="s-home-no-sidebar ig-home"> <?php } ?>
			<div id="primary" class="content-area">

				
					<main id="main" class="site-main" role="main">

					<?php
					if ( have_posts() ) :

						if ( is_home() && ! is_front_page() ) : ?>
							<header>
								<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
							</header>

						<?php
						endif;

						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() );
							
						endwhile;

						the_posts_pagination();

						else :

						get_template_part( 'template-parts/content', 'none' );
						
					endif; ?>
						
					</main><!-- #main -->
					

				
			</div><!-- #primary -->

			<?php get_sidebar(); ?>
	<?php if ( is_front_page() || is_home()) { ?> </div> <?php } ?>			
</div>	

<?php get_footer();

