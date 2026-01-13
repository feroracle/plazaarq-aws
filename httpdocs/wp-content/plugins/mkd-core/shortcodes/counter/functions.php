<?php

if ( ! function_exists( 'mkd_core_enqueue_scripts_for_counter_shortcodes' ) ) {
	/**
	 * Function that includes all necessary 3rd party scripts for this shortcode
	 */
	function mkd_core_enqueue_scripts_for_counter_shortcodes() {
		wp_enqueue_script( 'counter', MIKADO_CORE_SHORTCODES_URL_PATH . '/counter/assets/js/plugins/counter.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'absoluteCounter', MIKADO_CORE_SHORTCODES_URL_PATH . '/counter/assets/js/plugins/absoluteCounter.min.js', array( 'jquery' ), false, true );
	}
	
	add_action( 'entre_mikado_enqueue_third_party_scripts', 'mkd_core_enqueue_scripts_for_counter_shortcodes' );
}

if ( ! function_exists( 'mkd_core_add_counter_shortcodes' ) ) {
	function mkd_core_add_counter_shortcodes( $shortcodes_class_name ) {
		$shortcodes = array(
			'MikadoCore\CPT\Shortcodes\Counter\Counter'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	add_filter( 'mkd_core_filter_add_vc_shortcode', 'mkd_core_add_counter_shortcodes' );
}

if ( ! function_exists( 'mkd_core_set_counter_icon_class_name_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom icon class name for counter shortcode to set our icon for Visual Composer shortcodes panel
	 */
	function mkd_core_set_counter_icon_class_name_for_vc_shortcodes( $shortcodes_icon_class_array ) {
		$shortcodes_icon_class_array[] = '.icon-wpb-counter';
		
		return $shortcodes_icon_class_array;
	}
	
	add_filter( 'mkd_core_filter_add_vc_shortcodes_custom_icon_class', 'mkd_core_set_counter_icon_class_name_for_vc_shortcodes' );
}