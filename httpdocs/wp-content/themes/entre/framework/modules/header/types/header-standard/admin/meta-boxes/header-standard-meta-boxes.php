<?php

if ( ! function_exists( 'entre_mikado_get_hide_dep_for_header_standard_meta_boxes' ) ) {
	function entre_mikado_get_hide_dep_for_header_standard_meta_boxes() {
		$hide_dep_options = apply_filters( 'entre_mikado_header_standard_hide_meta_boxes', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'entre_mikado_header_standard_meta_map' ) ) {
	function entre_mikado_header_standard_meta_map( $parent ) {
		$hide_dep_options = entre_mikado_get_hide_dep_for_header_standard_meta_boxes();
		
		entre_mikado_create_meta_box_field(
			array(
				'parent'          => $parent,
				'type'            => 'select',
				'name'            => 'mkd_set_menu_area_position_meta',
				'default_value'   => '',
				'label'           => esc_html__( 'Choose Menu Area Position', 'entre' ),
				'description'     => esc_html__( 'Select menu area position in your header', 'entre' ),
				'options'         => array(
					''       => esc_html__( 'Default', 'entre' ),
					'left'   => esc_html__( 'Left', 'entre' ),
					'right'  => esc_html__( 'Right', 'entre' ),
					'center' => esc_html__( 'Center', 'entre' )
				),
				'hidden_property' => 'mkd_header_type_meta',
				'hidden_values'   => $hide_dep_options
			)
		);
	}
	
	add_action( 'entre_mikado_additional_header_area_meta_boxes_map', 'entre_mikado_header_standard_meta_map' );
}