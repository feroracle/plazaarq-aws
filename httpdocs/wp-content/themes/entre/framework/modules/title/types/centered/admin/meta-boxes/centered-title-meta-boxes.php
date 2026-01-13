<?php

if ( ! function_exists( 'entre_mikado_centered_title_type_options_meta_boxes' ) ) {
	function entre_mikado_centered_title_type_options_meta_boxes( $show_title_area_meta_container ) {
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_subtitle_side_padding_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Subtitle Side Padding', 'entre' ),
				'description' => esc_html__( 'Set left/right padding for subtitle area', 'entre' ),
				'parent'      => $show_title_area_meta_container,
				'args'        => array(
					'col_width' => 2,
					'suffix'    => 'px or %'
				)
			)
		);
	}
	
	add_action( 'entre_mikado_additional_title_area_meta_boxes', 'entre_mikado_centered_title_type_options_meta_boxes', 5 );
}