<?php

if ( ! function_exists( 'entre_mikado_footer_top_general_styles' ) ) {
	/**
	 * Generates general custom styles for footer top area
	 */
	function entre_mikado_footer_top_general_styles() {
		$item_styles      = array();
		$background_color = entre_mikado_options()->getOptionValue( 'footer_top_background_color' );
		
		if ( ! empty( $background_color ) ) {
			$item_styles['background-color'] = $background_color;
		}
		
		echo entre_mikado_dynamic_css( '.mkd-page-footer .mkd-footer-top-holder', $item_styles );
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_footer_top_general_styles' );
}

if ( ! function_exists( 'entre_mikado_footer_bottom_general_styles' ) ) {
	/**
	 * Generates general custom styles for footer bottom area
	 */
	function entre_mikado_footer_bottom_general_styles() {
		$item_styles      = array();
		$background_color = entre_mikado_options()->getOptionValue( 'footer_bottom_background_color' );
		
		if ( ! empty( $background_color ) ) {
			$item_styles['background-color'] = $background_color;
		}
		
		echo entre_mikado_dynamic_css( '.mkd-page-footer .mkd-footer-bottom-holder', $item_styles );
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_footer_bottom_general_styles' );
}