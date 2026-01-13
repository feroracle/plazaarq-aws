<?php

if ( ! function_exists( 'entre_mikado_register_header_vertical_sliding_type' ) ) {
	/**
	 * This function is used to register header type class for header factory file
	 */
	function entre_mikado_register_header_vertical_sliding_type( $header_types ) {
		$header_type = array(
			'header-vertical-sliding' => 'EntreMikado\Modules\Header\Types\HeaderVerticalSliding'
		);
		
		$header_types = array_merge( $header_types, $header_type );
		
		return $header_types;
	}
}

if ( ! function_exists( 'entre_mikado_init_register_header_vertical_sliding_type' ) ) {
	/**
	 * This function is used to wait header-function.php file to init header object and then to init hook registration function above
	 */
	function entre_mikado_init_register_header_vertical_sliding_type() {
		add_filter( 'entre_mikado_register_header_type_class', 'entre_mikado_register_header_vertical_sliding_type' );
	}
	
	add_action( 'entre_mikado_before_header_function_init', 'entre_mikado_init_register_header_vertical_sliding_type' );
}

if ( ! function_exists( 'entre_mikado_include_header_vertical_sliding_menu' ) ) {
	/**
	 * Registers additional menu navigation for theme
	 */
	function entre_mikado_include_header_vertical_sliding_menu( $menus ) {
		if ( ! array_key_exists( 'vertical-navigation', $menus ) ) {
			$menus['vertical-navigation'] = esc_html__( 'Vertical Navigation', 'entre' );
		}
		
		return $menus;
	}
	
	if ( entre_mikado_check_is_header_type_enabled( 'header-vertical-sliding' ) ) {
		add_filter( 'entre_mikado_register_headers_menu', 'entre_mikado_include_header_vertical_sliding_menu' );
	}
}

if ( ! function_exists( 'entre_mikado_register_header_vertical_sliding_widget_areas' ) ) {
	/**
	 * Registers additional widget areas for this header type
	 */
	function entre_mikado_register_header_vertical_sliding_widget_areas() {
		register_sidebar(
			array(
				'id'            => 'mkd-vertical-sliding-area',
				'name'          => esc_html__( 'Header Vertical Sliding Widget Area', 'entre' ),
				'description'   => esc_html__( 'Widgets added here will appear on the bottom of header vertical menu', 'entre' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s mkd-vertical-area-widget">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="mkd-widget-title">',
				'after_title'   => '</h5>'
			)
		);
	}
	
	if ( entre_mikado_check_is_header_type_enabled( 'header-vertical-sliding' ) ) {
		add_action( 'widgets_init', 'entre_mikado_register_header_vertical_sliding_widget_areas' );
	}
}

if ( ! function_exists( 'entre_mikado_get_header_vertical_sliding_widget_areas' ) ) {
	/**
	 * Loads header widgets area HTML
	 */
	function entre_mikado_get_header_vertical_sliding_widget_areas() {
		$page_id                            = entre_mikado_get_page_id();
		$custom_vertical_header_widget_area = get_post_meta( $page_id, 'mkd_custom_vertical_area_sidebar_meta', true );
		
		if ( is_active_sidebar( 'mkd-vertical-sliding-area' ) && empty( $custom_vertical_header_widget_area ) ) {
			dynamic_sidebar( 'mkd-vertical-sliding-area' );
		} else if ( ! empty( $custom_vertical_header_widget_area ) && is_active_sidebar( $custom_vertical_header_widget_area ) ) {
			dynamic_sidebar( $custom_vertical_header_widget_area );
		}
	}
}

if ( ! function_exists( 'entre_mikado_get_header_vertical_sliding_main_menu' ) ) {
	/**
	 * Loads vertical menu HTML
	 */
	function entre_mikado_get_header_vertical_sliding_main_menu() {
		entre_mikado_get_module_template_part( 'templates/vertical-sliding-navigation', 'header/types/header-vertical-sliding' );
	}
}

if ( ! function_exists( 'entre_mikado_vertical_sliding_header_holder_class' ) ) {
	/**
	 * Return holder class for this header type html
	 */
	function entre_mikado_vertical_sliding_header_holder_class() {
		$center_content = entre_mikado_get_meta_field_intersect( 'vertical_header_center_content', entre_mikado_get_page_id() );
		$holder_class   = $center_content === 'yes' ? 'mkd-vertical-alignment-center' : 'mkd-vertical-alignment-top';
		
		return $holder_class;
	}
}

if ( ! function_exists( 'entre_mikado_header_vertical_sliding_per_page_custom_styles' ) ) {
    /**
     * Return header per page styles
     */
    function entre_mikado_header_vertical_sliding_per_page_custom_styles( $style, $class_prefix, $page_id ) {
        $header_area_style    = array();
        $header_area_selector = array( $class_prefix . '.mkd-header-vertical-sliding .mkd-vertical-menu-area .mkd-vertical-area-background' );

        $vertical_header_background_color  = get_post_meta( $page_id, 'mkd_vertical_header_background_color_meta', true );
        $disable_vertical_background_image = get_post_meta( $page_id, 'mkd_disable_vertical_header_background_image_meta', true );
        $vertical_background_image         = get_post_meta( $page_id, 'mkd_vertical_header_background_image_meta', true );
        $vertical_shadow                   = get_post_meta( $page_id, 'mkd_vertical_header_shadow_meta', true );
        $vertical_border                   = get_post_meta( $page_id, 'mkd_vertical_header_border_meta', true );

        if ( ! empty( $vertical_header_background_color ) ) {
            $header_area_style['background-color'] = $vertical_header_background_color;
        }

        if ( $disable_vertical_background_image == 'yes' ) {
            $header_area_style['background-image'] = 'none';
        } elseif ( $vertical_background_image !== '' ) {
            $header_area_style['background-image'] = 'url(' . $vertical_background_image . ')';
        }

        if ( $vertical_shadow == 'yes' ) {
            $header_area_style['box-shadow'] = '1px 0 3px rgba(0, 0, 0, 0.05)';
        }

        if ( $vertical_border == 'yes' ) {
            $header_border_color = get_post_meta( $page_id, 'mkd_vertical_header_border_color_meta', true );

            if ( $header_border_color !== '' ) {
                $header_area_style['border-right'] = '1px solid ' . $header_border_color;
            }
        }

        $current_style = '';

        if ( ! empty( $header_area_style ) ) {
            $current_style .= entre_mikado_dynamic_css( $header_area_selector, $header_area_style );
        }

        $current_style = $current_style . $style;

        return $current_style;
    }

    add_filter( 'entre_mikado_add_header_page_custom_style', 'entre_mikado_header_vertical_sliding_per_page_custom_styles', 10, 3 );
}