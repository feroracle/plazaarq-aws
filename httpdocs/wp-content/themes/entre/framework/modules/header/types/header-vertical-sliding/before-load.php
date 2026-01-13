<?php

if ( ! function_exists( 'entre_mikado_set_header_vertical_sliding_type_global_option' ) ) {
	/**
	 * This function set header type value for global header option map
	 */
	function entre_mikado_set_header_vertical_sliding_type_global_option( $header_types ) {
		$header_types['header-vertical-sliding'] = array(
			'image' => MIKADO_FRAMEWORK_HEADER_TYPES_ROOT . '/header-vertical-sliding/assets/img/header-vertical-sliding.png',
			'label' => esc_html__( 'Vertical - Sliding', 'entre' )
		);
		
		return $header_types;
	}
	
	add_filter( 'entre_mikado_header_type_global_option', 'entre_mikado_set_header_vertical_sliding_type_global_option' );
}

if ( ! function_exists( 'entre_mikado_set_header_vertical_sliding_type_meta_boxes_option' ) ) {
	/**
	 * This function set header type value for header meta boxes map
	 */
	function entre_mikado_set_header_vertical_sliding_type_meta_boxes_option( $header_type_options ) {
		$header_type_options['header-vertical-sliding'] = esc_html__( 'Vertical - Sliding', 'entre' );
		
		return $header_type_options;
	}
	
	add_filter( 'entre_mikado_header_type_meta_boxes', 'entre_mikado_set_header_vertical_sliding_type_meta_boxes_option' );
}

if ( ! function_exists( 'entre_mikado_set_show_dep_options_for_header_vertical_sliding' ) ) {
	/**
	 * This function set show container values when this header type is selected for header type global option
	 */
	function entre_mikado_set_show_dep_options_for_header_vertical_sliding( $show_dep_options ) {
		$show_containers   = array();
		$show_containers[] = '#mkd_header_vertical_area_container';
		$show_containers[] = '#mkd_panel_vertical_main_menu';
		
		$show_containers = apply_filters( 'entre_mikado_show_dep_options_for_header_vertical_sliding', $show_containers );
		
		$show_dep_options['header-vertical-sliding'] = implode( ',', $show_containers );
		
		return $show_dep_options;
	}
	
	add_filter( 'entre_mikado_header_type_show_global_option', 'entre_mikado_set_show_dep_options_for_header_vertical_sliding' );
}

if ( ! function_exists( 'entre_mikado_set_hide_dep_options_for_header_vertical_sliding' ) ) {
	/**
	 * This function set hide container values when this header type is selected for header type global option
	 */
	function entre_mikado_set_hide_dep_options_for_header_vertical_sliding( $hide_dep_options ) {
		$hide_containers   = array();
		$hide_containers[] = '#mkd_header_behaviour';
		$hide_containers[] = '#mkd_menu_area_container';
		$hide_containers[] = '#mkd_logo_area_container';
		$hide_containers[] = '#mkd_panel_fullscreen_menu';
		$hide_containers[] = '#mkd_panel_main_menu';
		$hide_containers[] = '#mkd_panel_sticky_header';
		$hide_containers[] = '#mkd_panel_fixed_header';
		
		$hide_containers = apply_filters( 'entre_mikado_hide_dep_options_for_header_vertical_sliding', $hide_containers );
		
		$hide_dep_options['header-vertical-sliding'] = implode( ',', $hide_containers );
		
		return $hide_dep_options;
	}
	
	add_filter( 'entre_mikado_header_type_hide_global_option', 'entre_mikado_set_hide_dep_options_for_header_vertical_sliding' );
}

if ( ! function_exists( 'entre_mikado_set_show_dep_options_for_header_vertical_sliding_meta_boxes' ) ) {
	/**
	 * This function set show container values when this header type is selected for header type meta boxes map
	 */
	function entre_mikado_set_show_dep_options_for_header_vertical_sliding_meta_boxes( $show_dep_options ) {
		$show_containers   = array();
		$show_containers[] = '#mkd_header_vertical_area_container';
		
		$show_containers = apply_filters( 'entre_mikado_show_dep_options_for_header_vertical_sliding_meta_boxes', $show_containers );
		
		$show_dep_options['header-vertical-sliding'] = implode( ',', $show_containers );
		
		return $show_dep_options;
	}
	
	add_filter( 'entre_mikado_header_type_show_meta_boxes', 'entre_mikado_set_show_dep_options_for_header_vertical_sliding_meta_boxes' );
}

if ( ! function_exists( 'entre_mikado_set_hide_dep_options_for_header_vertical_sliding_meta_boxes' ) ) {
	/**
	 * This function set hide container values when this header type is selected for header type meta boxes map
	 */
	function entre_mikado_set_hide_dep_options_for_header_vertical_sliding_meta_boxes( $hide_dep_options ) {
		$hide_containers   = array();
		$hide_containers[] = '#mkd_logo_area_container';
		$hide_containers[] = '#mkd_menu_area_container';
		
		$hide_containers = apply_filters( 'entre_mikado_hide_dep_options_for_header_vertical_sliding_meta_boxes', $hide_containers );
		
		$hide_dep_options['header-vertical-sliding'] = implode( ',', $hide_containers );
		
		return $hide_dep_options;
	}
	
	add_filter( 'entre_mikado_header_type_hide_meta_boxes', 'entre_mikado_set_hide_dep_options_for_header_vertical_sliding_meta_boxes' );
}

if ( ! function_exists( 'entre_mikado_set_hide_dep_options_header_vertical_sliding' ) ) {
	/**
	 * This function is used to hide all containers/panels for admin options when this header type is selected
	 */
	function entre_mikado_set_hide_dep_options_header_vertical_sliding( $hide_dep_options ) {
		$hide_dep_options[] = 'header-vertical-sliding';
		
		return $hide_dep_options;
	}
	
	// header global panel options
	add_filter( 'entre_mikado_header_logo_area_hide_global_option', 'entre_mikado_set_hide_dep_options_header_vertical_sliding' );
	add_filter( 'entre_mikado_header_menu_area_hide_global_option', 'entre_mikado_set_hide_dep_options_header_vertical_sliding' );
	add_filter( 'entre_mikado_header_main_menu_hide_global_option', 'entre_mikado_set_hide_dep_options_header_vertical_sliding' );
	add_filter( 'entre_mikado_top_header_hide_global_option', 'entre_mikado_set_hide_dep_options_header_vertical_sliding' );
	
	// header global panel meta boxes
	add_filter( 'entre_mikado_header_logo_area_hide_meta_boxes', 'entre_mikado_set_hide_dep_options_header_vertical_sliding' );
	add_filter( 'entre_mikado_header_menu_area_hide_meta_boxes', 'entre_mikado_set_hide_dep_options_header_vertical_sliding' );
	add_filter( 'entre_mikado_top_header_hide_meta_boxes', 'entre_mikado_set_hide_dep_options_header_vertical_sliding' );
	
	// header behavior panel options
	add_filter( 'entre_mikado_header_behavior_hide_global_option', 'entre_mikado_set_hide_dep_options_header_vertical_sliding' );
	add_filter( 'entre_mikado_fixed_header_hide_global_option', 'entre_mikado_set_hide_dep_options_header_vertical_sliding' );
	add_filter( 'entre_mikado_sticky_header_hide_global_option', 'entre_mikado_set_hide_dep_options_header_vertical_sliding' );
	
	// header behavior panel meta boxes
	add_filter( 'entre_mikado_header_behavior_hide_meta_boxes', 'entre_mikado_set_hide_dep_options_header_vertical_sliding' );
	
	// header types panel options
	add_filter( 'entre_mikado_full_screen_menu_hide_global_option', 'entre_mikado_set_hide_dep_options_header_vertical_sliding' );
	add_filter( 'entre_mikado_header_centered_hide_global_option', 'entre_mikado_set_hide_dep_options_header_vertical_sliding' );
	add_filter( 'entre_mikado_header_standard_hide_global_option', 'entre_mikado_set_hide_dep_options_header_vertical_sliding' );
	
	// header types panel meta boxes
	add_filter( 'entre_mikado_header_centered_hide_meta_boxes', 'entre_mikado_set_hide_dep_options_header_vertical_sliding' );
	add_filter( 'entre_mikado_header_standard_hide_meta_boxes', 'entre_mikado_set_hide_dep_options_header_vertical_sliding' );
}