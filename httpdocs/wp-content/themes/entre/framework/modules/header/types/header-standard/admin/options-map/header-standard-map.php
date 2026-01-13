<?php

if ( ! function_exists( 'entre_mikado_get_hide_dep_for_header_standard_options' ) ) {
	function entre_mikado_get_hide_dep_for_header_standard_options() {
		$hide_dep_options = apply_filters( 'entre_mikado_header_standard_hide_global_option', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'entre_mikado_header_standard_map' ) ) {
	function entre_mikado_header_standard_map( $parent ) {
		$hide_dep_options = entre_mikado_get_hide_dep_for_header_standard_options();
		
		entre_mikado_add_admin_field(
			array(
				'parent'          => $parent,
				'type'            => 'select',
				'name'            => 'set_menu_area_position',
				'default_value'   => 'right',
				'label'           => esc_html__( 'Choose Menu Area Position', 'entre' ),
				'description'     => esc_html__( 'Select menu area position in your header', 'entre' ),
				'options'         => array(
					'right'  => esc_html__( 'Right', 'entre' ),
					'left'   => esc_html__( 'Left', 'entre' ),
					'center' => esc_html__( 'Center', 'entre' )
				),
				'hidden_property' => 'header_type',
				'hidden_values'   => $hide_dep_options
			)
		);
	}
	
	add_action( 'entre_mikado_additional_header_menu_area_options_map', 'entre_mikado_header_standard_map' );
}