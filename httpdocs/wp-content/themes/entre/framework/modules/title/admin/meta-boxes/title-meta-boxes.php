<?php

if ( ! function_exists( 'entre_mikado_get_title_types_meta_boxes' ) ) {
	function entre_mikado_get_title_types_meta_boxes() {
		$title_type_options = apply_filters( 'entre_mikado_title_type_meta_boxes', $title_type_options = array( '' => esc_html__( 'Default', 'entre' ) ) );
		
		return $title_type_options;
	}
}

foreach ( glob( MIKADO_FRAMEWORK_MODULES_ROOT_DIR . '/title/types/*/admin/meta-boxes/*.php' ) as $meta_box_load ) {
	include_once $meta_box_load;
}

if ( ! function_exists( 'entre_mikado_map_title_meta' ) ) {
	function entre_mikado_map_title_meta() {
		$title_type_meta_boxes = entre_mikado_get_title_types_meta_boxes();
		
		$title_meta_box = entre_mikado_create_meta_box(
			array(
				'scope' => apply_filters( 'entre_mikado_set_scope_for_meta_boxes', array( 'page', 'post' ), 'title_meta' ),
				'title' => esc_html__( 'Title', 'entre' ),
				'name'  => 'title_meta'
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_show_title_area_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'entre' ),
				'description'   => esc_html__( 'Disabling this option will turn off page title area', 'entre' ),
				'parent'        => $title_meta_box,
				'options'       => entre_mikado_get_yes_no_select_array(),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						''    => '',
						'no'  => '#mkd_mkd_show_title_area_meta_container',
						'yes' => ''
					),
					'show'       => array(
						''    => '#mkd_mkd_show_title_area_meta_container',
						'no'  => '',
						'yes' => '#mkd_mkd_show_title_area_meta_container'
					)
				)
			)
		);
		
			$show_title_area_meta_container = entre_mikado_add_admin_container(
				array(
					'parent'          => $title_meta_box,
					'name'            => 'mkd_show_title_area_meta_container',
					'hidden_property' => 'mkd_show_title_area_meta',
					'hidden_value'    => 'no'
				)
			);
		
				entre_mikado_create_meta_box_field(
					array(
						'name'          => 'mkd_title_area_type_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Title Area Type', 'entre' ),
						'description'   => esc_html__( 'Choose title type', 'entre' ),
						'parent'        => $show_title_area_meta_container,
						'options'       => $title_type_meta_boxes
					)
				);
		
				entre_mikado_create_meta_box_field(
					array(
						'name'          => 'mkd_title_area_in_grid_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Title Area In Grid', 'entre' ),
						'description'   => esc_html__( 'Set title area content to be in grid', 'entre' ),
						'options'       => entre_mikado_get_yes_no_select_array(),
						'parent'        => $show_title_area_meta_container
					)
				);
		
				entre_mikado_create_meta_box_field(
					array(
						'name'        => 'mkd_title_area_height_meta',
						'type'        => 'text',
						'label'       => esc_html__( 'Height', 'entre' ),
						'description' => esc_html__( 'Set a height for Title Area', 'entre' ),
						'parent'      => $show_title_area_meta_container,
						'args'        => array(
							'col_width' => 2,
							'suffix'    => 'px'
						)
					)
				);
				
				entre_mikado_create_meta_box_field(
					array(
						'name'        => 'mkd_title_area_background_color_meta',
						'type'        => 'color',
						'label'       => esc_html__( 'Background Color', 'entre' ),
						'description' => esc_html__( 'Choose a background color for title area', 'entre' ),
						'parent'      => $show_title_area_meta_container
					)
				);
		
				entre_mikado_create_meta_box_field(
					array(
						'name'        => 'mkd_title_area_background_image_meta',
						'type'        => 'image',
						'label'       => esc_html__( 'Background Image', 'entre' ),
						'description' => esc_html__( 'Choose an Image for title area', 'entre' ),
						'parent'      => $show_title_area_meta_container
					)
				);
		
				entre_mikado_create_meta_box_field(
					array(
						'name'          => 'mkd_title_area_background_image_behavior_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Background Image Behavior', 'entre' ),
						'description'   => esc_html__( 'Choose title area background image behavior', 'entre' ),
						'parent'        => $show_title_area_meta_container,
						'options'       => array(
							''                    => esc_html__( 'Default', 'entre' ),
							'hide'                => esc_html__( 'Hide Image', 'entre' ),
							'responsive'          => esc_html__( 'Enable Responsive Image', 'entre' ),
							'responsive-disabled' => esc_html__( 'Disable Responsive Image', 'entre' ),
							'parallax'            => esc_html__( 'Enable Parallax Image', 'entre' ),
							'parallax-zoom-out'   => esc_html__( 'Enable Parallax With Zoom Out Image', 'entre' ),
							'parallax-disabled'   => esc_html__( 'Disable Parallax Image', 'entre' )
						)
					)
				);
				
				entre_mikado_create_meta_box_field(
					array(
						'name'          => 'mkd_title_area_vertical_alignment_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Vertical Alignment', 'entre' ),
						'description'   => esc_html__( 'Specify title area content vertical alignment', 'entre' ),
						'parent'        => $show_title_area_meta_container,
						'options'       => array(
							''              => esc_html__( 'Default', 'entre' ),
							'header_bottom' => esc_html__( 'From Bottom of Header', 'entre' ),
							'window_top'    => esc_html__( 'From Window Top', 'entre' )
						)
					)
				);
				
				entre_mikado_create_meta_box_field(
					array(
						'name'          => 'mkd_title_area_title_tag_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Title Tag', 'entre' ),
						'options'       => entre_mikado_get_title_tag( true ),
						'parent'        => $show_title_area_meta_container
					)
				);
				
				entre_mikado_create_meta_box_field(
					array(
						'name'        => 'mkd_title_text_color_meta',
						'type'        => 'color',
						'label'       => esc_html__( 'Title Color', 'entre' ),
						'description' => esc_html__( 'Choose a color for title text', 'entre' ),
						'parent'      => $show_title_area_meta_container
					)
				);
				
				entre_mikado_create_meta_box_field(
					array(
						'name'          => 'mkd_title_area_subtitle_meta',
						'type'          => 'text',
						'default_value' => '',
						'label'         => esc_html__( 'Subtitle Text', 'entre' ),
						'description'   => esc_html__( 'Enter your subtitle text', 'entre' ),
						'parent'        => $show_title_area_meta_container,
						'args'          => array(
							'col_width' => 6
						)
					)
				);
		
				entre_mikado_create_meta_box_field(
					array(
						'name'          => 'mkd_title_area_subtitle_tag_meta',
						'type'          => 'select',
						'default_value' => '',
						'label'         => esc_html__( 'Subtitle Tag', 'entre' ),
						'options'       => entre_mikado_get_title_tag( true, array( 'p' => 'p' ) ),
						'parent'        => $show_title_area_meta_container
					)
				);
				
				entre_mikado_create_meta_box_field(
					array(
						'name'        => 'mkd_subtitle_color_meta',
						'type'        => 'color',
						'label'       => esc_html__( 'Subtitle Color', 'entre' ),
						'description' => esc_html__( 'Choose a color for subtitle text', 'entre' ),
						'parent'      => $show_title_area_meta_container
					)
				);
		
		/***************** Additional Title Area Layout - start *****************/
		
		do_action( 'entre_mikado_additional_title_area_meta_boxes', $show_title_area_meta_container );
		
		/***************** Additional Title Area Layout - end *****************/
		
	}
	
	add_action( 'entre_mikado_meta_boxes_map', 'entre_mikado_map_title_meta', 60 );
}