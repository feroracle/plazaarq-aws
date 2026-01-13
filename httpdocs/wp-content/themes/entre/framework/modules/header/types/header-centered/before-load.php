<?php

if ( ! function_exists( 'entre_mikado_set_header_centered_type_global_option' ) ) {
	/**
	 * This function set header type value for global header option map
	 */
	function entre_mikado_set_header_centered_type_global_option( $header_types ) {
		$header_types['header-centered'] = array(
			'image' => MIKADO_FRAMEWORK_HEADER_TYPES_ROOT . '/header-centered/assets/img/header-centered.png',
			'label' => esc_html__( 'Centered', 'entre' )
		);
		
		return $header_types;
	}
	
	add_filter( 'entre_mikado_header_type_global_option', 'entre_mikado_set_header_centered_type_global_option' );
}

if ( ! function_exists( 'entre_mikado_set_header_centered_type_meta_boxes_option' ) ) {
	/**
	 * This function set header type value for header meta boxes map
	 */
	function entre_mikado_set_header_centered_type_meta_boxes_option( $header_type_options ) {
		$header_type_options['header-centered'] = esc_html__( 'Centered', 'entre' );
		
		return $header_type_options;
	}
	
	add_filter( 'entre_mikado_header_type_meta_boxes', 'entre_mikado_set_header_centered_type_meta_boxes_option' );
}

if ( ! function_exists( 'entre_mikado_set_show_dep_options_for_header_centered' ) ) {
	/**
	 * This function set show container values when this header type is selected for header type global option
	 */
	function entre_mikado_set_show_dep_options_for_header_centered( $show_dep_options ) {
		$show_containers   = array();
		$show_containers[] = '#mkd_header_behaviour';
		$show_containers[] = '#mkd_menu_area_container';
		$show_containers[] = '#mkd_logo_area_container';
		$show_containers[] = '#mkd_logo_wrapper_padding_header_centered';
		$show_containers[] = '#mkd_panel_main_menu';
		$show_containers[] = '#mkd_panel_sticky_header';
		$show_containers[] = '#mkd_panel_fixed_header';
		
		$show_containers = apply_filters( 'entre_mikado_show_dep_options_for_header_centered', $show_containers );
		
		$show_dep_options['header-centered'] = implode( ',', $show_containers );
		
		return $show_dep_options;
	}
	
	add_filter( 'entre_mikado_header_type_show_global_option', 'entre_mikado_set_show_dep_options_for_header_centered' );
}

if ( ! function_exists( 'entre_mikado_set_hide_dep_options_for_header_centered' ) ) {
	/**
	 * This function set hide container values when this header type is selected for header type global option
	 */
	function entre_mikado_set_hide_dep_options_for_header_centered( $hide_dep_options ) {
		$hide_containers   = array();
		$hide_containers[] = '#mkd_panel_fullscreen_menu';
		
		$hide_containers = apply_filters( 'entre_mikado_hide_dep_options_for_header_centered', $hide_containers );
		
		$hide_dep_options['header-centered'] = implode( ',', $hide_containers );
		
		return $hide_dep_options;
	}
	
	add_filter( 'entre_mikado_header_type_hide_global_option', 'entre_mikado_set_hide_dep_options_for_header_centered' );
}

if ( ! function_exists( 'entre_mikado_set_show_dep_options_for_header_centered_meta_boxes' ) ) {
	/**
	 * This function set show container values when this header type is selected for header type meta boxes map
	 */
	function entre_mikado_set_show_dep_options_for_header_centered_meta_boxes( $show_dep_options ) {
		$show_containers   = array();
		$show_containers[] = '#mkd_logo_area_container';
		$show_containers[] = '#mkd_menu_area_container';
		$show_containers[] = '#mkd_logo_wrapper_padding_header_centered';
		
		$show_containers = apply_filters( 'entre_mikado_show_dep_options_for_header_centered_meta_boxes', $show_containers );
		
		$show_dep_options['header-centered'] = implode( ',', $show_containers );
		
		return $show_dep_options;
	}
	
	add_filter( 'entre_mikado_header_type_show_meta_boxes', 'entre_mikado_set_show_dep_options_for_header_centered_meta_boxes' );
}

if ( ! function_exists( 'entre_mikado_set_hide_dep_options_for_header_centered_meta_boxes' ) ) {
	/**
	 * This function set hide container values when this header type is selected for header type meta boxes map
	 */
	function entre_mikado_set_hide_dep_options_for_header_centered_meta_boxes( $hide_dep_options ) {
		$hide_containers = apply_filters( 'entre_mikado_hide_dep_options_for_header_centered_meta_boxes', $hide_containers = array() );
		
		$hide_dep_options['header-centered'] = implode( ',', $hide_containers );
		
		return $hide_dep_options;
	}
	
	add_filter( 'entre_mikado_header_type_hide_meta_boxes', 'entre_mikado_set_hide_dep_options_for_header_centered_meta_boxes' );
}

if ( ! function_exists( 'entre_mikado_set_centered_hide_dep_options_for_header_types' ) ) {
	/**
	 * This function is used to disable this header type specific containers/panels for admin options when another header type is selected
	 */
	function entre_mikado_set_centered_hide_dep_options_for_header_types( $hide_containers_dep_options ) {
		$hide_containers_dep_options[] = '#mkd_logo_wrapper_padding_header_centered';
		
		return $hide_containers_dep_options;
	}
	
	// hide header centered container for global options
	add_filter( 'entre_mikado_hide_dep_options_for_header_box', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_divided', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_minimal', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_standard', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_standard_extended', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_tabbed', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_top_menu', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_vertical', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_vertical_closed', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_vertical_compact', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	
	// hide header centered container for meta boxes
	add_filter( 'entre_mikado_hide_dep_options_for_header_box_meta_boxes', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_divided_meta_boxes', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_minimal_meta_boxes', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_standard_meta_boxes', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_standard_extended_meta_boxes', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_tabbed_meta_boxes', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_top_menu_meta_boxes', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_vertical_meta_boxes', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_vertical_closed_meta_boxes', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_vertical_compact_meta_boxes', 'entre_mikado_set_centered_hide_dep_options_for_header_types' );
}

if ( ! function_exists( 'entre_mikado_set_hide_dep_options_header_centered' ) ) {
	/**
	 * This function is used to hide all containers/panels for admin options when this header type is selected
	 */
	function entre_mikado_set_hide_dep_options_header_centered( $hide_dep_options ) {
		$hide_dep_options[] = 'header-centered';
		
		return $hide_dep_options;
	}
	
	// header types panel options
	add_filter( 'entre_mikado_full_screen_menu_hide_global_option', 'entre_mikado_set_hide_dep_options_header_centered' );
	add_filter( 'entre_mikado_header_standard_hide_global_option', 'entre_mikado_set_hide_dep_options_header_centered' );
	add_filter( 'entre_mikado_header_vertical_hide_global_option', 'entre_mikado_set_hide_dep_options_header_centered' );
	add_filter( 'entre_mikado_header_vertical_menu_hide_global_option', 'entre_mikado_set_hide_dep_options_header_centered' );
	
	// header types panel meta boxes
	add_filter( 'entre_mikado_header_standard_hide_meta_boxes', 'entre_mikado_set_hide_dep_options_header_centered' );
	add_filter( 'entre_mikado_header_vertical_hide_meta_boxes', 'entre_mikado_set_hide_dep_options_header_centered' );
}