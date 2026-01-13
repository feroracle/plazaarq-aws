<?php

if ( ! function_exists( 'entre_mikado_general_options_map' ) ) {
	/**
	 * General options page
	 */
	function entre_mikado_general_options_map() {
		
		entre_mikado_add_admin_page(
			array(
				'slug'  => '',
				'title' => esc_html__( 'General', 'entre' ),
				'icon'  => 'fa fa-institution'
			)
		);
		
		do_action( 'entre_mikado_action_additional_general_settings' );
		
		$panel_design_style = entre_mikado_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_design_style',
				'title' => esc_html__( 'Appearance', 'entre' )
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'google_fonts',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Google Font Family', 'entre' ),
				'description'   => esc_html__( 'Choose a default Google font for your site', 'entre' ),
				'parent'        => $panel_design_style
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'additional_google_fonts',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Additional Google Fonts', 'entre' ),
				'parent'        => $panel_design_style,
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "",
					"dependence_show_on_yes" => "#mkd_additional_google_fonts_container"
				)
			)
		);
		
		$additional_google_fonts_container = entre_mikado_add_admin_container(
			array(
				'parent'          => $panel_design_style,
				'name'            => 'additional_google_fonts_container',
				'hidden_property' => 'additional_google_fonts',
				'hidden_value'    => 'no'
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'additional_google_font1',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'entre' ),
				'description'   => esc_html__( 'Choose additional Google font for your site', 'entre' ),
				'parent'        => $additional_google_fonts_container
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'additional_google_font2',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'entre' ),
				'description'   => esc_html__( 'Choose additional Google font for your site', 'entre' ),
				'parent'        => $additional_google_fonts_container
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'additional_google_font3',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'entre' ),
				'description'   => esc_html__( 'Choose additional Google font for your site', 'entre' ),
				'parent'        => $additional_google_fonts_container
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'additional_google_font4',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'entre' ),
				'description'   => esc_html__( 'Choose additional Google font for your site', 'entre' ),
				'parent'        => $additional_google_fonts_container
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'additional_google_font5',
				'type'          => 'font',
				'default_value' => '-1',
				'label'         => esc_html__( 'Font Family', 'entre' ),
				'description'   => esc_html__( 'Choose additional Google font for your site', 'entre' ),
				'parent'        => $additional_google_fonts_container
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'google_font_weight',
				'type'          => 'checkboxgroup',
				'default_value' => '',
				'label'         => esc_html__( 'Google Fonts Style & Weight', 'entre' ),
				'description'   => esc_html__( 'Choose a default Google font weights for your site. Impact on page load time', 'entre' ),
				'parent'        => $panel_design_style,
				'options'       => array(
					'100'  => esc_html__( '100 Thin', 'entre' ),
					'100i' => esc_html__( '100 Thin Italic', 'entre' ),
					'200'  => esc_html__( '200 Extra-Light', 'entre' ),
					'200i' => esc_html__( '200 Extra-Light Italic', 'entre' ),
					'300'  => esc_html__( '300 Light', 'entre' ),
					'300i' => esc_html__( '300 Light Italic', 'entre' ),
					'400'  => esc_html__( '400 Regular', 'entre' ),
					'400i' => esc_html__( '400 Regular Italic', 'entre' ),
					'500'  => esc_html__( '500 Medium', 'entre' ),
					'500i' => esc_html__( '500 Medium Italic', 'entre' ),
					'600'  => esc_html__( '600 Semi-Bold', 'entre' ),
					'600i' => esc_html__( '600 Semi-Bold Italic', 'entre' ),
					'700'  => esc_html__( '700 Bold', 'entre' ),
					'700i' => esc_html__( '700 Bold Italic', 'entre' ),
					'800'  => esc_html__( '800 Extra-Bold', 'entre' ),
					'800i' => esc_html__( '800 Extra-Bold Italic', 'entre' ),
					'900'  => esc_html__( '900 Ultra-Bold', 'entre' ),
					'900i' => esc_html__( '900 Ultra-Bold Italic', 'entre' )
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'google_font_subset',
				'type'          => 'checkboxgroup',
				'default_value' => '',
				'label'         => esc_html__( 'Google Fonts Subset', 'entre' ),
				'description'   => esc_html__( 'Choose a default Google font subsets for your site', 'entre' ),
				'parent'        => $panel_design_style,
				'options'       => array(
					'latin'        => esc_html__( 'Latin', 'entre' ),
					'latin-ext'    => esc_html__( 'Latin Extended', 'entre' ),
					'cyrillic'     => esc_html__( 'Cyrillic', 'entre' ),
					'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'entre' ),
					'greek'        => esc_html__( 'Greek', 'entre' ),
					'greek-ext'    => esc_html__( 'Greek Extended', 'entre' ),
					'vietnamese'   => esc_html__( 'Vietnamese', 'entre' )
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'        => 'first_color',
				'type'        => 'color',
				'label'       => esc_html__( 'First Main Color', 'entre' ),
				'description' => esc_html__( 'Choose the most dominant theme color. Default color is #00bbb3', 'entre' ),
				'parent'      => $panel_design_style
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'        => 'page_background_color',
				'type'        => 'color',
				'label'       => esc_html__( 'Page Background Color', 'entre' ),
				'description' => esc_html__( 'Choose the background color for page content. Default color is #ffffff', 'entre' ),
				'parent'      => $panel_design_style
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'        => 'selection_color',
				'type'        => 'color',
				'label'       => esc_html__( 'Text Selection Color', 'entre' ),
				'description' => esc_html__( 'Choose the color users see when selecting text', 'entre' ),
				'parent'      => $panel_design_style
			)
		);
		
		/***************** Passepartout Layout - begin **********************/
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'boxed',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Boxed Layout', 'entre' ),
				'parent'        => $panel_design_style,
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "",
					"dependence_show_on_yes" => "#mkd_boxed_container"
				)
			)
		);
		
			$boxed_container = entre_mikado_add_admin_container(
				array(
					'parent'          => $panel_design_style,
					'name'            => 'boxed_container',
					'hidden_property' => 'boxed',
					'hidden_value'    => 'no'
				)
			);
		
				entre_mikado_add_admin_field(
					array(
						'name'        => 'page_background_color_in_box',
						'type'        => 'color',
						'label'       => esc_html__( 'Page Background Color', 'entre' ),
						'description' => esc_html__( 'Choose the page background color outside box', 'entre' ),
						'parent'      => $boxed_container
					)
				);
				
				entre_mikado_add_admin_field(
					array(
						'name'        => 'boxed_background_image',
						'type'        => 'image',
						'label'       => esc_html__( 'Background Image', 'entre' ),
						'description' => esc_html__( 'Choose an image to be displayed in background', 'entre' ),
						'parent'      => $boxed_container
					)
				);
				
				entre_mikado_add_admin_field(
					array(
						'name'        => 'boxed_pattern_background_image',
						'type'        => 'image',
						'label'       => esc_html__( 'Background Pattern', 'entre' ),
						'description' => esc_html__( 'Choose an image to be used as background pattern', 'entre' ),
						'parent'      => $boxed_container
					)
				);
				
				entre_mikado_add_admin_field(
					array(
						'name'          => 'boxed_background_image_attachment',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Background Image Attachment', 'entre' ),
						'description'   => esc_html__( 'Choose background image attachment', 'entre' ),
						'parent'        => $boxed_container,
						'options'       => array(
							''       => esc_html__( 'Default', 'entre' ),
							'fixed'  => esc_html__( 'Fixed', 'entre' ),
							'scroll' => esc_html__( 'Scroll', 'entre' )
						)
					)
				);
		
		/***************** Boxed Layout - end **********************/
		
		/***************** Passepartout Layout - begin **********************/
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'paspartu',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Passepartout', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will display passepartout around site content', 'entre' ),
				'parent'        => $panel_design_style,
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "",
					"dependence_show_on_yes" => "#mkd_paspartu_container"
				)
			)
		);
		
			$paspartu_container = entre_mikado_add_admin_container(
				array(
					'parent'          => $panel_design_style,
					'name'            => 'paspartu_container',
					'hidden_property' => 'paspartu',
					'hidden_value'    => 'no'
				)
			);
		
				entre_mikado_add_admin_field(
					array(
						'name'        => 'paspartu_color',
						'type'        => 'color',
						'label'       => esc_html__( 'Passepartout Color', 'entre' ),
						'description' => esc_html__( 'Choose passepartout color, default value is #ffffff', 'entre' ),
						'parent'      => $paspartu_container
					)
				);
				
				entre_mikado_add_admin_field(
					array(
						'name'        => 'paspartu_width',
						'type'        => 'text',
						'label'       => esc_html__( 'Passepartout Size', 'entre' ),
						'description' => esc_html__( 'Enter size amount for passepartout', 'entre' ),
						'parent'      => $paspartu_container,
						'args'        => array(
							'col_width' => 2,
							'suffix'    => 'px or %'
						)
					)
				);
		
				entre_mikado_add_admin_field(
					array(
						'name'        => 'paspartu_responsive_width',
						'type'        => 'text',
						'label'       => esc_html__( 'Responsive Passepartout Size', 'entre' ),
						'description' => esc_html__( 'Enter size amount for passepartout for smaller screens (tablets and mobiles view)', 'entre' ),
						'parent'      => $paspartu_container,
						'args'        => array(
							'col_width' => 2,
							'suffix'    => 'px or %'
						)
					)
				);
				
				entre_mikado_add_admin_field(
					array(
						'parent'        => $paspartu_container,
						'type'          => 'yesno',
						'default_value' => 'no',
						'name'          => 'disable_top_paspartu',
						'label'         => esc_html__( 'Disable Top Passepartout', 'entre' )
					)
				);
		
		/***************** Passepartout Layout - end **********************/
		
		/***************** Content Layout - begin **********************/
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'initial_content_width',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Initial Width of Content', 'entre' ),
				'description'   => esc_html__( 'Choose the initial width of content which is in grid (Applies to pages set to "Default Template" and rows set to "In Grid")', 'entre' ),
				'parent'        => $panel_design_style,
				'options'       => array(
					'mkd-grid-1100' => esc_html__( '1100px - default', 'entre' ),
					'mkd-grid-1300' => esc_html__( '1300px', 'entre' ),
					'mkd-grid-1200' => esc_html__( '1200px', 'entre' ),
					'mkd-grid-1000' => esc_html__( '1000px', 'entre' ),
					'mkd-grid-800'  => esc_html__( '800px', 'entre' )
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'preload_pattern_image',
				'type'          => 'image',
				'label'         => esc_html__( 'Preload Pattern Image', 'entre' ),
				'description'   => esc_html__( 'Choose preload pattern image to be displayed until images are loaded', 'entre' ),
				'parent'        => $panel_design_style
			)
		);
		
		/***************** Content Layout - end **********************/
		
		$panel_settings = entre_mikado_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_settings',
				'title' => esc_html__( 'Behavior', 'entre' )
			)
		);
		
		/***************** Smooth Scroll Layout - begin **********************/
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'page_smooth_scroll',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Smooth Scroll', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will perform a smooth scrolling effect on every page (except on Mac and touch devices)', 'entre' ),
				'parent'        => $panel_settings
			)
		);
		
		/***************** Smooth Scroll Layout - end **********************/
		
		/***************** Smooth Page Transitions Layout - begin **********************/
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'smooth_page_transitions',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Smooth Page Transitions', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will perform a smooth transition between pages when clicking on links', 'entre' ),
				'parent'        => $panel_settings,
				'args'          => array(
					"dependence"             => true,
					"dependence_hide_on_yes" => "",
					"dependence_show_on_yes" => "#mkd_page_transitions_container"
				)
			)
		);
		
			$page_transitions_container = entre_mikado_add_admin_container(
				array(
					'parent'          => $panel_settings,
					'name'            => 'page_transitions_container',
					'hidden_property' => 'smooth_page_transitions',
					'hidden_value'    => 'no'
				)
			);
		
				entre_mikado_add_admin_field(
					array(
						'name'          => 'page_transition_preloader',
						'type'          => 'yesno',
						'default_value' => 'no',
						'label'         => esc_html__( 'Enable Preloading Animation', 'entre' ),
						'description'   => esc_html__( 'Enabling this option will display an animated preloader while the page content is loading', 'entre' ),
						'parent'        => $page_transitions_container,
						'args'          => array(
							"dependence"             => true,
							"dependence_hide_on_yes" => "",
							"dependence_show_on_yes" => "#mkd_page_transition_preloader_container"
						)
					)
				);
				
				$page_transition_preloader_container = entre_mikado_add_admin_container(
					array(
						'parent'          => $page_transitions_container,
						'name'            => 'page_transition_preloader_container',
						'hidden_property' => 'page_transition_preloader',
						'hidden_value'    => 'no'
					)
				);
		
		
					entre_mikado_add_admin_field(
						array(
							'name'   => 'smooth_pt_bgnd_color',
							'type'   => 'color',
							'label'  => esc_html__( 'Page Loader Background Color', 'entre' ),
							'parent' => $page_transition_preloader_container
						)
					);
					
					$group_pt_spinner_animation = entre_mikado_add_admin_group(
						array(
							'name'        => 'group_pt_spinner_animation',
							'title'       => esc_html__( 'Loader Style', 'entre' ),
							'description' => esc_html__( 'Define styles for loader spinner animation', 'entre' ),
							'parent'      => $page_transition_preloader_container
						)
					);
					
					$row_pt_spinner_animation = entre_mikado_add_admin_row(
						array(
							'name'   => 'row_pt_spinner_animation',
							'parent' => $group_pt_spinner_animation
						)
					);
					
					entre_mikado_add_admin_field(
						array(
							'type'          => 'selectsimple',
							'name'          => 'smooth_pt_spinner_type',
							'default_value' => '',
							'label'         => esc_html__( 'Spinner Type', 'entre' ),
							'parent'        => $row_pt_spinner_animation,
							'options'       => array(
								'rotate_circles'        => esc_html__( 'Rotate Circles', 'entre' ),
								'pulse'                 => esc_html__( 'Pulse', 'entre' ),
								'double_pulse'          => esc_html__( 'Double Pulse', 'entre' ),
								'cube'                  => esc_html__( 'Cube', 'entre' ),
								'rotating_cubes'        => esc_html__( 'Rotating Cubes', 'entre' ),
								'stripes'               => esc_html__( 'Stripes', 'entre' ),
								'wave'                  => esc_html__( 'Wave', 'entre' ),
								'two_rotating_circles'  => esc_html__( '2 Rotating Circles', 'entre' ),
								'five_rotating_circles' => esc_html__( '5 Rotating Circles', 'entre' ),
								'atom'                  => esc_html__( 'Atom', 'entre' ),
								'clock'                 => esc_html__( 'Clock', 'entre' ),
								'mitosis'               => esc_html__( 'Mitosis', 'entre' ),
								'lines'                 => esc_html__( 'Lines', 'entre' ),
								'fussion'               => esc_html__( 'Fussion', 'entre' ),
								'wave_circles'          => esc_html__( 'Wave Circles', 'entre' ),
								'pulse_circles'         => esc_html__( 'Pulse Circles', 'entre' ),
                                'entre-loader'          => esc_html__( 'Entre Loader', 'entre' )
							)
						)
					);
					
					entre_mikado_add_admin_field(
						array(
							'type'          => 'colorsimple',
							'name'          => 'smooth_pt_spinner_color',
							'default_value' => '',
							'label'         => esc_html__( 'Spinner Color', 'entre' ),
							'parent'        => $row_pt_spinner_animation
						)
					);
					
					entre_mikado_add_admin_field(
						array(
							'name'          => 'page_transition_fadeout',
							'type'          => 'yesno',
							'default_value' => 'no',
							'label'         => esc_html__( 'Enable Fade Out Animation', 'entre' ),
							'description'   => esc_html__( 'Enabling this option will turn on fade out animation when leaving page', 'entre' ),
							'parent'        => $page_transitions_container
						)
					);
		
		/***************** Smooth Page Transitions Layout - end **********************/
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'show_back_button',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Show "Back To Top Button"', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will display a Back to Top button on every page', 'entre' ),
				'parent'        => $panel_settings
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'          => 'responsiveness',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Responsiveness', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will make all pages responsive', 'entre' ),
				'parent'        => $panel_settings
			)
		);
		
		$panel_custom_code = entre_mikado_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_custom_code',
				'title' => esc_html__( 'Custom Code', 'entre' )
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'        => 'custom_js',
				'type'        => 'textarea',
				'label'       => esc_html__( 'Custom JS', 'entre' ),
				'description' => esc_html__( 'Enter your custom Javascript here', 'entre' ),
				'parent'      => $panel_custom_code
			)
		);
		
		$panel_google_api = entre_mikado_add_admin_panel(
			array(
				'page'  => '',
				'name'  => 'panel_google_api',
				'title' => esc_html__( 'Google API', 'entre' )
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'name'        => 'google_maps_api_key',
				'type'        => 'text',
				'label'       => esc_html__( 'Google Maps Api Key', 'entre' ),
				'description' => esc_html__( 'Insert your Google Maps API key here. For instructions on how to create a Google Maps API key, please refer to our to our documentation.', 'entre' ),
				'parent'      => $panel_google_api
			)
		);
	}
	
	add_action( 'entre_mikado_options_map', 'entre_mikado_general_options_map', 1 );
}

if ( ! function_exists( 'entre_mikado_page_general_style' ) ) {
	/**
	 * Function that prints page general inline styles
	 */
	function entre_mikado_page_general_style( $style ) {
		$current_style = '';
		$page_id       = entre_mikado_get_page_id();
		$class_prefix  = entre_mikado_get_unique_page_class( $page_id );
		
		$boxed_background_style = array();
		
		$boxed_page_background_color = entre_mikado_get_meta_field_intersect( 'page_background_color_in_box', $page_id );
		if ( ! empty( $boxed_page_background_color ) ) {
			$boxed_background_style['background-color'] = $boxed_page_background_color;
		}
		
		$boxed_page_background_image = entre_mikado_get_meta_field_intersect( 'boxed_background_image', $page_id );
		if ( ! empty( $boxed_page_background_image ) ) {
			$boxed_background_style['background-image']    = 'url(' . esc_url( $boxed_page_background_image ) . ')';
			$boxed_background_style['background-position'] = 'center 0px';
			$boxed_background_style['background-repeat']   = 'no-repeat';
		}
		
		$boxed_page_background_pattern_image = entre_mikado_get_meta_field_intersect( 'boxed_pattern_background_image', $page_id );
		if ( ! empty( $boxed_page_background_pattern_image ) ) {
			$boxed_background_style['background-image']    = 'url(' . esc_url( $boxed_page_background_pattern_image ) . ')';
			$boxed_background_style['background-position'] = '0px 0px';
			$boxed_background_style['background-repeat']   = 'repeat';
		}
		
		$boxed_page_background_attachment = entre_mikado_get_meta_field_intersect( 'boxed_background_image_attachment', $page_id );
		if ( ! empty( $boxed_page_background_attachment ) ) {
			$boxed_background_style['background-attachment'] = $boxed_page_background_attachment;
		}
		
		$boxed_background_selector = $class_prefix . '.mkd-boxed .mkd-wrapper';
		
		if ( ! empty( $boxed_background_style ) ) {
			$current_style .= entre_mikado_dynamic_css( $boxed_background_selector, $boxed_background_style );
		}
		
		$paspartu_style     = array();
		$paspartu_res_style = array();
		$paspartu_res_start = '@media only screen and (max-width: 1024px) {';
		$paspartu_res_end   = '}';
		
		$paspartu_color = entre_mikado_get_meta_field_intersect( 'paspartu_color', $page_id );
		if ( ! empty( $paspartu_color ) ) {
			$paspartu_style['background-color'] = $paspartu_color;
		}
		
		$paspartu_width = entre_mikado_get_meta_field_intersect( 'paspartu_width', $page_id );
		if ( $paspartu_width !== '' ) {
			if ( entre_mikado_string_ends_with( $paspartu_width, '%' ) || entre_mikado_string_ends_with( $paspartu_width, 'px' ) ) {
				$paspartu_style['padding'] = $paspartu_width;
			} else {
				$paspartu_style['padding'] = $paspartu_width . 'px';
			}
		}
		
		$paspartu_selector = $class_prefix . '.mkd-paspartu-enabled .mkd-wrapper';
		
		if ( ! empty( $paspartu_style ) ) {
			$current_style .= entre_mikado_dynamic_css( $paspartu_selector, $paspartu_style );
		}
		
		$paspartu_responsive_width = entre_mikado_get_meta_field_intersect( 'paspartu_responsive_width', $page_id );
		if ( $paspartu_responsive_width !== '' ) {
			if ( entre_mikado_string_ends_with( $paspartu_responsive_width, '%' ) || entre_mikado_string_ends_with( $paspartu_responsive_width, 'px' ) ) {
				$paspartu_res_style['padding'] = $paspartu_responsive_width;
			} else {
				$paspartu_res_style['padding'] = $paspartu_responsive_width . 'px';
			}
		}
		
		if ( ! empty( $paspartu_res_style ) ) {
			$current_style .= $paspartu_res_start . entre_mikado_dynamic_css( $paspartu_selector, $paspartu_res_style ) . $paspartu_res_end;
		}
		
		$current_style = $current_style . $style;
		
		return $current_style;
	}
	
	add_filter( 'entre_mikado_add_page_custom_style', 'entre_mikado_page_general_style' );
}