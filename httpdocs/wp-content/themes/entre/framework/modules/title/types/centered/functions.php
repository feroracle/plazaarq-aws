<?php

if ( ! function_exists( 'entre_mikado_set_title_centered_type_for_options' ) ) {
	/**
	 * This function set centered title type value for title options map and meta boxes
	 */
	function entre_mikado_set_title_centered_type_for_options( $type ) {
		$type['centered'] = esc_html__( 'Centered', 'entre' );
		
		return $type;
	}
	
	add_filter( 'entre_mikado_title_type_global_option', 'entre_mikado_set_title_centered_type_for_options' );
	add_filter( 'entre_mikado_title_type_meta_boxes', 'entre_mikado_set_title_centered_type_for_options' );
}