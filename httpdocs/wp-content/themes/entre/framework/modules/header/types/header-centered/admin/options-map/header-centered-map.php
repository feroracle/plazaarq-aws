<?php

if ( ! function_exists( 'entre_mikado_get_hide_dep_for_header_centered_options' ) ) {
	function entre_mikado_get_hide_dep_for_header_centered_options() {
		$hide_dep_options = apply_filters( 'entre_mikado_header_centered_hide_global_option', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'entre_mikado_header_centered_map' ) ) {
	function entre_mikado_header_centered_map( $parent ) {
		$hide_dep_options = entre_mikado_get_hide_dep_for_header_centered_options();
		
		entre_mikado_add_admin_field(
			array(
				'parent'          => $parent,
				'type'            => 'text',
				'name'            => 'logo_wrapper_padding_header_centered',
				'default_value'   => '',
				'label'           => esc_html__( 'Logo Padding', 'entre' ),
				'description'     => esc_html__( 'Insert padding in format: 0px 0px 1px 0px', 'entre' ),
				'args'            => array(
					'col_width' => 3
				),
				'hidden_property' => 'header_type',
				'hidden_values'   => $hide_dep_options
			)
		);
	}
	
	add_action( 'entre_mikado_header_logo_area_additional_options', 'entre_mikado_header_centered_map' );
}