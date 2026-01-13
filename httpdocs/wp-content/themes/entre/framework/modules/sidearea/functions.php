<?php
if ( ! function_exists( 'entre_mikado_register_side_area_sidebar' ) ) {
	/**
	 * Register side area sidebar
	 */
	function entre_mikado_register_side_area_sidebar() {
		register_sidebar(
			array(
				'id'            => 'sidearea',
				'name'          => esc_html__( 'Side Area', 'entre' ),
				'description'   => esc_html__( 'Side Area', 'entre' ),
				'before_widget' => '<div id="%1$s" class="widget mkd-sidearea %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="mkd-widget-title-holder"><h6 class="mkd-widget-title">',
				'after_title'   => '</h6></div>'
			)
		);
	}
	
	add_action( 'widgets_init', 'entre_mikado_register_side_area_sidebar' );
}

if ( ! function_exists( 'entre_mikado_side_menu_body_class' ) ) {
	/**
	 * Function that adds body classes for different side menu styles
	 *
	 * @param $classes array original array of body classes
	 *
	 * @return array modified array of classes
	 */
	function entre_mikado_side_menu_body_class( $classes ) {
		
		if ( is_active_widget( false, false, 'mkd_side_area_opener' ) ) {
			
			$classes[] = 'mkd-side-menu-slide-from-right';
		}
		
		return $classes;
	}
	
	add_filter( 'body_class', 'entre_mikado_side_menu_body_class' );
}

if ( ! function_exists( 'entre_mikado_get_side_area' ) ) {
	/**
	 * Loads side area HTML
	 */
	function entre_mikado_get_side_area() {
		
		if ( is_active_widget( false, false, 'mkd_side_area_opener' ) ) {
			
			entre_mikado_get_module_template_part( 'templates/sidearea', 'sidearea' );
		}
	}
	
	add_action( 'entre_mikado_after_body_tag', 'entre_mikado_get_side_area', 10 );
}