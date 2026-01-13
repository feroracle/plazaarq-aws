<?php

if ( ! function_exists( 'entre_mikado_search_body_class' ) ) {
	/**
	 * Function that adds body classes for different search types
	 *
	 * @param $classes array original array of body classes
	 *
	 * @return array modified array of classes
	 */
	function entre_mikado_search_body_class( $classes ) {
		$classes[] = 'mkd-fullscreen-search';
		$classes[] = 'mkd-search-fade';
		
		return $classes;
	}
	
	add_filter( 'body_class', 'entre_mikado_search_body_class' );
}

if ( ! function_exists( 'entre_mikado_get_search' ) ) {
	/**
	 * Loads search HTML based on search type option.
	 */
	function entre_mikado_get_search() {
		entre_mikado_load_search_template();
	}
	
	add_action( 'entre_mikado_before_page_header', 'entre_mikado_get_search' );
}

if ( ! function_exists( 'entre_mikado_load_search_template' ) ) {
	/**
	 * Loads search HTML based on search type option.
	 */
	function entre_mikado_load_search_template() {
        entre_mikado_get_module_template_part( 'types/fullscreen/templates/fullscreen', 'search' );
	}
}