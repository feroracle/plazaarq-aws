<?php

if ( ! function_exists( 'entre_mikado_get_hide_dep_for_header_logo_area_meta_boxes' ) ) {
	function entre_mikado_get_hide_dep_for_header_logo_area_meta_boxes() {
		$hide_dep_options = apply_filters( 'entre_mikado_header_logo_area_hide_meta_boxes', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'entre_mikado_header_logo_area_meta_options_map' ) ) {
	function entre_mikado_header_logo_area_meta_options_map( $header_meta_box ) {
		$hide_dep_options = entre_mikado_get_hide_dep_for_header_logo_area_meta_boxes();
		
		$logo_area_container = entre_mikado_add_admin_container_no_style(
			array(
				'type'            => 'container',
				'name'            => 'logo_area_container',
				'parent'          => $header_meta_box,
				'hidden_property' => 'mkd_header_type_meta',
				'hidden_values'   => $hide_dep_options
			)
		);
		
		entre_mikado_add_admin_section_title(
			array(
				'parent' => $logo_area_container,
				'name'   => 'logo_area_style',
				'title'  => esc_html__( 'Logo Area Style', 'entre' )
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_disable_header_widget_logo_area_meta',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Disable Header Logo Area Widget', 'entre' ),
				'description'   => esc_html__( 'Enabling this option will hide widget area from the logo area', 'entre' ),
				'parent'        => $logo_area_container
			)
		);
		
		$entre_custom_sidebars = entre_mikado_get_custom_sidebars();
		if ( is_array( $entre_custom_sidebars ) && count( $entre_custom_sidebars ) > 0 ) {
			entre_mikado_create_meta_box_field(
				array(
					'name'        => 'mkd_custom_logo_area_sidebar_meta',
					'type'        => 'selectblank',
					'label'       => esc_html__( 'Choose Custom Widget Area for Logo Area', 'entre' ),
					'description' => esc_html__( 'Choose custom widget area to display in header logo area"', 'entre' ),
					'parent'      => $logo_area_container,
					'options'     => $entre_custom_sidebars
				)
			);
		}
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_logo_area_in_grid_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Logo Area In Grid', 'entre' ),
				'description'   => esc_html__( 'Set menu area content to be in grid', 'entre' ),
				'parent'        => $logo_area_container,
				'default_value' => '',
				'options'       => entre_mikado_get_yes_no_select_array(),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						''    => '#mkd_logo_area_in_grid_container',
						'no'  => '#mkd_logo_area_in_grid_container',
						'yes' => ''
					),
					'show'       => array(
						''    => '',
						'no'  => '',
						'yes' => '#mkd_logo_area_in_grid_container'
					)
				)
			)
		);
		
		$logo_area_in_grid_container = entre_mikado_add_admin_container(
			array(
				'type'            => 'container',
				'name'            => 'logo_area_in_grid_container',
				'parent'          => $logo_area_container,
				'hidden_property' => 'mkd_logo_area_in_grid_meta',
				'hidden_value'    => 'no',
				'hidden_values'   => array( '', 'no' )
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_logo_area_grid_background_color_meta',
				'type'        => 'color',
				'label'       => esc_html__( 'Grid Background Color', 'entre' ),
				'description' => esc_html__( 'Set grid background color for logo area', 'entre' ),
				'parent'      => $logo_area_in_grid_container
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_logo_area_grid_background_transparency_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Grid Background Transparency', 'entre' ),
				'description' => esc_html__( 'Set grid background transparency for logo area (0 = fully transparent, 1 = opaque)', 'entre' ),
				'parent'      => $logo_area_in_grid_container,
				'args'        => array(
					'col_width' => 2
				)
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_logo_area_in_grid_border_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Grid Area Border', 'entre' ),
				'description'   => esc_html__( 'Set border on grid logo area', 'entre' ),
				'parent'        => $logo_area_in_grid_container,
				'default_value' => '',
				'options'       => entre_mikado_get_yes_no_select_array(),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						''    => '#mkd_logo_area_in_grid_border_container',
						'no'  => '#mkd_logo_area_in_grid_border_container',
						'yes' => ''
					),
					'show'       => array(
						''    => '',
						'no'  => '',
						'yes' => '#mkd_logo_area_in_grid_border_container'
					)
				)
			)
		);
		
		$logo_area_in_grid_border_container = entre_mikado_add_admin_container(
			array(
				'type'            => 'container',
				'name'            => 'logo_area_in_grid_border_container',
				'parent'          => $logo_area_in_grid_container,
				'hidden_property' => 'mkd_logo_area_in_grid_border_meta',
				'hidden_value'    => 'no',
				'hidden_values'   => array( '', 'no' )
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_logo_area_in_grid_border_color_meta',
				'type'        => 'color',
				'label'       => esc_html__( 'Border Color', 'entre' ),
				'description' => esc_html__( 'Set border color for grid area', 'entre' ),
				'parent'      => $logo_area_in_grid_border_container
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_logo_area_background_color_meta',
				'type'        => 'color',
				'label'       => esc_html__( 'Background Color', 'entre' ),
				'description' => esc_html__( 'Choose a background color for logo area', 'entre' ),
				'parent'      => $logo_area_container
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_logo_area_background_transparency_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Transparency', 'entre' ),
				'description' => esc_html__( 'Choose a transparency for the logo area background color (0 = fully transparent, 1 = opaque)', 'entre' ),
				'parent'      => $logo_area_container,
				'args'        => array(
					'col_width' => 2
				)
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'          => 'mkd_logo_area_border_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Logo Area Border', 'entre' ),
				'description'   => esc_html__( 'Set border on logo area', 'entre' ),
				'parent'        => $logo_area_container,
				'default_value' => '',
				'options'       => entre_mikado_get_yes_no_select_array(),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						''    => '#mkd_logo_area_border_bottom_color_container',
						'no'  => '#mkd_logo_area_border_bottom_color_container',
						'yes' => ''
					),
					'show'       => array(
						''    => '',
						'no'  => '',
						'yes' => '#mkd_logo_area_border_bottom_color_container'
					)
				)
			)
		);
		
		$logo_area_border_bottom_color_container = entre_mikado_add_admin_container(
			array(
				'type'            => 'container',
				'name'            => 'logo_area_border_bottom_color_container',
				'parent'          => $logo_area_container,
				'hidden_property' => 'mkd_logo_area_border_meta',
				'hidden_value'    => 'no',
				'hidden_values'   => array( '', 'no' )
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_logo_area_border_color_meta',
				'type'        => 'color',
				'label'       => esc_html__( 'Border Color', 'entre' ),
				'description' => esc_html__( 'Choose color of header bottom border', 'entre' ),
				'parent'      => $logo_area_border_bottom_color_container
			)
		);
		
		do_action( 'entre_mikado_header_logo_area_additional_meta_boxes_map', $logo_area_container );
	}
	
	add_action( 'entre_mikado_header_logo_area_meta_boxes_map', 'entre_mikado_header_logo_area_meta_options_map', 10, 1 );
}