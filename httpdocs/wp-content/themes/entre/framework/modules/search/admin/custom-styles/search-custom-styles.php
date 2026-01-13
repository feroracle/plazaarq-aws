<?php

if ( ! function_exists( 'entre_mikado_search_opener_icon_colors' ) ) {
	function entre_mikado_search_opener_icon_colors() {
		$icon_color       = entre_mikado_options()->getOptionValue( 'header_search_icon_color' );
		$icon_hover_color = entre_mikado_options()->getOptionValue( 'header_search_icon_hover_color' );
		
		if ( ! empty( $icon_color ) ) {
			echo entre_mikado_dynamic_css( '.mkd-search-opener', array(
				'color' => $icon_color
			) );
		}
		
		if ( ! empty( $icon_hover_color ) ) {
			echo entre_mikado_dynamic_css( '.mkd-search-opener:hover', array(
				'color' => $icon_hover_color
			) );
		}
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_search_opener_icon_colors' );
}

if ( ! function_exists( 'entre_mikado_search_opener_text_styles' ) ) {
	function entre_mikado_search_opener_text_styles() {
		$item_styles = entre_mikado_get_typography_styles( 'search_icon_text' );
		
		$item_selector = array(
			'.mkd-search-icon-text'
		);
		
		echo entre_mikado_dynamic_css( $item_selector, $item_styles );
		
		$text_hover_color = entre_mikado_options()->getOptionValue( 'search_icon_text_color_hover' );
		
		if ( ! empty( $text_hover_color ) ) {
			echo entre_mikado_dynamic_css( '.mkd-search-opener:hover .mkd-search-icon-text', array(
				'color' => $text_hover_color
			) );
		}
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_search_opener_text_styles' );
}