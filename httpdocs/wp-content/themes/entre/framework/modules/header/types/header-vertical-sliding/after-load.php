<?php

if ( ! function_exists( 'entre_mikado_disable_behaviors_for_header_vertical_sliding' ) ) {
	/**
	 * This function is used to disable sticky header functions that perform processing variables their used in js for this header type
	 */
	function entre_mikado_disable_behaviors_for_header_vertical_sliding( $allow_behavior ) {
		return false;
	}
	
	if ( entre_mikado_check_is_header_type_enabled( 'header-vertical-sliding', entre_mikado_get_page_id() ) ) {
		add_filter( 'entre_mikado_allow_sticky_header_behavior', 'entre_mikado_disable_behaviors_for_header_vertical_sliding' );
		add_filter( 'entre_mikado_allow_content_boxed_layout', 'entre_mikado_disable_behaviors_for_header_vertical_sliding' );
	}
}