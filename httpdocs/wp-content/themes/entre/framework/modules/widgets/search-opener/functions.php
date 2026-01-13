<?php

if ( ! function_exists( 'entre_mikado_register_search_opener_widget' ) ) {
	/**
	 * Function that register search opener widget
	 */
	function entre_mikado_register_search_opener_widget( $widgets ) {
		$widgets[] = 'EntreMikadoSearchOpener';
		
		return $widgets;
	}
	
	add_filter( 'entre_core_filter_register_widgets', 'entre_mikado_register_search_opener_widget' );
}