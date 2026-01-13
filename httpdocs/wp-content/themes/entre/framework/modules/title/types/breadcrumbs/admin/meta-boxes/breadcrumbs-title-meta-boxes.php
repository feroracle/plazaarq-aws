<?php

if ( ! function_exists( 'entre_mikado_breadcrumbs_title_type_options_meta_boxes' ) ) {
	function entre_mikado_breadcrumbs_title_type_options_meta_boxes( $show_title_area_meta_container ) {
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_breadcrumbs_color_meta',
				'type'        => 'color',
				'label'       => esc_html__( 'Breadcrumbs Color', 'entre' ),
				'description' => esc_html__( 'Choose a color for breadcrumbs text', 'entre' ),
				'parent'      => $show_title_area_meta_container
			)
		);
	}
	
	add_action( 'entre_mikado_additional_title_area_meta_boxes', 'entre_mikado_breadcrumbs_title_type_options_meta_boxes' );
}