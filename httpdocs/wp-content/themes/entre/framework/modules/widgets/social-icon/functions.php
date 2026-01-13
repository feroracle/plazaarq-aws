<?php

if ( ! function_exists( 'entre_mikado_register_social_icon_widget' ) ) {
	/**
	 * Function that register social icon widget
	 */
	function entre_mikado_register_social_icon_widget( $widgets ) {
		$widgets[] = 'EntreMikadoSocialIconWidget';
		
		return $widgets;
	}
	
	add_filter( 'entre_core_filter_register_widgets', 'entre_mikado_register_social_icon_widget' );
}