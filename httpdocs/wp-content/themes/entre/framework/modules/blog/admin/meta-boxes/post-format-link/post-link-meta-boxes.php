<?php

if ( ! function_exists( 'entre_mikado_map_post_link_meta' ) ) {
	function entre_mikado_map_post_link_meta() {
		$link_post_format_meta_box = entre_mikado_create_meta_box(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Link Post Format', 'entre' ),
				'name'  => 'post_format_link_meta'
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_post_link_link_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Link', 'entre' ),
				'description' => esc_html__( 'Enter link', 'entre' ),
				'parent'      => $link_post_format_meta_box,
			
			)
		);
	}
	
	add_action( 'entre_mikado_meta_boxes_map', 'entre_mikado_map_post_link_meta', 24 );
}