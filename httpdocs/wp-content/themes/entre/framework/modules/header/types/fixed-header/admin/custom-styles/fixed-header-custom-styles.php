<?php

if ( ! function_exists( 'entre_mikado_fixed_header_styles' ) ) {
	/**
	 * Generates styles for fixed haeder
	 */
	function entre_mikado_fixed_header_styles() {
		$background_color        = entre_mikado_options()->getOptionValue( 'fixed_header_background_color' );
		$background_transparency = entre_mikado_options()->getOptionValue( 'fixed_header_transparency' );
		$border_color            = entre_mikado_options()->getOptionValue( 'fixed_header_border_bottom_color' );
		
		$fixed_area_styles = array();
		if ( ! empty( $background_color ) ) {
			$fixed_header_background_color              = $background_color;
			$fixed_header_background_color_transparency = 1;
			
			if ( $background_transparency !== '' ) {
				$fixed_header_background_color_transparency = $background_transparency;
			}
			
			$fixed_area_styles['background-color'] = entre_mikado_rgba_color( $fixed_header_background_color, $fixed_header_background_color_transparency ) . '!important';
		}
		
		if ( empty( $background_color ) && $background_transparency !== '' ) {
			$fixed_header_background_color              = '#fff';
			$fixed_header_background_color_transparency = $background_transparency;
			
			$fixed_area_styles['background-color'] = entre_mikado_rgba_color( $fixed_header_background_color, $fixed_header_background_color_transparency ) . '!important';
		}
		
		$selector = array(
			'.mkd-page-header .mkd-fixed-wrapper.fixed .mkd-menu-area'
		);
		
		echo entre_mikado_dynamic_css( $selector, $fixed_area_styles );
		
		$fixed_area_holder_styles = array();
		
		if ( ! empty( $border_color ) ) {
			$fixed_area_holder_styles['border-bottom-color'] = $border_color;
		}
		
		$selector_holder = array(
			'.mkd-page-header .mkd-fixed-wrapper.fixed'
		);
		
		echo entre_mikado_dynamic_css( $selector_holder, $fixed_area_holder_styles );
		
		// fixed menu style
		
		$menu_item_styles = entre_mikado_get_typography_styles( 'fixed' );
		
		$menu_item_selector = array(
			'.mkd-fixed-wrapper.fixed .mkd-main-menu > ul > li > a'
		);
		
		echo entre_mikado_dynamic_css( $menu_item_selector, $menu_item_styles );
		
		
		$hover_color = entre_mikado_options()->getOptionValue( 'fixed_hovercolor' );
		
		$menu_item_hover_styles = array();
		if ( ! empty( $hover_color ) ) {
			$menu_item_hover_styles['color'] = $hover_color;
		}
		
		$menu_item_hover_selector = array(
			'.mkd-fixed-wrapper.fixed .mkd-main-menu > ul > li:hover > a',
			'.mkd-fixed-wrapper.fixed .mkd-main-menu > ul > li.mkd-active-item > a'
		);
		
		echo entre_mikado_dynamic_css( $menu_item_hover_selector, $menu_item_hover_styles );
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_fixed_header_styles' );
}