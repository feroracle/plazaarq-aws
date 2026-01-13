<?php

if ( ! function_exists( 'entre_mikado_register_button_widget' ) ) {
	/**
	 * Function that register button widget
	 */
	function entre_mikado_register_button_widget( $widgets ) {
		$widgets[] = 'EntreMikadoButtonWidget';
		
		return $widgets;
	}
	
	add_filter( 'entre_core_filter_register_widgets', 'entre_mikado_register_button_widget' );
}