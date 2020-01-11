<?php 
/***********************************************************************************
 * Customize Premium Buy
***********************************************************************************/

		function seos_support($wp_customize){
			class seos_Customize extends WP_Customize_Control {
				public function render_content() { ?>
				<div class="seos-info"> 
						<a href="<?php echo esc_url( 'https://seosthemes.info/seos-premium-wordpress-theme/' ); ?>" title="<?php esc_attr_e( 'Customize Premium', 'customize' ); ?>" target="_blank">
						<?php _e( 'Preview Premium', 'customize' ); ?>
						</a>
				</div>
				<?php
				}
			}
		}
		add_action('customize_register', 'seos_support');

		function customize_styles_seos( $input ) { ?>
			<style type="text/css">
				#customize-theme-controls #accordion-panel-seos_buy_panel .accordion-section-title,
				#customize-theme-controls #accordion-panel-seos_buy_panel > .accordion-section-title {
					background: #555555;
					color: #FFFFFF;
				}

				.seos-info button a {
					color: #FFFFFF;
				}

				#customize-theme-controls   #accordion-section-seos_buy_section .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section1 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section2 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section3 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section4 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section5 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section6 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section7 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section8 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section9 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section10 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section11 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section12 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section13 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section14 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section15 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section16 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section17 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section18 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section19 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section20 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section21 .accordion-section-title:after,
				#customize-theme-controls   #accordion-section-seos_buy_section22 .accordion-section-title:after {
					font-size: 13px;
					font-weight: bold;
					content: "Premium";
					float: right;
					right: 40px;
					position: relative;
					color: #FF0000;
				}			
				
				#_customize-input-seos_setting0 {
					display: none;
				}
				
			</style>
		<?php }
		
		add_action( 'customize_controls_print_styles', 'customize_styles_seos');

		if ( ! function_exists( 'customize_buy' ) ) :
			function customize_buy( $wp_customize ) {
			$wp_customize->add_panel( 'seos_buy_panel', array(
				'title'			=> __('Customize Premium', 'customize'),
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 100,
			));
			
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section0', array(
				'title'			=> __('Preview The Theme', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	<a href="https://seosthemes.com/seos/" target="_blank">Learn more about Customize Premium.</a> ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting0', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,'seos_setting0', array(
						'section'	=> 'seos_buy_section0',
						'settings'	=> 'seos_setting0',
					)
				)
			);
						
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section', array(
				'title'			=> __('Footer Slider', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting', array(
						'label'		=> __('Menu Slider', 'customize'),
						'section'	=> 'seos_buy_section',
						'settings'	=> 'seos_setting',
					)
				)
			);
			
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section1', array(
				'title'			=> __('Contacts', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting1', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting1', array(
						'label'		=> __('Contacts', 'customize'),
						'section'	=> 'seos_buy_section1',
						'settings'	=> 'seos_setting1',
					)
				)
			);
						
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section2', array(
				'title'			=> __('Animations', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting2', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting2', array(
						'label'		=> __('Animations', 'customize'),
						'section'	=> 'seos_buy_section2',
						'settings'	=> 'seos_setting2',
					)
				)
			);
									
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section3', array(
				'title'			=> __('All Google Fonts', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting3', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting3', array(
						'label'		=> __('All Google Fonts', 'customize'),
						'section'	=> 'seos_buy_section3',
						'settings'	=> 'seos_setting3',
					)
				)
			);
												
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section4', array(
				'title'			=> __('Banners', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting4', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting4', array(
						'label'		=> __('Banners', 'customize'),
						'section'	=> 'seos_buy_section4',
						'settings'	=> 'seos_setting4',
					)
				)
			);
															
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section5', array(
				'title'			=> __('Shortcode Scroll Animation', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting5', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting5', array(
						'label'		=> __('Shortcode Scroll Animation', 'customize'),
						'section'	=> 'seos_buy_section5',
						'settings'	=> 'seos_setting5',
					)
				)
			);
																		
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section6', array(
				'title'			=> __('Home Page Custom Images', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting6', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting6', array(
						'label'		=> __('About US Section', 'customize'),
						'section'	=> 'seos_buy_section6',
						'settings'	=> 'seos_setting6',
					)
				)
			);
																					
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section7', array(
				'title'			=> __('Disabel all Comments', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting7', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting7', array(
						'label'		=> __('Disabel all Comments', 'customize'),
						'section'	=> 'seos_buy_section7',
						'settings'	=> 'seos_setting7',
					)
				)
			);
																								
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section8', array(
				'title'			=> __('Entry Meta', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting8', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting8', array(
						'label'		=> __('Entry Meta', 'customize'),
						'section'	=> 'seos_buy_section8',
						'settings'	=> 'seos_setting8',
					)
				)
			);
			
																											
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section9', array(
				'title'			=> __('Hide Options', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting9', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting9', array(
						'label'		=> __('Hide All Titles', 'customize'),
						'section'	=> 'seos_buy_section9',
						'settings'	=> 'seos_setting9',
					)
				)
			);
																														
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section10', array(
				'title'			=> __('Mobile Call Now', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting10', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting10', array(
						'label'		=> __('Mobile Call Now', 'customize'),
						'section'	=> 'seos_buy_section10',
						'settings'	=> 'seos_setting10',
					)
				)
			);
																																	
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section11', array(
				'title'			=> __('Testimonials Post Type', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting11', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting11', array(
						'label'		=> __('Testimonials Custom Post Type', 'customize'),
						'section'	=> 'seos_buy_section11',
						'settings'	=> 'seos_setting11',
					)
				)
			);
																																				
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section12', array(
				'title'			=> __('WooCommerce Colors', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting12', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting12', array(
						'label'		=> __('WooCommerce Colors', 'customize'),
						'section'	=> 'seos_buy_section12',
						'settings'	=> 'seos_setting12',
					)
				)
			);
			
																																							
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section13', array(
				'title'			=> __('WooCommerce Options', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting13', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting13', array(
						'label'		=> __('WooCommerce Options', 'customize'),
						'section'	=> 'seos_buy_section13',
						'settings'	=> 'seos_setting13',
					)
				)
			);
																																										
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section14', array(
				'title'			=> __('Footer Options', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting14', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting14', array(
						'label'		=> __('Footer Options', 'customize'),
						'section'	=> 'seos_buy_section14',
						'settings'	=> 'seos_setting14',
					)
				)
			);
																																													
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section15', array(
				'title'			=> __('Font Sizes', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting15', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting15', array(
						'label'		=> __('Font Sizes', 'customize'),
						'section'	=> 'seos_buy_section15',
						'settings'	=> 'seos_setting15',
					)
				)
			);
																																																
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section16', array(
				'title'			=> __('Under Construction', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting16', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting16', array(
						'label'		=> __('Under Construction', 'customize'),
						'section'	=> 'seos_buy_section16',
						'settings'	=> 'seos_setting16',
					)
				)
			);
																																																			
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section17', array(
				'title'			=> __('Read More Button Options', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting17', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting17', array(
						'label'		=> __('Read More Button Options', 'customize'),
						'section'	=> 'seos_buy_section17',
						'settings'	=> 'seos_setting17',
					)
				)
			);
																																																						
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section18', array(
				'title'			=> __('Pagination Options', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting18', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting18', array(
						'label'		=> __('Pagination Options', 'customize'),
						'section'	=> 'seos_buy_section18',
						'settings'	=> 'seos_setting18',
					)
				)
			);
																																																									
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section19', array(
				'title'			=> __('Antispam Login Form', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting19', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting19', array(
						'label'		=> __('Antispam Login Form', 'customize'),
						'section'	=> 'seos_buy_section19',
						'settings'	=> 'seos_setting19',
					)
				)
			);
																																																												
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section20', array(
				'title'			=> __('Back To Top Button Options', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting20', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting20', array(
						'label'		=> __('Back To Top Button Options', 'customize'),
						'section'	=> 'seos_buy_section20',
						'settings'	=> 'seos_setting20',
					)
				)
			);
																																																															
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section21', array(
				'title'			=> __('Copy Protection', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting21', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting21', array(
						'label'		=> __('Copy Protection', 'customize'),
						'section'	=> 'seos_buy_section21',
						'settings'	=> 'seos_setting21',
					)
				)
			);
																																																																		
/******************************************************************************/
		
			$wp_customize->add_section( 'seos_buy_section22', array(
				'title'			=> __('Custom JS', 'customize'),
				'panel'			=> 'seos_buy_panel',
				'description'	=> __('	Learn more about Customize Premium. ','customize'),
				'priority'		=> 3,
			));			
			
			$wp_customize->add_setting( 'seos_setting22', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new seos_Customize(
					$wp_customize,'seos_setting22', array(
						'label'		=> __('Custom JS', 'customize'),
						'section'	=> 'seos_buy_section22',
						'settings'	=> 'seos_setting22',
					)
				)
			);
			
			
		}
		endif;
		 
		add_action('customize_register', 'customize_buy');
		