<?php

if ( ! function_exists( 'entre_mikado_register_woocommerce_dropdown_cart_widget' ) ) {
	/**
	 * Function that register image gallery widget
	 */
	function entre_mikado_register_woocommerce_dropdown_cart_widget( $widgets ) {
		$widgets[] = 'EntreMikadoWoocommerceDropdownCart';
		
		return $widgets;
	}
    if( mkd_core_is_woocommerce_installed() ){
        add_filter( 'entre_core_filter_register_widgets', 'entre_mikado_register_woocommerce_dropdown_cart_widget' );
    }

}