<?php

if ( ! function_exists( 'entre_mikado_map_post_quote_meta' ) ) {
	function entre_mikado_map_post_quote_meta() {
		$quote_post_format_meta_box = entre_mikado_create_meta_box(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Quote Post Format', 'entre' ),
				'name'  => 'post_format_quote_meta'
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_post_quote_text_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Quote Text', 'entre' ),
				'description' => esc_html__( 'Enter Quote text', 'entre' ),
				'parent'      => $quote_post_format_meta_box,
			
			)
		);
		
		entre_mikado_create_meta_box_field(
			array(
				'name'        => 'mkd_post_quote_author_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Quote Author', 'entre' ),
				'description' => esc_html__( 'Enter Quote author', 'entre' ),
				'parent'      => $quote_post_format_meta_box,
			)
		);
	}
	
	add_action( 'entre_mikado_meta_boxes_map', 'entre_mikado_map_post_quote_meta', 25 );
}