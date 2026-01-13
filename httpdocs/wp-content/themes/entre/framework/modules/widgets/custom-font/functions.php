<?php

if ( ! function_exists( 'entre_mikado_register_custom_font_widget' ) ) {
	/**
	 * Function that register custom font widget
	 */
	function entre_mikado_register_custom_font_widget( $widgets ) {
		$widgets[] = 'EntreMikadoCustomFontWidget';
		
		return $widgets;
	}
	
	add_filter( 'entre_core_filter_register_widgets', 'entre_mikado_register_custom_font_widget' );
}