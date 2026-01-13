<?php

if ( ! function_exists( 'entre_mikado_header_top_bar_styles' ) ) {
	/**
	 * Generates styles for header top bar
	 */
	function entre_mikado_header_top_bar_styles() {
		$top_header_height = entre_mikado_options()->getOptionValue( 'top_bar_height' );
		
		if ( ! empty( $top_header_height ) ) {
			echo entre_mikado_dynamic_css( '.mkd-top-bar', array( 'height' => entre_mikado_filter_px( $top_header_height ) . 'px' ) );
			echo entre_mikado_dynamic_css( '.mkd-top-bar .mkd-logo-wrapper a', array( 'max-height' => entre_mikado_filter_px( $top_header_height ) . 'px' ) );
		}
		
		echo entre_mikado_dynamic_css( '.mkd-header-box .mkd-top-bar-background', array( 'height' => entre_mikado_get_top_bar_background_height() . 'px' ) );
		
		if ( entre_mikado_options()->getOptionValue( 'top_bar_in_grid' ) == 'yes' ) {
			$top_bar_grid_selector                = '.mkd-top-bar .mkd-grid .mkd-vertical-align-containers';
			$top_bar_grid_styles                  = array();
			$top_bar_grid_background_color        = entre_mikado_options()->getOptionValue( 'top_bar_grid_background_color' );
			$top_bar_grid_background_transparency = entre_mikado_options()->getOptionValue( 'top_bar_grid_background_transparency' );
			
			if ( !empty($top_bar_grid_background_color) ) {
				$grid_background_color        = $top_bar_grid_background_color;
				$grid_background_transparency = 1;
				
				if ( $top_bar_grid_background_transparency !== '' ) {
					$grid_background_transparency = $top_bar_grid_background_transparency;
				}
				
				$grid_background_color                   = entre_mikado_rgba_color( $grid_background_color, $grid_background_transparency );
				$top_bar_grid_styles['background-color'] = $grid_background_color;
			}
			
			echo entre_mikado_dynamic_css( $top_bar_grid_selector, $top_bar_grid_styles );
		}
		
		$top_bar_styles   = array();
		$background_color = entre_mikado_options()->getOptionValue( 'top_bar_background_color' );
		$border_color     = entre_mikado_options()->getOptionValue( 'top_bar_border_color' );
		
		if ( $background_color !== '' ) {
			$background_transparency = 1;
			if ( entre_mikado_options()->getOptionValue( 'top_bar_background_transparency' ) !== '' ) {
				$background_transparency = entre_mikado_options()->getOptionValue( 'top_bar_background_transparency' );
			}
			
			$background_color                   = entre_mikado_rgba_color( $background_color, $background_transparency );
			$top_bar_styles['background-color'] = $background_color;
			
			echo entre_mikado_dynamic_css( '.mkd-header-box .mkd-top-bar-background', array( 'background-color' => $background_color ) );
		}
		
		if ( entre_mikado_options()->getOptionValue( 'top_bar_border' ) == 'yes' && $border_color != '' ) {
			$top_bar_styles['border-bottom'] = '1px solid ' . $border_color;
		}
		
		echo entre_mikado_dynamic_css( '.mkd-top-bar', $top_bar_styles );
	}
	
	add_action( 'entre_mikado_style_dynamic', 'entre_mikado_header_top_bar_styles' );
}