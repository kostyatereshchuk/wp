<?php
/**
 * The template for displaying all single posts
 *
 */

get_header(); ?>

	<div id="content-center">
	
		<div id="primary" class="content-area">

			<main id="main" class="site-main app-post" role="main">
				<?php while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', get_post_format() );
				?>
				
				<div class="postnav">
				
					<div class="nav-previous"><span class="meta-nav"><i class="fa fa-caret-left"></i></span>

						<?php if(get_option('translation_8')) : previous_post_link('%link', " ". get_option('translation_8')); else : previous_post_link('%link', __(' Previous', 'customize')); endif; ?>
					
					</div>
						
					<div class="nav-next">
					
						<?php if(get_option('translation_9')) : next_post_link('%link', " ". get_option('translation_9')); else : next_post_link('%link', __('Next ', 'customize')); endif; ?>
					
						<span class="meta-nav"><i class="fa fa-caret-right"></i></span>
						
					</div>
				
				</div>
				
				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>

			</main><!-- #main -->
			
		</div><!-- #primary -->
		
		<?php get_sidebar(); ?>
		
	</div>

<?php get_footer();
