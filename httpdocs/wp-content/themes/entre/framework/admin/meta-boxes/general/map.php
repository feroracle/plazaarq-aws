<?php

if ( ! function_exists( 'entre_mikado_map_general_meta' ) ) {
	function entre_mikado_map_general_meta() {
		
		$general_meta_box = entre_mikado_create_meta_box(
			array(
				'scope' => apply_filters( 'entre_mikado_set_scope_for_meta_boxes', array( 'page', 'post' ), 'general_meta' ),
				'title' => esc_html__( 'General', 'entre' ),
				'name'  => 'general_meta'
			)
		);
		
		/***************** Slider Layout - begin **********************/
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_page_slider_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Slider Shortcode', 'entre' ),
				'description' => esc_html__( 'Paste your slider shortcode here', 'entre' ),
				'parent'      => $general_meta_box
			)
		);

        entre_mikado_create_meta_box_field(
            array(
                'name'          => 'mkd_uncovering_slider_section_meta',
                'type'          => 'yesno',
                'default_value' => 'no',
                'label'         => esc_html__( 'Uncovering Slider Section', 'entre' ),
                'description'   => esc_html__( 'This option only works when Slider Shortcode field is not empty', 'entre' ),
                'parent'        => $general_meta_box
            )
        );
		
		/***************** Slider Layout - begin **********************/
		
		/***************** Content Layout - begin **********************/
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_page_content_behind_header_meta',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Always put content behind header', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will put page content behind page header', 'entre' ),
				'parent'        => $general_meta_box
			)
		);
		
		$mkd_content_padding_group = entre_mikado_add_admin_group(
			array(
				'name'        => 'content_padding_group',
				'title'       => esc_html__( 'Content Style', 'entre' ),
				'description' => esc_html__( 'Define styles for Content area', 'entre' ),
				'parent'      => $general_meta_box
			)
		);
		
			$mkd_content_padding_row = entre_mikado_add_admin_row(
				array(
					'name'   => 'mkd_content_padding_row',
					'next'   => true,
					'parent' => $mkd_content_padding_group
				)
			);
		
				entre_mikado_create_meta_box_field(
					array(
						'name'   => 'mkd_page_content_top_padding',
						'type'   => 'textsimple',
						'label'  => esc_html__( 'Content Top Padding', 'entre' ),
						'parent' => $mkd_content_padding_row,
						'args'   => array(
							'suffix' => 'px'
						)
					)
				);
				
				entre_mikado_create_meta_box_field(
					array(
						'name'    => 'mkd_page_content_top_padding_mobile',
						'type'    => 'selectsimple',
						'label'   => esc_html__( 'Set this top padding for mobile header', 'entre' ),
						'parent'  => $mkd_content_padding_row,
						'options' => entre_mikado_get_yes_no_select_array( false )
					)
				);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_page_background_color_meta',
				'type'        => 'color',
				'label'       => esc_html__( 'Page Background Color', 'entre' ),
				'description' => esc_html__( 'Choose background color for page content', 'entre' ),
				'parent'      => $general_meta_box
			)
		);
		
		/***************** Content Layout - end **********************/
		
		/***************** Boxed Layout - begin **********************/
		
		entre_mikado_create_meta_box_field(
			array(
				'name'    => 'mkd_boxed_meta',
				'type'    => 'select',
				'label'   => esc_html__( 'Boxed Layout', 'entre' ),
				'parent'  => $general_meta_box,
				'options' => entre_mikado_get_yes_no_select_array(),
				'args'    => array(
					'dependence' => true,
					'hide'       => array(
						''    => '#mkd_boxed_container_meta',
						'no'  => '#mkd_boxed_container_meta',
						'yes' => ''
					),
					'show'       => array(
						''    => '',
						'no'  => '',
						'yes' => '#mkd_boxed_container_meta'
					)
				)
			)
		);
		
			$boxed_container_meta = entre_mikado_add_admin_container(
				array(
					'parent'          => $general_meta_box,
					'name'            => 'boxed_container_meta',
					'hidden_property' => 'mkd_boxed_meta',
					'hidden_values'   => array(
						'',
						'no'
					)
				)
			);
		
				entre_mikado_create_meta_box_field(
					array(
						'name'        => 'mkd_page_background_color_in_box_meta',
						'type'        => 'color',
						'label'       => esc_html__( 'Page Background Color', 'entre' ),
						'description' => esc_html__( 'Choose the page background color outside box', 'entre' ),
						'parent'      => $boxed_container_meta
					)
				);
				
				entre_mikado_create_meta_box_field(
					array(
						'name'        => 'mkd_boxed_background_image_meta',
						'type'        => 'image',
						'label'       => esc_html__( 'Background Image', 'entre' ),
						'description' => esc_html__( 'Choose an image to be displayed in background', 'entre' ),
						'parent'      => $boxed_container_meta
					)
				);
				
				entre_mikado_create_meta_box_field(
					array(
						'name'        => 'mkd_boxed_pattern_background_image_meta',
						'type'        => 'image',
						'label'       => esc_html__( 'Background Pattern', 'entre' ),
						'description' => esc_html__( 'Choose an image to be used as background pattern', 'entre' ),
						'parent'      => $boxed_container_meta
					)
				);
				
				entre_mikado_create_meta_box_field(
					array(
						'name'          => 'mkd_boxed_background_image_attachment_meta',
						'type'          => 'select',
						'default_value' => 'fixed',
						'label'         => esc_html__( 'Background Image Attachment', 'entre' ),
						'description'   => esc_html__( 'Choose background image attachment', 'entre' ),
						'parent'        => $boxed_container_meta,
						'options'       => array(
							''       => esc_html__( 'Default', 'entre' ),
							'fixed'  => esc_html__( 'Fixed', 'entre' ),
							'scroll' => esc_html__( 'Scroll', 'entre' )
						)
					)
				);
		
		/***************** Boxed Layout - end **********************/
		
		/***************** Passepartout Layout - begin **********************/
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_paspartu_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Passepartout', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will display passepartout around site content', 'entre' ),
				'parent'        => $general_meta_box,
				'options'       => entre_mikado_get_yes_no_select_array(),
				'args'    => array(
					'dependence'    => true,
					'hide'          => array(
						''    => '#mkd_mkd_paspartu_container_meta',
						'no'  => '#mkd_mkd_paspartu_container_meta',
						'yes' => ''
					),
					'show'          => array(
						''    => '',
						'no'  => '',
						'yes' => '#mkd_mkd_paspartu_container_meta'
					)
				)
			)
		);
		
			$paspartu_container_meta = entre_mikado_add_admin_container(
				array(
					'parent'          => $general_meta_box,
					'name'            => 'mkd_paspartu_container_meta',
					'hidden_property' => 'mkd_paspartu_meta',
					'hidden_values'   => array(
						'',
						'no'
					)
				)
			);
		
				entre_mikado_create_meta_box_field(
					array(
						'name'        => 'mkd_paspartu_color_meta',
						'type'        => 'color',
						'label'       => esc_html__( 'Passepartout Color', 'entre' ),
						'description' => esc_html__( 'Choose passepartout color, default value is #ffffff', 'entre' ),
						'parent'      => $paspartu_container_meta
					)
				);
				
				entre_mikado_create_meta_box_field(
					array(
						'name'        => 'mkd_paspartu_width_meta',
						'type'        => 'text',
						'label'       => esc_html__( 'Passepartout Size', 'entre' ),
						'description' => esc_html__( 'Enter size amount for passepartout', 'entre' ),
						'parent'      => $paspartu_container_meta,
						'args'        => array(
							'col_width' => 2,
							'suffix'    => 'px or %'
						)
					)
				);
		
				entre_mikado_create_meta_box_field(
					array(
						'name'        => 'mkd_paspartu_responsive_width_meta',
						'type'        => 'text',
						'label'       => esc_html__( 'Responsive Passepartout Size', 'entre' ),
						'description' => esc_html__( 'Enter size amount for passepartout for smaller screens (tablets and mobiles view)', 'entre' ),
						'parent'      => $paspartu_container_meta,
						'args'        => array(
							'col_width' => 2,
							'suffix'    => 'px or %'
						)
					)
				);
				
				entre_mikado_create_meta_box_field(
					array(
						'parent'        => $paspartu_container_meta,
						'type'          => 'select',
						'default_value' => '',
						'name'          => 'mkd_disable_top_paspartu_meta',
						'label'         => esc_html__( 'Disable Top Passepartout', 'entre' ),
						'options'       => entre_mikado_get_yes_no_select_array(),
					)
				);
		
		/***************** Passepartout Layout - end **********************/
		
		/***************** Content Width Layout - begin **********************/
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_initial_content_width_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Initial Width of Content', 'entre' ),
				'description'   => esc_html__( 'Choose the initial width of content which is in grid (Applies to pages set to "Default Template" and rows set to "In Grid")', 'entre' ),
				'parent'        => $general_meta_box,
				'options'       => array(
					''                => esc_html__( 'Default', 'entre' ),
					'mkd-grid-1100' => esc_html__( '1100px', 'entre' ),
					'mkd-grid-1300' => esc_html__( '1300px', 'entre' ),
					'mkd-grid-1200' => esc_html__( '1200px', 'entre' ),
					'mkd-grid-1000' => esc_html__( '1000px', 'entre' ),
					'mkd-grid-800'  => esc_html__( '800px', 'entre' )
				)
			)
		);
		
		/***************** Content Width Layout - end **********************/
		
		/***************** Smooth Page Transitions Layout - begin **********************/
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_smooth_page_transitions_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Smooth Page Transitions', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will perform a smooth transition between pages when clicking on links', 'entre' ),
				'parent'        => $general_meta_box,
				'options'       => entre_mikado_get_yes_no_select_array(),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						''    => '#mkd_page_transitions_container_meta',
						'no'  => '#mkd_page_transitions_container_meta',
						'yes' => ''
					),
					'show'       => array(
						''    => '',
						'no'  => '',
						'yes' => '#mkd_page_transitions_container_meta'
					)
				)
			)
		);
		
			$page_transitions_container_meta = entre_mikado_add_admin_container(
				array(
					'parent'          => $general_meta_box,
					'name'            => 'page_transitions_container_meta',
					'hidden_property' => 'mkd_smooth_page_transitions_meta',
					'hidden_values'   => array(
						'',
						'no'
					)
				)
			);
		
				entre_mikado_create_meta_box_field(
					array(
						'name'        => 'mkd_page_transition_preloader_meta',
						'type'        => 'select',
						'label'       => esc_html__( 'Enable Preloading Animation', 'entre' ),
						'description' => esc_html__( 'Enabling this option will display an animated preloader while the page content is loading', 'entre' ),
						'parent'      => $page_transitions_container_meta,
						'options'     => entre_mikado_get_yes_no_select_array(),
						'args'        => array(
							'dependence' => true,
							'hide'       => array(
								''    => '#mkd_page_transition_preloader_container_meta',
								'no'  => '#mkd_page_transition_preloader_container_meta',
								'yes' => ''
							),
							'show'       => array(
								''    => '',
								'no'  => '',
								'yes' => '#mkd_page_transition_preloader_container_meta'
							)
						)
					)
				);
				
				$page_transition_preloader_container_meta = entre_mikado_add_admin_container(
					array(
						'parent'          => $page_transitions_container_meta,
						'name'            => 'page_transition_preloader_container_meta',
						'hidden_property' => 'mkd_page_transition_preloader_meta',
						'hidden_values'   => array(
							'',
							'no'
						)
					)
				);
				
					entre_mikado_create_meta_box_field(
						array(
							'name'   => 'mkd_smooth_pt_bgnd_color_meta',
							'type'   => 'color',
							'label'  => esc_html__( 'Page Loader Background Color', 'entre' ),
							'parent' => $page_transition_preloader_container_meta
						)
					);
					
					$group_pt_spinner_animation_meta = entre_mikado_add_admin_group(
						array(
							'name'        => 'group_pt_spinner_animation_meta',
							'title'       => esc_html__( 'Loader Style', 'entre' ),
							'description' => esc_html__( 'Define styles for loader spinner animation', 'entre' ),
							'parent'      => $page_transition_preloader_container_meta
						)
					);
					
					$row_pt_spinner_animation_meta = entre_mikado_add_admin_row(
						array(
							'name'   => 'row_pt_spinner_animation_meta',
							'parent' => $group_pt_spinner_animation_meta
						)
					);
					
					entre_mikado_create_meta_box_field(
						array(
							'type'    => 'selectsimple',
							'name'    => 'mkd_smooth_pt_spinner_type_meta',
							'label'   => esc_html__( 'Spinner Type', 'entre' ),
							'parent'  => $row_pt_spinner_animation_meta,
							'options' => array(
								''                      => esc_html__( 'Default', 'entre' ),
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
					
					entre_mikado_create_meta_box_field(
						array(
							'type'   => 'colorsimple',
							'name'   => 'mkd_smooth_pt_spinner_color_meta',
							'label'  => esc_html__( 'Spinner Color', 'entre' ),
							'parent' => $row_pt_spinner_animation_meta
						)
					);
					
					entre_mikado_create_meta_box_field(
						array(
							'name'        => 'mkd_page_transition_fadeout_meta',
							'type'        => 'select',
							'label'       => esc_html__( 'Enable Fade Out Animation', 'entre' ),
							'description' => esc_html__( 'Enabling this option will turn on fade out animation when leaving page', 'entre' ),
							'options'     => entre_mikado_get_yes_no_select_array(),
							'parent'      => $page_transitions_container_meta
						
						)
					);
		
		/***************** Smooth Page Transitions Layout - end **********************/
		
		/***************** Comments Layout - begin **********************/
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_page_comments_meta',
				'type'        => 'select',
				'label'       => esc_html__( 'Show Comments', 'entre' ),
				'description' => esc_html__( 'Enabling this option will show comments on your page', 'entre' ),
				'parent'      => $general_meta_box,
				'options'     => entre_mikado_get_yes_no_select_array()
			)
		);
		
		/***************** Comments Layout - end **********************/
	}
	
	add_action( 'entre_mikado_meta_boxes_map', 'entre_mikado_map_general_meta', 10 );
}