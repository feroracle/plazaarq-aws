<?php

if ( ! function_exists( 'mkd_core_enqueue_scripts_for_image_tooltip_shortcodes' ) ) {
	/**
	 * Function that includes all necessary 3rd party scripts for this shortcode
	 */
	function mkd_core_enqueue_scripts_for_image_tooltip_shortcodes() {
		wp_enqueue_script( 'bootstrap-tooltip', MIKADO_CORE_SHORTCODES_URL_PATH . '/image-tooltip/assets/js/plugins/bootstrap-tooltip.js', array( 'jquery' ), false, true );
	}
	
	add_action( 'entre_mikado_enqueue_third_party_scripts', 'mkd_core_enqueue_scripts_for_image_tooltip_shortcodes' );
}

if ( ! function_exists( 'mkd_core_add_image_tooltip_shortcodes' ) ) {
	function mkd_core_add_image_tooltip_shortcodes( $shortcodes_class_name ) {
		$shortcodes = array(
			'MikadoCore\CPT\Shortcodes\ImageTooltip\ImageTooltip'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	add_filter( 'mkd_core_filter_add_vc_shortcode', 'mkd_core_add_image_tooltip_shortcodes' );
}