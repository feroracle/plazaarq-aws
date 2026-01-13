<?php

if ( ! function_exists( 'entre_mikado_sidebar_layout' ) ) {
	/**
	 * Function that check is sidebar is enabled and return type of sidebar layout
	 */
	function entre_mikado_sidebar_layout() {
		$sidebar_layout         = '';
		$sidebar_layout_meta    = entre_mikado_get_meta_field_intersect( 'sidebar_layout' );
		$archive_sidebar_layout = entre_mikado_options()->getOptionValue( 'archive_sidebar_layout' );
		$search_sidebar_layout  = entre_mikado_options()->getOptionValue( 'search_page_sidebar_layout' );
		$single_sidebar_layout  = entre_mikado_get_meta_field_intersect( 'blog_single_sidebar_layout' );
		
		if ( ! empty( $sidebar_layout_meta ) ) {
			$sidebar_layout = $sidebar_layout_meta;
		}
		
		if ( is_singular( 'post' ) && ! empty( $single_sidebar_layout ) ) {
			$sidebar_layout = $single_sidebar_layout;
		}
		
		if ( is_search() && ! entre_mikado_is_woocommerce_shop() && ! empty( $search_sidebar_layout ) ) {
			$sidebar_layout = $search_sidebar_layout;
		}
		
		if ( ( is_archive() || ( is_home() && is_front_page() ) ) && ! entre_mikado_is_woocommerce_page() && ! empty( $archive_sidebar_layout ) ) {
			$sidebar_layout = $archive_sidebar_layout;
		}
		
		if ( ! empty( $sidebar_layout ) && ! is_active_sidebar( entre_mikado_get_sidebar() ) ) {
			$sidebar_layout = '';
		}
		
		return apply_filters( 'entre_mikado_sidebar_layout', $sidebar_layout );
	}
}

if ( ! function_exists( 'entre_mikado_get_content_sidebar_class' ) ) {
	/**
	 * Return classes for content holder when sidebar is active
	 *
	 * @return string
	 */
	function entre_mikado_get_content_sidebar_class() {
		$sidebar_layout = entre_mikado_sidebar_layout();
		$content_class  = array( 'mkd-page-content-holder' );
		
		switch ( $sidebar_layout ) {
			case 'sidebar-33-right':
				$content_class[] = 'mkd-grid-col-8';
				break;
			case 'sidebar-25-right':
				$content_class[] = 'mkd-grid-col-9';
				break;
            case 'sidebar-20-right':
                $content_class[] = 'mkd-grid-col-10';
                break;
			case 'sidebar-33-left':
				$content_class[] = 'mkd-grid-col-8';
				$content_class[] = 'mkd-grid-col-push-4';
				break;
			case 'sidebar-25-left':
				$content_class[] = 'mkd-grid-col-9';
				$content_class[] = 'mkd-grid-col-push-3';
				break;
            case 'sidebar-20-left':
                $content_class[] = 'mkd-grid-col-10';
                $content_class[] = 'mkd-grid-col-push-2';
                break;
			default:
				$content_class[] = 'mkd-grid-col-12';
				break;
		}
		
		return entre_mikado_get_class_attribute( $content_class );
	}
}

if ( ! function_exists( 'entre_mikado_get_sidebar_holder_class' ) ) {
	/**
	 * Return classes for sidebar holder when sidebar is active
	 *
	 * @return string
	 */
	function entre_mikado_get_sidebar_holder_class() {
		$sidebar_layout = entre_mikado_sidebar_layout();
		$sidebar_class  = array( 'mkd-sidebar-holder' );
		
		switch ( $sidebar_layout ) {
			case 'sidebar-33-right':
				$sidebar_class[] = 'mkd-grid-col-4';
				break;
			case 'sidebar-25-right':
				$sidebar_class[] = 'mkd-grid-col-3';
				break;
            case 'sidebar-20-right':
                $sidebar_class[] = 'mkd-grid-col-2';
                break;
			case 'sidebar-33-left':
				$sidebar_class[] = 'mkd-grid-col-4';
				$sidebar_class[] = 'mkd-grid-col-pull-8';
				break;
			case 'sidebar-25-left':
				$sidebar_class[] = 'mkd-grid-col-3';
				$sidebar_class[] = 'mkd-grid-col-pull-9';
				break;
            case 'sidebar-20-left':
                $sidebar_class[] = 'mkd-grid-col-2';
                $sidebar_class[] = 'mkd-grid-col-pull-10';
		}
		
		return entre_mikado_get_class_attribute( $sidebar_class );
	}
}

if ( ! function_exists( 'entre_mikado_get_sidebar' ) ) {
	/**
	 * Return Sidebar name
	 *
	 * @return string
	 */
	function entre_mikado_get_sidebar() {
		$sidebar_name                = 'sidebar';
		$custom_sidebar_area         = entre_mikado_get_meta_field_intersect( 'custom_sidebar_area' );
		$custom_archive_sidebar_area = entre_mikado_options()->getOptionValue( 'archive_custom_sidebar_area' );
		$custom_search_sidebar_area  = entre_mikado_options()->getOptionValue( 'search_custom_sidebar_area' );
		$custom_single_sidebar_area  = entre_mikado_get_meta_field_intersect( 'blog_single_custom_sidebar_area' );
		
		if ( ! empty( $custom_sidebar_area ) ) {
			$sidebar_name = $custom_sidebar_area;
		}
		
		if ( is_singular( 'post' ) && ! empty( $custom_single_sidebar_area ) ) {
			$sidebar_name = $custom_single_sidebar_area;
		}
		
		if ( is_search() && ! empty( $custom_search_sidebar_area ) ) {
			$sidebar_name = $custom_search_sidebar_area;
		}
		
		if ( ( is_archive() || ( is_home() && is_front_page() ) ) && ! entre_mikado_is_woocommerce_page() && ! empty( $custom_archive_sidebar_area ) ) {
			$sidebar_name = $custom_archive_sidebar_area;
		}
		
		return apply_filters( 'entre_mikado_sidebar_name', $sidebar_name );
	}
}

if ( ! function_exists( 'entre_mikado_get_custom_sidebars' ) ) {
	/**
	 * Function that returns all custom made sidebars.
	 *
	 * @uses get_option()
	 * @return array array of custom made sidebars where key and value are sidebar name
	 */
	function entre_mikado_get_custom_sidebars() {
		$entre_custom_sidebars = get_option( 'mkd_sidebars' );
		$formatted_array             = array();
		
		if ( is_array( $entre_custom_sidebars ) && count( $entre_custom_sidebars ) ) {
			foreach ( $entre_custom_sidebars as $custom_sidebar ) {
				$formatted_array[ sanitize_title( $custom_sidebar ) ] = $custom_sidebar;
			}
		}
		
		return $formatted_array;
	}
}

if ( ! function_exists( 'entre_mikado_get_custom_sidebars_options' ) ) {
	function entre_mikado_get_custom_sidebars_options( $enable_default = false ) {
		$sidebar_options = array();
		
		if ( $enable_default ) {
			$sidebar_options[''] = esc_html__( 'Default', 'entre' );
		}
		
		$sidebar_options['no-sidebar']       = esc_html__( 'No Sidebar', 'entre' );
		$sidebar_options['sidebar-33-right'] = esc_html__( 'Sidebar 1/3 Right', 'entre' );
		$sidebar_options['sidebar-25-right'] = esc_html__( 'Sidebar 1/4 Right', 'entre' );
		$sidebar_options['sidebar-20-right'] = esc_html__( 'Sidebar 1/5 Right', 'entre' );
		$sidebar_options['sidebar-33-left']  = esc_html__( 'Sidebar 1/3 Left', 'entre' );
		$sidebar_options['sidebar-25-left']  = esc_html__( 'Sidebar 1/4 Left', 'entre' );
		$sidebar_options['sidebar-20-left']  = esc_html__( 'Sidebar 1/5 Left', 'entre' );
		
		return $sidebar_options;
	}
}