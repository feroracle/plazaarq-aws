<?php

if ( ! function_exists( 'entre_mikado_register_image_gallery_widget' ) ) {
	/**
	 * Function that register image gallery widget
	 */
	function entre_mikado_register_image_gallery_widget( $widgets ) {
		$widgets[] = 'EntreMikadoImageGalleryWidget';
		
		return $widgets;
	}
	
	add_filter( 'entre_core_filter_register_widgets', 'entre_mikado_register_image_gallery_widget' );
}