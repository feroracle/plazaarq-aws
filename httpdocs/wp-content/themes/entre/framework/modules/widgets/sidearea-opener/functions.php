<?php

if ( ! function_exists( 'entre_mikado_register_sidearea_opener_widget' ) ) {
	/**
	 * Function that register sidearea opener widget
	 */
	function entre_mikado_register_sidearea_opener_widget( $widgets ) {
		$widgets[] = 'EntreMikadoSideAreaOpener';
		
		return $widgets;
	}
	
	add_filter( 'entre_core_filter_register_widgets', 'entre_mikado_register_sidearea_opener_widget' );
}