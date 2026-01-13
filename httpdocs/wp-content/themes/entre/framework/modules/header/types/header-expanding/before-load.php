<?php

if ( ! function_exists( 'entre_mikado_set_header_expanding_type_global_option' ) ) {
	/**
	 * This function set header type value for global header option map
	 */
	function entre_mikado_set_header_expanding_type_global_option( $header_types ) {
		$header_types['header-expanding'] = array(
			'image' =>  MIKADO_FRAMEWORK_HEADER_TYPES_ROOT . '/header-expanding/assets/img/header-expanding.png',
			'label' => esc_html__( 'Expanding', 'entre' )
		);
		
		return $header_types;
	}
	
	add_filter( 'entre_mikado_header_type_global_option', 'entre_mikado_set_header_expanding_type_global_option' );
}

if ( ! function_exists( 'entre_mikado_set_header_expanding_type_meta_boxes_option' ) ) {
	/**
	 * This function set header type value for header meta boxes map
	 */
	function entre_mikado_set_header_expanding_type_meta_boxes_option( $header_type_options ) {
		$header_type_options['header-expanding'] = esc_html__( 'Expanding', 'entre' );
		
		return $header_type_options;
	}
	
	add_filter( 'entre_mikado_header_type_meta_boxes', 'entre_mikado_set_header_expanding_type_meta_boxes_option' );
}

if ( ! function_exists( 'entre_mikado_set_show_dep_options_for_header_expanding' ) ) {
	/**
	 * This function set show container values when this header type is selected for header type global option
	 */
	function entre_mikado_set_show_dep_options_for_header_expanding( $show_dep_options ) {
		$show_containers   = array();
		$show_containers[] = '#mkd_header_behaviour';
		$show_containers[] = '#mkd_panel_main_menu';
		$show_containers[] = '#mkd_panel_sticky_header';
		$show_containers[] = '#mkd_panel_fixed_header';
		$show_containers[] = '#mkd_header_expanding_area_container';
		
		$show_containers = apply_filters( 'entre_mikado_show_dep_options_for_header_minimal', $show_containers );
		
		$show_dep_options['header-expanding'] = implode( ',', $show_containers );
		
		return $show_dep_options;
	}
	
	add_filter( 'entre_mikado_header_type_show_global_option', 'entre_mikado_set_show_dep_options_for_header_expanding' );
}

if ( ! function_exists( 'entre_mikado_set_hide_dep_options_for_header_expanding' ) ) {
	/**
	 * This function set hide container values when this header type is selected for header type global option
	 */
	function entre_mikado_set_hide_dep_options_for_header_expanding( $hide_dep_options ) {
		$hide_containers   = array();
		$hide_containers[] = '#mkd_panel_fullscreen_menu';
		$hide_containers[] = '#mkd_logo_area_container';
		
		$hide_containers = apply_filters( 'entre_mikado_hide_dep_options_for_header_expanding', $hide_containers );
		
		$hide_dep_options['header-expanding'] = implode( ',', $hide_containers );
		
		return $hide_dep_options;
	}
	
	add_filter( 'entre_mikado_header_type_hide_global_option', 'entre_mikado_set_hide_dep_options_for_header_expanding' );
}

if ( ! function_exists( 'entre_mikado_set_hide_dep_options_for_header_expanding_meta_boxes' ) ) {
	/**
	 * This function set hide container values when this header type is selected for header type meta boxes map
	 */
	function entre_mikado_set_hide_dep_options_for_header_expanding_meta_boxes( $hide_dep_options ) {
		$hide_containers   = array();
		$hide_containers[] = '#mkd_mkd_set_menu_area_position_meta';
		
		$hide_containers = apply_filters( 'entre_mikado_hide_dep_options_for_header_expanding_meta_boxes', $hide_containers );
		
		$hide_dep_options['header-expanding'] = implode( ',', $hide_containers );
		
		return $hide_dep_options;
	}
	
	add_filter( 'entre_mikado_header_type_hide_meta_boxes', 'entre_mikado_set_hide_dep_options_for_header_expanding_meta_boxes' );
}

if ( ! function_exists( 'entre_mikado_set_hide_dep_options_header_expanding' ) ) {
	/**
	 * This function is used to hide all containers/panels for admin options when this header type is selected
	 */
	function entre_mikado_set_hide_dep_options_header_expanding( $hide_dep_options ) {
		$hide_dep_options[] = 'header-expanding';
		
		return $hide_dep_options;
	}
	
	// header types panel options
	add_filter( 'entre_mikado_full_screen_menu_hide_global_option', 'entre_mikado_set_hide_dep_options_header_expanding' );
	add_filter( 'entre_mikado_header_standard_hide_global_option', 'entre_mikado_set_hide_dep_options_header_expanding' );
	add_filter( 'entre_mikado_header_vertical_hide_global_option', 'entre_mikado_set_hide_dep_options_header_expanding' );
	add_filter( 'entre_mikado_header_vertical_menu_hide_global_option', 'entre_mikado_set_hide_dep_options_header_expanding' );
	
	// header types panel meta boxes
	add_filter( 'entre_mikado_header_standard_hide_meta_boxes', 'entre_mikado_set_hide_dep_options_header_expanding' );
	add_filter( 'entre_mikado_header_vertical_hide_meta_boxes', 'entre_mikado_set_hide_dep_options_header_expanding' );
}