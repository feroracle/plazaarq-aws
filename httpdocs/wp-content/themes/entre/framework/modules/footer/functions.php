<?php

if ( ! function_exists( 'entre_mikado_register_footer_sidebar' ) ) {
	function entre_mikado_register_footer_sidebar() {
		
		$show_footer_top    = entre_mikado_options()->getOptionValue( 'show_footer_top' ) !== 'yes' ? false : true;
		$show_footer_bottom = entre_mikado_options()->getOptionValue( 'show_footer_bottom' ) !== 'yes' ? false : true;
		
		if ( $show_footer_top ) {
			
			register_sidebar(
				array(
					'id'            => 'footer_top_column_1',
					'name'          => esc_html__( 'Footer Top Column 1', 'entre' ),
					'description'   => esc_html__( 'Widgets added here will appear in the first column of top footer area', 'entre' ),
					'before_widget' => '<div id="%1$s" class="widget mkd-footer-column-1 %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<div class="mkd-widget-title-holder"><h6 class="mkd-widget-title">',
					'after_title'   => '</h6></div>'
				)
			);
			
			register_sidebar(
				array(
					'id'            => 'footer_top_column_2',
					'name'          => esc_html__( 'Footer Top Column 2', 'entre' ),
					'description'   => esc_html__( 'Widgets added here will appear in the second column of top footer area', 'entre' ),
					'before_widget' => '<div id="%1$s" class="widget mkd-footer-column-2 %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<div class="mkd-widget-title-holder"><h6 class="mkd-widget-title">',
					'after_title'   => '</h6></div>'
				)
			);
			
			register_sidebar(
				array(
					'id'            => 'footer_top_column_3',
					'name'          => esc_html__( 'Footer Top Column 3', 'entre' ),
					'description'   => esc_html__( 'Widgets added here will appear in the third column of top footer area', 'entre' ),
					'before_widget' => '<div id="%1$s" class="widget mkd-footer-column-3 %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<div class="mkd-widget-title-holder"><h6 class="mkd-widget-title">',
					'after_title'   => '</h6></div>'
				)
			);
			
			register_sidebar(
				array(
					'id'            => 'footer_top_column_4',
					'name'          => esc_html__( 'Footer Top Column 4', 'entre' ),
					'description'   => esc_html__( 'Widgets added here will appear in the fourth column of top footer area', 'entre' ),
					'before_widget' => '<div id="%1$s" class="widget mkd-footer-column-4 %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<div class="mkd-widget-title-holder"><h6 class="mkd-widget-title">',
					'after_title'   => '</h6></div>'
				)
			);
		}
		
		if ( $show_footer_bottom ) {
			
			register_sidebar(
				array(
					'id'            => 'footer_bottom_column_1',
					'name'          => esc_html__( 'Footer Bottom Column 1', 'entre' ),
					'description'   => esc_html__( 'Widgets added here will appear in the first column of bottom footer area', 'entre' ),
					'before_widget' => '<div id="%1$s" class="widget mkd-footer-bottom-column-1 %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<div class="mkd-widget-title-holder"><h6 class="mkd-widget-title">',
					'after_title'   => '</h6></div>'
				)
			);
			
			register_sidebar(
				array(
					'id'            => 'footer_bottom_column_2',
					'name'          => esc_html__( 'Footer Bottom Column 2', 'entre' ),
					'description'   => esc_html__( 'Widgets added here will appear in the second column of bottom footer area', 'entre' ),
					'before_widget' => '<div id="%1$s" class="widget mkd-footer-bottom-column-2 %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<div class="mkd-widget-title-holder"><h6 class="mkd-widget-title">',
					'after_title'   => '</h6></div>'
				)
			);
			
			register_sidebar(
				array(
					'id'            => 'footer_bottom_column_3',
					'name'          => esc_html__( 'Footer Bottom Column 3', 'entre' ),
					'description'   => esc_html__( 'Widgets added here will appear in the third column of bottom footer area', 'entre' ),
					'before_widget' => '<div id="%1$s" class="widget mkd-footer-bottom-column-3 %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<div class="mkd-widget-title-holder"><h6 class="mkd-widget-title">',
					'after_title'   => '</h6></div>'
				)
			);
		}
	}
	
	add_action( 'widgets_init', 'entre_mikado_register_footer_sidebar' );
}

if ( ! function_exists( 'entre_mikado_get_footer' ) ) {
	/**
	 * Loads footer HTML
	 */
	function entre_mikado_get_footer() {
		$parameters             = array();
		$page_id                = entre_mikado_get_page_id();
		$disable_footer_meta    = get_post_meta( $page_id, 'mkd_disable_footer_meta', true );
        $uncovering_footer_meta = entre_mikado_get_meta_field_intersect( 'uncovering_footer', $page_id );
        $uncovering_footer      = $uncovering_footer_meta === 'yes' ? 'mkd-footer-uncover' : '';
		
		$parameters['display_footer']        		= $disable_footer_meta === 'yes' ? false : true;
		$parameters['display_footer_top']    		= entre_mikado_show_footer_top();
		$parameters['display_footer_bottom'] 		= entre_mikado_show_footer_bottom();

		$parameters['footer_classes'] = array(
			'mkd-page-footer'
		);

        $parameters['footer_classes'][] = $uncovering_footer;
		$parameters['footer_classes'][] = $parameters['display_footer_top'] ? 'mkd-footer-has-footer-top': '';
		$parameters['footer_classes'][] = $parameters['display_footer_bottom'] ? 'mkd-footer-has-footer-bottom': '';

		entre_mikado_get_module_template_part( 'templates/footer', 'footer', '', $parameters );
	}
	
	add_action( 'entre_mikado_get_footer_template', 'entre_mikado_get_footer' );
}

if ( ! function_exists( 'entre_mikado_show_footer_top' ) ) {
	/**
	 * Check footer top showing
	 * Function check value from options and checks if footer columns are empty.
	 * return bool
	 */
	function entre_mikado_show_footer_top() {
		$footer_top_flag = false;
		
		//check value from options and meta field on current page
		$option_flag = ( entre_mikado_get_meta_field_intersect( 'show_footer_top' ) === 'yes' ) ? true : false;
		
		//check footer columns.If they are empty, disable footer top
		$columns_flag = false;
		for ( $i = 1; $i <= 4; $i ++ ) {
			$footer_columns_id = 'footer_top_column_' . $i;
			if ( is_active_sidebar( $footer_columns_id ) ) {
				$columns_flag = true;
				break;
			}
		}
		
		if ( $option_flag && $columns_flag ) {
			$footer_top_flag = true;
		}
		
		return $footer_top_flag;
	}
}

if ( ! function_exists( 'entre_mikado_show_footer_bottom' ) ) {
	/**
	 * Check footer bottom showing
	 * Function check value from options and checks if footer columns are empty.
	 * return bool
	 */
	function entre_mikado_show_footer_bottom() {
		$footer_bottom_flag = false;
		
		//check value from options and meta field on current page
		$option_flag = ( entre_mikado_get_meta_field_intersect( 'show_footer_bottom' ) === 'yes' ) ? true : false;
		
		//check footer columns.If they are empty, disable footer bottom
		$columns_flag = false;
		for ( $i = 1; $i <= 3; $i ++ ) {
			$footer_columns_id = 'footer_bottom_column_' . $i;
			if ( is_active_sidebar( $footer_columns_id ) ) {
				$columns_flag = true;
				break;
			}
		}
		
		if ( $option_flag && $columns_flag ) {
			$footer_bottom_flag = true;
		}
		
		return $footer_bottom_flag;
	}
}

if ( ! function_exists( 'entre_mikado_get_content_bottom_area' ) ) {
	/**
	 * Loads content bottom area HTML with all needed parameters
	 */
	function entre_mikado_get_content_bottom_area() {
		$parameters = array();
		
		//Current page id
		$id = entre_mikado_get_page_id();
		
		//is content bottom area enabled for current page?
		$parameters['content_bottom_area'] = entre_mikado_get_meta_field_intersect( 'enable_content_bottom_area', $id );
		
		if ( $parameters['content_bottom_area'] === 'yes' ) {
			
			//Sidebar for content bottom area
			$parameters['content_bottom_area_sidebar'] = entre_mikado_get_meta_field_intersect( 'content_bottom_sidebar_custom_display', $id );
			//Content bottom area in grid
			$parameters['grid_class'] = ( entre_mikado_get_meta_field_intersect( 'content_bottom_in_grid', $id ) ) === 'yes' ? 'mkd-grid' : 'mkd-full-width';
			
			$parameters['content_bottom_style'] = array();
			
			//Content bottom area background color
			$background_color = entre_mikado_get_meta_field_intersect( 'content_bottom_background_color', $id );
			if ( $background_color !== '' ) {
				$parameters['content_bottom_style'][] = 'background-color: ' . $background_color . ';';
			}
			
			if ( is_active_sidebar( $parameters['content_bottom_area_sidebar'] ) ) {
				entre_mikado_get_module_template_part( 'templates/parts/content-bottom-area', 'footer', '', $parameters );
			}
		}
	}
}

if ( ! function_exists( 'entre_mikado_get_footer_top' ) ) {
	/**
	 * Return footer top HTML
	 */
	function entre_mikado_get_footer_top() {
		$parameters = array();
		
		//get number of top footer columns
		$parameters['footer_top_columns'] = entre_mikado_options()->getOptionValue( 'footer_top_columns' );
		
		//get footer top grid/full width class
		$parameters['footer_top_grid_class'] = entre_mikado_options()->getOptionValue( 'footer_in_grid' ) === 'yes' ? 'mkd-grid' : 'mkd-full-width';
		
		//get footer top other classes
		$footer_top_classes = array();
		
		//footer alignment
		$footer_top_alignment = entre_mikado_options()->getOptionValue( 'footer_top_columns_alignment' );
		$footer_top_classes[] = ! empty( $footer_top_alignment ) ? 'mkd-footer-top-alignment-' . esc_attr( $footer_top_alignment ) : '';

		//footer top logo
		$show_footer_logo = entre_mikado_options()->getOptionValue( 'show_footer_logo' );
		$parameters['show_footer_logo'] = ( ! empty( $show_footer_logo ) &&  ( $show_footer_logo == 'yes') ) ? true : false;
		$parameters['footer_has_logo_class'] = ( ! empty( $show_footer_logo ) &&  ( $show_footer_logo == 'yes') ) ? 'mkd-footer-top-has-logo' : '';
		
		$footer_top_classes = apply_filters( 'entre_mikado_footer_top_classes', $footer_top_classes );
		
		$parameters['footer_top_classes'] = implode( ' ', $footer_top_classes );
		
		entre_mikado_get_module_template_part( 'templates/parts/footer-top', 'footer', '', $parameters );
	}
}

if ( ! function_exists( 'entre_mikado_get_footer_bottom' ) ) {
	/**
	 * Return footer bottom HTML
	 */
	function entre_mikado_get_footer_bottom() {
		$parameters = array();
		
		//get number of bottom footer columns
		$parameters['footer_bottom_columns'] = entre_mikado_options()->getOptionValue( 'footer_bottom_columns' );
		
		//get footer top grid/full width class
		$parameters['footer_bottom_grid_class'] = entre_mikado_options()->getOptionValue( 'footer_in_grid' ) === 'yes' ? 'mkd-grid' : 'mkd-full-width';
		
		//get footer top other classes
		$footer_bottom_classes = array();
		$footer_bottom_classes = apply_filters( 'entre_mikado_footer_bottom_classes', $footer_bottom_classes );
		
		$parameters['footer_bottom_classes'] = implode( ' ', $footer_bottom_classes );
		
		entre_mikado_get_module_template_part( 'templates/parts/footer-bottom', 'footer', '', $parameters );
	}
}

if ( ! function_exists( 'entre_mikado_get_footer_logo' ) ) {
	/**
	 * Return footer logo HTML
	 */
	function entre_mikado_get_footer_logo() {

		$logo_image = entre_mikado_options()->getOptionValue( 'footer_logo' );
		$attachment_meta = entre_mikado_get_attachment_meta_from_url($logo_image);
		$hwstring = !empty($attachment_meta) ? image_hwstring( $attachment_meta['width'], $attachment_meta['height'] ) : '';

		$html = '';

		$html .= '<a itemprop="url" href="' . esc_url(home_url('/')) . '">
		        <img itemprop="image" class="mkd-footer-logo" src=" ' . esc_url($logo_image) . '" ' .  wp_kses($hwstring, array('width' => true, 'height' => true)) . ' alt="' .  esc_attr('logo','entre') . '"/>
		    </a> ';

		return $html;
	}
}