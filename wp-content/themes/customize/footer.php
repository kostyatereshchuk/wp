<?php
/**
 * The template for displaying the footer
 */

?>

	</div><!-- #content -->
	
	<?php if (esc_attr(get_theme_mod( 'social_media_activate' )) ) { ?>
	
		<div class="social">
				<div  style="float: none;" class="fa-icons">
					<?php echo customize_social_section (); ?>		

				</div>
		</div>
		
	<?php } ?>	

	<footer role="contentinfo">
			<div class="footer-center sw-clear">
			
				<?php if (  is_active_sidebar('footer-1') ) : ?>
					<div class="footer-widgets">
						<?php dynamic_sidebar( 'footer-1' ); ?>
					</div>
				<?php endif; ?>
				
				<?php if (  is_active_sidebar('footer-2') ) : ?>
					<div class="footer-widgets">
						<?php dynamic_sidebar( 'footer-2' ); ?>
					</div>
				<?php endif; ?>
				
				<?php if (  is_active_sidebar('footer-3') ) : ?>
					<div class="footer-widgets">
						<?php dynamic_sidebar( 'footer-3' ); ?>
					</div>
				<?php endif; ?>
				
				<?php if (  is_active_sidebar('footer-4') ) : ?>
					<div class="footer-widgets">
						<?php dynamic_sidebar( 'footer-4' ); ?>
					</div>
				<?php endif; ?>
				
			</div>		
		<div id="colophon"  class="site-info">
		<?php if (get_theme_mod('customize_premium_copyright1')) : echo get_theme_mod('customize_premium_copyright1'); else : ?>
			<p>
					<?php esc_html_e('All rights reserved', 'customize'); ?>  &copy; <?php bloginfo('name'); ?>
								
					<a title="Seos Themes" href="<?php echo esc_url('https://seosthemes.com/', 'customize'); ?>" target="_blank"><?php esc_html_e('Theme by Seos Themes', 'customize'); ?></a>
			</p>
		<?php endif; ?>		
		</div><!-- .site-info -->
		
	</footer><!-- #colophon -->
	
	<?php if (!get_theme_mod('customize_activate_to_top')) { ?>
		<a id="totop" href="#"><div><?php if(get_theme_mod('customize_to_top_text')) {echo get_theme_mod('customize_to_top_text'); } else { esc_html_e('To Top', 'customize'); }?></div></a>
	<?php } ?>
	
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
