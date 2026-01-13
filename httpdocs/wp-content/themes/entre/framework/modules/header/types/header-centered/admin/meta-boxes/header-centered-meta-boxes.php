<?php

if ( ! function_exists( 'entre_mikado_get_hide_dep_for_header_centered_meta_boxes' ) ) {
	function entre_mikado_get_hide_dep_for_header_centered_meta_boxes() {
		$hide_dep_options = apply_filters( 'entre_mikado_header_centered_hide_meta_boxes', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'entre_mikado_header_centered_meta_map' ) ) {
	function entre_mikado_header_centered_meta_map( $parent ) {
		$hide_dep_options = entre_mikado_get_hide_dep_for_header_centered_meta_boxes();
		
		entre_mikado_create_meta_box_field(
			array(
				'parent'          => $parent,
				'type'            => 'text',
				'name'            => 'mkd_logo_wrapper_padding_header_centered_meta',
				'default_value'   => '',
				'label'           => esc_html__( 'Logo Padding', 'entre' ),
				'description'     => esc_html__( 'Insert padding in format: 0px 0px 1px 0px', 'entre' ),
				'args'            => array(
					'col_width' => 3
				),
				'hidden_property' => 'mkd_header_type_meta',
				'hidden_values'   => $hide_dep_options
			)
		);
	}
	
	add_action( 'entre_mikado_header_logo_area_additional_meta_boxes_map', 'entre_mikado_header_centered_meta_map', 10, 1 );
}