<?php

if ( ! function_exists( 'entre_mikado_get_blog_holder_params' ) ) {
	/**
	 * Function that generates params for holders on blog templates
	 */
	function entre_mikado_get_blog_holder_params( $params ) {
		$params_list = array();
		
		$params_list['holder'] = 'mkd-container';
		$params_list['inner']  = 'mkd-container-inner clearfix';
		
		return $params_list;
	}
	
	add_filter( 'entre_mikado_blog_holder_params', 'entre_mikado_get_blog_holder_params' );
}

if ( ! function_exists( 'entre_mikado_get_blog_holder_classes' ) ) {
	/**
	 * Function that generates blog holder classes for blog page
	 */
	function entre_mikado_get_blog_holder_classes( $classes ) {
		$sidebar_classes   = array();
		$sidebar_classes[] = 'mkd-grid-medium-gutter';
		
		return implode( ' ', $sidebar_classes );
	}
	
	add_filter( 'entre_mikado_blog_holder_classes', 'entre_mikado_get_blog_holder_classes' );
}

if ( ! function_exists( 'entre_mikado_blog_part_params' ) ) {
	function entre_mikado_blog_part_params( $params ) {
		
		$part_params              = array();
		$part_params['title_tag'] = 'h2';
		$part_params['link_tag']  = 'h6';
		$part_params['quote_tag'] = 'h6';
		
		return array_merge( $params, $part_params );
	}
	
	add_filter( 'entre_mikado_blog_part_params', 'entre_mikado_blog_part_params' );
}