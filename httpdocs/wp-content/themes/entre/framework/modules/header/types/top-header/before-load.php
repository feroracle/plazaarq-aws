<?php

if ( ! function_exists( 'entre_mikado_set_show_dep_options_for_top_header' ) ) {
	/**
	 * This function is used to show this header type specific containers/panels for admin options when another header type is selected
	 */
	function entre_mikado_set_show_dep_options_for_top_header( $show_dep_options ) {
		$show_dep_options[] = '#mkd_top_header_container';
		
		return $show_dep_options;
	}
	
	// show top header container for global options
	add_filter( 'entre_mikado_show_dep_options_for_header_box', 'entre_mikado_set_show_dep_options_for_top_header' );
	add_filter( 'entre_mikado_show_dep_options_for_header_centered', 'entre_mikado_set_show_dep_options_for_top_header' );
	add_filter( 'entre_mikado_show_dep_options_for_header_divided', 'entre_mikado_set_show_dep_options_for_top_header' );
	add_filter( 'entre_mikado_show_dep_options_for_header_minimal', 'entre_mikado_set_show_dep_options_for_top_header' );
	add_filter( 'entre_mikado_show_dep_options_for_header_standard', 'entre_mikado_set_show_dep_options_for_top_header' );
	add_filter( 'entre_mikado_show_dep_options_for_header_standard_extended', 'entre_mikado_set_show_dep_options_for_top_header' );
	add_filter( 'entre_mikado_show_dep_options_for_header_tabbed', 'entre_mikado_set_show_dep_options_for_top_header' );
	
	// show top header container for meta boxes
	add_filter( 'entre_mikado_show_dep_options_for_header_box_meta_boxes', 'entre_mikado_set_show_dep_options_for_top_header' );
	add_filter( 'entre_mikado_show_dep_options_for_header_centered_meta_boxes', 'entre_mikado_set_show_dep_options_for_top_header' );
	add_filter( 'entre_mikado_show_dep_options_for_header_divided_meta_boxes', 'entre_mikado_set_show_dep_options_for_top_header' );
	add_filter( 'entre_mikado_show_dep_options_for_header_minimal_meta_boxes', 'entre_mikado_set_show_dep_options_for_top_header' );
	add_filter( 'entre_mikado_show_dep_options_for_header_standard_meta_boxes', 'entre_mikado_set_show_dep_options_for_top_header' );
	add_filter( 'entre_mikado_show_dep_options_for_header_standard_extended_meta_boxes', 'entre_mikado_set_show_dep_options_for_top_header' );
	add_filter( 'entre_mikado_show_dep_options_for_header_tabbed_meta_boxes', 'entre_mikado_set_show_dep_options_for_top_header' );
}

if ( ! function_exists( 'entre_mikado_set_hide_dep_options_for_top_header' ) ) {
	/**
	 * This function is used to hide this header type specific containers/panels for admin options when another header type is selected
	 */
	function entre_mikado_set_hide_dep_options_for_top_header( $hide_dep_options ) {
		$hide_dep_options[] = '#mkd_top_header_container';
		
		return $hide_dep_options;
	}
	
	// hide top header container for global options
	add_filter( 'entre_mikado_hide_dep_options_for_header_top_menu', 'entre_mikado_set_hide_dep_options_for_top_header' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_vertical', 'entre_mikado_set_hide_dep_options_for_top_header' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_vertical_closed', 'entre_mikado_set_hide_dep_options_for_top_header' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_vertical_compact', 'entre_mikado_set_hide_dep_options_for_top_header' );
	
	// hide top header container for meta boxes
	add_filter( 'entre_mikado_hide_dep_options_for_header_top_menu_meta_boxes', 'entre_mikado_set_hide_dep_options_for_top_header' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_vertical_meta_boxes', 'entre_mikado_set_hide_dep_options_for_top_header' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_vertical_closed_meta_boxes', 'entre_mikado_set_hide_dep_options_for_top_header' );
	add_filter( 'entre_mikado_hide_dep_options_for_header_vertical_compact_meta_boxes', 'entre_mikado_set_hide_dep_options_for_top_header' );
}