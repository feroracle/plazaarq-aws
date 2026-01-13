<?php

if ( ! function_exists( 'entre_mikado_sticky_header_styles' ) ) {
	/**
	 * Generates styles for sticky haeder
	 */
	function entre_mikado_sticky_header_styles() {
		$background_color        = entre_mikado_options()->getOptionValue( 'sticky_header_background_color' );
		$background_transparency = entre_mikado_options()->getOptionValue( 'sticky_header_transparency' );
		$border_color            = entre_mikado_options()->getOptionValue( 'sticky_header_border_color' );
		$header_height           = entre_mikado_options()->getOptionValue( 'sticky_header_height' );
		
		if ( ! empty( $background_color ) ) {
			$header_background_color              = $background_color;
			$header_background_color_transparency = 1;
			
			if ( $background_transparency !== '' ) {
				$header_background_color_transparency = $background_transparency;
			}
			
			echo entre_mikado_dynamic_css( '.mkd-page-header .mkd-sticky-header .mkd-sticky-holder', array( 'background-color' => entre_mikado_rgba_color( $header_background_color, $header_background_color_transparency ) ) );
		}
		
		if ( ! empty( $border_color ) ) {
			echo entre_mikado_dynamic_css( '.mkd-page-header .mkd-sticky-header .mkd-sticky-holder', array( 'border-color' => $border_color ) );
		}
		
		if ( ! empty( $header_height ) ) {
			$height = entre_mikado_filter_px( $header_height ) . 'px';
			
			echo entre_mikado_dynamic_css( '.mkd-page-header .mkd-sticky-header', array( 'height' => $height ) );
			echo entre_mikado_dynamic_css( '.mkd-page-header .mkd-sticky-header .mkd-logo-wrapper a', array( 'max-height' => $height ) );
		}
		
		// sticky menu style
		
		$menu_item_styles = entre_mikado_get_typography_styles( 'sticky' );
		
		$menu_item_selector = array(
			'.mkd-main-menu.mkd-sticky-nav > ul > li > a'
		);
		
		echo entre_mikado_dynamic_css( $menu_item_selector, $menu_item_styles );
		
		
		$hover_color = entre_mikado_options()->getOptionValue( 'sticky_hovercolor' );
		
		$menu_item_hover_styles = array();
		if ( ! empty( $hover_color ) ) {
			$menu_item_hover_styles['color'] = $hover_color;
		}
		
		$menu_item_hover_selector = array(
			'.mkd-main-menu.mkd-sticky-nav > ul > li:hover > a',
			'.mkd-main-menu.mkd-sticky-nav > ul > li.mkd-active-item > a'
		);
		
		echo entre_mikado_dynamic_css( $menu_item_hover_selector, $menu_item_hover_styles );
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_sticky_header_styles' );
}