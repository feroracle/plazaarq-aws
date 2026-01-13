<?php

foreach ( glob( MIKADO_FRAMEWORK_MODULES_ROOT_DIR . '/title/types/*/admin/custom-styles/*.php' ) as $options_load ) {
	include_once $options_load;
}

if ( ! function_exists( 'entre_mikado_title_area_typography_style' ) ) {
	function entre_mikado_title_area_typography_style() {
		
		// title default/small style
		
		$item_styles = entre_mikado_get_typography_styles( 'page_title' );
		
		$item_selector = array(
			'.mkd-title-holder .mkd-title-wrapper .mkd-page-title'
		);
		
		echo entre_mikado_dynamic_css( $item_selector, $item_styles );
		
		// subtitle style
		
		$item_styles = entre_mikado_get_typography_styles( 'page_subtitle' );
		
		$item_selector = array(
			'.mkd-title-holder .mkd-title-wrapper .mkd-page-subtitle'
		);
		
		echo entre_mikado_dynamic_css( $item_selector, $item_styles );
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_title_area_typography_style' );
}