<?php

if ( ! function_exists( 'entre_mikado_add_product_info_shortcode' ) ) {
	function entre_mikado_add_product_info_shortcode( $shortcodes_class_name ) {
		$shortcodes = array(
			'MikadoCore\CPT\Shortcodes\ProductInfo\ProductInfo',
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	if ( entre_mikado_core_plugin_installed() ) {
		add_filter( 'mkd_core_filter_add_vc_shortcode', 'entre_mikado_add_product_info_shortcode' );
	}
}

if ( ! function_exists( 'entre_mikado_add_product_info_into_shortcodes_list' ) ) {
	function entre_mikado_add_product_info_into_shortcodes_list( $woocommerce_shortcodes ) {
		$woocommerce_shortcodes[] = 'mkd_product_info';
		
		return $woocommerce_shortcodes;
	}
	
	add_filter( 'entre_mikado_woocommerce_shortcodes_list', 'entre_mikado_add_product_info_into_shortcodes_list' );
}