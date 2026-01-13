<?php

if ( ! function_exists( 'entre_mikado_breadcrumbs_title_area_typography_style' ) ) {
	function entre_mikado_breadcrumbs_title_area_typography_style() {
		
		$item_styles = entre_mikado_get_typography_styles( 'page_breadcrumb' );
		
		$item_selector = array(
			'.mkd-title-holder .mkd-title-wrapper .mkd-breadcrumbs'
		);
		
		echo entre_mikado_dynamic_css( $item_selector, $item_styles );
		
		
		$breadcrumb_hover_color = entre_mikado_options()->getOptionValue( 'page_breadcrumb_hovercolor' );
		
		$breadcrumb_hover_styles = array();
		if ( ! empty( $breadcrumb_hover_color ) ) {
			$breadcrumb_hover_styles['color'] = $breadcrumb_hover_color;
		}
		
		$breadcrumb_hover_selector = array(
			'.mkd-title-holder .mkd-title-wrapper .mkd-breadcrumbs a:hover'
		);
		
		echo entre_mikado_dynamic_css( $breadcrumb_hover_selector, $breadcrumb_hover_styles );
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_breadcrumbs_title_area_typography_style' );
}