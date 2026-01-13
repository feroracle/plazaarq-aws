<?php

if ( ! function_exists( 'entre_mikado_register_separator_widget' ) ) {
	/**
	 * Function that register separator widget
	 */
	function entre_mikado_register_separator_widget( $widgets ) {
		$widgets[] = 'EntreMikadoSeparatorWidget';
		
		return $widgets;
	}
	
	add_filter( 'entre_core_filter_register_widgets', 'entre_mikado_register_separator_widget' );
}