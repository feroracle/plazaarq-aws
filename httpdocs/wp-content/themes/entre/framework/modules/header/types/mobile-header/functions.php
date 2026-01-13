<?php

if ( ! function_exists( 'entre_mikado_include_mobile_header_menu' ) ) {
	function entre_mikado_include_mobile_header_menu( $menus ) {
		$menus['mobile-navigation'] = esc_html__( 'Mobile Navigation', 'entre' );
		
		return $menus;
	}
	
	add_filter( 'entre_mikado_register_headers_menu', 'entre_mikado_include_mobile_header_menu' );
}

if ( ! function_exists( 'entre_mikado_register_mobile_header_areas' ) ) {
	/**
	 * Registers widget areas for mobile header
	 */
	function entre_mikado_register_mobile_header_areas() {
		if ( entre_mikado_is_responsive_on() ) {
			register_sidebar(
				array(
					'id'            => 'mkd-right-from-mobile-logo',
					'name'          => esc_html__( 'Mobile Header Widget Area', 'entre' ),
					'description'   => esc_html__( 'Widgets added here will appear on the right hand side from the mobile logo on mobile header', 'entre' ),
					'before_widget' => '<div id="%1$s" class="widget %2$s mkd-right-from-mobile-logo">',
					'after_widget'  => '</div>'
				)
			);
		}
	}
	
	add_action( 'widgets_init', 'entre_mikado_register_mobile_header_areas' );
}

if ( ! function_exists( 'entre_mikado_mobile_header_class' ) ) {
	function entre_mikado_mobile_header_class( $classes ) {
		$classes[] = 'mkd-default-mobile-header';
		
		$classes[] = 'mkd-sticky-up-mobile-header';
		
		return $classes;
	}
	
	add_filter( 'body_class', 'entre_mikado_mobile_header_class' );
}

if ( ! function_exists( 'entre_mikado_get_mobile_header' ) ) {
	/**
	 * Loads mobile header HTML only if responsiveness is enabled
	 */
	function entre_mikado_get_mobile_header( $slug = '', $module = '' ) {
		if ( entre_mikado_is_responsive_on() ) {
			$mobile_menu_title = entre_mikado_options()->getOptionValue( 'mobile_menu_title' );
			$has_navigation    = has_nav_menu( 'main-navigation' ) || has_nav_menu( 'mobile-navigation' ) ? true : false;
			
			$parameters = array(
				'show_navigation_opener' => $has_navigation,
				'mobile_menu_title'      => $mobile_menu_title
			);

            $module = apply_filters('entre_mikado_mobile_menu_module', 'header/types/mobile-header');
            $slug = apply_filters('entre_mikado_mobile_menu_slug', '');

            entre_mikado_get_module_template_part( 'templates/mobile-header', $module, $slug, $parameters );
		}
	}
	
	add_action( 'entre_mikado_after_wrapper_inner', 'entre_mikado_get_mobile_header', 20 );
}

if ( ! function_exists( 'entre_mikado_get_mobile_logo' ) ) {
	/**
	 * Loads mobile logo HTML. It checks if mobile logo image is set and uses that, else takes normal logo image
	 */
	function entre_mikado_get_mobile_logo() {
		$show_logo_image = entre_mikado_options()->getOptionValue( 'hide_logo' ) === 'yes' ? false : true;
		
		if ( $show_logo_image ) {
			$mobile_logo_image = entre_mikado_get_meta_field_intersect( 'logo_image_mobile', entre_mikado_get_page_id() );
			
			//check if mobile logo has been set and use that, else use normal logo
			$logo_image = ! empty( $mobile_logo_image ) ? $mobile_logo_image : entre_mikado_get_meta_field_intersect( 'logo_image', entre_mikado_get_page_id() );
			
			//get logo image dimensions and set style attribute for image link.
			$logo_dimensions = entre_mikado_get_image_dimensions( $logo_image );
			
			$logo_height = '';
			$logo_styles = '';
			if ( is_array( $logo_dimensions ) && array_key_exists( 'height', $logo_dimensions ) ) {
				$logo_height = $logo_dimensions['height'];
				$logo_styles = 'height: ' . intval( $logo_height / 2 ) . 'px'; //divided with 2 because of retina screens
			}
			
			//set parameters for logo
			$parameters = array(
				'logo_image'      => $logo_image,
				'logo_dimensions' => $logo_dimensions,
				'logo_height'     => $logo_height,
				'logo_styles'     => $logo_styles
			);
			
			entre_mikado_get_module_template_part( 'templates/mobile-logo', 'header/types/mobile-header', '', $parameters );
		}
	}
}

if ( ! function_exists( 'entre_mikado_get_mobile_nav' ) ) {
	/**
	 * Loads mobile navigation HTML
	 */
	function entre_mikado_get_mobile_nav() {
		entre_mikado_get_module_template_part( 'templates/mobile-navigation', 'header/types/mobile-header' );
	}
}

if ( ! function_exists( 'cityrama_mkd_mobile_header_per_page_js_var' ) ) {
    function cityrama_mkd_mobile_header_per_page_js_var( $perPageVars ) {
        $perPageVars['mkdMobileHeaderHeight'] = entre_mikado_set_default_mobile_menu_height_for_header_types();

        return $perPageVars;
    }

    add_filter( 'cityrama_mkd_per_page_js_vars', 'cityrama_mkd_mobile_header_per_page_js_var' );
}