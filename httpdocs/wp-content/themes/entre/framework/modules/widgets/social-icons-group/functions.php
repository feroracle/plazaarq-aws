<?php

if ( ! function_exists( 'entre_mikado_register_social_icons_widget' ) ) {
	/**
	 * Function that register social icon widget
	 */
	function entre_mikado_register_social_icons_widget( $widgets ) {
		$widgets[] = 'EntreMikadoClassIconsGroupWidget';
		
		return $widgets;
	}
	
	add_filter( 'entre_core_filter_register_widgets', 'entre_mikado_register_social_icons_widget' );
}