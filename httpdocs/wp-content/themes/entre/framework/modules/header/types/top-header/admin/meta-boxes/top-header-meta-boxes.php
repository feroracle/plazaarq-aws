<?php

if ( ! function_exists( 'entre_mikado_get_hide_dep_for_top_header_area_meta_boxes' ) ) {
	function entre_mikado_get_hide_dep_for_top_header_area_meta_boxes() {
		$hide_dep_options = apply_filters( 'entre_mikado_top_header_hide_meta_boxes', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'entre_mikado_header_top_area_meta_options_map' ) ) {
	function entre_mikado_header_top_area_meta_options_map( $header_meta_box ) {
		$hide_dep_options = entre_mikado_get_hide_dep_for_top_header_area_meta_boxes();
		
		$top_header_container = entre_mikado_add_admin_container_no_style(
			array(
				'type'            => 'container',
				'name'            => 'top_header_container',
				'parent'          => $header_meta_box,
				'hidden_property' => 'mkd_header_type_meta',
				'hidden_values'   => $hide_dep_options
			)
		);
		
		entre_mikado_add_admin_section_title(
			array(
				'parent' => $top_header_container,
				'name'   => 'top_area_style',
				'title'  => esc_html__( 'Top Area', 'entre' )
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_top_bar_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Header Top Bar', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will show header top bar area', 'entre' ),
				'parent'        => $top_header_container,
				'options'       => entre_mikado_get_yes_no_select_array(),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						''    => '#mkd_top_bar_container_no_style',
						'no'  => '#mkd_top_bar_container_no_style',
						'yes' => ''
					),
					'show'       => array(
						''    => '',
						'no'  => '',
						'yes' => '#mkd_top_bar_container_no_style'
					)
				)
			)
		);
		
		$top_bar_container = entre_mikado_add_admin_container_no_style(
			array(
				'name'            => 'top_bar_container_no_style',
				'parent'          => $top_header_container,
				'hidden_property' => 'mkd_top_bar_meta',
				'hidden_value'    => 'no',
				'hidden_values'   => array( '', 'no' )
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_top_bar_in_grid_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Top Bar In Grid', 'entre' ),
				'description'   => esc_html__( 'Set top bar content to be in grid', 'entre' ),
				'parent'        => $top_bar_container,
				'default_value' => '',
				'options'       => entre_mikado_get_yes_no_select_array()
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'   => 'mkd_top_bar_background_color_meta',
				'type'   => 'color',
				'label'  => esc_html__( 'Top Bar Background Color', 'entre' ),
				'parent' => $top_bar_container
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_top_bar_background_transparency_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Top Bar Background Color Transparency', 'entre' ),
				'description' => esc_html__( 'Set top bar background color transparenct. Value should be between 0 and 1', 'entre' ),
				'parent'      => $top_bar_container,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_top_bar_border_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Top Bar Border', 'entre' ),
				'description'   => esc_html__( 'Set border on top bar', 'entre' ),
				'parent'        => $top_bar_container,
				'default_value' => '',
				'options'       => entre_mikado_get_yes_no_select_array(),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						''    => '#mkd_top_bar_border_container',
						'no'  => '#mkd_top_bar_border_container',
						'yes' => ''
					),
					'show'       => array(
						''    => '',
						'no'  => '',
						'yes' => '#mkd_top_bar_border_container'
					)
				)
			)
		);
		
		$top_bar_border_container = entre_mikado_add_admin_container(
			array(
				'type'            => 'container',
				'name'            => 'top_bar_border_container',
				'parent'          => $top_bar_container,
				'hidden_property' => 'mkd_top_bar_border_meta',
				'hidden_value'    => 'no',
				'hidden_values'   => array( '', 'no' )
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_top_bar_border_color_meta',
				'type'        => 'color',
				'label'       => esc_html__( 'Border Color', 'entre' ),
				'description' => esc_html__( 'Choose color for top bar border', 'entre' ),
				'parent'      => $top_bar_border_container
			)
		);
	}
	
	add_action( 'entre_mikado_additional_header_area_meta_boxes_map', 'entre_mikado_header_top_area_meta_options_map', 10, 1 );
}