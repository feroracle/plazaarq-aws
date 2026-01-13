<?php

if ( ! function_exists( 'entre_mikado_register_icon_widget' ) ) {
	/**
	 * Function that register icon widget
	 */
	function entre_mikado_register_icon_widget( $widgets ) {
		$widgets[] = 'EntreMikadoIconWidget';
		
		return $widgets;
	}
	
	add_filter( 'entre_core_filter_register_widgets', 'entre_mikado_register_icon_widget' );
}