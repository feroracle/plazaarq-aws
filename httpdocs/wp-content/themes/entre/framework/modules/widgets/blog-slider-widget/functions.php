<?php

if ( ! function_exists( 'entre_mikado_register_blog_slider_widget' ) ) {
	/**
	 * Function that register blog list widget
	 */
	function entre_mikado_register_blog_slider_widget( $widgets ) {
		$widgets[] = 'EntreMikadoBlogSliderWidget';
		
		return $widgets;
	}
	
	add_filter( 'entre_core_filter_register_widgets', 'entre_mikado_register_blog_slider_widget' );
}