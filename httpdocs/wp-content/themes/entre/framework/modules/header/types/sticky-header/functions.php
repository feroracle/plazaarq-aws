<?php

if ( ! function_exists( 'entre_mikado_sticky_header_global_js_var' ) ) {
	function entre_mikado_sticky_header_global_js_var( $global_variables ) {
		$global_variables['mkdStickyHeaderHeight']             = entre_mikado_get_sticky_header_height();
		$global_variables['mkdStickyHeaderTransparencyHeight'] = entre_mikado_get_sticky_header_height_of_complete_transparency();
		
		return $global_variables;
	}
	
	add_filter( 'entre_mikado_js_global_variables', 'entre_mikado_sticky_header_global_js_var' );
}

if ( ! function_exists( 'entre_mikado_sticky_header_per_page_js_var' ) ) {
	function entre_mikado_sticky_header_per_page_js_var( $perPageVars ) {
		$perPageVars['mkdStickyScrollAmount'] = entre_mikado_get_sticky_scroll_amount();
		
		return $perPageVars;
	}
	
	add_filter( 'entre_mikado_per_page_js_vars', 'entre_mikado_sticky_header_per_page_js_var' );
}

if ( ! function_exists( 'entre_mikado_register_sticky_header_areas' ) ) {
	/**
	 * Registers widget area for sticky header
	 */
	function entre_mikado_register_sticky_header_areas() {
		register_sidebar(
			array(
				'id'            => 'mkd-sticky-right',
				'name'          => esc_html__( 'Sticky Header Widget Area', 'entre' ),
				'description'   => esc_html__( 'Widgets added here will appear on the right hand side from the sticky menu', 'entre' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s mkd-sticky-right">',
				'after_widget'  => '</div>'
			)
		);
	}
	
	add_action( 'widgets_init', 'entre_mikado_register_sticky_header_areas' );
}

if ( ! function_exists( 'entre_mikado_get_sticky_menu' ) ) {
	/**
	 * Loads sticky menu HTML
	 *
	 * @param string $additional_class addition class to pass to template
	 */
	function entre_mikado_get_sticky_menu( $additional_class = 'mkd-default-nav' ) {
		entre_mikado_get_module_template_part( 'templates/sticky-navigation', 'header/types/sticky-header', '', array( 'additional_class' => $additional_class ) );
	}
}

if ( ! function_exists( 'entre_mikado_get_sticky_header' ) ) {
	/**
	 * Loads sticky header behavior HTML
	 */
	function entre_mikado_get_sticky_header( $slug = '', $module = '' ) {
        $page_id             = entre_mikado_get_page_id();
		$sticky_in_grid      = entre_mikado_options()->getOptionValue( 'sticky_header_in_grid' ) == 'yes' ? true : false;
		$header_in_grid_meta = get_post_meta( $page_id, 'mkd_menu_area_in_grid_meta', true);
		
		if ( $header_in_grid_meta === 'yes' && ! $sticky_in_grid ) {
			$sticky_in_grid = true;
		} else if ( $header_in_grid_meta === 'no' && $sticky_in_grid ) {
			$sticky_in_grid = false;
		}
		
		$parameters = array(
			'hide_logo'             => entre_mikado_options()->getOptionValue( 'hide_logo' ) == 'yes' ? true : false,
			'sticky_header_in_grid' => $sticky_in_grid,
            'menu_area_position'    => entre_mikado_get_meta_field_intersect( 'set_menu_area_position', $page_id )

		);
		
		$module = ! empty( $module ) ? $module : 'header/types/sticky-header';
		
		entre_mikado_get_module_template_part( 'templates/sticky-header', $module, $slug, $parameters );
	}
}

if ( ! function_exists( 'entre_mikado_get_sticky_header_height' ) ) {
	/**
	 * Returns top sticky header height
	 *
	 * @return bool|int|void
	 */
	function entre_mikado_get_sticky_header_height() {
		$allow_sticky_behavior = true;
		$allow_sticky_behavior = apply_filters( 'entre_mikado_allow_sticky_header_behavior', $allow_sticky_behavior );
		$header_behaviour      = entre_mikado_get_meta_field_intersect( 'header_behaviour' );
		
		//sticky menu height, needed only for sticky header on scroll up
		if ( $allow_sticky_behavior && in_array( $header_behaviour, array( 'sticky-header-on-scroll-up' ) ) ) {
			$sticky_header_height = entre_mikado_filter_px( entre_mikado_options()->getOptionValue( 'sticky_header_height' ) );
			
			return $sticky_header_height !== '' ? intval( $sticky_header_height ) : 70;
		} else {
			return 0;
		}
	}
}

if ( ! function_exists( 'entre_mikado_get_sticky_header_height_of_complete_transparency' ) ) {
	/**
	 * Returns top sticky header height it is fully transparent. used in anchor logic
	 *
	 * @return bool|int|void
	 */
	function entre_mikado_get_sticky_header_height_of_complete_transparency() {
		$allow_sticky_behavior = true;
		$allow_sticky_behavior = apply_filters( 'entre_mikado_allow_sticky_header_behavior', $allow_sticky_behavior );
		
		if ( $allow_sticky_behavior ) {
			$stickyHeaderTransparent = entre_mikado_options()->getOptionValue( 'sticky_header_background_color' ) !== '' && entre_mikado_options()->getOptionValue( 'sticky_header_transparency' ) === '0';
			
			if ( $stickyHeaderTransparent ) {
				return 0;
			} else {
				$sticky_header_height = entre_mikado_filter_px( entre_mikado_options()->getOptionValue( 'sticky_header_height' ) );
				
				return $sticky_header_height !== '' ? intval( $sticky_header_height ) : 70;
			}
		} else {
			return 0;
		}
	}
}

if ( ! function_exists( 'entre_mikado_get_sticky_scroll_amount' ) ) {
	/**
	 * Returns top sticky scroll amount
	 *
	 * @return bool|int|void
	 */
	function entre_mikado_get_sticky_scroll_amount() {
		$allow_sticky_behavior = true;
		$allow_sticky_behavior = apply_filters( 'entre_mikado_allow_sticky_header_behavior', $allow_sticky_behavior );
		$header_behaviour      = entre_mikado_get_meta_field_intersect( 'header_behaviour' );
		
		//sticky menu scroll amount
		if ( $allow_sticky_behavior && in_array( $header_behaviour, array( 'sticky-header-on-scroll-up', 'sticky-header-on-scroll-down-up' ) ) ) {
			$sticky_scroll_amount = entre_mikado_filter_px( entre_mikado_get_meta_field_intersect( 'scroll_amount_for_sticky' ) );
			
			return $sticky_scroll_amount !== '' ? intval( $sticky_scroll_amount ) : 0;
		} else {
			return 0;
		}
	}
}