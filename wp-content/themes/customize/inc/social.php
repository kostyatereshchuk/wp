<?php if( ! defined( 'ABSPATH' ) ) exit;

	function customize_social_section () { ?>

				<?php if (get_theme_mod( 'customize_facebook' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' )) == "_blank"){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_facebook' )); ?>"><i class="fa fa-facebook-f"></i></a>
				<?php endif; ?>
							
				<?php if (get_theme_mod( 'customize_twitter' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_twitter' )) ?>"><i class="fa fa-twitter"></i></a>
				<?php endif; ?>
											
				<?php if (get_theme_mod( 'customize_google' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_google' )); ?>"><i class="fa fa-google-plus"></i></a>
				<?php endif; ?>
															
				<?php if (get_theme_mod( 'customize_youtube' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_youtube' )); ?>"><i class="fa fa-youtube"></i></a>
				<?php endif; ?>
																			
				<?php if (get_theme_mod( 'customize_vimeo' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_vimeo' )); ?>"><i class="fa fa-vimeo"></i></a>
				<?php endif; ?>
																			
				<?php if (get_theme_mod( 'customize_pinterest' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_pinterest' )); ?>"><i class="fa fa-pinterest"></i></a>
				<?php endif; ?>	
				
				<?php if (get_theme_mod( 'customize_instagram' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_instagram' )); ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a>
				<?php endif; ?>
																			
				<?php if (get_theme_mod( 'customize_linkedin' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_linkedin' )); ?>"><i class="fa fa-linkedin"></i></a>
				<?php endif; ?>
																			
				<?php if (get_theme_mod( 'customize_rss' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_rss' )); ?>"><i class="fa fa-rss"></i></a>
				<?php endif; ?>
																			
				<?php if (get_theme_mod( 'customize_stumbleupon' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_stumbleupon' )); ?>"><i class="fa fa-stumbleupon"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_kirki_social_10' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_kirki_social_10' )); ?>"><i class="fa fa-flickr" aria-hidden="true"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_dribbble' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_dribbble' )); ?>"><i class="fa fa-dribbble"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_digg' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_digg' )); ?>"><i class="fa fa-digg"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_skype' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_skype' )); ?>"><i class="fa fa-skype"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_deviantart' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_deviantart' )); ?>"><i class="fa fa-deviantart"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_yahoo' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_yahoo' )); ?>"><i class="fa fa-yahoo"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_reddit_alien' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_reddit_alien' )); ?>"><i class="fa fa-reddit-alien"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_paypal' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_paypal' )); ?>"><i class="fa fa-paypal"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_dropbox' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_dropbox' )); ?>"><i class="fa fa-dropbox"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_soundcloud' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_soundcloud' )); ?>"><i class="fa fa-soundcloud"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_vk' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_vk' )); ?>"><i class="fa fa-vk"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_envelope' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_envelope' )); ?>"><i class="fa fa-envelope"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_address_book' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_address_book' )); ?>"><i class="fa fa-address-book" aria-hidden="true"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_address_apple' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_address_apple' )); ?>"><i class="fa fa-apple"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_address_amazon' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_address_amazon' )); ?>"><i class="fa fa-amazon"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_address_slack' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_address_slack' )); ?>"><i class="fa fa-slack"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_address_slideshare' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_address_slideshare' )); ?>"><i class="fa fa-slideshare"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_address_wikipedia' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_address_wikipedia' )); ?>"><i class="fa fa-wikipedia-w"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_address_wordpress' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_address_wordpress' )); ?>"><i class="fa fa-wordpress"></i></a>
				<?php endif; ?>
																							
				<?php if (get_theme_mod( 'customize_address_odnoklassniki' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_address_odnoklassniki' )); ?>"><i class="fa fa-odnoklassniki"></i></a>
				<?php endif; ?>
																											
				<?php if (get_theme_mod( 'customize_address_tumblr' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'customize_social_link_type' ))){echo esc_attr(get_theme_mod( 'customize_social_link_type' )); } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'customize_address_tumblr' )); ?>"><i class="fa fa-tumblr"></i></a>
				<?php endif; ?>

<?php }  ?>