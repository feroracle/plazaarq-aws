<?php

if ( ! function_exists( 'entre_mikado_register_blog_list_widget' ) ) {
	/**
	 * Function that register blog list widget
	 */
	function entre_mikado_register_blog_list_widget( $widgets ) {
		$widgets[] = 'EntreMikadoBlogListWidget';
		
		return $widgets;
	}
	
	add_filter( 'entre_core_filter_register_widgets', 'entre_mikado_register_blog_list_widget' );
}