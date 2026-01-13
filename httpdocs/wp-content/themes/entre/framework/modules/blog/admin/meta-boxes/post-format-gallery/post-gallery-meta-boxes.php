<?php

if ( ! function_exists( 'entre_mikado_map_post_gallery_meta' ) ) {
	
	function entre_mikado_map_post_gallery_meta() {
		$gallery_post_format_meta_box = entre_mikado_create_meta_box(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Gallery Post Format', 'entre' ),
				'name'  => 'post_format_gallery_meta'
			)
		);
		
		entre_mikado_add_multiple_images_field(
			array(
				'name'        => 'mkd_post_gallery_images_meta',
				'label'       => esc_html__( 'Gallery Images', 'entre' ),
				'description' => esc_html__( 'Choose your gallery images', 'entre' ),
				'parent'      => $gallery_post_format_meta_box,
			)
		);
	}
	
	add_action( 'entre_mikado_meta_boxes_map', 'entre_mikado_map_post_gallery_meta', 21 );
}
