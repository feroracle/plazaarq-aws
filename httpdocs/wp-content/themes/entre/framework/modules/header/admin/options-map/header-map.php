<?php

if ( ! function_exists( 'entre_mikado_get_header_types_options' ) ) {
	function entre_mikado_get_header_types_options() {
		$header_type_options = apply_filters( 'entre_mikado_header_type_global_option', $header_type_options = array() );
		
		return $header_type_options;
	}
}

if ( ! function_exists( 'entre_mikado_get_header_type_default_options' ) ) {
	function entre_mikado_get_header_type_default_options() {
		$header_type_option = apply_filters( 'entre_mikado_default_header_type_global_option', $header_type_option = '' );
		
		return $header_type_option;
	}
}

if ( ! function_exists( 'entre_mikado_get_show_dep_for_header_types_options' ) ) {
	function entre_mikado_get_show_dep_for_header_types_options() {
		$show_dep_options = apply_filters( 'entre_mikado_header_type_show_global_option', $show_dep_options = array() );
		
		return $show_dep_options;
	}
}

if ( ! function_exists( 'entre_mikado_get_hide_dep_for_header_types_options' ) ) {
	function entre_mikado_get_hide_dep_for_header_types_options() {
		$hide_dep_options = apply_filters( 'entre_mikado_header_type_hide_global_option', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

if ( ! function_exists( 'entre_mikado_get_hide_dep_for_header_behavior_options' ) ) {
	function entre_mikado_get_hide_dep_for_header_behavior_options() {
		$hide_dep_options = apply_filters( 'entre_mikado_header_behavior_hide_global_option', $hide_dep_options = array() );
		
		return $hide_dep_options;
	}
}

foreach ( glob( MIKADO_FRAMEWORK_HEADER_ROOT_DIR . '/admin/options-map/*/*.php' ) as $options_load ) {
	include_once $options_load;
}

foreach ( glob( MIKADO_FRAMEWORK_HEADER_TYPES_ROOT_DIR . '/*/admin/options-map/*.php' ) as $options_load ) {
	include_once $options_load;
}

if ( ! function_exists( 'entre_mikado_header_options_map' ) ) {
	function entre_mikado_header_options_map() {
		$header_type_options              = entre_mikado_get_header_types_options();
		$header_type_default_option       = entre_mikado_get_header_type_default_options();
		$header_type_options_show_dep     = entre_mikado_get_show_dep_for_header_types_options();
		$header_type_options_hide_dep     = entre_mikado_get_hide_dep_for_header_types_options();
		$header_behavior_options_hide_dep = entre_mikado_get_hide_dep_for_header_behavior_options();
		
		entre_mikado_add_admin_page(
			array(
				'slug'  => '_header_page',
				'title' => esc_html__( 'Header', 'entre' ),
				'icon'  => 'fa fa-header'
			)
		);
		
		$panel_header = entre_mikado_add_admin_panel(
			array(
				'page'  => '_header_page',
				'name'  => 'panel_header',
				'title' => esc_html__( 'Header', 'entre' )
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent'        => $panel_header,
				'type'          => 'radiogroup',
				'name'          => 'header_type',
				'default_value' => $header_type_default_option,
				'label'         => esc_html__( 'Choose Header Type', 'entre' ),
				'description'   => esc_html__( 'Select the type of header you would like to use', 'entre' ),
				'options'       => $header_type_options,
				'args'          => array(
					'use_images'  => true,
					'hide_labels' => true,
					'dependence'  => true,
					'show'        => $header_type_options_show_dep,
					'hide'        => $header_type_options_hide_dep
				)
			)
		);
		
		entre_mikado_add_admin_field(
			array(
				'parent'          => $panel_header,
				'type'            => 'select',
				'name'            => 'header_behaviour',
				'default_value'   => 'fixed-on-scroll',
				'label'           => esc_html__( 'Choose Header Behaviour', 'entre' ),
				'description'     => esc_html__( 'Select the behaviour of header when you scroll down to page', 'entre' ),
				'options'         => array(
					'fixed-on-scroll'                 => esc_html__( 'Fixed on scroll', 'entre' ),
					'no-behavior'                     => esc_html__( 'No Behavior', 'entre' ),
					'sticky-header-on-scroll-up'      => esc_html__( 'Sticky on scroll up', 'entre' ),
					'sticky-header-on-scroll-down-up' => esc_html__( 'Sticky on scroll up/down', 'entre' )
				),
				'hidden_property' => 'header_type',
				'hidden_values'   => $header_behavior_options_hide_dep,
				'args'            => array(
					'dependence'   => true,
					'show'         => array(
						'fixed-on-scroll'                 => '#mkd_panel_fixed_header',
						'no-behavior'                     => '',
						'sticky-header-on-scroll-up'      => '#mkd_panel_sticky_header',
						'sticky-header-on-scroll-down-up' => '#mkd_panel_sticky_header'
					),
					'hide'         => array(
						'fixed-on-scroll'                 => '#mkd_panel_sticky_header',
						'no-behavior'                     => '#mkd_panel_sticky_header, #mkd_panel_fixed_header',
						'sticky-header-on-scroll-up'      => '#mkd_panel_fixed_header',
						'sticky-header-on-scroll-down-up' => '#mkd_panel_fixed_header'
					)
				)
			)
		);
		
		/***************** Header Skin Options -start ********************/
		
		entre_mikado_add_admin_field(
			array(
				'parent'        => $panel_header,
				'type'          => 'select',
				'name'          => 'header_style',
				'default_value' => '',
				'label'         => esc_html__( 'Header Skin', 'entre' ),
				'description'   => esc_html__( 'Choose a predefined header style for header elements (logo, main menu, side menu opener...)', 'entre' ),
				'options'       => array(
					''             => esc_html__( 'Default', 'entre' ),
					'light-header' => esc_html__( 'Light', 'entre' ),
					'dark-header'  => esc_html__( 'Dark', 'entre' )
				)
			)
		);
		
		/***************** Header Skin Options - end ********************/
		
		/***************** Top Header Layout - start **********************/
		
		do_action( 'entre_mikado_header_top_options_map', $panel_header );
		
		/***************** Top Header Layout - end **********************/
		
		/***************** Logo Area Layout - start **********************/
		
		do_action( 'entre_mikado_header_logo_area_options_map', $panel_header );
		
		/***************** Logo Area Layout - end **********************/
		
		/***************** Menu Area Layout - start **********************/
		
		do_action( 'entre_mikado_header_menu_area_options_map', $panel_header );
		
		/***************** Menu Area Layout - end **********************/
		
		/***************** Additional Header Menu Area Layout - start *****************/
		
		do_action( 'entre_mikado_additional_header_menu_area_options_map', $panel_header );
		
		/***************** Additional Header Menu Area Layout - end *****************/
		
		/***************** Sticky Header Layout - start *******************/
		
		do_action( 'entre_mikado_header_sticky_options_map', $panel_header );
		
		/***************** Sticky Header Layout - end *******************/
		
		/***************** Fixed Header Layout - start ********************/
		
		do_action( 'entre_mikado_header_fixed_options_map', $panel_header );
		
		/***************** Fixed Header Layout - end ********************/
		
		/******************* Main Menu Layout - start *********************/
		
		do_action( 'entre_mikado_header_main_navigation_options_map' );
		
		/******************* Main Menu Layout - end *********************/
		
		/***************** Additional Main Menu Area Layout - start *****************/
		
		do_action( 'entre_mikado_additional_header_main_navigation_options_map', $panel_header );
		
		/***************** Additional Main Menu Area Layout - end *****************/
	}
	
	add_action( 'entre_mikado_options_map', 'entre_mikado_header_options_map', 4 );
}