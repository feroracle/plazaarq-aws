<?php

if ( ! function_exists( 'entre_mikado_sticky_header_meta_boxes_options_map' ) ) {
	function entre_mikado_sticky_header_meta_boxes_options_map( $header_meta_box ) {
		
		$sticky_amount_container = entre_mikado_add_admin_container(
			array(
				'parent'          => $header_meta_box,
				'name'            => 'sticky_amount_container_meta_container',
				'hidden_property' => 'mkd_header_behaviour_meta',
				'hidden_values'   => array(
					'',
					'no-behavior',
					'fixed-on-scroll',
					'sticky-header-on-scroll-up'
				)
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_scroll_amount_for_sticky_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Scroll amount for sticky header appearance', 'entre' ),
				'description' => esc_html__( 'Define scroll amount for sticky header appearance', 'entre' ),
				'parent'      => $sticky_amount_container,
				'args'        => array(
					'col_width' => 2,
					'suffix'    => 'px'
				)
			)
		);
	}
	
	add_action( 'entre_mikado_additional_header_area_meta_boxes_map', 'entre_mikado_sticky_header_meta_boxes_options_map', 10, 1 );
}