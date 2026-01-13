<?php

if ( ! function_exists( 'entre_mikado_get_hide_dep_for_header_logo_area_options' ) ) {
	function entre_mikado_get_hide_dep_for_header_logo_area_options() {
		$hide_dep_options = apply_filters( 'entre_mikado_header_logo_area_hide_global_option', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'entre_mikado_header_logo_area_options_map' ) ) {
	function entre_mikado_header_logo_area_options_map( $panel_header ) {
		$hide_dep_options = entre_mikado_get_hide_dep_for_header_logo_area_options();
		
		$logo_area_container = entre_mikado_add_admin_container_no_style(
			array(
				'parent'          => $panel_header,
				'name'            => 'logo_area_container',
				'hidden_property' => 'header_type',
				'hidden_values'   => $hide_dep_options
			)
		);
		
		entre_mikado_add_admin_section_title(
			array(
				'parent' => $logo_area_container,
				'name'   => 'logo_menu_area_title',
				'title'  => esc_html__( 'Logo Area', 'entre' )
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent'        => $logo_area_container,
				'type'          => 'yesno',
				'name'          => 'logo_area_in_grid',
				'default_value' => 'no',
				'label'         => esc_html__( 'Logo Area In Grid', 'entre' ),
				'description'   => esc_html__( 'Set menu area content to be in grid', 'entre' ),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_logo_area_in_grid_container'
				)
			)
		);
		
		$logo_area_in_grid_container = entre_mikado_add_admin_container(
			array(
				'parent'          => $logo_area_container,
				'name'            => 'logo_area_in_grid_container',
				'hidden_property' => 'logo_area_in_grid',
				'hidden_value'    => 'no'
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent'        => $logo_area_in_grid_container,
				'type'          => 'color',
				'name'          => 'logo_area_grid_background_color',
				'default_value' => '',
				'label'         => esc_html__( 'Grid Background Color', 'entre' ),
				'description'   => esc_html__( 'Set grid background color for logo area', 'entre' ),
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent'        => $logo_area_in_grid_container,
				'type'          => 'text',
				'name'          => 'logo_area_grid_background_transparency',
				'default_value' => '',
				'label'         => esc_html__( 'Grid Background Transparency', 'entre' ),
				'description'   => esc_html__( 'Set grid background transparency', 'entre' ),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent'        => $logo_area_in_grid_container,
				'type'          => 'yesno',
				'name'          => 'logo_area_in_grid_border',
				'default_value' => 'no',
				'label'         => esc_html__( 'Grid Area Border', 'entre' ),
				'description'   => esc_html__( 'Set border on grid area', 'entre' ),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_logo_area_in_grid_border_container'
				)
			)
		);
		
		$logo_area_in_grid_border_container = entre_mikado_add_admin_container(
			array(
				'parent'          => $logo_area_in_grid_container,
				'name'            => 'logo_area_in_grid_border_container',
				'hidden_property' => 'logo_area_in_grid_border',
				'hidden_value'    => 'no'
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent'        => $logo_area_in_grid_border_container,
				'type'          => 'color',
				'name'          => 'logo_area_in_grid_border_color',
				'default_value' => '',
				'label'         => esc_html__( 'Border Color', 'entre' ),
				'description'   => esc_html__( 'Set border color for grid area', 'entre' ),
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent'        => $logo_area_container,
				'type'          => 'color',
				'name'          => 'logo_area_background_color',
				'default_value' => '',
				'label'         => esc_html__( 'Background Color', 'entre' ),
				'description'   => esc_html__( 'Set background color for logo area', 'entre' )
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent'        => $logo_area_container,
				'type'          => 'text',
				'name'          => 'logo_area_background_transparency',
				'default_value' => '',
				'label'         => esc_html__( 'Background Transparency', 'entre' ),
				'description'   => esc_html__( 'Set background transparency for logo area', 'entre' ),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent'        => $logo_area_container,
				'type'          => 'yesno',
				'name'          => 'logo_area_border',
				'default_value' => 'no',
				'label'         => esc_html__( 'Logo Area Border', 'entre' ),
				'description'   => esc_html__( 'Set border on logo area', 'entre' ),
				'args'          => array(
					'dependence'             => true,
					'dependence_hide_on_yes' => '',
					'dependence_show_on_yes' => '#mkd_logo_area_border_container'
				)
			)
		);
		
		$logo_area_border_container = entre_mikado_add_admin_container(
			array(
				'parent'          => $logo_area_container,
				'name'            => 'logo_area_border_container',
				'hidden_property' => 'logo_area_border',
				'hidden_value'    => 'no'
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent'        => $logo_area_border_container,
				'type'          => 'color',
				'name'          => 'logo_area_border_color',
				'default_value' => '',
				'label'         => esc_html__( 'Border Color', 'entre' ),
				'description'   => esc_html__( 'Set border color for logo area', 'entre' ),
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent'        => $logo_area_container,
				'type'          => 'text',
				'name'          => 'logo_area_height',
				'default_value' => '',
				'label'         => esc_html__( 'Height', 'entre' ),
				'description'   => esc_html__( 'Enter logo area height (default is 115px)', 'entre' ),
				'args'          => array(
					'col_width' => 3,
					'suffix'    => 'px'
				)
			)
		);
		
		do_action( 'entre_mikado_header_logo_area_additional_options', $logo_area_container );
	}
	
	add_action( 'entre_mikado_header_logo_area_options_map', 'entre_mikado_header_logo_area_options_map', 10, 1 );
}