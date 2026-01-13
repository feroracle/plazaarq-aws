<?php

if ( ! function_exists( 'entre_mikado_map_sidebar_meta' ) ) {
	function entre_mikado_map_sidebar_meta() {
		$mkd_sidebar_meta_box = entre_mikado_create_meta_box(
			array(
				'scope' => apply_filters( 'entre_mikado_set_scope_for_meta_boxes', array( 'page' ), 'sidebar_meta' ),
				'title' => esc_html__( 'Sidebar', 'entre' ),
				'name'  => 'sidebar_meta'
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_sidebar_layout_meta',
				'type'        => 'select',
				'label'       => esc_html__( 'Sidebar Layout', 'entre' ),
				'description' => esc_html__( 'Choose the sidebar layout', 'entre' ),
				'parent'      => $mkd_sidebar_meta_box,
                'options'       => entre_mikado_get_custom_sidebars_options( true )
			)
		);
		
		$mkd_custom_sidebars = entre_mikado_get_custom_sidebars();
		if ( is_array( $mkd_custom_sidebars ) && count( $mkd_custom_sidebars ) > 0 ) {
			entre_mikado_create_meta_box_field(
				array(
					'name'        => 'mkd_custom_sidebar_area_meta',
					'type'        => 'selectblank',
					'label'       => esc_html__( 'Choose Widget Area in Sidebar', 'entre' ),
					'description' => esc_html__( 'Choose Custom Widget area to display in Sidebar"', 'entre' ),
					'parent'      => $mkd_sidebar_meta_box,
					'options'     => $mkd_custom_sidebars,
					'args'        => array(
						'select2' => true
					)
				)
			);
		}
	}
	
	add_action( 'entre_mikado_meta_boxes_map', 'entre_mikado_map_sidebar_meta', 31 );
}