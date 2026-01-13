<?php

if ( ! function_exists( 'entre_mikado_get_separator_html' ) ) {
	/**
	 * Calls separator shortcode with given parameters and returns it's output
	 *
	 * @param $params
	 *
	 * @return mixed|string
	 */
	function entre_mikado_get_separator_html( $params ) {
		$separator_html = entre_mikado_execute_shortcode( 'mkd_separator', $params );
		$separator_html = str_replace( "\n", '', $separator_html );
		
		return $separator_html;
	}
}

if ( ! function_exists( 'mkd_core_add_separator_shortcodes' ) ) {
	function mkd_core_add_separator_shortcodes( $shortcodes_class_name ) {
		$shortcodes = array(
			'MikadoCore\CPT\Shortcodes\Separator\Separator'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	add_filter( 'mkd_core_filter_add_vc_shortcode', 'mkd_core_add_separator_shortcodes' );
}

if ( ! function_exists( 'mkd_core_set_separator_icon_class_name_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom icon class name for separator shortcode to set our icon for Visual Composer shortcodes panel
	 */
	function mkd_core_set_separator_icon_class_name_for_vc_shortcodes( $shortcodes_icon_class_array ) {
		$shortcodes_icon_class_array[] = '.icon-wpb-separator';
		
		return $shortcodes_icon_class_array;
	}
	
	add_filter( 'mkd_core_filter_add_vc_shortcodes_custom_icon_class', 'mkd_core_set_separator_icon_class_name_for_vc_shortcodes' );
}